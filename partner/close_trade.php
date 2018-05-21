<?php
/**
 * 关闭交易定单
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$params = getRequestParams();

if (!isset($params['out_trade_no'])) {
    failExit('请指定要关闭的订单');
}

$objPayParams = new PayParams();
$params['inner_out_trade_no'] = $objPayParams->wrapOutTradeNo($params['out_trade_no'], $params['partner']);

try {
$tmpObjInternalResultTransfer = PayCenterAdapter::closeTrade($params);
if ($tmpObjInternalResultTransfer->isSuccess()) {
	successExit($tmpObjInternalResultTransfer->getData());
} else {
	failExit($tmpObjInternalResultTransfer->getData());
}
} catch (Exception $e) {
	echo $e->getMessage();
}