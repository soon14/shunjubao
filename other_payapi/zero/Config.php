<?php
/**
 * 商户配置文件项
 */
//设置北京时间
date_default_timezone_set('PRC');
$merconfig = Array(
		"Version"     => "2.5",                                    //版本号
		"MerNo"     => "06781478",                                    //商户id
		"Md5Key"     => "9a2585a737ebcfddc83a3f6c5f119608",    		  //密钥
		//请求地址
		"ReqUrl"      => "http://api.1yigou.com.cn:8881/merchant-trade-api/command",
		"NotifyUrl"      => "http://www.zhiying365.com/other_payapi/zero/AsynCallBack.php", //异步通知URL  商户 修改 设置为自己项目域名
		"Charset"   => "UTF-8", //字符编码
		"SignMethod"=> "MD5",//签名类型
		"Url_Param_Connect_Flag"=>"&",//参数分隔符
);
//需做Base64加密的参数
$base64Keys= array("CodeUrl", "ImgUrl", "Token_Id","PayInfo","sPayUrl","PayUrl"
		,"NotifyUrl","ReturnUrl");

$removeKeys = array("SignMethod","Signature");
?>