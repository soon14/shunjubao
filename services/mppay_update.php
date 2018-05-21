<?php
/**
 * 更新商户号
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$will_out_trade_no 	= Request::r('will_out_trade_no');//订单号
$dtime 	= Request::r('dtime');//状态
$sign 	= Request::r('sign');
$will_mchId 	= Request::r('will_mchId');
$keyw = "zy3658786787676";

$msign = md5($will_out_trade_no.$will_mchId.$keyw.$dtime);
if($msign!=$sign){
	exit('更新异常！');
}

$objUserChargeFront = new UserChargeFront();
$tmpChargeResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($will_out_trade_no);
if(!$tmpChargeResult->isSuccess()) {
	failExit($tmpChargeResult->getData());
}

$userChargeInfo = $tmpChargeResult->getData();
if ($userChargeInfo['return_message']>0) {//已存在商户号不需要更新了
	exit('success');	
}


$userChargeInfo['return_message']	= $will_mchId;
$tmpResult = $objUserChargeFront->modify($userChargeInfo);
if (!$tmpResult->isSuccess()) {
	exit('用户充值失败');
}else{
	exit('用户充值成功');	
}