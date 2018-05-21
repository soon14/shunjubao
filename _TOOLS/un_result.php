<?php
/**
 * 获取小何异常赛果数据,并发送通知信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$objUnResult = new UnResult();
$objUnResult_fb_list = $objUnResult->getUnResult("fb");
$objZYShortMessage = new ZYShortMessage();

$moblie = array("15295466220");


/*$moblie = "13602484941";
$data["ballid"] = "5001";
$data["lotttime"] = "2016-05-22";
$result = $objZYShortMessage->sendDataAbort($moblie,"fb_".$data["ballid"], $data["lotttime"]);

die("ssssssssss");*/

if($objUnResult_fb_list){
	foreach ($objUnResult_fb_list as $data) {	
	
		for($i=0;$i<count($moblie);$i++){
			 $objZYShortMessage->sendDataAbort($moblie[$i],"fb_".$data["ballid"], $data["lotttime"]);
		}
		 log_result_error("fb".$data["ballid"],'objZYShortMessage');
		//var_dump($result);exit();
	}
}


$objUnResult_bk_list = $objUnResult->getUnResult("bk");
if($objUnResult_bk_list){
	
	foreach ($objUnResult_bk_list as $data) {	
		 for($i=0;$i<count($moblie);$i++){
			 $objZYShortMessage->sendDataAbort($moblie[$i],"bk_".$data["ballid"], $data["lotttime"]);
		}
		log_result_error("bk".$data["ballid"],'objZYShortMessage');
	}
}


?>