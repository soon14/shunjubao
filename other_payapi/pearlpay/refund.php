<?php
/**
 *功能：申请退款
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

$params = array(
	'version' => 1, // 版本号
	'outRefundNo' => $_GET['outRefundNo'],//'refund_uid_'.microtime(true), //outRefundNo，唯一
	'payNo' => $_GET['payNo'],  // 支付编号
	'appId' => pp_conf::APP_ID,  // 应用ID
	'refundType' => 2, // 退款方式 ， 退款到第三方账户
	'refundAmount' => $_GET['refundAmount'], // 支付金额
	'signType' => 'md5',
	'notifyUrl' => 'http://dev.peralppay.com/demo/notify.php',
);

$returnJson = $pp_sdk->refund_order($params); //创建订单
$result = json_decode($returnJson);  //解析返回结果


if($result->retCode == 0){  //retCode = 0 为创建成功
	$refundNo = $result->data->refundNo;
	echo '申请退款成功，refundNo = '.$refundNo . '<br>';
	//组装支付链接
	echo '<a href="queryRefund.php?version=1&refundNo='.$refundNo.'" target="_blank">查看退款结果</a>'; 
}else{
	var_dump($result);
	die('申请退款失败' );
}