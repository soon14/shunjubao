<?php
/**
 * 用户支付方式
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = Runtime::getUser();

$pay_type = Request::r('pay_type');
$pay_account = Request::r('pay_account');

$condition = array();
$condition['u_id'] = $userInfo['u_id'];
$condition['default'] = UserPayment::DEFAULT_PAY_TYPE;

$objUserPaymentFront = new UserPaymentFront();
$userPaymentInfos = $objUserPaymentFront->getsByCondition($condition);

if ($userPaymentInfos) {
	$userPaymentInfo = array_pop($userPaymentInfos);
} else {
	$userPaymentInfo = array();
}
// pr($userPaymentInfo);
$tpl = new Template();
$payTypeDesc = UserPayment::getPayTypeDesc();

$tpl->assign('payTypeDesc', $payTypeDesc);
$tpl->assign('userPaymentInfo', $userPaymentInfo);

if (!$pay_type || !$pay_account) {
	echo_exit($tpl->r('user_payment'));
}

$msg_error = $msg_success = '';

do{
	if (!array_key_exists($pay_type, $payTypeDesc)) {
		$msg_error = '未知的支付类型';
		break;
	}
	
	if (!$userPaymentInfo) {
		
		$userPaymentInfo['pay_type'] = $pay_type;
		$userPaymentInfo['pay_account'] = $pay_account;
		$userPaymentInfo['default'] = UserPayment::DEFAULT_PAY_TYPE;
		$tmpResult = $objUserPaymentFront->add($userPaymentInfo);
		if (!$tmpResult) {
			$msg_error = '添加记录失败';
			break;
		}
	} else {
		
		$userPaymentInfo['pay_type'] = $pay_type;
		$userPaymentInfo['pay_account'] = $pay_account;
		$tmpResult = $objUserPaymentFront->modify($userPaymentInfo);
		
		if (!$tmpResult->isSuccess()) {
			$msg_error = '修改记录失败';
			break;
		}
	}
	$msg_success = '操作成功';
}while (false);

$tpl->assign('userPaymentInfo', $userPaymentInfo);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('msg_error', $msg_error);
echo_exit($tpl->r('user_payment'));
