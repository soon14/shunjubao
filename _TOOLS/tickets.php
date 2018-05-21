<?php
/**
 * 本站用户票统一处理脚本
 * 暂时只处理北单的票
 * 1、投注
 * 2、出票
 * 3、返奖
 * 4、记录日志到统一的文件
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$processId = realpath(__FILE__) . "--{zhiying_tickets}";
$timeout = 30 * 60;//30分钟
$alive_time = 2 * 60 * 60;//脚本存活时间为2小时
$objSingleProcess = new SingleProcess($processId, $timeout);
if ($objSingleProcess->isRun()) {
 	echo "已经有进程在跑了\r\n";
	exit();
}
$objSingleProcess->run();

do {
	if (!isAlive($alive_time)) {
		break;
	}
	
	//更新投注
	orderTicketToTouzhu();
	usleep(1000000);
	
	//更新出票
	orderTicketToChuPiao();
	usleep(100000);
	
	//更新返奖
	orderTicketToFanJiang();
	usleep(1000000);
	
	//积分投注
	jifenOrderToPrize();
	usleep(1000000);
	
	$objSingleProcess->active();
	
	usleep(1000000);
	
} while (true);
	
$objSingleProcess->complete();
	
echo "done\r\n";
exit;	

/**
 * 系统订单状态更新之投注
 * 工作流程：
 * 1、查询未出票或部分投注的用户票，找出其系统票；
 * 2、统计投注成功或失败的数量，由于投注出去之后系统票的状态必为其一，因此可以根据这两个状态进行后续操作
 * 3、按照投注成功或失败的数量分别更新用户票的状态，全部成功->已投注；部分成功->部分投注；全部失败->投注失败
 */
function orderTicketToTouzhu(){
	
	$objUserTicketAllFront = new UserTicketAllFront();
	//处理用户票投注状态
	$condition = array();
	$condition['print_state'] = array(UserTicketAll::TICKET_STATE_NOT_LOTTERY, UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_PART);//未出票状态的
// 	$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
	$userTickets = $objUserTicketAllFront->getsByCondition($condition, null, 'datetime asc');
	
	foreach ($userTickets as $userTicket) {
	
		$objUserTicketLog = new UserTicketLog($userTicket['u_id']);
	
		//有未出票的，表明当前用户票没有投注成功，出于性能的考虑，先查一次未出票的
		$cond = array();
		$cond['print_state'] = UserTicketAll::TICKET_STATE_NOT_LOTTERY;
		$cond['ticket_id'] = $userTicket['id'];
		$not_touzhu_orderTicketInfo = $objUserTicketLog->getsByCondition($cond ,1);
		if ($not_touzhu_orderTicketInfo) {
			continue;
		}
		
		$cond = array();
		$cond['ticket_id'] = $userTicket['id'];
		$orderTicketInfos = $objUserTicketLog->getsByCondition($cond);
		if (!$orderTicketInfos) {
			$word = 'userTicketId'.$userTicket['id'].':未发现系统票';
			log_result_error($word);
			continue;
		}
		
		$successNum = 0;//投注成功的系统票数量
		$failNum = 0;//投注失败的数量
		foreach ($orderTicketInfos as $orderTicketInfo) {
			$print_state = $orderTicketInfo['print_state'];
			//可能出现的情况：系统票对应的用户票未来得及更新到已投注状态，就已经是出票状态了，因此成功的数量要把出票和出票中的算入
			$state = array(
					UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU,
					UserTicketAll::TICKET_STATE_LOTTERY_ING,
					UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS,
			);
			if (in_array($print_state, $state)) {
				$successNum++;
			}
			if ($print_state == UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED) {
				$failNum++;
			}
	
		}
		//所有系统票都已经投注成功
		do{
			
			if ($successNum == count($orderTicketInfos)) {
				$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU;
				break;
			}
			
			if ($failNum == count($orderTicketInfos)) {//全部失败
				$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED;
				$word = 'userTicketId'.$userTicket['id'].':投注失败';
				log_result_error($word);
				break;
			}
			
			if ($successNum && $failNum) {//部分成功
				$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_PART;
				$word = 'userTicketId'.$userTicket['id'].':部分失败';
				log_result_error($word);
				break;
			}
		}while (false);
		
		
		$tmpResult = $objUserTicketAllFront->modify($userTicket);
		if (!$tmpResult->isSuccess()) {
			$word = 'userTicketId'.$userTicket['id'].' modify failed :'.$tmpResult->getData();
			log_result_error($word);
			continue;
		}
	}
}

