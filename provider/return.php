<?php
/**
 * 统一处理同步通知页面
 * 功能：付完款后－跳转的页面
 * 1.获取订单号
 * 2.通过订单号查询出订单信息
 * 3.通过不同的支付商获取相应的redirect同步通知方法
 * 
 * 该页面会跳转到第三方app，并会携带以下参数：
 * array(
 *       'total_fee'     => (float),//交易金额（必填）。该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
 *       'trade_status'  => (),//本次交易状态
 *       'out_trade_no'  => (string),//第三方app调用支付平台时传递过来的订单号
 *       'partner'       => (string),//第三方app的商户号
 *       'subject'       => (string),
 *       'body'          => (string),
 *       'provider'      => (string),//本次支付所使用的支付商，如 alipay
 *       'trade_no'      => (int),//支付中心的订单号
 *       'yoka_user_id'  => (int),//YOKA用户id
 *       'extra_common_param'    => (string | null),//公用回传参数
 * );
 * 
 * lihuanchun@qq.com
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

header("Vary: Accept-Encoding");
header("Content-Type: text/html; charset=utf-8");

if (!preg_match('#/return/([^/?]+)#', $_SERVER['REQUEST_URI'], $match)) {
	echo '无效的请求';
	exit;
};

$provider = $match[1];

$params = getRequestParams();

$objPayCenterAdapter = new PayCenterAdapter($provider);
$objInternalResultTransfer = $objPayCenterAdapter->redirect($params);
if (!$objInternalResultTransfer->isSuccess()) {
	echo $objInternalResultTransfer->getData();
	exit;
}

$result = $objInternalResultTransfer->getData();
$order_id = $result['order_id'];
$objPayOrderFront = new PayOrderFront();
$orderInfo = $objPayOrderFront->get($order_id);
if (!$orderInfo) {
	echo '没有找到对应的订单';
    exit;
}



$partner = $orderInfo['partner'];
$objPartnerConfig = new PartnerConfig($partner);
$securitCode = $objPartnerConfig->getSecuritCode();

$objPayOrder = new PayOrder();
$tradeStatusDesc = $objPayOrder->getStatusDesc($result['trade_status']);
if ($tradeStatusDesc === false) {
	echo '状态值转换成状态描述时出错';
    exit;
}

$tmpInfo = array(
	'total_fee'     => $result['total_fee']/100,//金额由支付中心的　分　转化成　元
	'trade_status'  => $tradeStatusDesc,
	'out_trade_no'  => $orderInfo['out_trade_no'],//第三方app调用支付平台时传递过来的订单号
	'partner'       => $partner,
	'subject'       => $orderInfo['subject'],
	'body'          => $orderInfo['body'],
	'provider'      => $orderInfo['provider'],
    'trade_no'      => $order_id,//支付中心的订单号
    'yoka_user_id'  => $orderInfo['yoka_user_id'],
    'extra_common_param'    => $orderInfo['extra_common_param'],
);
$objYokaServiceUtility = new YokaServiceUtility();
$objYokaServiceUtility->secret = $securitCode;
$tmpInfo['sign'] = $objYokaServiceUtility->createSign($tmpInfo);

$return_url = $orderInfo['return_url'];
$url = jointUrl($return_url, $tmpInfo);

redirect($url);
exit;
