<?php
/**
 * 虚拟投注
 * 1、手动添加虚拟账户列表
 * 2、虚拟用户登录并投注
 * 3、找出虚拟投注的用户票，查找彩果，反奖
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//找出未开奖的用户票
$objUserTicketAllFront = new UserTicketAllFront();

$ticket_state = UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU;
$condition = array();
$condition['print_state'] = $ticket_state;//出票状态的
$condition['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_OPEN;
// $condition['company_id'] = SqlHelper::addCompareOperator('!=', TicketCompany::COMPANY_MANUAL);//人工的票有单独的程序
$condition['return_time'] = SqlHelper::addCompareOperator('<=', date('Y-m-d H:i:s', time() + 90 * 60));
$order = 'datetime asc';
$step = 20;
$offset = 0;

do{
	$limit = "{$offset}, {$step}";
	$all_tickets = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);//用户票

	if (empty($all_tickets)) {
		break;
	}
	
	$issue = array();//当前的奖期
	
	foreach ($all_tickets as $key=>$ticket) {
		
		$ticketId 		= $ticket['id'];
		$ticket_uid 	= $ticket['u_id'];
		$objUserTicketLog = new UserTicketLog($ticket_uid);
		
		$condition_this = array();
		$condition_this['ticket_id'] 		= $ticketId;
		$condition_this['print_state'] 		= $ticket_state;
		$condition_this['prize_state'] 		= UserTicketAll::PRIZE_STATE_NOT_OPEN;
		$order_tickets = $objUserTicketLog->getsByCondition($condition_this, 100, $order);//所有系统票
		if (empty($order_tickets)) {
			//未找到当前系统票
			continue;
		}
		//查找跟单人
		$condition_this = array();
		$condition_this['partent_id'] = $ticket['id'];
		$condition_this['prize_state'] = SqlHelper::addCompareOperator('!=', UserTicketAll::PRIZE_STATE_NOT_OPEN);
		$followTicketInfo = $objUserTicketAllFront->getsByCondition($condition_this, 1);
		if ($followTicketInfo) {
			$followTicketInfo = array_pop($followTicketInfo);
			//跟单人的系统订单
			$f_objUserTicketLog = new UserTicketLog($followTicketInfo['u_id']);
			$followOrderTicketInfos = $f_objUserTicketLog->getsByCondition(array('ticket_id'=>$followTicketInfo['id']));
		} else {
			$followTicketInfo = $followOrderTicketInfos = array();
		}
		
		foreach ($order_tickets as $order_ticket) {
			
			$sport = $order_ticket['sport'];
			//系统票中奖场次
			$orderPrizeNum = $match_count = 0;
			//未中奖场次：有一个未中奖就算整个未中奖
			$orderNotPrizeNum = 0;
			$prize = 0;
			
			//按赛果计算中奖情况
			//系统票场次：由于系统票均为n串1模式，故总场次==中奖场次时算中奖
			$matchs = explode(',', $order_ticket['combination']);//combination had|55855|a#2.32,hhad|55857|a#2.25
			$prize = 2 * $order_ticket['multiple'];
			if ($sport == 'bd') {
				$prize *= 0.65;//北单需要x65%
			}
			
			foreach($matchs as $k => $v) {
				$match_count++;
				$match = explode("|", $v);
				$mid = $match[1];
				$spool = $match[0];
				$o = explode("#", $match[2]);
				$option = $o[0];
				$prize *= $o[1];
				$sport = strtolower($sport);
				if ($sport == 'bd') {
					$objBettingBD = new BettingBD();
					$bettingInfo = $objBettingBD->get($mid);
					$objPoolResult = new PoolResultBD();
					$cond = array();
					$cond['lotteryId'] = $spool;
					$cond['issueNumber'] = $bettingInfo['issueNumber'];
					$cond['matchid'] = $bettingInfo['matchid'];
					$poolResults = $objPoolResult->getsByCondition($cond);//彩果
				}
				if ($sport == 'bk' || $sport == 'fb') {
					$objPoolResult = new PoolResult($sport);
					$cond = array();
					$cond['m_id'] = $mid;
					$cond['s_code'] = strtoupper($sport);
					$cond['p_code'] = strtoupper($spool);
					$cond['value'] = '';
					$poolResults = $objPoolResult->getsByCondition($cond);//彩果
				}
				
				if ($poolResults) {
					$poolResult = array_pop($poolResults);
					$results = getResults($spool, $poolResult['combination']);
					$user_option = getChineseByPoolCode($spool, $option);
					if ($results == $user_option) {
						$orderPrizeNum++;
					} else {
						$orderNotPrizeNum++;
					}
				}
			}
			//按跟单人订单计算中奖情况
			if ($followOrderTicketInfos) {
				$prize = 0;
				//未开奖情况
				do {
					if ($followTicketInfo['prize_state'] == UserTicketAll::PRIZE_STATE_NOT_OPEN) {
						$orderPrizeNum = $orderNotPrizeNum = 0;
						break;
					}
					foreach ($followOrderTicketInfos as $fot) {
						if (!isCombinationSame($order_ticket['combination'],$fot['combination'])){
							continue;
						}
						
						//投注代码相同且中奖时算奖
						if ($fot['prize_state'] == UserTicketAll::PRIZE_STATE_WIN) {
							$prize += $fot['prize'] * $order_ticket['multiple']/$fot['multiple'];
							$orderPrizeNum++;
							$match_count = $orderPrizeNum;
						} else {
							$orderNotPrizeNum++;
						}
						break;
					}
				}while (false);
			}
			//中奖了
			$modify_order_ticket = false;
			do{
				if ($orderPrizeNum == $match_count) {
					$order_ticket['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
					$order_ticket['prize'] = ConvertData::toMoney($prize, false);
					$modify_order_ticket = true;
					break;
				}
				if ($orderNotPrizeNum) {
					$order_ticket['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
					$modify_order_ticket = true;
					break;
				}
				
			}while (false);
			//更新系统票
			if ($modify_order_ticket) {
				$tmpResult = $objUserTicketLog->modify($order_ticket);
				if (!$tmpResult->isSuccess()) {
					$word = 'modify failed,userorderId:'.$order_ticket['ticket_id'].';orderId:'.$order_ticket['id'];
					log_result_error($word);
				}
			}
			
		}
	}
		
	$offset += $step;
	sleep(1);
}while (true);
exit;
/**
 * 去掉赔率后比较两种combination是否一致
 * SPF|40049|d#3.83,SPF|40055|h#2.84
 */
function isCombinationSame($c1,$c2) {
	$c1 = preg_replace('#\#\d+(\.\d+)?#', '#',$c1);
	$c2 = preg_replace('#\#\d+(\.\d+)?#', '#',$c2);
	return $c1==$c2;
}