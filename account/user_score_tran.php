<?php
/**
 * 用户积分兑换成彩金
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
		
// 		$score = $userAccountInfo['score'];
		$score = Request::r('score');

		if (!$score) {
			$msg_error = '请输入积分，否则不能执行转换操作';
			break;
		}
		
		if ($score <10) {
			$msg_error = '积分不足10，不能执行转换操作';
			break;
		}
		
		if ($score > $userAccountInfo['score']) {
			$msg_error = '最多转换积分为:'.$userAccountInfo['score'].'，不能执行转换操作';
			break;
		}
		
		//可兑换的积分 
		$gift = floor($score/10);
		
		#清除原有积分
		$clear_score = $gift * 10;
		
		$tmpResult = $objUserAccountFront->consumeScore($u_id, $clear_score);
		if (!$tmpResult->isSuccess()) {
			$msg_error = '扣除积分失败，原因：'.$tmpResult->getData().' 请联系客服人员。';
			break;
		}
		
		$userAccountInfo = $objUserAccountFront->get($u_id);
		
		$objUserScoreLogFront = new UserScoreLogFront();
		#添加积分日志
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['score'] 		= $clear_score;
		$tableInfo['log_type'] 		= BankrollChangeType::SOCRE_TRANTO_GIFT;
		$tableInfo['old_score'] 	= $userAccountInfo['score'];//原金额
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		
		$tmpResult = $objUserScoreLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			$msg_error = '添加积分日志失败';
			break;
		}
		
		#添加彩金
		$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
		
		if (!$tmpResult->isSuccess()) {
			$msg_error = '添加彩金失败，原因：'.$tmpResult->getData();
			break;
		}
		
		$userAccountInfo = $objUserAccountFront->get($u_id);
		
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['gift'] 			= $gift;
		$tableInfo['log_type'] 		= BankrollChangeType::GIFT_TO_ACCOUNT;
		$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		//添加账户日志
		$objUserGiftLogFront = new UserGiftLogFront();
		$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			$msg_error = '添加账户日志失败，请联系客服人员。';
			break;
		}
		
		$msg_success = '操作成功';
		
		break;
	default:
		break;
}

$score = $userAccountInfo['score'];
//可兑换的积分
$gift = floor($score/10);
$tpl->assign('gift', $gift);
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('userVirtualTicketInfo', $userVirtualTicketInfo);
echo_exit($tpl->r('user_score_tran'));