<?php
/**
 * 获取支付表单信息
 * 调用示例：http://ROOT_DOMAIN/get_pay_forms.php?providers=alipay,tenpay
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$params = getRequestParams();

# 外部传入的金额单位是：元，转成内部统一单位：分
$params['total_fee'] = round($params['total_fee'] * 100);

# 从请求参数里解析出 支付提供商名称 列表
if (! isset ( $params ['providers'] )) {
	# 没有指定支持提供商
	failExit ( '没有指定支付提供商(providers)' );
}
$tmpProviders = trim ( $params ['providers'] );
$providers = explode ( ',', $tmpProviders );
unset ( $params ['providers'] );

# 对subject字段处理
if (isset($params['subject'])) {
    $params['subject'] = strip_tags($params['subject']);
}

# 对body字段处理。
if (isset($params['body'])) {
    $params['body'] = strip_tags($params['body']);
}

# 验证传递来的字符串 
$objPayParams = new PayParams ();
$dataMessage = $objPayParams->checkBasicGetPayFormsParms ( $params );
if (! $dataMessage ['status']) {
	#验证失败
	failExit ( $dataMessage ['message'] );
}

# 处理合作方传递过来的订单，确保合作方与合作方之间的订单id是排重的
$params['inner_out_trade_no'] = $objPayParams->wrapOutTradeNo($params['out_trade_no'], $params['partner']);

$forms = array ();
foreach ( $providers as $provider ) {
	$tmpObjPayCenter = new PayCenterAdapter ( $provider );
	$tmpObjInternalResultTransfer = $tmpObjPayCenter->getPayFormArray ( $params );
	if (!$tmpObjInternalResultTransfer->isSuccess()) {
//		failExit($tmpObjInternalResultTransfer->getData());
		continue;
	}
	$forms [$provider] = $tmpObjInternalResultTransfer->getData();
}

# 插入pay_order表中
$objPayOrderFront = new PayOrderFront();
if (!$objPayOrderFront->initializeOneOrder($params)) {
	failExit('初始化订单出错');
}
	
#记录操作行为日志
$objPayLogFront = new PayLogFront ();
$resLogId = $objPayLogFront->addOneLog ( 'get_pay_forms', PayOrder::WAIT_BUYER_PAY, $params ['inner_out_trade_no'], $params );

successExit ( $forms );

