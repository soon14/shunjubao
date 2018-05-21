<?php
/**
 *功能：下单账单
 *版本：1.0
 *修改日期：2016-06-28
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
	'appId' => pp_conf::APP_ID,  // 应用ID
	'signType' => 'md5',
	'billType' => 11,
	'billDate' => '20160628'
	
);

$returnJson = $pp_sdk->download_bill($params); //下载账单
$result = json_decode($returnJson);  //解析返回结果

var_dump($result);