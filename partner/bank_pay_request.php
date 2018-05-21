<?php
/**
 * 由用户浏览器调用，请求跳转到指定支付商的银行支持接口
 * 调用示例：http://ROOT_DOMAIN/bank_pay_request.php?provider=tenpay
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$params = getRequestParams();

# 外部传入的金额单位是：元
$params['total_fee'] = $params['total_fee'];

# 从请求参数里解析出 支付提供商
if (!isset($params['provider'])) {
    # 没有指定支持提供商
    failExit('没有指定的银行支付提供商(provider)');
}

# 对subject字段处理
if (isset($params['subject'])) {
    $params['subject'] = strip_tags($params['subject']);
}

# 对body字段处理。
if (isset($params['body'])) {
    $params['body'] = strip_tags($params['body']);
}

$objPayParams = new PayParams();
$params['inner_out_trade_no'] = $objPayParams->wrapOutTradeNo($params['out_trade_no'], $params['partner']);

$provider = $params['provider'];
$objPayCenter = new PayCenterAdapter($provider);
$objInternalResultTransfer = $objPayCenter->getPayFormArray($params);
if (!$objInternalResultTransfer->isSuccess()) {
	failExit($objInternalResultTransfer->getData());
}
$form = $objInternalResultTransfer->getData();

$out_trade_no = $params['out_trade_no'];
# 插入初始化用户充值表
$objUserChargeFront = new UserChargeFront();
# 保证订单号记录唯一
$tmpUserChargeInfo = $objUserChargeFront->getUserChargeInfoByOutTradeNo($out_trade_no);
if (!$tmpUserChargeInfo->isSuccess()) {
	failExit($tmpUserChargeInfo->getData());
}

if ($provider == 'gopay') { // 国付宝需使用post请求支付
	$return_url = jointUrl(ROOT_DOMAIN . "/partner/gopayPayment.php", $form);
} else {
	$return_url = jointUrl($form['action'], $form['params']);
}
//echo $return_url;exit;
redirect($return_url);
exit;