<?php
require ("../Config.php");//加载配置文件
require ( "../Util.php");//加载配置文件
/*
 * 支付宝扫码支付  正扫
 * 交易码 210110-机构统一下单
 * 产品类型:0602-支付宝扫码
 */
	$util = new Util();
	$util->writelog("==========210110 支付宝扫码支付=============");
	//===设置请求参数
	$req["Version"] =$merconfig["Version"];
	$req["SignMethod"] =$merconfig["SignMethod"];
	//交易码 210110-机构统一下单
	$req["TxCode"] ="210110";
	//产品类型:0602-支付宝扫码
	$req["ProductId"] ="0602";
	$req["MerNo"] =$merconfig["MerNo"];
	//商户交易流水号(唯一)
	$req["TxSN"] =date('Ymdhis',time());
	//金额:单位:分
	$req["Amount"] ="10000";
	//商品名称
	$req["PdtName"] ="测试";
	//备注
	$req["Remark"] ="测试";
	//异步通知URL
	$req["NotifyUrl"] =$merconfig["NotifyUrl"];


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
		if (strcmp($respAr['RspCod'],"00000") == 0 
			&& strcmp($respAr['Status'],"1") == 0
			&& isset($respAr["ImgUrl"])){
			//申请成功 进行业务逻辑处理
			$util->writelog("申请成功 进行业务逻辑处理!!!");
			$util->writelog("微信二维码图片地址:".$respAr["ImgUrl"]);
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