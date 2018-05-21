<?php
/**
 * 简单操作集合
 * 方便js调用
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$u_id = Runtime::getUid();

$operate = Request::r('operate');

switch ($operate) {
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