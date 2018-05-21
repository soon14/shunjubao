<?php   
include_once ("../config.inc.php");
include '../include/phpqrcode.php';
$key = 'wuhLhyqW4kB4Q4yOrwH80HuVnXNSehOr';
$merid = '100001';

switch (get_param('action')){
	
	  case 'order_add'://下单
		
			$orderNum = get_param('orderNum');	
			if(empty($orderNum)){
				 $orderNum = "yzb".time().rand(10000,99999);
			}

			 $amount = get_param('amount');
			 if(empty($amount)){
				 $amount = '1.00';
			 }
			 
			 
			$data['merid'] = $merid;
			$data['merchantOutOrderNo'] = $orderNum;
			$data['notifyUrl'] = 'http://www.zhiying365.com/other_payapi/yizhibank/callback.php';
			$data['noncestr'] = '12345678910';
			$data['orderMoney'] = $amount;
			$data['orderTime'] = date('YmdHis');
			
			
			$signstr = 'merchantOutOrderNo='.$data['merchantOutOrderNo'].'&merid='.$data['merid'].'&noncestr='.$data['noncestr'].'&notifyUrl='.$data['notifyUrl'].'&orderMoney='.$data['orderMoney'].'&orderTime='.$data['orderTime'];
			$signstr.= '&key='.$key;
			
			 log_result("signstr.txt",$signstr); 
			
			
			$data['sign'] = md5($signstr);
			$url = 'http://jhpay.yizhibank.com/api/createPcOrder';
			
			
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
			$result = curl_exec($ch);
			log_result("result.txt",$result); 
			
			$temp = json_decode($result);     
			
			
			curl_close($ch);
			$imgurl = $temp->url;
			if(empty($imgurl)){
				
				echo("出错提示：".$temp->msg);
				exit();
			}else{
				
				$matrixPointSize = 6;//生成图片大小
				$errorCorrectionLevel = 'L';//容错级别
				var_dump(QRcode::png($imgurl, false, $errorCorrectionLevel, $matrixPointSize));
				/*	$str = '<img src="http://qr.liantu.com/api.php?text='.$imgurl.'"/>';
				echo $str;   */
			}
			
			
			
		
	
	
		 break;
	  default:
		 break;
}	
	
	
   
?>