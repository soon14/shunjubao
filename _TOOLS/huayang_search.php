<?php
/**
 * 华阳接口之出票查询
 * 1、查询是否出票成功
 * 2、若成功更改系统票和用户票的状态
 * 3、若未出票成功且时间过长，则通知华阳方面尽快出票
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{hy_search}";
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
	
	$ticket_state = array(UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_PART, UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU, UserTicketAll::TICKET_STATE_LOTTERY_ING);
	$condition = array();
	$condition['print_state'] = $ticket_state;//未出票状态的
	$condition['company_id'] = TicketCompany::COMPANY_HUAYANG;
	$order = 'datetime asc';
	$step = 20;
	$offset = 0;
	$max_time = 60*5;//最大忍受的时长，单位秒
	
	$transactiontype = 13004;

//1、查询是否出票，若出票成功更改系统票状态
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
		$condition_this['u_id'] 			= $ticket_uid;
		$condition_this['print_state'] 		= array(UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU, UserTicketAll::TICKET_STATE_LOTTERY_ING);
		$condition_this['company_id'] 		= TicketCompany::COMPANY_HUAYANG;
		#100
		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, 100, $order);//所有系统票
		if (empty($order_tickets)) {
			//未找到当前系统票
			continue;
		}
		
		$data = array();
		foreach ($order_tickets as $order_ticket) {
			
			$pass_time = strtotime($order_ticket['datetime']) - time();//从用户投注到目前超过一定时间的系统票
			if ($pass_time >= $max_time) {
				#TODO 出票时间过长
			}
			
			$ID = $order_ticket['return_id'];//代理发起投注时产生的流水号20位
			//重组数组，流水id=>order_ticket
			$order_tickets[$ID] = $order_ticket;
			
			$element = array('id'=>$ID);
			$data[] = $element;
		}
	
		$header_needle = array('transactiontype'=>$transactiontype);
		$xml = $objHY->formMessage($data, $header_needle);
	
		//发送xml
		$objHY->sent($xml);
		sleep(1);
//		pr(count($data));
		if (!$objHY->isSendOk()) {
			//发送失败
			$word = $ID.'系统票查询落地发送失败，原因：'.$objHY->getErrorMessage();
			log_result($word, 'search_send', true);
			continue;
		}
		
		//待处理的返回数组
		$resArray = array();
		//通过返回结果更新系统票和用户票
		$resInfo = $objHY->getResponseArray();
		//判断是否多维数组
		$res_element = $resInfo['body']['elements']['element'];
		
		if (!$res_element) {
			//未得到查询结果
			$word = '未得到查询结果，原因：'.$objHY->getErrorMessage();
			log_result($word, 'search_send', true);
			continue;
		}
		
		if (!is_array($res_element[0])) {
			$resArray[] = $res_element;
		} else {
			$resArray = $res_element;
		}
		
//		pr($resArray);
		foreach ($resArray as $k=>$v) {
			
			$this_order_ticket 		= $order_tickets[$v['id']];
			$order_ticket_id 		= $this_order_ticket['id'];
			$u_id 					=  $this_order_ticket['u_id'];
			
			$objUserTicketLog = new UserTicketLog($u_id);
			
			$status 			= $v['status'];
			$ticket_id 			= $v['ticketid'];//体彩中心提供的彩票号
			$tickettime 		= $v['tickettime'];//出票时间
			$spvalue 			= $v['spvalue'];//即时赔率 131111-001(3_1.68);131111-002(0_1.88)
			$old_ticket_state 	= $this_order_ticket['print_state'];//当前彩票的状态
			$new_ticket_state 	= $this_order_ticket['print_state'];//当前彩票的状态
			
			//0：不可出票，1：可出票状态，2：出票成功，3：出票失败(允许再出票） 4：出票中 5：出票中（体彩中心），6：出票失败（不允许出票）
			switch ($status) {
				case 2:
					$new_ticket_state = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
					$this_order_ticket['print_time'] = $tickettime;
					$this_order_ticket['return_str'] = $ticket_id;
					#TODO待确认odds
					$this_order_ticket['odds'] = $v['spvalue'];
					break;
				case 1:case 3:case 4:case 5:
					$new_ticket_state = UserTicketAll::TICKET_STATE_LOTTERY_ING;
					break;
				case 6:
					$new_ticket_state = UserTicketAll::TICKET_STATE_LOTTERY_FAILED;
					$order_ticket['return_str'] = '出票失败（不允许出票）';
					break;
				case 0:
					$new_ticket_state = UserTicketAll::TICKET_STATE_LOTTERY_FAILED;
					$order_ticket['return_str'] = '不可出票';
					break;
				default:
					//更新系统票状态失败
					$word = '未知的票状态：'.$status;
					log_result($word, 'update_orderticket_state', true);
					break;
			}
			
			if ($old_ticket_state != $new_ticket_state) {
				//状态发生变化
				$this_order_ticket['print_state'] = $new_ticket_state;
				$tmpResult = $objUserTicketLog->modify($this_order_ticket);
				
				if (!$tmpResult->isSuccess()) {
					//更新系统票状态失败
					$word = '更新系统票状态失败，原因：'.$tmpResult->getData();
					log_result($word, 'update_orderticket_state', true);
				}
				
			}
			
		}
		
	}
	$offset += $step;
}while (true);

//后面更改用户票的机制转移到tickets.php
// continue;

// $offset = 0;
// $condition = array();
// $condition['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU;
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
// 		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, null, $order);//所有系统票
// 		if (empty($order_tickets)) {
// 			//未找到当前系统票
// 			continue;
// 		}
		
// 		$TicketSuccessNum = 0;//出票成功数量
// 		$last_print_time = '3000-01-01 00:00:00';
// 		foreach ($order_tickets as $order_ticket) {
// 			if ($order_ticket['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS) {
// 				$TicketSuccessNum++;
// 				if ($last_print_time > $order_ticket['print_time']) {
// 					$last_print_time = $order_ticket['print_time'];
// 				}
// 			}
// 		}
		
// 		if (!$TicketSuccessNum) {
// 			continue;			
// 		}
		
// 		//所有系统票均出票成功
// 		if ($TicketSuccessNum == count($order_tickets)) {
// 			//状态发生变化
// 			$ticket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
// 			$ticket['print_time'] = $last_print_time;//最后一张系统票的出票时间
// 		} else {
// 			$ticket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_PART;
// 		}
		
// 		$tmpResult = $objUserTicketAllFront->modify($ticket);
// 		if (!$tmpResult->isSuccess()) {
// 			//更新系统票状态失败
// 			$word = '更新用户票状态失败，原因：'.$tmpResult->getData();
// 			log_result($word, 'update_userticket_state', true);
// 		}
		
// 	}
// 	$offset += $step;
// }while (true);

 $objSingleProcess->active();

    usleep(500000);
//     echo "休息...\r\n";
} while (true);

$objSingleProcess->complete();

// echo "done\r\n";
exit;