/**
 * 系统订单状态更新之出票
 * 只处理全部投注成功和部分成功的情况
 * 工作流程：
 * 1、查询全部投注成功和部分成功的用户票，找到其系统票
 * 2、统计系统票出票的数量，系统票的状态必定是下列情况之一：已出票，出票失败、投注失败
 */
function orderTicketToChuPiao() {
	
	$objUserTicketAllFront = new UserTicketAllFront();
	//处理用户票投注状态
	$condition = array();
	$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU, UserTicketAll::TICKET_STATE_LOTTERY_PART);//未出票状态的
// 	$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
	$userTickets = $objUserTicketAllFront->getsByCondition($condition, null, 'datetime asc');
	foreach ($userTickets as $userTicket) {
		$objUserTicketLog = new UserTicketLog($userTicket['u_id']);
	
		//有出票中的，表明当前用户票没有完全出票，出于性能的考虑，先查一次出票中的
		$cond = array();
		$cond['print_state'] = UserTicketAll::TICKET_STATE_NOT_LOTTERY;
		$cond['ticket_id'] = $userTicket['id'];
		$ing_orderTicketInfo = $objUserTicketLog->getsByCondition($cond ,1);
		if ($ing_orderTicketInfo) {
			continue;
		}
		
		$cond = array();
		$cond['ticket_id'] = $userTicket['id'];
		$orderTicketInfos = $objUserTicketLog->getsByCondition($cond);
		$successNum = 0;//成功出票数量
		$failNum = 0;//出票失败的数量
		$last_print_time = '3000-01-01 00:00:00';//最后一张系统票的出票时间
		foreach ($orderTicketInfos as $orderTicketInfo) {
			$print_state = $orderTicketInfo['print_state'];
	
			if ($print_state == UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS) {
				$successNum++;
				if ($last_print_time > $orderTicketInfo['print_time']) {
					$last_print_time = $orderTicketInfo['print_time'];
				}
			}
			if ($print_state == UserTicketAll::TICKET_STATE_LOTTERY_FAILED) {
				$failNum++;
			}
	
		}
			
				
		//所有系统票都已经出票成功
		if ($successNum == count($orderTicketInfos)) {
			$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
			$userTicket['print_time'] = $last_print_time;
			//返点逻辑
			$objUserRebateFront = new UserRebateFront();
			$objUserRebateFront->addUserTicketRebate($userTicket['u_id'], $userTicket['id']);
		}
	
		if ($failNum == count($orderTicketInfos)) {//全部失败
			$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_FAILED;
		}
	
		if ($successNum && $failNum) {//部分成功
			$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_PART;
		}
	
		$tmpResult = $objUserTicketAllFront->modify($userTicket);
		if (!$tmpResult->isSuccess()) {
			$word = 'userTicketId'.$userTicket['id'].' modify failed :'.$tmpResult->getData();
			log_result_error($word);
			continue;
		}
	}
}

/**
 * 系统订单状态更新之返奖
 * 工作流程：
 * 1、查询已出票且未开奖的用户票,找到其系统票
 * 2、当系统票中的状态不是未开奖状态时，按照中奖系统票的数量更新用户票状态
 * 3、系统票有未开奖状态时，不处理
 * #TODO可能会出现未开奖的系统票的堆积bug
 */
function orderTicketToFanJiang() {
	
	$objUserTicketAllFront = new UserTicketAllFront();
	//处理用户票投注状态
	$condition = array();
	$condition['print_state'] = array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);//出票状态的
	$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;//未开奖，这个状态很重要
