<?php
/**
 * 提供给亿起发查询某天更新订单信息接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if( !Verify::int(Request::g('cid')) ){
	echo '请输入正确的渠道id！';
}else{
	$cid = Request::g('cid');
}

if( !Verify::int(Request::g('d')) || strlen(Request::g('d')) != 8 ) {
	echo '时间格式错误！正确格式如(20111009)';
}else{
	$d = strtotime(Request::g('d').'00:00:00');
}

$objUserOrderForStatisFront = new UserOrderForStatisFront();
$ids = $objUserOrderForStatisFront->getIdsByTimeAndCid($d, $cid, 'update_time');

$objUserOrderFront = new UserOrderFront();
$userOrders = $objUserOrderFront->gets($ids);

# 获取支付类型
$payType = UserOrder::getPayTypeDesc();

# 获取订单状态
$status = UserOrder::getStatusDesc();

//$result = '订单号||订单状态||更新时间||支付状态||支付类型||运费||优惠金额<br>';
$result = '';
foreach ($userOrders as $tmpV){
	$update_time = date('Y-m-d H:i:s', $tmpV['update_time']);

	if($tmpV['status'] == UserOrder::STATUS_SIGN_AND_PAID || $tmpV['status'] == UserOrder::STATUS_PAID){
		$pay_status = '已支付';
	}else{
		$pay_status = '未支付';
	}

	$coupon_money = isset($tmpV['coupon_money'])?$tmpV['coupon_money']:'0';
	$payTypeDesc = $payType[$tmpV['pay_type']]['desc'];
	$statusDesc = $status[$tmpV['status']]['desc'];

	$result .="{$tmpV['out_trade_no']}||{$statusDesc}||{$update_time}||{$pay_status}||{$payTypeDesc}||{$tmpV['expressfee']}||{$coupon_money}";
	$result .='<br>';
}

echo $result;
