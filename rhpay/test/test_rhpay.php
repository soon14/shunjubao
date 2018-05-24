<?php
include_once ("config.inc.php");
$key_code1 = 'XCHFiJe78TE3CE4UXAawmpxjhDzyKAfm';//签名秘钥
$key_code2 = 'tCZfuo6NyEtd2YMDANVZivoi';//加密秘钥
	 
 $merchantNo = "B100001906";
 $goodsName = "智赢充值"; 
 $callbackUrl = "http://www.shunjubao.xyz/rhpay/callback.php"; 
 $serverCallbackUrl = "http://www.shunjubao.xyz/rhpay/serverCallback.php";  
 $toibkn = "310651000048";//行号
 $cardNo = "6217921851778004";//帐号
 $idCardNo = "420104197805052010";//身份证
 $payerName = "梁澋铖";
 $encrypt = "T0";	
	
		
switch (get_param('action')){
	
	  case 'order_add'://下单

	   	 $orderNum = "rhali".time().rand(100000,999999);
		 $timeOut =date("YmdHis",(time()+60*60*24*1));
		 $orderIp = get_ip(); 
		 
	
		 
		 $post_param["trxType"] = get_param('trxType');//类型--WX_SCANCODE  --Alipay_SCANCODE
		 if(get_param('trxType')=="Alipay_SCANCODE"){//支付宝扫码
			 $SignKey = "Zvt2CQvcXsFEJfIkYDJjOXXlDx3k6hhy";
			 $desKey = "SVMERx3mbns8aqurMw7dmQ5t";
			 $serverPayUrl ="http://test.trx.ronghuijinfubj.com/middlepaytrx/alipay/scanCommonCode?";
		 }elseif(get_param('trxType')=="WX_SCANCODE"){
			 $SignKey = "Zvt2CQvcXsFEJfIkYDJjOXXlDx3k6hhy";
			 $desKey = "SVMERx3mbns8aqurMw7dmQ5t";
			 $serverPayUrl ="http://test.trx.ronghuijinfubj.com/middlepaytrx/wx/scanCommonCode?";
		 }
		
		
		 $post_param["merchantNo"] = $merchantNo;
		 $post_param["orderNum"] = $orderNum;
		 $post_param["amount"] = get_param('amount');
		 $post_param["goodsName"] = $goodsName;
		 $post_param["timeOut"] = $timeOut; 
		 $post_param["callbackUrl"] =  $callbackUrl;
		 $post_param["serverCallbackUrl"] = $serverCallbackUrl;
		 $post_param["orderIp"] = $orderIp;
		 $post_param["toibkn"] = $toibkn;
		 $post_param["cardNo"] = $cardNo;
		 $post_param["idCardNo"] = $idCardNo;
		 $post_param["payerName"] = $payerName;
		 $post_param["encrypt"] = $encrypt;
		// $post_param["authCode"] = get_param('authCode');  
		// $post_param["openId"] = get_param('openId');   
		 $post_param["cardNo"] = encrypt($post_param["cardNo"],$desKey);//cardNo加密
		 $post_param["idCardNo"] = encrypt($post_param["idCardNo"],$desKey);//idCardNo加密 
		 $post_param["payerName"] = encrypt($post_param["payerName"],$desKey);//payerName加密  
	//	var_dump(getPaySign($post_param,$SignKey));exit();
		
		 
		//var_dump(getPaySign($post_param,$SignKey)); //exit();
		 
		 $sign = md5(getPaySign($post_param,$SignKey));
		 $post_param["sign"] = $sign;   
		 
		 $post_param["cardNo"] = urlencode($post_param["cardNo"]);
		 $post_param["idCardNo"] = urlencode($post_param["idCardNo"]);
		 $post_param["payerName"] = urlencode($post_param["payerName"]);
	
		 
		
		 foreach ($post_param as $k => $v){
         	$string .=$k."=".$v.'&';
        }

        $body_str=substr($string,0,strlen($string)-1);
		
		//var_dump($body_str);
		$result = https_request($serverPayUrl,$body_str); 
		 
		 
		 //var_dump($result);
		 
		 
		$content = json_decode($result,true);
		$qrCode = $content["qrCode"];//二维码地址
		
		
		
	include 'include/phpqrcode.php';
	$errorCorrectionLevel = 'L';//容错级别
	$matrixPointSize = 7;//生成图片大小
	//生成二维码图片
	//QRcode::png($qrCode, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 10);
	//直接返回 二维码图片
	var_dump(QRcode::png($qrCode, false, $errorCorrectionLevel, $matrixPointSize));
	exit();

	  	break;
	  case 'merchant_open'://商户号开通
			
	 	  $post_param["channelName"] = get_param('channelName');
	      $post_param["channelNo"] = get_param('channelNo');
	      $post_param["merchantName"] = get_param('merchantName');
		  $post_param["merchantBillName"] = get_param('merchantBillName'); 
		  $post_param["installProvince"] = get_param('installProvince');  
		  $post_param["installCity"] = get_param('installCity');  
	      $post_param["installCounty"] = get_param('installCounty');  
		  $post_param["operateAddress"] = get_param('operateAddress');  
		  $post_param["merchantType"] = get_param('merchantType');  
		  $post_param["businessLicense"] = get_param('businessLicense'); 
		  $post_param["legalPersonName"] = get_param('legalPersonName');  
		  $post_param["legalPersonID"] = get_param('legalPersonID');  
		  $post_param["merchantPersonName"] = get_param('merchantPersonName');  
 		  $post_param["merchantPersonPhone"] = get_param('merchantPersonPhone'); 
		  $post_param["merchantPersonEmail"] = get_param('merchantPersonEmail'); 
		  $post_param["wxType"] = get_param('wxType'); 
		  $post_param["wxT1Fee"] = get_param('wxT1Fee');  
		  $post_param["wxT0Fee"] = get_param('wxT0Fee');   
		  $post_param["alipayType"] = get_param('alipayType');  
		  $post_param["alipayT1Fee"] = get_param('alipayT1Fee');  
		  $post_param["alipayT0Fee"] = get_param('alipayT0Fee'); 
		  $post_param["bankType"] = get_param('bankType');  
		  $post_param["accountName"] = get_param('accountName');  
		  $post_param["accountNo"] = get_param('accountNo');   
		  $post_param["bankCode"] = get_param('bankCode') ;
		  $post_param["creditCardNo"] = get_param('creditCardNo');
		  $post_param["remarks"] = get_param('remarks');
		  
	  	  $post_param["accountNo"] = encrypt($post_param["accountNo"],$key_code2);//accountNo加密

			
 		  $sign  = getSign($post_param,$key_code1);

		//echo($sign); exit();
		 $post_param["sign"] = $sign;
		 $jsonStr=json_encode($post_param,JSON_UNESCAPED_UNICODE);
	 //  	var_dump($jsonStr);exit();

		  $serverPayUrl = "http://test.portal.ronghuijinfubj.com/middlepayportal/merchant/in";
		  $result = http_post_data($serverPayUrl,$jsonStr); 
		  
		  var_dump($result);
		 //array(2) { [0]=> int(200) [1]=> string(326) "{"AlipaySignKey":"Zvt2CQvcXsFEJfIkYDJjOXXlDx3k6hhy","AlipaydesKey":"SVMERx3mbns8aqurMw7dmQ5t","desKey":"SVMERx3mbns8aqurMw7dmQ5t","merchantNo":"B100001906","queryKey":"3idxyRpClBql1N4zwWg3ZMLWz5umsnxY","respCode":"0000","respMsg":"成功","sign":"61E28E54F615C04F53FD13E9F9B86F9E","signKey":"Zvt2CQvcXsFEJfIkYDJjOXXlDx3k6hhy"}" }
		 break;
	  default:
		 break;
}


 
?>