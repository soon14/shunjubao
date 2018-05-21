<?php
require ("../Config.php");//加载配置文件
require ( "../Util.php");//加载配置文件
/* 网银B2C
 * 210112-网银B2C跳转收银台
 * 产品类型:0612-网银B2C跳转收银台
 */
	$util = new Util();
	$util->writelog("==========210112-网银B2C跳转收银台=============");
	//==设置请求参数
	$req["Version"] =$merconfig["Version"];
	$req["SignMethod"] =$merconfig["SignMethod"];
	$req["MerNo"] =$merconfig["MerNo"];
	//交易码 210112-网银B2C跳转收银台
	$req["TxCode"] ="210112";
	// 产品类型:0612-网银B2C跳转收银台
	$req["ProductId"] ="0612";
	//商户交易流水号(唯一)
	$req["TxSN"] =date('Ymdhis',time());
	//金额:单位:分
	$req["Amount"] ="10000";
	//商品名称
	$req["PdtName"] ="测试";
	//备注
	$req["Remark"] ="测试";
	//请求时间 格式:Ymdhis
	$req["ReqTime"] =date('Ymdhis',time());

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
		
		if (strcmp($respAr['RspCod'],"00000") == 0
			&& strcmp($respAr['Status'],"1") == 0
			&& isset($respAr['PayUrl'])){
			//请求成功进行处理
			$util->writelog("获取支付链接成功  进行Post表单提交或者重定向");
			$util->writelog("支付链接：".$respAr['PayUrl']);
			//header("Location:".$respAr['PayUrl']);//需要把$util->writelog中print_r屏蔽
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