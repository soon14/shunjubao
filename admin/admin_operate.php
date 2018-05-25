<?php
/**
 * 后台操作中心
 * 一：给用户退票
 * 1、只能退还未出票，出票失败，部分出票失败，投注失败，部分投注失败的用户票
 * 2、
 * 二、手动算奖
 * 1、选择性处理某些用户票，
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,false)) {
    ajax_fail_exit("该页面不允许查看");
}

$type = Request::r('type');
switch ($type) {
	case 'refund_money'://给用户退票，使用情况：所有系统票为非出票或出票中状态
		$userTicketId = Request::r('userTicketId');
		if (!Verify::int($userTicketId)) {
			 ajax_fail_exit($userTicketId."userTicketId不正确");
		}
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicket = $objUserTicketAllFront->get($userTicketId);
		if (!$userTicket) {
			 ajax_fail_exit("userTicket不存在");
		}
		
		$u_id = $userTicket['u_id'];
		$objUserTicketLog = new UserTicketLog($u_id);
		
		$condition = array();
		$condition['ticket_id'] = $userTicketId;
		
		$orderTickets = $objUserTicketLog->getsByCondition($condition);
		if (!$orderTickets) {
			 ajax_fail_exit("orderTicket不存在");
		}
		//获取全部系统票，用于判断是否全部退款
		$condition['print_state'] = array(
				UserTicketAll::TICKET_STATE_LOTTERY_ING,
// 				UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS,
		);
		$succ_orderTickets = $objUserTicketLog->getsByCondition($condition);
		
		if ($succ_orderTickets) {
			ajax_fail_exit("有部分系统票正在出票，无法全部退款。");
		}

    	//用户票返款
    	$tmpResult = $objUserTicketAllFront->returnTicketMoney($userTicketId);
    	if (!$tmpResult->isSuccess()) {
    		ajax_fail_exit("退款失败，原因：".$tmpResult->getData());
    	}	
		
		//更改用户票状态
		$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_RETURN_MONEY;
		
		$tmpResult = $objUserTicketAllFront->modify($userTicket);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit("更改用户票状态失败，原因：".$tmpResult->getData());
		}	
		
		userTicketOperateSpeed($userTicketId, UserTicketOperate::TYPE_REFUND_TICKET);

		$objUserRealInfoFront = new UserRealInfoFront();
		$userRealInfo = $objUserRealInfoFront->get($u_id);

		$msg = '操作成功！';
		//发送短信通知
		if (isset($userRealInfo['mobile']) and Verify::mobile($userRealInfo['mobile'])) {
			$objZYShortMessage = new ZYShortMessage();
			$sm_res = $objZYShortMessage->sendOneSelectWrong($userRealInfo['mobile']);
			if ($sm_res->isSuccess()) {
				$msg .= '短信发送成功';
			} else {
				$msg .= '短信发送失败，请到后台查看日志';
			}
		}

		ajax_success_exit($msg);
		break;
	case 'manu_prize'://手动返奖，用来处理吃票的情况，目前只能处理所有系统票均出票失败的情况
		//比赛取消的赛事集合，此类比赛的sp均为1，算作中奖
		$sp_1 = sp_1_match();
		$userTicketId = Request::r('userTicketId');
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicket = $objUserTicketAllFront->get($userTicketId);
		$userTicket['print_time']   = getCurrentDate();
		$userTicket['return_money'] = 0;
		if (!$userTicket) {
			ajax_fail_exit('未发现用户票');
		}
		
		if ($userTicket['prize_state'] != UserTicketAll::PRIZE_STATE_NOT_OPEN) {
			ajax_fail_exit('用户票状态不是未开奖');
		}
		
		$u_id = $userTicket['u_id'];
		$objUserTicketLog = new UserTicketLog($u_id);
		$condition = array();
		$condition['ticket_id'] = $userTicketId;
		$orderTickets = $objUserTicketLog->getsByCondition($condition);//所有系统票；
		if (!$orderTickets) {
			ajax_fail_exit('未发现系统票');
		}
		$diff = 0;
		foreach ($orderTickets as $value) {
			if ($value['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_ING || $value['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS) {
// 				ajax_fail_exit('发现系统票'.$value['id'].'已出票或正在出票，无法完成后续操作');
			}
			if ($value['prize_state'] != UserTicketAll::PRIZE_STATE_NOT_OPEN) {
				$diff++;//手动返奖一定是未开奖的
			}
		}
		//当所有系统票均为出票失败时才人工算奖
		if ($diff) {
// 			ajax_fail_exit('发现已算奖系统票'.$diff.'张');
		}
		
		//找出需要返奖的用户票
		//1、查询赛果，所有系统票均有赛果时返奖
		//2、计算奖金，奖金=sp!*倍数*2,注：北单需要再x65%
		//3、添加余额，记录日志
		$manu_prize = 0;

		foreach ($orderTickets as $order_ticket) {
			$combination = $order_ticket['combination'];//had|55855|h#2.66,hhad|55857|h#2.65
			//是否所有比赛都有赛果
			$m = explode(',', $combination);
			$prize = 2 * $order_ticket['multiple'];//系统票奖金，中奖基数：2*倍数
			if ($userTicket['sport'] == 'bd') {
				$prize *= 0.65;
			}
			$not_prize = false;//系统票是否未中奖
			$eqal = '|';
			foreach ($m as $m1) {//
				$m2 = explode('|', $m1);//$m1-had|55855|h#2.66
				$pool = $m2[0];
				$mid = $m2[1];
				$m3 = explode('#', $m2[2]);//$m2[2]-h#2.66
				$sp = $m3[1];
				
				$sport = $userTicket['sport'];
				//取消的比赛算做中奖
				$match_sp_1 = false;
				
				if (in_array($mid, $sp_1[$sport])) {
					$match_sp_1 = true;
					$sp = 1;
				}
				
				$prize *= $sp;//sp值连乘
				$eqal .= $sp.'x';
				
				if ($match_sp_1) {
					continue;
				}
				
				//竞彩返奖
				switch ($sport) {
					case 'fb':case 'bk':
						$objPoolResult = new PoolResult($sport);
						$objBetting = new Betting($sport);
						$bettingInfo = $objBetting->get($mid);
						
						$condition = array();
						$condition['m_id'] = $mid;
						$condition['s_code'] = strtoupper($sport);
						$condition['p_code'] = strtoupper($pool);
						$condition['value'] = '';
						$poolResults = $objPoolResult->getsByCondition($condition);//彩果
						break;
					case 'bd'://北单返奖
						$objPoolResult = new PoolResultBD();
						$objBettingBD = new BettingBD();
						$bettingInfo = $objBettingBD->get($mid);
						
						$cond = array();
						$cond['lotteryId'] = strtoupper($pool);
						$cond['issueNumber'] = $bettingInfo['issueNumber'];
						$cond['matchid'] = $bettingInfo['matchid'];
						$poolResults = $objPoolResult->getsByCondition($cond);//彩果
					break;
				}
				
				if (!$poolResults) ajax_fail_exit('部分比赛:'.$mid.'没有赛果，无法返奖');
				$poolResult = array_pop($poolResults);
				
				$user_option = getChineseByPoolCode($pool, $m3[0]);
				$this_option = getResults($pool, $poolResult['combination']);
				if ($user_option != $this_option) {
					//没中的情况，只要有没中的就不算中奖
					$not_prize = true;
				}
				
			}
			//中奖的情况
			if (!$not_prize) {
				$manu_prize += $prize;
			}
			
		}
		//处理到此处，除虚拟票外无论中奖与否，用票的状态都应是已出票
		if ($userTicket['print_state'] != UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU) {
			$userTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
		}
		
		if (!$manu_prize) {
			$userTicket['prize_state'] = UserTicketAll::PRIZE_STATE_NOT_WIN;
			$objUserTicketAllFront->modify($userTicket);
			ajax_success_exit('算奖成功，结果：所有票均未中奖');
		}
		$manu_prize = convertToMoney($manu_prize, false);
		
		//修改用户票状态
		$userTicket['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
		$userTicket['prize'] = $manu_prize;
		$objUserTicketAllFront->modify($userTicket);
		//添加余额
		$objUserAccountFront = new UserAccountFront();
		$tmpResult = $objUserAccountFront->addCash($u_id, $manu_prize);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit($tmpResult->getData());
		}
		
		$userAccountInfo = $objUserAccountFront->get($u_id);
		//添加日志
		$tableInfo = array();
		$tableInfo['log_type'] 		= BankrollChangeType::PAIJIANG;
		$tableInfo['u_id'] 			= $userTicket['u_id'];
		$tableInfo['money'] 		= $manu_prize;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];
		$tableInfo['record_table'] 	= 'user_account';
		$tableInfo['record_id'] 	= $userTicket['u_id'];
		$tableInfo['create_time'] 	= getCurrentDate();
		$objUserAccountLogFront = new UserAccountLogFront($userTicket['u_id']);
		$tmpResult = $objUserAccountLogFront->add($tableInfo);
		if (!$tmpResult) {
			ajax_fail_exit('添加日志失败');
		}
		
		$pmsBody = '尊敬的会员，恭喜您中奖，奖金&yen'.$manu_prize.'元已派送至账户，<a href="'.ROOT_DOMAIN.'/account/user_ticket_log.php">请查收！</a>';
		sendUserPms($userTicket['u_id'], '中奖', $pmsBody);
		
		userTicketOperateSpeed($userTicketId, UserTicketOperate::TYPE_MANUL_PRIZE);
		
		ajax_success_exit(substr($eqal, 0, -1) . '已经返奖：'.$manu_prize);
		
		break;
	case 'message_to_not_shenhe':
		$id = Request::r('id');
		if (!$id) {
			ajax_fail_exit('参数不正确');
		}
		$objUserMessageFront = new UserMessageFront();
		$info['id'] = $id;
		$info['status'] = UserMessage::STATUS_NOT_SHENHE;
		$result = $objUserMessageFront->modify($info);
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		ajax_success_exit('操作成功');
		break;
	case 'message_to_shenhe':
		$id = Request::r('id');
		if (!$id) {
			ajax_fail_exit('参数不正确');
		}
		$objUserMessageFront = new UserMessageFront();
		$info['id'] = $id;
		$info['status'] = UserMessage::STATUS_SHENHE;
		$result = $objUserMessageFront->modify($info);
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		ajax_success_exit('操作成功');
		break;
	case 'delete_log':
		//删除日志
		$id = Request::r('id');
		if (!Verify::int($id)) {
			ajax_fail_exit('参数不正确');
		}
		$objZYLog = new ZYLog();
		$result = $objZYLog->delete(array('id'=>$id));
		if (!$result) {
			ajax_fail_exit('删除失败');
		}
		ajax_success_exit('操作成功');
		break;
	case 'delete_log_all':
		//删除日志
		$ids = Request::r('ids');
		if (!$ids) {
			ajax_fail_exit('参数不正确');
		}
		$ids = explode(',', trim($ids,','));
		$objZYLog = new ZYLog();
		$result = $objZYLog->delete(array('id'=>$ids));
		if (!$result) {
			ajax_fail_exit('删除失败');
		}
		ajax_success_exit('操作成功');
		break;
	case 'unbind'://解绑用户
		
		$connect_id = Request::r('connect_id');
		
		$objUserConnect = new UserConnect();
		$result = $objUserConnect->unbind($connect_id);
		
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		
		ajax_success_exit('操作成功');
		break;
	case 'company_to_zhiying'://出票方转换成聚宝(吃票)
		/**
		 * 处理逻辑
		 * 1、找到用户票，是否是已经出票，已出票的不处理，否则转向2
		 * 2、找到系统票，是否全部已经出票，若全部已出票则不处理，否则转向3
		 * 3、此时的系统票都是非已出票状态，转换出票方为聚宝，状态转为已出票
		 * 4、转换用户票状态为已出票
		 */
		$userTicketId = Request::r('userTicketId');//用户票id
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
		if (!$userTicketInfo) {
			ajax_fail_exit('用户票信息未找到');
		}
		
		if ($userTicketInfo['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS) {
			ajax_fail_exit('用户票状态为已出票，停止处理');
		}
		
		//需要处理的状态列表
		$print_states = array(
			UserTicketAll::TICKET_STATE_LOTTERY_FAILED,
			UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED,
			UserTicketAll::TICKET_STATE_NOT_LOTTERY,	
		);
		
		$objUserTicketLog = new UserTicketLog($userTicketInfo['u_id']);
		$condition = array();
		$condition['ticket_id'] = $userTicketInfo['id'];
		$condition['print_state'] = $print_states;
		$orderTicketsInfo = $objUserTicketLog->getsByCondition($condition);
		
		if (!$orderTicketsInfo) {
			ajax_fail_exit('系统票均为已出票或出票中，停止处理');
		}
		//更新系统票
		foreach ($orderTicketsInfo as $orderTicketInfo) {
			$orderTicketInfo['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
			$orderTicketInfo['company_id'] = TicketCompany::COMPANY_ZHIYING;
			$orderTicketInfo['return_money'] = 0;
			$orderTicketInfo['print_time'] =getCurrentDate();
			$tmpResult = $objUserTicketLog->modify($orderTicketInfo);
			if (!$tmpResult->isSuccess()) {
				ajax_fail_exit('更新系统票失败：'.$tmpResult->getData());
			}
		}
		//更新用户票
		$userTicketInfo['return_money'] = 0;
		$userTicketInfo['company_id'] = TicketCompany::COMPANY_ZHIYING;
		$userTicketInfo['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
		$userTicketInfo['print_time'] 	= getCurrentDate();//添加更新出票时间2017-03-31
		$tmpResult = $objUserTicketAllFront->modify($userTicketInfo);
		if (!$tmpResult->isSuccess()) {
			ajax_fail_exit('更新用户票失败：'.$tmpResult->getData());
		}
		
		userTicketOperateSpeed($userTicketId, UserTicketOperate::TYPE_ZHIYING_TICKET);
		
		ajax_success_exit('操作成功');
		
		break;
	case 'batch_manul_ticket'://批量人工出票
		//用户票转为人工，添加操作人信息，系统票更该为出票状态
		$ids = Request::r('ids');
		if (!$ids) {
			ajax_fail_exit('参数不正确');
		}
		
		$objUserTicketAllFront = new UserTicketAllFront();
		
		$ids = explode(',', trim($ids,','));

		$operate_uid = Request::r('operate_uid');
		$operate_uname = Request::r('operate_uname');

		foreach($ids as $id) {
			$action_ticketinfo = $objUserTicketAllFront->get($id);
			if ($action_ticketinfo['print_state']!= UserTicketAll::TICKET_STATE_NOT_LOTTERY || $action_ticketinfo['company_id'] != TicketCompany::COMPANY_MANUAL) {
				ajax_fail_exit('用户订单不是未出票状态');
			}
			$action_ticketinfo['return_money'] = 0;
			$action_ticketinfo['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU;
			$action_ticketinfo['print_time'] 	= getCurrentDate();//添加更新出票时间2017-03-31
			$tmpResult = $objUserTicketAllFront->modify($action_ticketinfo);
			if (!$tmpResult->isSuccess()) {
				ajax_fail_exit($tmpResult->getData());
			}
			
			$objUserTicketLog = new UserTicketLog($action_ticketinfo['u_id']);
			$cond = array();
			$cond['ticket_id'] = $id;
			$cond['print_state'] = UserTicketAll::TICKET_STATE_NOT_LOTTERY;
			$orderTickets = $objUserTicketLog->getsByCondition($cond);
			foreach ($orderTickets as $orderTicket) {
				$orderTicket['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
				$orderTicket['print_time'] 	= getCurrentDate();
				$tmpResult = $objUserTicketLog->modify($orderTicket);
				if (!$tmpResult->isSuccess()) {
					ajax_fail_exit($tmpResult->getData());
				}
			}

			$info = array();
			$info['user_ticket_id'] = $id;
			$info['money'] 			= $action_ticketinfo['money'];
			$info['datetime'] 			= $action_ticketinfo['datetime'];
			$info['type']					= UserTicketOperate::TYPE_MANUL_TICKET;
			$info['operate_uid']		= $operate_uid;
			$info['operate_uname']	= $operate_uname;

			$objUserTicketOperate = new UserTicketOperate();
			$operId = $objUserTicketOperate->add($info);
			if (!$operId) {
				ajax_fail_exit('添加订单操作记录失败');
			}
		}

		ajax_success_exit('操作成功');
		break;
	default:
		ajax_fail_exit('未知操作');
	break;
}
