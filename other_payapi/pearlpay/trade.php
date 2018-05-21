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

$pp_sdk = new prlpay_sdk();

session_start();

$params = array(
	'version' => 1, // 版本号
	'subject' => 'test', // 订单名称
	'outTradeNo' => 'order_uuid_'.microtime(true), //outTradeNo，唯一
	'appId' => pp_conf::APP_ID,  // 应用ID
	'payType' => 31, // 支付方式 , 可选
	'payAmount' => 1, // 支付金额
	'spUno' => $_GET['uid'] ? $_GET['uid'] : session_id() ,  // 用户唯一ID
	'extInfo' => 'needLogin%3D0',
	'signType' => 'md5',
	'notifyUrl' => 'http://localhost/notify.php',
	'returnUrl' => 'http://peralppay.com?a=xx'
	
);

$returnJson = $pp_sdk->create_order($params); //创建订单
$result = json_decode($returnJson);  //解析返回结果

if($result->retCode == 0){  //retCode = 0 为创建成功
	$payNo = $result->data->payNo;
	echo '创建订单成功，payNo = '.$payNo . '<br>';
	//组装支付链接
	echo '<a href="'.pp_conf::PP_PAY_EXCHANGE_URL.'?version=1&payNo='.$payNo.'&payType='.$params['payType'].'" target="_blank">支付链接</a><br>'; // payType=31 为百度钱包支付方式
	echo '<a href="query.php?version=1&payNo='.$payNo.'" target="_blank">查看支付结果</a>'; 


}else{
	var_dump($result);
	die('创建订单失败' );
}
