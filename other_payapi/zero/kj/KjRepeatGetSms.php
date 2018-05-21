<?php
require ("../Config.php");//加载配置文件
require ( "../Util.php");//加载配置文件
/* 快捷支付
 * 交易码 210104-机构快捷支付（验证码重新获取接口）  
 */
	$util = new Util();
	$util->writelog("==========210104-机构快捷支付（验证码重新获取接口）  =============");
	//==设置请求参数
	$req["Version"] =$merconfig["Version"];
	$req["SignMethod"] =$merconfig["SignMethod"];
	//交易码210104-机构快捷支付（验证码重新获取接口）  
	$req["TxCode"] ="210104";
	$req["MerNo"] =$merconfig["MerNo"];
	//商户交易流水号(唯一)
	$req["TxSN"] ="170715043456";


	//==设置请求签名
	$util->setSignature($req,$merconfig["Url_Param_Connect_Flag"]
			,$removeKeys,$merconfig["Md5Key"]);
	
	//==得到请求数据
	$post_data = $util->getWebForm($req, $base64Keys, $merconfig["Charset"]
			,$merconfig["Url_Param_Connect_Flag"]);
	
	//==提交数据
	$respMsg = $util->postData($merconfig["ReqUrl"],$post_data);
	$util->writelog("返回数据:".$respMsg);
	
	//==解析返回数据为数组
	$respAr = $util->parseResponse($respMsg,$base64Keys
			,$merconfig["Url_Param_Connect_Flag"], $merconfig["Charset"]);
	//==验签数据
	if ($util->verifySign($respAr, $merconfig["Url_Param_Connect_Flag"], $removeKeys
			, $merconfig["Md5Key"])){
		if (strcmp($respAr['RspCod'],"00000") == 0
		&& strcmp($respAr['Status'],"1") == 0){
			//重获支付短信成功,稍后调用验证短信支付接口提交短信验证码
			//业务处理
			$util->writelog("重获支付短信成功,稍后调用验证短信支付接口提交短信验证码");
		}
		else {
			//失败
			$util->writelog("失败!!!");
		}

	}
	else {
		$util->writelog("验证签名失败:");
	}
?>