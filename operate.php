<?php
/**
 * 简单操作集合
 * 方便js调用
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$u_id = Runtime::getUid();

$operate = Request::r('operate');

switch ($operate) {
	case 'addtips'://打赏
		if (!$u_id) {
			ajax_fail_exit('access denied');
		}
		
		$tips_to = Request::r('tips_to');//给谁打赏
		$ticket_id = Request::r('id');//自己的订单号
		$tips_money = Request::r('tips_money');//打赏金额
		
		if(!$tips_to || !$ticket_id || !$tips_money){
			 ajax_fail_exit("打赏出错！");
			
		}
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($u_id);
		$user_cash = $userAccountInfo['cash'];
		
		if($user_cash  < $tips_money){
			 ajax_fail_exit('余额不足,请先充值！');
		}
		
		/*$u_id = 3084;//谁
		$tips_to = 3082;//给谁打赏*/

		
		$objUserAccountLogFront = new UserAccountLogFront($u_id);
		$tmpResult = $objUserAccountFront->consumeCash($u_id, $tips_money);
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		$tableInfo['money'] 		= $tips_money;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];
		$tableInfo['log_type'] 		= BankrollChangeType::TIPS_CASH_CONSUME;
		$tableInfo['record_table'] 	= 'user_ticket_all';
		$tableInfo['record_id'] 	= $ticket_id;
		$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
		//var_dump($ticket_log_id);exit();
		
		//======================================
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($tips_to);
		$to_u_id = $userAccountInfo['u_id'];
		
		$objUserAccountLogFront = new UserAccountLogFront($tips_to);
		$tmpResult = $objUserAccountFront->addCash($tips_to, $tips_money);
		$tableInfo = array();
		$tableInfo['u_id'] 			= $tips_to;
		$tableInfo['create_time'] 	= getCurrentDate();
		$tableInfo['money'] 		= $tips_money;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];
		$tableInfo['log_type'] 		= BankrollChangeType::TIPS_CASH_ADD;
		$tableInfo['record_table'] 	= 'user_ticket_all';
		$tableInfo['record_id'] 	= $ticket_id;
		$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
		
		$objUserAddtipsLog = new UserAddtipsLog();
		$tableInfo = array();
		$tableInfo['u_id'] 				= $u_id;
		$tableInfo['to_u_id'] 			= $to_u_id;
		$tableInfo['addtips_money'] 	= $tips_money;
		$tableInfo['ticket_id'] 		= $ticket_id;
		$tableInfo['addtime'] 			= getCurrentDate();
		$tableInfo['addip'] 			= getClientIp();
		$user_addtips_log_id = $objUserAddtipsLog->add($tableInfo);
		
		ajax_success_exit($tips_money);
		break;
	case 'refreshCash':
		if (!$u_id) {
			ajax_fail_exit('access denied');
		}
		$objUserAccountFront = new UserAccountFront();
		$userAccountInfo = $objUserAccountFront->get($u_id);
		ajax_success_exit($userAccountInfo['cash']);
		break;
	case 'getIssueNumber'://获取最近几次的北单赛事信息
		$condition = array();
		$return = array();
		$objBDIssueInfos = new BDIssueInfos();
		$results = $objBDIssueInfos->getsByCondition($condition, 60, 'id desc');
		foreach ($results as $result) {
			$lotteryId = strtoupper($result['lotteryId']);
			$return[$lotteryId][$result['issueNumber']] = $result['issueNumber'];
		}
		//排序，最近的靠前
		foreach ($return as $key=>$issueNumbers) {
			rsort($issueNumbers);
			$return[$key] = $issueNumbers;
		}
		ajax_success_exit($return);
		break;
	case 'show_ticket'://晒单用户操作之：订单可晒
		
		if (!$u_id) ajax_fail_exit('请先登录');
		
		$userTicketId = Request::r('id');
		
		$objAdminOperate = new AdminOperate();
		$res = $objAdminOperate->isShowTickeUser($u_id);
		if (!$res) {
			ajax_fail_exit('您没有操作权限');
		}
		
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
		//只能从不公开到公开
		if ($userTicketInfo['combination_type'] != UserTicketAll::COMBINATION_TYPE_NOT_OPEN) {
			ajax_fail_exit('订单状态不正确');
		}
		//未开奖
		if ($userTicketInfo['prize_state'] != UserTicketAll::PRIZE_STATE_NOT_OPEN) {
			ajax_fail_exit('订单必须是未开奖状态');
		}
		//比赛未开始
		if ($userTicketInfo['endtime'] <= getCurrentDate()) {
			ajax_fail_exit('晒单时间已过');
		}
		
	   //增加查询控制每天只能晒单足球篮球的单子不能超过3个
		$field = 'datetime';
		$order = $field. ' desc';
		$condition_limit['u_id'] =$u_id;		
		$condition_limit['sport'] =$userTicketInfo['sport'];
		$condition_limit['combination_type'] = UserTicketAll::COMBINATION_TYPE_OPEN;
		$start_time =  date('Y-m-d', time());
		$end_time = date('Y-m-d', time());

		$combination_limit = $objUserTicketAllFront->getsByCondtionWithField($start_time. ' 00:00:00', $end_time. ' 23:59:59', $field, $condition_limit, $limit, $order);
	
		if(count($combination_limit)>2){
			ajax_fail_exit('24小时内最多只能晒3单！');
		}
		
		//增加晒单提成设置 2017-01-18 by joe
		$show_range = Request::r('show_range');//是否所有人可见
		$pay_rate = Request::r('pay_rate');//跟单提成比例
		
		$userTicketInfo['combination_type'] = UserTicketAll::COMBINATION_TYPE_OPEN;
		$userTicketInfo['show_range'] = $show_range;
		$userTicketInfo['pay_rate'] = $pay_rate;
		
		$result = $objUserTicketAllFront->modify($userTicketInfo);
		
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		ajax_success_exit('操作成功');
		break;
	case 'show_ticket_cancel'://晒单用户操作之：晒单取消
		
		if (!$u_id) ajax_fail_exit('请先登录');
		
		$userTicketId = Request::r('id');
		$objUserTicketAllFront = new UserTicketAllFront();
		$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
		//只能从不公开到公开
		if ($userTicketInfo['combination_type'] != UserTicketAll::COMBINATION_TYPE_OPEN) {
			ajax_fail_exit('订单状态不正确');
		}
		
		$userTicketInfo['combination_type'] = UserTicketAll::COMBINATION_TYPE_NOT_OPEN;
		$result = $objUserTicketAllFront->modify($userTicketInfo);
		
		if (!$result->isSuccess()) {
			ajax_fail_exit($result->getData());
		}
		ajax_success_exit('操作成功');
		break;
}
ajax_fail_exit('access denied');