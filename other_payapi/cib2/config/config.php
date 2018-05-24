<?php
class Config{
    private $cfg = array(
	
        'url'=>'https://pay.swiftpass.cn/pay/gateway',//接口请求地址，固定不变，无需修改
       // 'mchId'=>'101560126158',//测试商户号，商户需改为自己的
      //  'key'=>'c269b6c28969fd35a1a165fee8ceff7f',//测试密钥，商户需改为自己的
	  
	   // 'mchId'=>'399500021170',//测试商户号，商户需改为自己的
//        'key'=>'4c5ce0dd9a5aa5591fcd164f406305ff',//测试密钥，商户需改为自己
		'mchId'=>'101530270328',//测试商户号，商户需改为自己的
        'key'=>'9cfb48aabd8e3005b4b2664d943d06d8',//测试密钥，商户需改为自己
		
		/*'mchId'=>'101590136183',//测试商户号，商户需改为自己的
        'key'=>'9f692f321f95b3de6e1c6670857cfae7',//测试密钥，商户需改为自己*/
		'notify_url'=>'http://www.shunjubao.xyz/other_payapi/cib2/request.php?method=callback',
        'version'=>'2.0'//版本号，默认2.0
       );
	   
	   
	   
	   
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>