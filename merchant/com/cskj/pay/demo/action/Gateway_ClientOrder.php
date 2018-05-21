<?php

namespace com\cskj\pay\demo\action;

use com\cskj\pay\demo\common\ConfigUtil;
use com\cskj\pay\demo\common\HttpUtils;
use com\cskj\pay\demo\common\SignUtil;
use com\cskj\pay\demo\common\TDESUtil;
include '../common/ConfigUtil.php';
include '../common/SignUtil.php';
include '../common/HttpUtils.php';
include '../common/TDESUtil.php';
class ClientOrder{
	public function execute(){
		$param;
		if($_POST["tradeType"] != null && $_POST["tradeType"]!=""){
		    $param["tradeType"]=$_POST["tradeType"];
		}
		if($_POST["version"] != null && $_POST["version"]!=""){
		    $param["version"]=$_POST["version"];
		}
		if($_POST["channel"] != null && $_POST["channel"]!=""){
		    $param["channel"]=$_POST["channel"];
		}
		if($_POST["mchId"] != null && $_POST["mchId"]!=""){
		    $param["mchId"]=$_POST["mchId"];
		}
		if($_POST["body"] != null && $_POST["body"]!=""){
		    $param["body"]=$_POST["body"];
		}
		if($_POST["outTradeNo"] != null && $_POST["outTradeNo"]!=""){
		    $param["outTradeNo"]=$_POST["outTradeNo"];
		}
		if($_POST["amount"] != null && $_POST["amount"]!=""){
		    $param["amount"]=$_POST["amount"];
		}
		if($_POST["description"] != null && $_POST["description"]!=""){
		    $param["description"]=$_POST["description"];
		}
		if($_POST["currency"] != null && $_POST["currency"]!=""){
		    $param["currency"]=$_POST["currency"];
		}
		if($_POST["timePaid"] != null && $_POST["timePaid"]!=""){
		    $param["timePaid"]=$_POST["timePaid"];
		}
		if($_POST["timeExpire"] != null && $_POST["timeExpire"]!=""){
		    $param["timeExpire"]=$_POST["timeExpire"];
		}
		if($_POST["subject"] != null && $_POST["subject"]!=""){
		    $param["subject"]=$_POST["subject"];
		}
		if($_POST["limitPay"] != null && $_POST["limitPay"]!=""){
		    $param["limitPay"]=$_POST["limitPay"];
		}
		if($_POST["openId"] != null && $_POST["openId"]!=""){
		    $param["openId"]=$_POST["openId"];
		}
		if($_POST["notifyUrl"] != null && $_POST["notifyUrl"]!=""){
		    $param["notifyUrl"]=$_POST["notifyUrl"];
		}
		if($_POST["goodsTag"] != null && $_POST["goodsTag"]!=""){
		    $param["goodsTag"]=$_POST["goodsTag"];
		}
		if($_POST["authCode"] != null && $_POST["authCode"]!=""){
		    $param["authCode"]=$_POST["authCode"];
		}
		if($_POST["callbackUrl"] != null && $_POST["callbackUrl"]!=""){
		    $param["callbackUrl"]=$_POST["callbackUrl"];
		}
		
		if($_POST["directPay"] != null && $_POST["directPay"]!=""){
		    $param["directPay"]=$_POST["directPay"];
		}
		
		if($_POST["accessType"]!=""){
		    $param["accessType"]=$_POST["accessType"];
		}
		
		
		
		if($_POST["directPay"] ==1 && $_POST["directPay"] != null && $_POST["directPay"]!=""){
			
			//银行代码转换
			if($_POST["bankCode"]=="CCB"){//建设银行
				$bankCode ="1051";
			}elseif($_POST["bankCode"]=="CMB"){	//招商银行
				$bankCode ="3080";
			}elseif($_POST["bankCode"]=="ABC"){//农业银行
				$bankCode ="103";
			}elseif($_POST["bankCode"]=="BOC"){//中国银行
				$bankCode ="104";
			}elseif($_POST["bankCode"]=="CITIC"){//中信银行	
				$bankCode ="313";
			}elseif($_POST["bankCode"]=="CGB"){	//广发银行
				$bankCode ="3061";
			}elseif($_POST["bankCode"]=="CEB"){	//光大银行
				$bankCode ="312";
			}elseif($_POST["bankCode"]=="PAYH"){//平安银行	
				$bankCode ="307";
			}elseif($_POST["bankCode"]=="CIB"){	//兴业银行
				$bankCode ="309";
			}elseif($_POST["bankCode"]=="ICBC"){	//工商银行
				$bankCode ="1025";
			}elseif($_POST["bankCode"]=="BOCM"){//交通银行
				$bankCode ="3407";
			}elseif($_POST["bankCode"]=="PSBC"){//邮政
				$bankCode ="3230";
			}elseif($_POST["bankCode"]=="SPDB"){//浦发银行
				$bankCode ="314";
			}elseif($_POST["bankCode"]=="HXB"){	//华夏银行
				$bankCode ="311";
			}elseif($_POST["bankCode"]=="SHBANK"){//上海银行	
				$bankCode ="326";			
			}else{
				exit("对不起,您选择的银行类型不支持");
			}
			
		    $param["bankCode"]=$bankCode;
		}
		

		
	
		
		$oriUrl = $_POST["saveUrl"];
		$unSignKeyList = array ("sign");

		//echo  $_POST["currency"];
// 		$desKey = ConfigUtil::get_val_by_key("desKey");
		$sign = SignUtil::signMD5($param, $unSignKeyList);
		$param["sign"] = $sign;
		$jsonStr=json_encode($param);
		//echo $jsonStr;
		$serverPayUrl=ConfigUtil::get_val_by_key("serverPayUrl");

		$httputil = new HttpUtils();
		list ( $return_code, $return_content )  = $httputil->http_post_data($serverPayUrl, $jsonStr);
	//	echo $return_content;
	
		log_result_co("ClientOrder_return_content.txt",$return_content);
		$respJson=json_decode($return_content,true);
		
		if(!empty($respJson["payCode"])){
			 $url = $respJson["payCode"];
	
			header("location:".$url);
			exit();
		}else{
			echo $respJson["errCodeDes"]."\n\r请重新支付;";
			exit();
		}
		exit();
		//var_dump($respJson);
	//	die();
		//echo $respJson;
		$respSign = SignUtil::signMD5($respJson, $unSignKeyList);
		echo $respSign;
		
		if($respSign !=  $respJson['sign']){
			echo '验签失败！';
		}else{
			if($responseJson['returnCode'] == '0' && $responseJson['resultCode'] == '0'){
				echo $responseJson['payCode'];
			}else{
				echo $return_content;
			}
			
		}
	
	}
	
}
error_reporting(0);
$m = new ClientOrder();
$m->execute();




function  log_result_co($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}


?>