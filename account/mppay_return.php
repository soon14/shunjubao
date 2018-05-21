<?php
/**
 * 更新订单页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$out_trade_no 	= Request::r('out_trade_no');//订单号
$total_fee 	= Request::r('total_fee');//金额
$trade_status 	= Request::r('trade_status');//金额


$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);
if(!$tmpChargeResult->isSuccess()) {
	failExit($tmpChargeResult->getData());
}

$userChargeInfo = $tmpChargeResult->getData();
if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_SUCCESS) {//已经充值成功，不能再改变了
	exit('已经成功了，不需要再更新');	
}

if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_FAILED) {
	exit('订单已经充值失败,，不允许充值');	
}

if($total_fee!=$userChargeInfo['money']){
	exit('金额不一致！');	
}


$u_id = $userChargeInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);
if (!$userInfo) {
	exit('用户信息未找到');
}

$userChargeInfo['charge_status'] 	= UserCharge::CHARGE_STATUS_SUCCESS;
$userChargeInfo['return_time'] 		= getCurrentDate();
$userChargeInfo['return_code']		= $out_trade_no;
$userChargeInfo['return_message']	= $trade_status;
$tmpResult = $objUserChargeFront->modify($userChargeInfo);
if (!$tmpResult->isSuccess()) {
	exit('用户充值失败');
}else{
	exit('用户充值成功');	
}