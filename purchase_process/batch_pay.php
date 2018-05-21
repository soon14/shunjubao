<?php
/**
 * 购物流程之：批量订单付款
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//pr($_REQUEST);
$userInfo = Runtime::getUser();
# 支付商
$provider 	= Request::r('provider');
$payment 	= Request::r('payment');//单位为元
$uid 		= Request::r('uid');

if ($uid != $userInfo['u_id']) {
	fail_exit_g("无效用户");
}

if (!Verify::money($payment)) {
	fail_exit_g("无效的金额");
}

if (empty($provider)) {
	$provider = 'alipay';
}

# 银行
# TODO 有待进一步处理，不指定bank_type时，支付平台校验会出错，查下原因
$bank_type = Request::r('bank_type') ? Request::r('bank_type') : 'ICBC';

if($bank_type=="alipay_transfer"){	//支付宝转帐到客服帐号
	$tmpUrl = ROOT_DOMAIN."/account/transfer_alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="alipay"){
	echo "需充值的会员请联系客服进行手工充值（客服微信：a37573231 QQ:2733292184）为避免充不上，请于赛前20分钟完成充值";
	exit;
}

if($bank_type=="perALIPAY_test"){	//派洛支付宝
	$tmpUrl = ROOT_DOMAIN."/account/perALIPAY_test.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="perALIPAY"){	//派洛支付宝
	$tmpUrl = ROOT_DOMAIN."/account/per_alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}



if($bank_type=="perWeixin"){	//派洛微信
	$tmpUrl = ROOT_DOMAIN."/account/per_alipay.php?ptype=wx&payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="pertenpay"){	//派洛微信
	$tmpUrl = ROOT_DOMAIN."/account/per_alipay.php?ptype=tenpay&payment=".$payment;
	redirect($tmpUrl);
	exit;
}


if($bank_type=="cibALIPAY"){	//兴业银行支付宝扫码
	$tmpUrl = ROOT_DOMAIN."/account/cib_alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="cib2ALIPAY"){	//新兴业支付宝扫码
	$tmpUrl = ROOT_DOMAIN."/account/cib2_alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="cib2h5ALIPAY"){	//兴业银行h5
	$tmpUrl = ROOT_DOMAIN."/account/cib2_h5alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="ALIPAY2"){	//支付宝扫码
	$tmpUrl = ROOT_DOMAIN."/account/zx_alipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}




if($bank_type=="wx"){	//中信网银_微信
	$tmpUrl = ROOT_DOMAIN."/account/mppay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="rhwx"){	//融汇_微信
	$tmpUrl = ROOT_DOMAIN."/account/rhmppay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}

if($bank_type=="rhALIPAY"){	//融汇_支付宝
	$tmpUrl = ROOT_DOMAIN."/account/rhalipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}


if($bank_type=="yzbALIPAY"){//yizhibank_支付宝
	$tmpUrl = ROOT_DOMAIN."/account/yzbalipay.php?payment=".$payment;
	redirect($tmpUrl);
	exit;
}




if($bank_type=="zxwy"){	//中信  快捷支付
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=zxwy";
	redirect($tmpUrl);
	exit;
}
if($bank_type=="jdPayDebitCredit"){	//中信  京东支付移动
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=jdPayDebitCredit&accessType=1";
	redirect($tmpUrl);
	exit;
}

if($bank_type=="jdPayDebitCredit_wap"){	//中信  京东支付移动
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=jdPayDebitCredit&accessType=2";
	redirect($tmpUrl);
	exit;
}


if($bank_type=="jdPay"){	//中信  京东支付移动
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=jdPay&accessType=1";
	redirect($tmpUrl);
	exit;
}

if($bank_type=="jdQpay"){	//中信  京东支付移动
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=jdQpay";
	redirect($tmpUrl);
	exit;
}


if($bank_type=="jdPay_wap"){	//中信  京东支付移动
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=jdPay&accessType=2";
	redirect($tmpUrl);
	exit;
}



$zxwy_bank_array=array("CMB1","ICBC1","CCB1","BOC1","ABC1","BOCM1","SPDB1","CGB1","CITIC1","CEB1","CIB1","PAYH1","CMBC1","BCCB1","PSBC1","HXB1","SHBANK1");

if(in_array($bank_type,$zxwy_bank_array)){//中信网银
	$tmpUrl = ROOT_DOMAIN."/account/zxwy.php?payment=".$payment."&bank_type=".substr($bank_type,0,-1);
	redirect($tmpUrl);
	exit;
}

#易宝支付2016720 PaulHE
$yee_bank_array=array("ICBC-NET-B2C","CCB-NET-B2C","CMBCHINA-NET-B2C","BOCO-NET-B2C","CIB-NET-B2C","CMBC-NET-B2C","CEB-NET-B2C","BOC-NET-B2C","PINGANBANK-NET-B2C","ECITIC-NET-B2C","SDB-NET-B2C","SDB-NET-B2C","GDB-NET-B2C","SHB-NET-B2C","SPDB-NET-B2C","HXB-NET-B2C","BCCB-NET-B2C","ABC-NET-B2C","POST-NET-B2C");
if(in_array($bank_type,$yee_bank_array)){	
	$tmpUrl = ROOT_DOMAIN."/account/yeepay.php?payment=".$payment."&uid=".$uid."&bank_type=".$bank_type;
	redirect($tmpUrl);
	exit;
}







$out_trade_no = createUniqueOutTradeNo();

##################################

$u_id = $userInfo['u_id'];

#######################################
# 真实流程是不可能流转到这一步的。因为如果无需再额外支付金额，则在 下订单那步，就已经处理完了。#
if ($payment == 0) {
	fail_exit_g("不可能走到这里");
}
#######################################
if($bank_type=="twjALIPAY"){
	$notify = "notify_twjpay.php";
	
	$web_site = "http://pay.manyitmall.com";
	//$web_site = ROOT_DOMAIN;
	
}else{
	$notify = "notify_pay.php";
	$web_site = ROOT_DOMAIN;
}

/*$file = "tmp.txt";
$word=$web_site;
$fp = fopen($file,"a");
flock($fp, LOCK_EX) ;
fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
flock($fp, LOCK_UN);
fclose($fp);*/

$payParams = array(
    'notify_url'    => $web_site . '/services/'.$notify,
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

#获取支付url
$objPayCenterClient = new PayCenterClient();
$tmpResult = $objPayCenterClient->getsBankPayUrl($payParams, $providerAndbanks);
if (!$tmpResult->isSuccess()) {
    fail_exit_g("生成支付url失败，原因：".$tmpResult->getData());
}

#记录充值日志
$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->initUserCharge($payParams, $provider,$bank_type);
if (!$tmpChargeResult) {
    fail_exit_g("记录充值日志失败，原因：".$tmpChargeResult->getData());
}

$payUrls = $tmpResult->getData();
$tmpUrl = array_pop($payUrls);
$tmpUrl = $tmpUrl['pay_url'];
//pr($tmpResult);
redirect($tmpUrl);
exit;
