<?php
require ("../Config.php");//加载配置文件
require ( "../Util.php");//加载配置文件
/*
 * 交易订单查询
 * 交易码 210101-机构支付查询交易
 */
	$util = new Util();
	$util->writelog("==========210101  -机构支付查询交易=============");
	//==设置请求参数
	$req["Version"] =$merconfig["Version"];
	$req["SignMethod"] =$merconfig["SignMethod"];
	//交易码 210101-机构支付查询交易
	$req["TxCode"] ="210101";
	$req["MerNo"] =$merconfig["MerNo"];
	//商户交易流水号(唯一)
	$req["TxSN"] ="20170710180022";

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
		$util->writelog("验证签名成功:");
	}
	else {
		$util->writelog("验证签名失败:");
	}
?>