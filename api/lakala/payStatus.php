<?php
/**
 * 拉卡拉查询订单状态接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

# 接口版本。商户响应原样返回
$v = Request::g('v', null);

# 服务
$service = Request::g('service', null);

# 拉卡拉商户号。由合作伙伴提供（拉卡拉在合作伙伴提供）
$mer_id = Request::g('mer_id', null);

# 安全号配置号。由合作伙伴提供 暂提供sec_id=RSA,MD5
$sec_id = Request::g('sec_id', null);

# 请求ID。按照原值返回
$req_id = Request::g('req_id', null);

# 账单号。合作伙伴订单号
$trade_no = Request::g('trade_no');

# 金额 。以元为单位、范围为[0，999999.99] 
$amount = Request::g('amount', null);

# 拉卡拉查询时间。格式为YYYYMMDDhhmmss
$lakala_query_time = Request::g('lakala_query_time', null);

# 签名
$sign = Request::g('sign', null);


$data = "amount={$amount}&lakala_query_time={$lakala_query_time}&mer_id={$mer_id}&req_id={$req_id}&sec_id={$sec_id}&service={$service}&trade_no={$trade_no}&v={$v}".MACKEY;

if ($sign != md5($data)) {
	echo "验证失败！";
	exit;
}


$objUserOrderFront = new UserOrderFront();
$id = $objUserOrderFront->getIdByOutTradeNo($trade_no);
$userOrder = $objUserOrderFront->get($id);

# can_pay的值 y表示可以支付，  n 表示账单号不存在，001 金额输入有误,002，账单号错误，003，支付金额小于交易金额，004 商品售罄
$can_pay = '002'; 
if ($userOrder['status'] == UserOrder::STATUS_NOT_PAID) {
	$can_pay = 'y';
}
if ($userOrder['need_pay_money'] != $amount) {
	$can_pay = '001';
}
if (!$userOrder || $userOrder['status'] == UserOrder::STATUS_PAID) {
	$can_pay = 'n';
}

# time
$time = date("YmdHis");

$objUserFront = new UserFront();
$user = $objUserFront->get($userOrder['uid']);

# 用户名使用Base64编码
$partner_extendinfo = '';

# 签名  
$sign_arg = md5("amount={$amount}&can_pay={$can_pay}&mer_id={$mer_id}&partner_bill_no={$trade_no}&partner_extendinfo={$partner_extendinfo}&partner_query_time={$time}&req_id={$req_id}&sec_id={$sec_id}&service={$service}&v={$v}".MACKEY);

$feedbackInfo = array(
	'v'						=> $v,
	'service'				=> $service,
	'mer_id'				=> $mer_id,
	'sec_id'				=> $sec_id,
	'req_id'				=> $req_id,
	'can_pay'				=> $can_pay,
	'partner_bill_no'		=> $trade_no,
	'amount'				=> $amount,
	'partner_query_time'	=> $time,
	'partner_extendinfo'	=> $partner_extendinfo,
	'sign'					=> $sign_arg,
);

echo substr( jointUrl(null, $feedbackInfo), 1 );
exit;