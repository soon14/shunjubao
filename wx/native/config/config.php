<?php
class Config{
    private $cfg = array(
        //接口请求地址，固定不变，无需修改
        'url'=>'https://pay.swiftpass.cn/pay/gateway',
	   //测试商户号，商户需改为自己的
        'mchId'=>'102510244173',
	   //测试密钥，商户需改为自己的
        'key'=>'51ea0116720527b5cccb4750dc2dced3',
	   //版本号默认为2.0
        'version'=>'2.0'
       );
    
    public function C($cfgName){
		
		//return $this->cfg[$cfgName];
		//$this->log_result("wx_url_log.txt",$cfgName);
		
		$payment_type=2;
		$keyw = "zy3658786787676";
		$dtime = time();
		$sign = md5($payment_type.$keyw.$dtime);
		$url="http://quan.zhiying365.com/get_payment_list.php?payment_type=$payment_type&dtime=$dtime&sign=$sign";
		//$this->log_result("mchId.txt",$url);
		
		
		$get_key = file_get_contents($url);
		$new_key = json_decode($get_key,true); 

		$mchId = $new_key["mchId"];
		$mkey = $new_key["mkey"];
		//$this->log_result("wx_url_log.txt",$mchId);
		if(!empty($new_key)){
			
			   $cfg2 = array(
					//接口请求地址，固定不变，无需修改
					'url'=>'https://pay.swiftpass.cn/pay/gateway',
				   //测试商户号，商户需改为自己的
					'mchId'=>$mchId,
				   //测试密钥，商户需改为自己的
					'key'=>$mkey,
				   //版本号默认为2.0
					'version'=>'2.0'
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