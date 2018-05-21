<?php
/**
 * 中信支付宝支付
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();
$tpl = new Template();

#标题
$TEMPLATE ['title'] = "智赢网充值中心-支付宝支付！ ";
$TEMPLATE['keywords'] = '智赢网充值中心-支付宝支付！';
$TEMPLATE['description'] = '智赢网充值中心-支付宝支付！。';

#埋藏跳转页面
$payment 	= Request::r('payment');//单位为元，充值金额
$uid 		= Runtime::getUid();

if ($uid != $userInfo['u_id']) {
	fail_exit_g("无效用户");
}

$ismoney =  (boolean) preg_match('#^\d+(\.\d{1,2})?$#', $payment);

if (!$ismoney) {
	fail_exit_g("无效的金额");
}

if (empty($provider)) {
	$provider = 'alipay_qr';
}
$bank_type = Request::r('bank_type') ? Request::r('bank_type') : 'ICBC';


$randNumber = rand('100000','999999');
$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);
$out_trade_no = "rhALI".date('ymdHis',time()). $rands;//订单号
$u_id = $userInfo['u_id'];

$payParams = array(
    'notify_url'    => ROOT_DOMAIN . '/services/notify_pay.php',
    'return_url'    => ROOT_DOMAIN . '/purchase_process/pay_success_tips.php?id=' . $out_trade_no,
    'out_trade_no'  => $out_trade_no,
    'subject'       => '批量支付',
    'total_fee'     => $payment,
    'user_ip'       => Request::getIpAddress(),
    'yoka_user_id'  => $u_id,
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

$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);

$tpl->assign('total_fee', $payment);
$tpl->assign('payment', $payment);

$tpl->assign('out_trade_no', $out_trade_no);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);

$YOKA ['output'] = $tpl->r ( 'rhalipay' );
echo_exit ( $YOKA ['output'] );