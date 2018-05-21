<?php
namespace com\cskj\pay\demo\action;
use com\cskj\pay\demo\common\XMLUtil;
use com\cskj\pay\demo\common\ConfigUtil;
include '../common/ConfigUtil.php';
include '../common/XMLUtil.php';
class AsynNotifyAction{
	public function execute(){
		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><jdpay> <version>V2.0</version> <merchant>22294531</merchant> <result> <code>000000</code> <desc>success</desc> </result> <encrypt>NWI4MTBiNWNlMmRkZDdlYThjNjc0YmY1ZWJlY2QyODU0YTc5NmQ3ZWQxMWU1NzE3MWQ0OTUwOGI5NzllYmE4ZjM1YzRiZjlmYWE1M2ZiYjVmYzBmYTgyMDYyM2Q0YjM0NGM1ODFkZDhlYTA2Mjk0ZDE5ZDBlZDk5NTc3MmE4Nzk4OTFlYjIwZDgzMTc4MDU3NGVkZTFjNDY0MDMzNzNjZjc2OWZiMDQ0YjVhZGNhYmRhMGZmYTkyNzRhZDNhM2IxOGY5ZjZhYjBmYjhmZmI3Yzg0OTA3YzM0OGJmZTYwZTIzNzM3YjVmYzMzNmNkYTE0MjM2OWIwZDM5MjI2YWM5YmY3ZmZjZDBkNWJmM2ZkYWY4YTU3OWU4MDE3ZjQ5YmQ0ZWIyMDA0NTFmODZkNmViMDBiMDE2YTU3NTNjMzJjNDIzNWI5ZDkyYzQ3OTU4OTc2YzBiMDdmNWQ0MzIyZTEyZjMyM2VjY2U2NTYxNWRiNTMzNWI5ZDkyYzQ3OTU4OTc2NmIwM2QyZTU1ODJlNDNjM2M1NjA2YmQ5ZDc3MTRkMmNjN2ZiMDM3Yzg5ZDk1ODFkZGRiMmZhYTc4MDkyZmEwY2RlMzQwYzgzZDg5MTY0ZTZjODc4YjNmNTFmMTNhMjE0MzM1ZGM4YjI5MzhjNGQ1ZTU0YjkwMDJlMWI5ODg3MTk3MjM4MjI3ZmMwMjUzMThkZGIyMGM5Njg2Yjc5Y2QwNDcwNjI1YTc3ZWQ1ZTEyMzU2NTI2ZjljNTQ2NmQ5Yzc3YjRjMzZkOGI0NGYxYzllMzViMGYyNmJiMzA1ZjM3MDNhMjg5ODUyZTU0YWUzNTVlZjE0M2Y4OTY1ZjU3Y2UyM2U4ODU5MGRhODcwMDg0MDRjY2NiNmZlYTYzYzkwOTEyOTMzNDc3YzZiNzdiY2UwMjBlMzU5MzEyN2FiYWU4NzMxMjgyYTQwN2I3YTVjMjJlZDM2YmQ3NWE1N2VjNTQxNWI3MDYwMTk4ZTRlNmNlN2RjMWM2NjE1YTAzNWU5MmJkYTFkMzFiNTYwMTQwYTQ0YzZjMDQzYzE2YWYzMmQ4MzZmNGQyNDcwZDE0ZWRjMmQxYjgxMzhhNjA5M2ZlNDkxYTQyMzE5YzBlNTA0MTdkYTg2ZGQ2NDQwODBmMjM4ZGI2YzIzMjNhOTE0M2VmMjZiZjczN2M5NWQwODYxMWY2OGE5MDQ0ZDZmNzE0NmIxZjQwZDdmZDMxOTQ2ZDM3YjIwNDJiODUzZGM0NTk0MzM5YzJkN2M2NDdiNGM4MzQ4MTRjZTIxZTlmYTYzNDYxNGMxMjlhZTE3NjE0ZDIzM2Q2MTQ4YzJiNWE3ZWVjMDU5MjFmNzJkNGNjNTU1NWZkNzVhN2U5Y2I1MDU1NjhlMWRlNjVhNzkyOGUxMThlODQyMGJkNzE2NjdmMDc3YmEyYTFkNmQyOTFiOGNjZTU2ZGMyYmE2MWZhZWYyNTI5ODFhMTk5OGQ5ZmY5YTkyZTM2ZDU0MDY2Y2E5NjI0N2I1MGE4MTliMDBkNGIzNmViZTJlY2JmYTcwODUzYTM5ZTcwMDVmYWEzNWY2MDFhMWM2MGQ1MzE4MmZjMjNlMmYwYzRmOGE2ZDc0OGFkMGQ0ODJlNTgxOTIxNmNmYTkwMDkwNDNhOWFkNzQ4YWQwZDQ4MmU1ODE5ZjE3OWUzMDc2NWRiNGY0YWQ5NWIzOTY3NzViNWIyYmU0ZWU1NzE3MGNiODNjOGFjZDZiZDU5NGE2Nzk2ZGMxMjgyMGU5OTY5OGUxN2M1ZGZkNzQ4YWQwZDQ4MmU1ODE5ZDEwOWUwOTRhMDA5MDQ4YzMwY2M1N2E0Y2FlZDEwOWRkNDRiODVjMzRiNjhkYTM3YmEwNDZlNmNlODU5M2NkYzhlODdhNzRmZGViNDUyODVhOWRmOGM4NmFjNTNjZTA4ODVmNDY4OTA5YTdjMjlmNTk1OGQ2ODU4ZDYxNWQwMzA5ZmNjOTlmNmU5ZTMwZTVkYjI3YmRlYTQ5NTMxYjEyOTIxZmI0ZmE2ZTk0ZGI2NDZmYzgzMWJlMGRkZWYxNDkzZTJiMWY2Y2Q0MGNjMDg5M2VlM2Y5MmQzZTM2YmVjYzM3NmVhMjc2ZGFiYTk1M2Q4NTMwYmE3OTJiNGI2NWQyNzNhNjg5Y2I5YWYzZjU3ZWNkNTI4ODVjOGJmZGVlZTMyYWNmM2U4OWVhY2I3ZWRjNDM3ZmI4YzQyMzhjZTRhYzk3YzA5ZTk1MDQyM2YyZDQ3YzQyZDNkNDUxYTI3MWVmMw==</encrypt></jdpay>";
		$resdata;
		$falg = XMLUtil::decryptResXml($xml, $resdata);
		if(falg){
			echo "验签成功";
			echo json_encode($resdata);
		}else{
			echo "验签失败";
		}
	}
}





