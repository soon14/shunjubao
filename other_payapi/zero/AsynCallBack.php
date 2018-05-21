<?php
	require ("Config.php"); // 加载配置文件
	require ("Util.php"); // 加载配置文件
/*
 * 230000-机构支付异步通知回调
 */
	$util = new Util ();
	$util->writelog("===========异步通知========");
	$Params = null;
	foreach ( $_REQUEST as $key => $val ) {
		$Params [$key] = urldecode ( $val );
	}
	$util->writelog ("异步通知参数:" .$util->getURLParam($Params,$merconfig["Url_Param_Connect_Flag"],true,null));
	//==验签数据
	if ($util->verifySign($Params, $merconfig["Url_Param_Connect_Flag"], $removeKeys
			, $merconfig["Md5Key"])){
		$util->writelog("异步通知验证签名成功!");
		if (strcmp($Params['Status'],"1") == 0){
			//成功
			$util->writelog("支付成功,业务处理!!!订单号:".$Params['TxSN']
				.'支付状态:'.$Params['Status']
				.'支付金额:'.$Params['Amount']
				.'零点支付流水号:'.$Params['PlatTxSN']
				);
		}
		else {
			//失败
			$util->writelog("支付失败,业务处理!!!");
		}
	}
	else {
		$util->writelog("异步通知验证失败:");
	}
	//处理完成后一定返回,不然定时再次发送异步通知
	echo "success";
?>