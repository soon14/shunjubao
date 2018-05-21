<?php
/**
 * 更新订单页
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
$out_trade_no 	= Request::r('out_trade_no');//订单号


$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);
if(!$tmpChargeResult->isSuccess()) {
	$status='5';
}

$userChargeInfo = $tmpChargeResult->getData();
if ($userChargeInfo['charge_status'] == UserCharge::CHARGE_STATUS_SUCCESS) {//查询订单是否成功，如果则返回1
	$status='2';
}else{
	$status='1';
}

$r = array('status'=>$status);	
echo json_encode($r); exit();	
