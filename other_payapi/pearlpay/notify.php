<?php
/**
 *功能：接收并处理通知
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

$postParams = $_POST["transData"];//post参数
$pp_sdk = new prlpay_sdk();

//日志上报
$paramsData = array();

if(!empty($postParams)){
    $postArr = array();
    parse_str($postParams, $postArr);
    $paramsData = array_merge($paramsData, $postArr);
}



$arrParams = json_decode($postParams,true);
if($pp_sdk->test_sign($arrParams)){
	
	//{"appId":"aa10015db2dd430b","outTradeNo":"per20171017184908051077","payAmount":"110","payNo":"2017101796317174852","payTime":"20171017184915","payType":"11","privateInfo":"","sign":"6d98c47fabd04c2e21409117e597ffa5","signType":"md5","state":"1"}

	$will_out_trade_no = $arrParams["outTradeNo"];
	$will_mchId = $arrParams["appId"];
	
	$keyw = "zy3658786787676";
	$dtime = time();
	$sign = md5($will_out_trade_no.$will_mchId.$keyw.$dtime);
	$turl='http://www.shunjubao.xyz/services/mppay_update.php?will_out_trade_no='.$will_out_trade_no.'&will_mchId='.$will_mchId.'&dtime='.$dtime.'&sign='.$sign; 
	$result = file_get_contents($turl);

	$total_fee  = ($arrParams["payAmount"]/100);
	$out_trade_no =  $arrParams["outTradeNo"];
	$trade_status =  $arrParams["outTradeNo"];	
	$keyw = "zy3658786787676";
	$dtime = time();
	$sign = md5($out_trade_no.$keyw.$dtime);
	
	$turl='http://www.shunjubao.xyz/services/mppay_return.php?out_trade_no='.$out_trade_no.'&total_fee='.$total_fee.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$will_mchId;
	
	$result = file_get_contents($turl);
	log_result("ali_error_log.txt",$turl);//exit();

	
	

	
	
	
	// 验签成功,do sth
	echo 'success';
}else{
	echo "\n".'fail'."\n";
}






function  log_result($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}
