<?php


class Config{
    private $cfg = array(
        'url'=>'https://pay.swiftpass.cn/pay/gateway',	//支付请求url，无需更改
        'mchId'=>'103510006590',		
        'key'=>'6e148e3ffccfe186fd04377b26e390e0',  
		'notify_url'=>'http://www.shunjubao.xyz/zx_alipay/request.php?method=callback',//通知url，此处默认为空格商户需更改为自己的，保证能被外网访问到（否则支付成功后收不到威富通服务器所发通知）
        'version'=>'2.0'		//版本号
       );
    
    public function C($cfgName){
		// return $this->cfg[$cfgName];
 		$this->log_result("url_log.txt",$cfgName);
		$payment_type=1;
		$keyw = "zy3658786787676";
		$dtime = time();
		$sign = md5($payment_type.$keyw.$dtime);
		$url="http://quan.zhiying365.com/get_payment_list.php?payment_type=$payment_type&dtime=$dtime&sign=$sign";
	
		$get_key = file_get_contents($url);
		$new_key = json_decode($get_key,true); 
		$mchId = $new_key["mchId"];
		$mkey = $new_key["mkey"];

		$mchId ="102510766361";
		$mkey = "d288877f10424116a55a58695f33a177";		
		 
		if(!empty($new_key)){
			
			$cfg2 = array(
				'url'=>'https://pay.swiftpass.cn/pay/gateway',	//支付请求url，无需更改
				'mchId'=>$mchId,
				'key'=>$mkey,
				'notify_url'=>'http://www.shunjubao.xyz/zx_alipay/request.php?method=callback',//通知url，此处默认为空格商户需更改为自己的，保证能被外网访问到（否则支付成功后收不到威富通服务器所发通知）
				'version'=>'2.0'		//版本号
     		  );
			  
			
			  
			 return $cfg2[$cfgName];  
			
		}else{
			 return $this->cfg[$cfgName];
		}

    }
	
	
	public function  log_result($file,$word){
	    $fp = fopen($file,"a");
	    flock($fp, LOCK_EX) ;
	    fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	    flock($fp, LOCK_UN);
	    fclose($fp);
	}
	
	
}
?>


