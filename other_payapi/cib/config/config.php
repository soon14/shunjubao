<?php
class Config{
    private $cfg = array(
	
        'url'=>'https://pay.swiftpass.cn/pay/gateway',//接口请求地址，固定不变，无需修改
       // 'mchId'=>'101560126158',//测试商户号，商户需改为自己的
      //  'key'=>'c269b6c28969fd35a1a165fee8ceff7f',//测试密钥，商户需改为自己的
	  
	    'mchId'=>'101520128336',//测试商户号，商户需改为自己的
        'key'=>'0229d037d7e6c8d46b2dd2569461ab72',//测试密钥，商户需改为自己
		'notify_url'=>'http://www.shunjubao.xyz/other_payapi/cib/request.php?method=callback',
        'version'=>'2.0'//版本号，默认2.0
       );
	   
	   
	   
	   
    
    public function C($cfgName){
        return $this->cfg[$cfgName];
    }
}
?>