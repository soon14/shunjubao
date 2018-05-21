<?php
/*
 * 统一处理异步通知页面
 * 功能：付完款后－后台通知页面
 * 1.获取订单号
 * 2.通过订单号查询出订单信息
 * 3.通过不同的支付商获取相应的notfyurl异步通知方法
 * lihuanchun@qq.com
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$params = getRequestParams();

if (!preg_match('#/notify/([^/?]+)#', $_SERVER['REQUEST_URI'], $match)) {
    # 记录日志，不打印任何信息，因为这是一个服务器端执行的页面
    tmp_log("REQUEST_URI正则匹配错误：{$_SERVER['REQUEST_URI']}");
    exit;
};

$provider = $match[1];

$objPayCenterAdapter = new PayCenterAdapter($provider);
$objInternalResultTransfer = $objPayCenterAdapter->notify($params);
if (!$objInternalResultTransfer->isSuccess()) {
	$detial = $objInternalResultTransfer->getData();
	# 记录日志，不打印任何信息，因为这是一个服务器端执行的页面
	tmp_log("provider：{$provider}；PayCenterAdapter->notify失败，原因：{$detial}");
    exit;
}

$result = $objInternalResultTransfer->getData();

$order_id = $result['order_id'];
$objPayOrderFront = new PayOrderFront();
$orderInfo = $objPayOrderFront->get($order_id);
if (!$orderInfo) {
    # 记录日志，不打印任何信息，因为这是一个服务器端执行的页面
    tmp_log("provider：{$provider}；PayOrderFront->get失败，order_id：{$order_id}");
    exit;
}

$notify_url = $orderInfo['notify_url'];
$tmpObjInternalResultTransfer = PayCenterAdapter::notify_partner($result);
if ($tmpObjInternalResultTransfer->isSuccess()) {
	$objResupplyOrderQueueFront = new ResupplyOrderQueueFront();
	$objResupplyOrderQueueFront->deleteByOrderIdAndStatus($result['order_id'], $result['trade_status']);
} else {
	# 通知失败时，记录日志
    tmp_log("provider：{$provider}；PayCenterAdapter::notify_partner失败，原因：{$tmpObjInternalResultTransfer->getData()}");
}

exit;


function tmp_log($msg) {
	global $params;
	$logPath = 'pay_notify_error_'.date('Y-m-d').'.log';
	$logMsg = 'params值：';
	$logMsg .= "\n";
	$logMsg .= var_export($params, true);
	$logMsg .= "\n";
	$logMsg .= "错误描述：";
	$logMsg .= "\n";
	$logMsg .= "{$msg}";
	$logMsg .= "\n\n";
	Log::customLog($logPath, $logMsg);
}
