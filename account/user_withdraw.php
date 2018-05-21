<?php
/**
 * 用户中心申请提现页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
#会员基本信息
$objUserMemberFront = new UserMemberFront();
$objUserAccountFront = new UserAccountFront();
$objUserRealInfoFront = new UserRealInfoFront();
$userRealInfo = $objUserRealInfoFront->get($u_id);
$tpl = new Template();

$msg_error = '';
$msg_success = '';

//提现申请
if ($_REQUEST['u_id'] && $_REQUEST['money']) {
	do {
		$uid = Request::r('u_id');//为验证用户传来的uid
		$money = Request::r('money');//单位为元
		$mobile = Request::r('mobile');
		if ($uid != $userInfo['u_id']) {
			$msg_error = '不允许的操作';
			break;
		}
		if (!Verify::money($money)) {
			$msg_error = '金额不正确';
			break;
		}
		if ($money < 10) {
			$msg_error = '金额必须大于10元';
			break;
		}
		if (!Verify::mobile($mobile)) {
			$msg_error = '手机号不正确';
			break;
		}
		$userAccountInfo = $objUserAccountFront->get($u_id);
		if ($money > $userAccountInfo['cash']) {
			$msg_error = '金额超过余额';
			break;
		}
		//账户真实信息是否已经绑定
		if (!$userRealInfo['realname']) {
			$msg_error = '账户未进行实名认证';
			break;
		}
		//账户银行卡是否已经绑定
		if (!$userRealInfo['bank']) {
			$msg_error = '账户银行卡未绑定';
			break;
		}
		//投注额需超过充值额的50%
		$objUserChargeFront = new UserChargeFront();
		$userChargeInfo = $objUserChargeFront->getsByCondition(array('u_id'=>$u_id, 'charge_status'=>UserCharge::CHARGE_STATUS_SUCCESS));
		if ($userChargeInfo) {
			$objUserTicketAllFront = new UserTicketAllFront();
			$userTicketInfo = $objUserTicketAllFront->getsByCondition(array('u_id'=>$u_id,'print_state'=>UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS));
			$touzhu_money = 0;
			$charge_money = 0;
			foreach ($userChargeInfo as $value) {
				$charge_money += $value['money'];
			}
			foreach ($userTicketInfo as $value) {
				$touzhu_money += $value['money'];
			}
			if ($touzhu_money <= $charge_money * 0.5) {
				$msg_error = '投注额需超过充值额的50%';
// 				if(Runtime::getUname()!='快乐的安安') break;
			}
		}
		
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['money'] 		= $money;
		$tableInfo['mobile']		= $mobile;
		//添加目前绑定的真实信息
		$tableInfo['realname'] 		= $userRealInfo['realname'];
		$tableInfo['bank'] 			= $userRealInfo['bank'];
		$tableInfo['bankcard'] 		= $userRealInfo['bankcard'];
		$tableInfo['bank_province'] = $userRealInfo['bank_province'];
		$tableInfo['bank_city'] 	= $userRealInfo['bank_city'];
		$tableInfo['bank_branch'] 	= $userRealInfo['bank_branch'];
		//提现方式
		$tableInfo['payment']		= Request::r('payment');
		
		//添加待审核记录
		$objUserEncashFront = new UserEncashFront();
		$tmpResult = $objUserEncashFront->add($tableInfo);
		
		if (!$tmpResult) {
			$msg_error = '提现申请添加失败';
			break;
		}
		
		$record_id = $tmpResult;
		
		$tmpResult = $objUserAccountFront->moneyToFrozen($u_id, $money);
		if (!$tmpResult->isSuccess()) {
			$msg_error = $tmpResult->getData();
			break;
		}
    	
    	$record_table = 'user_encash';
    	
    	$tableInfo = array();
    	$tableInfo['u_id'] 			= $u_id;
    	$tableInfo['money'] 		= $money;
    	$tableInfo['log_type'] 		= BankrollChangeType::CASH_TO_FROZEN;
    	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
    	$tableInfo['record_table'] 	= $record_table;//对应的表
    	$tableInfo['record_id'] 	= $record_id;
    	$tableInfo['create_time'] 	= getCurrentDate();
    	
    	//添加账户日志
    	$objUserAccountLogFront = new UserAccountLogFront($u_id);
    	$tmpResult = $objUserAccountLogFront->add($tableInfo);
    	
    	if (!$tmpResult) {
    		$msg_error = '添加账户日志失败';
    	}
    	
		$msg_success = '操作成功';
		//发送站内信，通知管理员
		sendUserPms(1, '提现申请','<a href="http://www.zhiying365365.com/admin/user/encash.php" target="_blank">查看</a>');
	}
	while (false);
	
}

$EncashPaymentDesc = UserEncash::getEncashPaymentDesc();
$tpl->assign('EncashPaymentDesc', $EncashPaymentDesc);

$objUserPaymentFront = new UserPaymentFront();
$userPaymentInfo = $objUserPaymentFront->getsByCondition(array('u_id'=>$u_id,'default'=>UserPayment::DEFAULT_PAY_TYPE));
if ($userPaymentInfo) {
	$userPaymentInfo = array_pop($userPaymentInfo);
}
$tpl->assign('userPaymentInfo', $userPaymentInfo);

$userAccountInfo = $objUserAccountFront->get($u_id);
$TEMPLETE['title'] = '智赢网用户提现';
$TEMPLATE['keywords'] = '智赢竞彩,智赢网,智赢用户中心';
$TEMPLATE['description'] = '智赢网用户提现。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccountInfo', $userAccountInfo);
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
echo_exit($tpl->r('user_withdraw'));