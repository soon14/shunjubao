<?php
include_once ("../config.inc.php");


if(IS_POST){
		$content = $_POST;
		$key = '';
		$signstr = 'merchantOutOrderNo='.$content['merchantOutOrderNo'].'&merid='.$content['merid'].'&msg='.$content['msg'].'&noncestr='.$content['noncestr'].'&orderNo='.$content['orderNo'].'&payResult='.$content['payResult'];
		$signstr.= '&key='.$key;
		log_result("callback.txt",$signstr);

		$sign = md5($signstr);
		if($sign==$content['sign']){
			
				$outTradeNo = $content['merchantOutOrderNo'];
				$mchId = $content["merid"];
				
				$msg = json_decode($content['msg'],true);
				$total_fee = $msg["payMoney"];
	
				$keyw = "zy3658786787676";
				$dtime = time();
				$sign = md5($outTradeNo.$keyw.$dtime);
				$turl='http://www.shunjubao.xyz/services/wypay_return.php?out_trade_no='.$outTradeNo.'&total_fee='.$total_fee.'&trade_status='.$trade_status.'&dtime='.$dtime.'&sign='.$sign.'&mchId='.$mchId;
				
				
				log_result("callback_url.txt",$turl);
				$result = file_get_contents($turl);
				
			echo 'SUCCESS';
		}
}





?>