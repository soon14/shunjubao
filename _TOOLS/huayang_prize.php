<?php
/**
 * 华阳接口之反奖
 * 1、找出已出票的所有系统票
 * 2、查询是否中奖
 * 3、对已中奖彩票的用户更新账户余额
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{hy_prize}";
$timeout = 30 * 60;//30分钟
$alive_time = 2 * 60 * 60;//脚本存活时间为2小时

$objSingleProcess = new SingleProcess($processId, $timeout, true);

if ($objSingleProcess->isRun()) {
//     echo "已经有进程在跑了\r\n";
    exit();
}
$objSingleProcess->run();

do {
    if (!isAlive($alive_time)) {
    	break;
    }
    
$objUserTicketAllFront = new UserTicketAllFront();
$objHY = new HuaYangTicketClient();

$ticket_state = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_PART);
$condition = array();
$condition['print_state'] = $ticket_state;//出票状态的
$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
$condition['return_time'] = SqlHelper::addCompareOperator('<=', date('Y-m-d H:i:s', time() + 90 * 60));
$condition['company_id'] = TicketCompany::COMPANY_HUAYANG;
$order = 'datetime asc';
$step = 20;
$offset = 0;
$transactiontype = 13011;

do{
	$limit = "{$offset}, {$step}";
	$all_tickets = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);//用户票

	if (empty($all_tickets)) {
		break;
	}
	$combination = array();//玩法
	$issue = array();//当前的奖期
	
	foreach ($all_tickets as $key=>$ticket) {
		
		$ticketId 		= $ticket['id'];
		$ticket_uid 	= $ticket['u_id'];
		$objUserTicketLog = new UserTicketLog($ticket_uid);
		
		$condition_this = array();
		$condition_this['ticket_id'] 		= $ticketId;
//		$condition_this['u_id'] 			= $ticket_uid;
		$condition_this['print_state'] 		= UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
		$condition_this['prize_state'] 		= UserTicketAll::PRIZE_STATE_NOT_OPEN;
		$condition_this['company_id'] 		= TicketCompany::COMPANY_HUAYANG;
		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, 100, $order);//所有系统票
		if (empty($order_tickets)) {
			//未找到当前系统票
			continue;
		}
		
		$data = $element = array();
		foreach ($order_tickets as $order_ticket) {
			
			$ID = $order_ticket['return_id'];//代理发起投注时产生的流水号20位
			
			if (!$ID) {
				#TODO
				continue;
			}
			
			//重组数组，流水id=>order_ticket
			$order_tickets[$ID] = $order_ticket;
			
			$element = array('id'=>$ID);
			$data[] = $element;
		}
	
		$header_needle = array('transactiontype'=>$transactiontype);
		$xml = $objHY->formMessage($data, $header_needle);
	
		//发送xml
		$objHY->sent($xml);
		$isSendOk = $objHY->isSendOk();
		//睡眠1秒，暂时解决查询频率过大的问题；#TODO，需要根据奖期来查询是否中奖
		sleep(1);
		//发送情况错误信息
		$errorCode = $objHY->getErrorCode();
		$errorMessage = $objHY->getErrorMessage();
			
		$resInfo = $objHY->getResponseArray();
		
		if (!$isSendOk) {
			//发送失败
			$word = '系统票查询落地发送失败，原因：'.$objHY->getErrorMessage();
			log_result($word, 'search_send', true);
			continue;
		}
		
		//通过返回结果更新系统票和用户票
		$resInfo = $objHY->getResponseArray();
		$res_element = $resInfo['body']['elements']['element'];
		if (empty($res_element)) {
			//未查询到中奖数据
			$word = '未查询到中奖数据';
			log_result($word, 'search_prize', true);
			continue;
		}
		
		//系统票中奖个数
		$orderPrizeNum = 0;
//		$prize = $ticket['prize'];//目前用户票中奖金额
//		pr($resArray);//此种情况需要改写数组
//[element] => Array
//                        (
//                            [id] => 20140508181815665379
//                            [status] => 2
//                            [ticketid] => 140508181809726619
//                            [prebonusvalue] => 415
//                            [bonusvalue] => 415
//                        )
		//返回的数组
		$resArray = array();
		if (!is_array($res_element[0])) {
			$resArray[] = $res_element;
		} else {
			$resArray = $res_element;
		}
		
		foreach ($resArray as $k=>$v) {
			
			$this_order_ticket 		= $order_tickets[$v['id']];//系统票
			$order_ticket_id 		= $this_order_ticket['id'];//系统票id
			$u_id 					= $this_order_ticket['u_id'];
			
			$objUserTicketLog = new UserTicketLog($u_id);
			
			$status 			= $v['status'];//中奖状态
//			$ticketid 			= $v['ticketid'];//彩票id
			$prebonusvalue 		= $v['prebonusvalue']/100;//税前奖金，单位：分
			$bonusvalue 		= $v['bonusvalue']/100;//总奖金，税后，单位：分
			
			if ($prebonusvalue > $bonusvalue) {
				$word = $v['id'].'发现巨额中奖，税前:'.$prebonusvalue.'元;税后:'.$bonusvalue.'元;';
				$word .= "用户uid:{$u_id};用户票id：{$order_ticket_id};";
				log_result($word, 'big_prize');
			}
			
			$old_prize_state 	= $this_order_ticket['prize_state'];//当前彩票的状态
			$new_prize_state 	= $this_order_ticket['prize_state'];//当前彩票的状态
			
//			pr($this_order_ticket);
			//中奖状态 0：未开奖 1：未中奖 2：中奖
			//未出票成功的状态：3为中心出票中;4出票中;5是未出票;6是出票失败;7为完成;

			switch ($status) {
				case 0: case 3: case 4:case 5:case 7:
					break;	
				case 1:
					$new_prize_state = UserTicketAll::PRIZE_STATE_NOT_WIN;
					//状态发生变化
					$this_order_ticket['prize_state'] = $new_prize_state;
					$tmpResult = $objUserTicketLog->modify($this_order_ticket);
					if (!$tmpResult->isSuccess()) {
						//更新系统票状态失败
						$word = $v['id'].'更新系统票状态失败，原因：'.$tmpResult->getData();
						log_result($word, 'search_state', true);
					}
					break;
				case 2:
					$new_prize_state = UserTicketAll::PRIZE_STATE_WIN;
					//状态发生变化
					$this_order_ticket['prize_state'] = $new_prize_state;
					//奖金发生变化
					$this_order_ticket['prize'] = $bonusvalue;
					
					$tmpResult = $objUserTicketLog->modify($this_order_ticket);
					if (!$tmpResult->isSuccess()) {
						//更新系统票状态失败
						$word = $v['id'].'更新系统票状态失败，原因：'.$tmpResult->getData();
						log_result($word, 'update_state', true);
					}
					break;
				case 6:
					$word = '出票失败，ID:'.$v['id'];
					log_result($word, 'ticket', true);
					break;
				default:
					$word = '更新系统票中奖状态失败，原因：未知的中奖状态,prize_state:'.$status;
					log_result($word, 'search_prize_state', true);
					break;
			}
		}
		
	}
	$offset += $step;
}while (true);


//返奖已经转移至tickets
// $offset = 0;
// $condition = array();
// $condition['print_state'] = $ticket_state;
// $condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
// $condition['company_id'] = TicketCompany::COMPANY_HUAYANG;
// //2、查询用户票下的所有系统票是否均出票成功，若成功则更改用户票状态	
// do{
// 	$limit = "{$offset}, {$step}";
// 	$all_tickets = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);//用户票

// 	if (empty($all_tickets)) {
// 		break;
// 	}
	
// 	$combination = array();//玩法
// 	$issue = array();//当前的奖期
	
// 	foreach ($all_tickets as $key=>$ticket) {
		
// 		$ticketId 		= $ticket['id'];
// 		$ticket_uid 	= $ticket['u_id'];
// 		$objUserTicketLog = new UserTicketLog($ticket_uid);
		
// 		$condition_this = array();
// 		$condition_this['ticket_id'] 		= $ticketId;
// 		$condition_this['u_id'] 			= $ticket_uid;
// 		$condition_this['company_id'] 		= TicketCompany::COMPANY_HUAYANG;
// 		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, null, $order);//所有未开奖的系统票
// 		if (empty($order_tickets)) {
// 			//未找到当前系统票
// 			continue;
// 		}
		
// 		$TicketNotWinNum = 0;//未中奖数量
// 		$TicketWinNum = 0;//中奖数量
// 		$TicketPrizeNOTOpenNum = 0;//未开奖数量
// 		$prize = 0;//该用户票中奖金额
// 		foreach ($order_tickets as $order_ticket) {
// 			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_NOT_WIN) {
// 				$TicketNotWinNum++;
// 			}
// 			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_WIN) {
// 				$TicketWinNum++;
// 				$prize += $order_ticket['prize'];//累加所有中奖的系统票
// 			}
// 			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_NOT_OPEN) {
// 				$TicketPrizeNOTOpenNum++;//有未开奖的系统票
// 			}
// 		}
// 		//必须等到所有比赛都算奖才可以给用户反奖
// 		if ($TicketPrizeNOTOpenNum) {
// 			continue;
// 		}
// 		//更改用户票状态为中奖
// 		if ($TicketWinNum) {
// 			$ticket['prize'] 		= $prize;
// 			$ticket['prize_state'] 	= UserTicketAll::PRIZE_STATE_WIN;
// 			$tmpResult = $objUserTicketAllFront->modify($ticket);
// 			if (!$tmpResult->isSuccess()) {
// 				//更新系统票状态失败
// 				$word = '更新系统票状态失败，原因：'.$tmpResult->getData();
// 				log_result($word, 'update_user_ticket_all', true);
// 				continue;
// 			}
// 			//更改账户余额
// 			$objUserAccountFront = new UserAccountFront();
// 			$tmpResult = $objUserAccountFront->addCash($ticket_uid, $prize);
// 			if (!$tmpResult->isSuccess()) {
// 				//更新系统票状态失败
// 				$word = 'u_id:'.$ticket_uid.',更改账户余额失败，原因：'.$tmpResult->getData();
// 				log_result($word, 'add_account', true);
// 			}
// 			$userAccountInfo = $objUserAccountFront->get($ticket_uid);
// 			//添加日志
// 			$tableInfo = array();
// 			$tableInfo['log_type'] 		= BankrollChangeType::PAIJIANG;
// 			$tableInfo['u_id'] 			= $ticket_uid;
// 			$tableInfo['money'] 		= $prize;
// 			$tableInfo['old_money'] 	= $userAccountInfo['cash'];
// 			$tableInfo['record_table'] 	= 'user_account';
// 			$tableInfo['record_id'] 	= $ticket_uid;
// 			$tableInfo['create_time'] 	= getCurrentDate();
// 			$objUserAccountLogFront = new UserAccountLogFront($ticket_uid);
// 			$tmpResult = $objUserAccountLogFront->add($tableInfo);
// 			if (!$tmpResult) {
// 				//更新系统票状态失败
// 				$word = 'u_id:'.$ticket_uid.',添加日志失败;系统票id：'.$ticketId;
// 				log_result($word, 'add_account_log', true);
// 			}
// 			#TODO方案加奖
// // 			prizeAddGift($ticket['id'], $prize);
// 			prizePms($ticket_uid, $prize);
// // 			sendUserPms($ticket_uid, '中奖','尊敬的会员，恭喜您中奖，奖金&yen'.$prize.'元已派送至账户，<a href="'.ROOT_DOMAIN.'/account/user_ticket_log.php">请查收！</a>');
// 		}
		
// 		//所有系统票均未中奖
// 		if ($TicketNotWinNum == count($order_tickets)) {
// 			//状态发生变化
// 			$ticket['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
// 			$tmpResult = $objUserTicketAllFront->modify($ticket);
				
// 			if (!$tmpResult->isSuccess()) {
// 				//更新系统票状态失败
// 				$word = '更新用户票状态失败，原因：'.$tmpResult->getData();
// 				log_result($word, 'update_userticket_state', true);
// 			}
// 		}
		
// 	}
// 	$offset += $step;
// 	sleep(1);
// }while (true);

 $objSingleProcess->active();

    sleep(1);
//     echo "休息...\r\n";
} while (true);

$objSingleProcess->complete();

// echo "done\r\n";
exit;