// 	$condition['company_id'] = TicketCompany::COMPANY_ZUNAO;
	$userTickets = $objUserTicketAllFront->getsByCondition($condition, null, 'datetime asc');
	
	foreach ($userTickets as $key=>$ticket) {
	
		$ticketId 		= $ticket['id'];
		$ticket_uid 	= $ticket['u_id'];
		$objUserTicketLog = new UserTicketLog($ticket_uid);
	
		$condition_this = array();
		$condition_this['ticket_id'] 		= $ticketId;
		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, null, 'datetime asc');//所有未开奖的系统票
		if (empty($order_tickets)) {
			//未找到当前系统票
			continue;
		}
	
		$TicketNotWinNum = 0;//未中奖数量
		$TicketWinNum = 0;//中奖数量
		$TicketPrizeNOTOpenNum = 0;//未开奖数量
		$prize = 0;//该用户票中奖金额
		foreach ($order_tickets as $order_ticket) {
			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_NOT_WIN) {
				$TicketNotWinNum++;
			}
			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_WIN) {
				$TicketWinNum++;
				$prize += $order_ticket['prize'];//累加所有中奖的系统票
			}
			if ($order_ticket['prize_state'] == UserTicketAll::PRIZE_STATE_NOT_OPEN) {
				$TicketPrizeNOTOpenNum++;//有未开奖的系统票
			}
		}
		//必须等到所有比赛都算奖才可以给用户反奖
		if ($TicketPrizeNOTOpenNum) {
			continue;
		}
		
		//更改用户票状态为中奖
		if ($TicketWinNum) {
			$ticket['prize'] 		= $prize;
			$ticket['prize_state'] 	= UserTicketAll::PRIZE_STATE_WIN;
			$tmpResult = $objUserTicketAllFront->modify($ticket);
			if (!$tmpResult->isSuccess()) {
				//更新系统票状态失败
				$word = 'userticketId: '.$ticket['id'].' modify Ticket failed :'.$tmpResult->getData();
				log_result_error($word);
				continue;
			}
			//更改账户余额
			$objUserAccountFront = new UserAccountFront();
			$tmpResult = $objUserAccountFront->addCash($ticket_uid, $prize);
			if (!$tmpResult->isSuccess()) {
				//更新系统票状态失败
				$word = 'userticketId: '.$ticket['id'].' addcash prize: '.$prize.' failed :'.$tmpResult->getData();
				log_result_error($word);
				continue;
			}
			$userAccountInfo = $objUserAccountFront->get($ticket_uid);
			//添加日志
			$tableInfo = array();
			$tableInfo['log_type'] 		= BankrollChangeType::PAIJIANG;
			$tableInfo['u_id'] 			= $ticket_uid;
			$tableInfo['money'] 		= $prize;
			$tableInfo['old_money'] 	= $userAccountInfo['cash'];
			$tableInfo['record_table'] 	= 'user_account';
			$tableInfo['record_id'] 	= $ticket_uid;
			$tableInfo['create_time'] 	= getCurrentDate();
			$objUserAccountLogFront = new UserAccountLogFront($ticket_uid);
			$tmpResult = $objUserAccountLogFront->add($tableInfo);
			if (!$tmpResult) {
				//更新系统票状态失败
				$word = 'userticketId: '.$ticket['id'].' addaccountlog failed';
				log_result_error($word);
			}
			//中奖后再加奖
			prizeAddGift($ticket['id']);
			prizePms($ticket_uid, $prize);
			//更新用户票操作表的奖金
			$objUserTicketOperate = new UserTicketOperate();
			$objUserTicketOperate->update(array('prize'=>$prize), array('user_ticket_id'=>$ticketId));
		}
	
		//所有系统票均未中奖
		if ($TicketNotWinNum == count($order_tickets)) {
			//状态发生变化
			$ticket['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
			$tmpResult = $objUserTicketAllFront->modify($ticket);
	
			if (!$tmpResult->isSuccess()) {
				//更新系统票状态失败
				$word = 'userticketId: '.$ticket['id'].' modify userticket to not win failed:'.$tmpResult->getData();
				log_result_error($word);
			}
		}
		
	}
}

/**
 * 积分投注返奖
 */
