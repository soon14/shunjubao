<?php
/**
 * 更新订单页
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
header("Content-type: text/html; charset=utf-8");
$out_trade_no 	= Request::r('out_trade_no');//订单号
$total_fee 	= Request::r('total_fee');//金额
$sign 	= Request::r('sign');
$keyw = "zy3658786787676";

if($keyw!=$sign){
	exit('更新异常！');
}

$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);



if(!$tmpChargeResult->isSuccess()) {
	exit('订单id充值信息出错');	
	//failExit($tmpChargeResult->getData());
}
$userChargeInfo = $tmpChargeResult->getData();

if($total_fee!=$userChargeInfo['money']){
	exit('金额不一致！');	
}

if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_SUCCESS) {//已经充值成功，不能再改变了
	exit('此订单已充值成功，不能重复充值，请到后台查询');	
}

if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_FAILED) {
	exit('订单已经充值失败,，不允许充值');	
}




$u_id = $userChargeInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);
if (!$userInfo) {
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
	failExit('用户充值失败');
}




$userChargeInfo['charge_status'] 	= UserCharge::CHARGE_STATUS_SUCCESS;
$userChargeInfo['return_time'] 		= getCurrentDate();
$userChargeInfo['return_code']		= $out_trade_no;
$userChargeInfo['return_message']	= $mchId;
$tmpResult = $objUserChargeFront->modify($userChargeInfo);
if (!$tmpResult->isSuccess()) {
	exit('用户充值失败');
}else{
	exit('用户充值成功');	
}