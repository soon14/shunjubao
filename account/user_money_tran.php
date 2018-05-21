<?php
/**
 * 用户余额兑换成积分
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$u_id = Runtime::getUid();

$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($u_id);


$objVirtualTicket = new VirtualTicket();
$condition = array();
$condition['u_id'] = $u_id;
$condition['status'] = SqlHelper::addCompareOperator('!=', VirtualTicket::VIRTUAL_TICKET_STATUS_NOT_TOUZHU);
$userVirtualTicketInfo = $objVirtualTicket->getsByCondition($condition,1);

$action = Request::r('action');

$msg_error = '';
$msg_success = '';
$tpl = new Template();

switch ($action) {
	case 'tran'://转换成彩金的操作
	/*	if (!$userVirtualTicketInfo) {
			$msg_error = '未找到积分投注记录，不能执行转换操作';//未下过积分订单的不能转换
			break;
		}*/
		

		$cash = Request::r('cash');
		
		if (!$cash) {
			$msg_error = '请输入余额，否则不能执行转换操作';
			break;
		}
		
		if ($cash <1) {
			$msg_error = '余额不足，不能执行转换操作';
			break;
		}
		
		if ($cash > $userAccountInfo['cash']) {
			$msg_error = '最多转换积分为:'.$userAccountInfo['cash'].'，不能执行转换操作';
			break;
		}
		
		//可兑换的积分 
		 $score = floor($cash*10);
		
		$tmpResult = $objUserAccountFront->consumeCash($u_id, $cash);
		if (!$tmpResult->isSuccess()) {
			$msg_error = '扣除余额失败，原因：'.$tmpResult->getData().' 请联系客服人员。';
			break;
		}
		
		$userAccountInfo = $objUserAccountFront->get($u_id);
		
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['money'] 		= $cash;
		$tableInfo['log_type'] 		= BankrollChangeType::CASH_TO_GIFT;
		$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		
		//添加账户日志
		$objUserAccountLogFront = new UserAccountLogFront($u_id);
		$tmpResult = $objUserAccountLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			$msg_error = '添加积分日志失败';
			break;
		}
		
		#添加积分
		$tmpResult = $objUserAccountFront->addScore($u_id, $score);
		
		if (!$tmpResult->isSuccess()) {
			$msg_error = '添加积分失败，原因：'.$tmpResult->getData();
			break;
		}
		
		$objUserScoreLogFront = new UserScoreLogFront();
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['score'] 		= $score;
		$tableInfo['log_type'] 		= BankrollChangeType::SCORE_TO_ACCOUNT;
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		//添加账户日志
		$tmpResult = $objUserScoreLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			$msg_error = '添加账户日志失败，请联系客服人员。';
			break;
		}
		
		$msg_success = '操作成功';
		
		break;
	default:
		break;
}

$cash = $userAccountInfo['cash'];
//可兑换的积分
$gift = floor($cash*10);
$tpl->assign('gift', $gift);
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('userVirtualTicketInfo', $userVirtualTicketInfo);
echo_exit($tpl->r('user_money_tran'));