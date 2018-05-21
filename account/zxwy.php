<?php
/**
 * 用户中心充值页，中信网银行支付
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();
$tpl = new Template();

#标题
$TEMPLATE ['title'] = "智赢网充值中心-在线网银支付！ ";
$TEMPLATE['keywords'] = '智赢网充值中心-在线网银支付！';
$TEMPLATE['description'] = '智赢网充值中心在线网银支付！。';

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
	$provider = 'online_bank';
}
$bank_type = Request::r('bank_type') ? Request::r('bank_type') : 'ICBC';

$randNumber = rand('100000','999999');
$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);
$out_trade_no = "wy".date('ymdHis',time()). $rands;//订单号
$u_id = $userInfo['u_id'];

//定义 网银行使用的跳转处理页面


if($bank_type=="jdPayDebitCredit"){	
	$accessType 	= Request::r('accessType');
	$iframe_url=ROOT_DOMAIN."/merchant/com/cskj/pay/demo/page/payStart_jdPayDebitCredit.php?total_fee=".number_format($payment,2)."&out_trade_no=".$out_trade_no."&u_id=".$userInfo['u_id']."&accessType=".$accessType;
	
}elseif($bank_type=="zxwy"){
	$iframe_url=ROOT_DOMAIN."/merchant/com/cskj/pay/demo/page/payStart_zxwy.php?total_fee=".$payment."&out_trade_no=".$out_trade_no;
}elseif($bank_type=="jdPay"){
	$out_trade_no = "wyjd".date('ymd',time()). $rands;//订单号
	$accessType 	= Request::r('accessType');
	$iframe_url=ROOT_DOMAIN."/merchant/com/cskj/pay/demo/page/payStart_jdPay.php?total_fee=".$payment."&out_trade_no=".$out_trade_no."&u_id=".$userInfo['u_id']."&accessType=".$accessType;	
}elseif($bank_type=="jdQpay"){//京东快捷支付
	$iframe_url=ROOT_DOMAIN."/merchant/com/cskj/pay/demo/page/payStart_jdQpay.php?total_fee=".$payment."&out_trade_no=".$out_trade_no;
}else{//网银支付
echo "a";
	$out_trade_no = "wy".$bank_type.date('ymd',time()). $rands;//订单号
	$iframe_url=ROOT_DOMAIN."/merchant/com/cskj/pay/demo/page/payStart.php?total_fee=".$payment."&out_trade_no=".$out_trade_no."&bankCode=".$bank_type."&directPay=1&u_id=".$userInfo['u_id'];
}



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


$tpl->assign('iframe_url', $iframe_url);

$tpl->assign('total_fee', $payment);
$tpl->assign('payment', $payment);
$tpl->assign('bank_type', $bank_type);
$tpl->assign('out_trade_no', $out_trade_no);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);

$YOKA ['output'] = $tpl->r ( 'zxwy' );
echo_exit ( $YOKA ['output'] );