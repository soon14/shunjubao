<?php
require ("../Config.php");//加载配置文件
require ( "../Util.php");//加载配置文件
/*
 * 快捷支付
 * 210102-机构快捷支付（申请请求）获取短信验证码
 */
	$util = new Util();
	$util->writelog("==========210102-机构快捷支付（申请请求）获取短信验证码=============");
	
	//===设置请求参数
	$req["Version"] =$merconfig["Version"];
	$req["SignMethod"] =$merconfig["SignMethod"];
	//交易码 210102-机构快捷支付（申请请求）获取短信验证码
	$req["TxCode"] ="210102";
	//商户号
	$req["MerNo"] =$merconfig["MerNo"];
	//产品ID
	$req["ProductId"] =$merconfig["0613"];
	//商户交易流水号(唯一)
	$req["TxSN"] =date('Ymdhis',time());
	//金额:单位:分
	$req["Amount"] ="10000";
	//商品名称 商户 修改
	$req["PdtName"] ="测试";
	//备注 商户 修改
	$req["Remark"] ="测试";
	//账户类型:11-个人账户
	$req["AccountType"] ="11";
	//银卡卡类型: 1:借记卡,2:信用卡(暂不支持)
	$req["BankAcountCardType"] ="1";
	//银行账户名称
	$req["BankAccountName"] ="张三";		
	//银行账户号码
	$req["BankAccountNumber"] ="xxxxxxxxxxxxxxxx";
	//银行账户证件类型:P01-身份证
	$req["BankAccountCertType"] ="P01";	
	//银行账户证件号码
	$req["BankAccountCertNo"] ="xxxxxxxxxxxxxxxxxx";
	//银行账户开户手机号码
	$req["BankAccountMoblie"] ="XXXXXXXXXXX";
	//信用卡有效期:格式:月月年年;当卡类型为信用卡时必填
	//$req["BankAcountCardExpire"] ="0422";
	//信用卡cvv2;当卡类型为信用卡时必填
	//$req["BankAcountCardCVV2"] ="000";	
	
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
			&& strcmp($respAr['Status'],"1") == 0){
			//业务处理
			$util->writelog("创建快捷支付订单成功,短信已发送,稍后调用验证短信支付接口提交短信验证码!!!");
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