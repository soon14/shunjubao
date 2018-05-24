<?php
/**
 *功能：创建订单
 *版本：1.0
 *修改日期：2016-06-08
 '说明：
 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的需要，按照技术文档编写,并非一定要使用该代码。
 '该代码仅供学习和研究派洛贝云计费接口使用，只是提供一个参考。
 */

if (!defined("prlpay_sdk_ROOT"))
{
	define("prlpay_sdk_ROOT", dirname(__FILE__) . DIRECTORY_SEPARATOR);
}
 
require_once(prlpay_sdk_ROOT . 'pearlpay_sdk.php');

$subject = trim($_GET["subject"]);

$payType = trim($_GET["payType"]);
$payAmount = trim($_GET["payAmount"]);
$outTradeNo = trim($_GET["out_trade_no"]);


$pp_sdk = new prlpay_sdk();

$params = array(
	'version' => 1, // 版本号
	'subject' => $subject, // 订单名称
	'outTradeNo' => $outTradeNo, //outTradeNo，唯一
	'appId' => pp_conf::APP_ID,  // 应用ID
	'payType' => $payType, // 支付方式 , 可选
	'payAmount' => $payAmount, // 支付金额
	'spUno' => $_GET['u_id'] ? $_GET['u_id'] : 'test'.time() ,  // 用户唯一ID
	'signType' => 'md5',
	'notifyUrl' => 'http://www.shunjubao.xyz/other_payapi/pearlpay/notify.php',
	
);




$returnJson = $pp_sdk->create_order($params); //创建订单
$result = json_decode($returnJson);  //解析返回结果


if($result->retCode === 0){  //retCode = 0 为创建成功
	$payNo = $result->data->payNo;
	$to_ali_url =  pp_conf::PP_PAY_EXCHANGE_URL.'?version=1&payNo='.$payNo.'&payType='.$params['payType'];
	echo $to_ali_url;
	//header("Location: ".$to_ali_url); 
	exit();
	
	
	

	echo '创建订单成功，payNo = '.$payNo . '<br>';
	//组装支付链接
	echo '<a href="'.pp_conf::PP_PAY_EXCHANGE_URL.'?version=1&payNo='.$payNo.'&payType='.$params['payType'].'" target="_blank">支付链接</a><br>'; // payType=31 为百度钱包支付方式
	echo '<a href="query.php?version=1&payNo='.$payNo.'" target="_blank">查看支付结果</a>'; 


}else{
	var_dump($result);
	die('创建订单失败' );
}