function jifenOrderToPrize(){
	$objVirtualTicket = new VirtualTicket();
	$objBettingVirtual = new BettingVirtual();
	
	$offset = 0;
	$step = 100;
	
	$condition = array();
	$condition['status'] = VirtualTicket::VIRTUAL_TICKET_STATUS_TOUZHU;
	
	do{
		$limit = "{$offset},{$step}";
		
		$results = $objVirtualTicket->getsByCondition($condition, $limit);
		
		if (!$results) {
			break;
		}
		
		
		foreach ($results as $key=>$order) {
			$combinaion = $order['combination'];//1|h#0.22&a#1.78,2|h#2.52
			$multiple = $order['multiple'];//订单倍数
			$u_id = $order['u_id'];
			$currentDate = getCurrentDate();//返奖时间
			$prize = 0.00;//订单的奖金
			$lottery_result = true;//比赛是否有彩果，判断订单是否可以派奖的开关
			$matchIds = array();
			
			$m1 = explode(',', $combinaion);
			foreach ($m1 as $km1=>$vm1) {
				$m2 = explode('|', $vm1);//1|h#0.22&a#1.78
				$matchId = $m2[0];
				$matchInfo = $objBettingVirtual->get($matchId);
				
				if (!$matchInfo['lottery_result']) {
					$lottery_result = false;
					break;
				}
				
				if (!$matchInfo) {
					#LOGO;
				}
				
				$m3 = explode('&', $m2[1]);//h#0.22&a#1.78
				//用户选项
				$user_option = '';
				foreach ($m3 as $km3=>$vm3) {//vm3 h#0.22
					$m4 = explode('#', $vm3);
					$user_option = $m4[0];
					$user_odd = $m4[1];
					
					if ($user_option == $matchInfo['lottery_result']) {
						//中奖
						if (!$prize) {
							$prize = $user_odd * $multiple * 2;
						} else {
							$prize += $user_odd * $multiple * 2;
						}
					} else {
						//未中奖
					}
					
				}
			}
			
			//有比赛没有彩果，不进行算奖
			if (!$lottery_result) {
				continue;
			}
			
			if ($prize) {
				$prize = ConvertData::toMoney($prize);
				//返奖逻辑
				$order['status'] = VirtualTicket::VIRTUAL_TICKET_STATUS_PRIZE;
				$order['prize'] = $prize;
				$r = $objVirtualTicket->modify($order);
				if (!$r->isSuccess()) {
					#LOGO;
					echo_exit($r->getData());
				}
				
				//添加用户积分，并做log
				$objUserAccountFront = new UserAccountFront();
				$tmpResult = $objUserAccountFront->addScore($u_id, $prize);
				if (!$tmpResult->isSuccess()) {
					echo_exit($tmpResult->getData());
				}
				
				$userAccountInfo = $objUserAccountFront->get($u_id);
				
				$tableInfo = array();
				$tableInfo['u_id'] 			= $u_id;
				$tableInfo['score'] 		= $prize;
				$tableInfo['log_type'] 		= BankrollChangeType::SCORE_PAIJIANG;
				$tableInfo['old_score'] 	= $userAccountInfo['score'];//原金额
				$tableInfo['record_table'] 	= 'user_account';//对应的表
				$tableInfo['record_id'] 	= $u_id;
				$tableInfo['create_time'] 	= $currentDate;
				//添加账户日志
				$objUserScoreLogFront = new UserScoreLogFront();
				$tmpResult = $objUserScoreLogFront->add($tableInfo);
				
				if (!$tmpResult) {
					echo_exit('添加账户日志失败');
				}
				echo "orderid：".$order['id'].' uid:'.$order['u_id']." 返奖成功,中奖：{$prize}\r\n";
			} else {
				$order['status'] = VirtualTicket::VIRTUAL_TICKET_STATUS_NOT_PRIZE;
				$order['prize'] = $prize;
				$r = $objVirtualTicket->modify($order);
				if (!$r->isSuccess()) {
					#LOGO;
					echo_exit($r->getData());
				}
				echo "orderid：".$order['id'].' uid:'.$order['u_id']." 返奖成功,未中奖\r\n";
			}
			
		}
		
		$offset += $step;
	}while (true);
}