$param=file_get_contents('php://input', 'r');


log_result("AsynNotifyAction_phpinput.txt",$param);

$r = json_decode($param,true);
	
$amount = trim($r["amount"]);
$mchId = trim($r["mchId"]);
$resultCode = trim($r["resultCode"]);//0：成功、1：失败
$channel = trim($r["channel"]);//gateway网关
$sign = trim($r["sign"]);//gateway网关
$body = trim($r["body"]);//gateway网关
$outChannelNo = trim($r["outChannelNo"]);//07862531201704240000000081
$payChannelType = trim($r["payChannelType"]);//rongbao
$outTradeNo = trim($r["outTradeNo"]);//outTradeNo
$currency = trim($r["currency"]);//CNY
$status = trim($r["status"]);//02


if($resultCode=="0"){//支付成功

	$total_fee = $amount;
	$trade_status = $outTradeNo;
	$keyw = "zy3658786787676";
	$dtime = time();
	$sign = md5($outTradeNo.$keyw.$dtime);
	$turl='http://www.shunjubao.com/services/wypay_return.php?out_trade_no='.$outTradeNo.'&total_fee='.$amount.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$outChannelNo;
	log_result("AsynNotifyAction_url.txt",$turl);
	$result = file_get_contents($turl);
	 echo 'success';
	 header("location: /account/user_center.php?p=charge_log");
	 exit();
}else{
	 echo 'fail';
	 exit();
}


error_reporting(0);
$m=new AsynNotifyAction();
$m->execute();







function  log_result($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}




?>





