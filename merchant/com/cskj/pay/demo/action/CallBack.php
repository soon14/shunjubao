<?php
namespace com\cskj\pay\demo\action;

use com\cskj\pay\demo\common\ConfigUtil;
use com\cskj\pay\demo\common\TDESUtil;
use com\cskj\pay\demo\common\SignUtil;
use com\cskj\pay\demo\common\RSAUtils;
include '../common/ConfigUtil.php';
include '../common/TDESUtil.php';
include '../common/SignUtil.php';

class CallBack{
	public function execute(){
	    $param;

		
		$amount = trim($_POST["amount"]);
		$mchId = trim($_POST["mchId"]);
		$resultCode = trim($_POST["resultCode"]);//0：成功、1：失败
		$channel = trim($_POST["channel"]);//gateway网关
		$sign = trim($_POST["sign"]);//gateway网关
		$body = trim($_POST["body"]);//gateway网关
		$outChannelNo = trim($_POST["outChannelNo"]);//07862531201704240000000081
		$payChannelType = trim($_POST["payChannelType"]);//rongbao
		$outTradeNo = trim($_POST["outTradeNo"]);//outTradeNo
		$currency = trim($_POST["currency"]);//CNY
		$status = trim($_POST["status"]);//02
		
		
		

		if($resultCode=="0"){//支付成功
			
			
			 
			$total_fee = $amount;
			$trade_status = $outTradeNo;
			$keyw = "zy3658786787676";
			$dtime = time();
			$sign = md5($outTradeNo.$keyw.$dtime);
			$turl='http://news.shunjubao.com/services/wypay_return.php?out_trade_no='.$outTradeNo.'&total_fee='.$amount.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$outChannelNo;
			log_result("CallBack.txt",$turl);
			$result = file_get_contents($turl);
			 echo 'success';
			 
			 
			 header("location: /account/user_center.php?p=charge_log");
			 exit();
			
		}else{
			 echo 'fail';
			 exit();
		}

		
		//-------------------
		$unSignKeyList = array ("sign");
		 
		//echo  $_GET["currency"];
		// 		$desKey = ConfigUtil::get_val_by_key("desKey");
       $param=json_encode(file_get_contents('php://input'));
	   log_result("call_back.txt",$param);
	   
	   
	   $sign = $param['sign'];//SignUtil::signMD5($param, $unSignKeyList);
		//echo $param;
        //echo $param;
        $respJson=json_decode($param,true);
		
		
		
	
		
		die("====");
		//echo gettype($respJson);
 		//echo $respJson;
 		$sign = $respJson['sign'];
		echo "====";
		echo $sign;
        $respSign = SignUtil::signMD5($respJson, $unSignKeyList);
		//echo "respSign=";
		echo $respSign;
		
		if($sign!=$respSign){
			echo "验证签名失败！";
		}else{
			echo "验证签名成功！";
			$_SESSION["tradeResultRes"]=$param;
			header("location:../page/success.php");
		}
		
	}
}


//log_result("call_back.txt","aaaaaaaaaa");

function  log_result($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

error_reporting(0);
$m = new CallBack();
$m->execute();
?>