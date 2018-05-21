<?php
/**
 * 用户彩金兑换成积分
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
		if (!$userVirtualTicketInfo) {
			$msg_error = '未找到积分投注记录，不能执行转换操作';//未下过积分订单的不能转换
			break;
		}

		$gift = Request::r('gift');

		if (!$gift) {
			$msg_error = '彩金有误，不能执行转换操作';
			break;
		}
		
		if ($gift<0) {
			$msg_error = '彩金为负数，不能执行转换操作';
			break;
		}
		
		if ($gift>$userAccountInfo['gift']) {
			$msg_error = '最多转换彩金为:'.$userAccountInfo['gift'].'，不能执行转换操作';
			break;
		}
		
		//可兑换的彩金
		$score = ConvertData::toMoney($gift*10);

		#清除原有彩金
		$tmpResult = $objUserAccountFront->consumeGift($u_id, $gift);
		if (!$tmpResult->isSuccess()) {
			$msg_error = '扣除积分失败，原因：'.$tmpResult->getData().' 请联系客服人员。';
			break;
		}

		$objUserGiftLogFront = new UserGiftLogFront();
		#添加积分日志
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['gift'] 			= $gift;
		$tableInfo['log_type'] 		= BankrollChangeType::GIFT_TRANTO_SOCRE;
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();

		$tmpResult = $objUserGiftLogFront->add($tableInfo);

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

		$userAccountInfo = $objUserAccountFront->get($u_id);
		$msg_success = '操作成功';

		break;
	default:
		break;
}

// $score = $userAccountInfo['score'];
//可兑换的彩金
$score = ConvertData::toMoney($userAccountInfo['gift']*10);
$tpl->assign('score', $score);
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('userVirtualTicketInfo', $userVirtualTicketInfo);
echo_exit($tpl->r('user_gift_tran'));