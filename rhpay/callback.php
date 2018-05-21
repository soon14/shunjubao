<?php
include_once ("config.inc.php");

$data = file_get_contents("php://input");
log_result("callback.txt",$data);

$r5_business = get_param('r5_business');//业务 WX
$trxType = get_param('trxType');//接口类型 WX_SCANCODE
$r4_bankId = get_param('r4_bankId');//银行编码 WX
$r8_orderStatus = get_param('r8_orderStatus');//SUCCESS
$sign = get_param('sign');
$r1_merchantNo = get_param('r1_merchantNo');//商户编号
$r9_serialNumber = get_param('r9_serialNumber');//平台序列号
$r3_amount = get_param('r3_amount');//金额
$retCode = get_param('retCode');//处理结果码
$r7_completeDate = get_param('r7_completeDate');//系统订单完成时间
$r2_orderNumber = get_param('r2_orderNumber');//商户订单号
$r10_t0PayResult = get_param('r10_t0PayResult');//T0，T1 标识
if($retCode=="0000" && $r8_orderStatus=="SUCCESS"){

	$outTradeNo = $r2_orderNumber;
	$total_fee = $r3_amount;
	$trade_status = $r8_orderStatus;
	$keyw = "zy3658786787676";
	$dtime = time();
	$sign = md5($outTradeNo.$keyw.$dtime);
	$turl='http://www.zhiying365.com/services/wypay_return.php?out_trade_no='.$outTradeNo.'&total_fee='.$total_fee.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$r1_merchantNo;
	log_result("callback_url.txt",$turl);
	$result = file_get_contents($turl);
	echo 'SUCCESS';
	// header("location: /account/user_center.php?p=charge_log");
	
	
}else{
		log_result("callback_error.txt",$data);
}


/* $merchantNo = "B100001906";
 $goodsName = "智赢充值"; 
 $callbackUrl = "http://www.zhiying365.com/rhpay/callback.php"; 
 $serverCallbackUrl = "http://www.zhiying365.com/rhpay/serverCallback.php";  
 $toibkn = "310651000048";//行号
 $cardNo = "6217921851778004";//帐号
 $idCardNo = "420104197805052010";//身份证
 $payerName = "梁澋铖";
 $encrypt = "T0";	*/
	


?>