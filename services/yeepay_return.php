<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>易宝支付结果</title>
</head>

<body>
</body>
</html>

<?php
/**
 * 更新订单页
 */

header("Content-type: text/html; charset=utf8");
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
include '../account/class/yeepayCommon.php';	


//----------------------------------------------------------------//
#	只有支付成功时易宝支付才会通知商户.
##支付成功回调有两次，都会通知到在线支付请求参数中的p8_Url上：浏览器重定向;服务器点对点通讯.

#	解析返回参数.
$return = getCallBackValue($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);


#	判断返回签名是否正确（True/False）
$bRet = CheckHmac($r0_Cmd,$r1_Code,$r2_TrxId,$r3_Amt,$r4_Cur,$r5_Pid,$r6_Order,$r7_Uid,$r8_MP,$r9_BType,$hmac);
#	以上代码和变量不需要修改.
		 	
#	校验码正确.
if($bRet){
	if($r1_Code=="1"){
		
	#	需要比较返回的金额与商家数据库中订单的金额是否相等，只有相等的情况下才认为是交易成功.
	#	并且需要对返回的处理进行事务控制，进行记录的排它性处理，在接收到支付结果通知后，判断是否进行过业务逻辑处理，不要重复进行业务逻辑处理，防止对同一条交易重复发货的情况发生.      	  	
		
		if($r9_BType=="1" || $r9_BType=="2"){
				echo "success";
			//echo "交易成功";
			//echo  "<br />在线支付页面返回";				
				
			/*	$out_trade_no 	= "Y160722689474";//订单号
				$total_fee 	= "0.01";//金额
				$trade_status 	= "1";//状态*/
				
				 $out_trade_no 	= $r6_Order;//订单号				
				$total_fee 	= $r3_Amt;//金额
				$trade_status 	= $r1_Code;//状态
				
				
				
			
				$objUserChargeFront = new UserChargeFront();
				$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);
				if(!$tmpChargeResult->isSuccess()) {
					failExit($tmpChargeResult->getData());
				}
				
				
			
				$userChargeInfo = $tmpChargeResult->getData();
				if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_SUCCESS) {//已经充值成功，不能再改变了
					$tmpUrl = "http://www.shunjubao.xyz/account/user_center.php";
					redirect($tmpUrl);
					exit('已经成功了，不需要再更新');	
				}
				
				if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_FAILED) {
					$tmpUrl = "http://www.shunjubao.xyz/account/user_charge.php";
					redirect($tmpUrl);
					exit('订单已经充值失败,，不允许充值');	
				}
				
				if($total_fee!=$userChargeInfo['money']){
					$tmpUrl = "http://www.shunjubao.xyz/account/user_charge.php";
					redirect($tmpUrl);
					exit('金额不一致！');	
				}
				
				
				$u_id = $userChargeInfo['u_id'];
				$objUserMemberFront = new UserMemberFront();
				$userInfo = $objUserMemberFront->get($u_id);
				if (!$userInfo) {
					$tmpUrl = "http://www.shunjubao.xyz/account/user_charge.php";
					redirect($tmpUrl);
					exit('用户信息未找到');
				}
				
				
				#2第三方充值
				$objUserAccountFront = new UserAccountFront();
				$accountResult = $objUserAccountFront->addCash($u_id, $total_fee);
				if (!$accountResult->isSuccess()) {
					#记录充值失败的日志
					$logMsg = '第三方充值失败,时间：'.getCurrentDate();
					$logMsg .= 'uid:'.$u_id;
					$logMsg .= '金额:'.$total_fee;
					$logMsg .= "\n";
					$logMsg .= 'params值：';
					$logMsg .= "\n";
					$logMsg .= var_export($params, true);
					$logMsg .= "\n";
					$logMsg .= "错误描述：";
					$logMsg .= "\n";
					log_result($logMsg, $params['provider'], true);
					failExit('用户充值失败');
				}
				
				$userAccountInfo = $objUserAccountFront->get($u_id);
				
				$tableInfo = array();
				$tableInfo['u_id'] 			= $u_id;
				$tableInfo['money'] 		= $total_fee;
				$tableInfo['log_type'] 		= BankrollChangeType::CHARGE;
				$tableInfo['old_money'] 	= $userAccountInfo['cash'];//原金额
				$tableInfo['record_table'] 	= 'user_charge';//对应的表
				$tableInfo['record_id'] 	= $userChargeInfo['charge_id'];
				$tableInfo['create_time'] 	= getCurrentDate();
				//添加账户日志
				$objUserAccountLogFront = new UserAccountLogFront($u_id);
				$tmpResult = $objUserAccountLogFront->add($tableInfo);
				
				if (!$tmpResult) {
					$logMsg = '添加账户日志失败，pay_order_id:'.$out_trade_no;
					log_result($logMsg, 'add_account_log', true);
					
					$tmpUrl = "http://www.shunjubao.xyz/account/user_charge.php";
					redirect($tmpUrl);
					failExit('用户充值失败');
				}
				
				
				$userChargeInfo['charge_status'] 	= UserCharge::CHARGE_STATUS_SUCCESS;
				$userChargeInfo['return_time'] 		= getCurrentDate();
				$userChargeInfo['return_code']		= $out_trade_no;
				$userChargeInfo['return_message']	= $trade_status;
				$tmpResult = $objUserChargeFront->modify($userChargeInfo);
				if (!$tmpResult->isSuccess()) {
					$tmpUrl = "http://www.shunjubao.xyz/account/user_charge.php";
					redirect($tmpUrl);
					exit('用户充值失败');
				}else{
					$tmpUrl = "http://www.shunjubao.xyz/account/user_center.php";
					redirect($tmpUrl);
					exit('用户充值成功');	
				}
				
				
				
			
			
		}elseif($r9_BType=="2"){
			#如果需要应答机制则必须回写流,以success开头,大小写不敏感.
			echo "success";
			echo "<br />交易成功";
			echo  "<br />在线支付服务器返回";      			 
		}
	}
	
}else{
	echo "交易信息被篡改";
}

//----------------------------------------------------------------//


?>


