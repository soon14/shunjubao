<?php
/**
 * 购物流程之：付款成功提示
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


$out_trade_no = Request::r('out_trade_no');
if ($out_trade_no < 1) {
	fail_exit_g("请指定用户充值订单号");
}

$objUserChargeFront = new UserChargeFront();
$tmpResult = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);
if (!$tmpResult->isSuccess()) {
	fail_exit_g($tmpResult->getData());
}

$userChargeInfo = $tmpResult->getData();

if (Runtime::getUid() != $userChargeInfo['u_id']) {
	fail_exit_g("不允许查看别人的订单信息");
}

if ($userChargeInfo['charge_status'] != UserCharge::CHARGE_STATUS_SUCCESS) {
	fail_exit_g("订单未支付");
}

$url = ROOT_DOMAIN . '/account/user_center.php';
redirect($url);
exit;