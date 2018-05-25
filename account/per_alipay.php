<?php
/**
 * 中信支付宝支付
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
header("Content-type: text/html; charset=utf-8"); 
#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();
$tpl = new Template();


#标题
$TEMPLATE ['title'] = "聚宝网充值中心-支付宝支付！ ";
$TEMPLATE['keywords'] = '聚宝网充值中心-支付宝支付！';
$TEMPLATE['description'] = '聚宝网充值中心-支付宝支付！。';

#埋藏跳转页面
$payment 	= Request::r('payment');//单位为元，充值金额
$uid 		= Runtime::getUid();
$ptype = Request::r('ptype');
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


$randNumber = rand('10000','99999');
$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);


if($ptype=="wx"){
	$provider = 'weixin';
	$pname = '微信';
	$out_trade_no = "perwx".date('YmdHis',time()). $rands;//订单号
	$payType=21;
	
}elseif($ptype=="tenpay"){
	$provider = 'tenpay';
	$pname = '财付通QQ钱包';
	$out_trade_no = "pertenpay".date('YmdHis',time()). $rands;//订单号
	$payType=71;	
	
}else{
	$pname = '支付宝';
	$out_trade_no = "per".date('YmdHis',time()). $rands;//订单号
	$payType=11;
}	


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

$mch_create_ip = Request::getIpAddress();
$subject = "聚宝商城";
$attach = "聚宝商城";
$total_fee = $payment*100;




$get_ali_url = "http://www.shunjubao.xyz/other_payapi/pearlpay/index.php?subject=$subject&payAmount=$total_fee&payType=".$payType."&out_trade_no=$out_trade_no&u_id=$u_id";
$to_ali_url = file_get_contents($get_ali_url);


//var_dump();

/*header("Location: ".$to_ali_url); 
exit();*/

$tpl->assign('to_ali_url', $to_ali_url);


$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);
$tpl->assign('to_ali_url', $to_ali_url);
$tpl->assign('total_fee', $total_fee);
$tpl->assign('payment', $payment);
$tpl->assign('mch_create_ip', $mch_create_ip);
$tpl->assign('subject', $subject);
$tpl->assign('attach', $attach);
$tpl->assign('pname', $pname);
$tpl->assign('out_trade_no', $out_trade_no);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);

$YOKA ['output'] = $tpl->r ( 'per_alipay' );
echo_exit ( $YOKA ['output'] );