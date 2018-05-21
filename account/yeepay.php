<?php
header("Content-type: text/html; charset=gb2312");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();
$payment 	= Request::r('payment');//单位为元，充值金额
$uid 		= Request::r('uid');

if ($uid != $userInfo['u_id']) {
	fail_exit_g("无效用户");
}
$ismoney =  (boolean) preg_match('#^\d+(\.\d{1,2})?$#', $payment);

if (!$ismoney) {
	fail_exit_g("无效的金额");
}

if (empty($provider)) {
	$provider = 'yeepay';
}
$bank_type = Request::r('bank_type') ? Request::r('bank_type') : 'ICBC';

$randNumber = rand('100000','999999');
$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);
$out_trade_no = "Y".date('ymdHis',time()). $rands;//订单号

$payParams = array(
    'notify_url'    => ROOT_DOMAIN . '/services/notify_pay.php',
    'return_url'    => ROOT_DOMAIN . '/purchase_process/pay_success_tips.php?id=' . $out_trade_no,
    'out_trade_no'  => $out_trade_no,
    'subject'       => '批量支付',
    'total_fee'     => $payment,
    'user_ip'       => Request::getIpAddress(),
    'yoka_user_id'  => $uid,
);



$providerAndbanks = array(
    array(
        'provider'  => $provider,
        'bank_type' => $bank_type,
    ),
);


//#记录充值日志
$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->initUserCharge($payParams, $provider);
if (!$tmpChargeResult) {
    fail_exit_g("记录充值日志失败，原因：".$tmpChargeResult->getData());
}

define('PAY_ROOT',dirname(__FILE__));
include (PAY_ROOT."/class/yeepayCommon.php");
include (PAY_ROOT."/class/yeepay.class.php");
$yeepayObj=new yeepay();

echo $yeepayObj->sendPay($out_trade_no,$payment,$bank_type);
?>
