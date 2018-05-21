<?php
/**
 * 领克特CPS查询接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if(!Request::g('yyyymmdd')){
	echo '缺少有效参数';
}

if(strlen(Request::g('yyyymmdd')) != 8 || !Verify::unsignedInt(Request::g('yyyymmdd')) ){
	echo '请输入真确的时间格式！如：20070809';
	exit;
}

$d = Request::g('yyyymmdd');

$time_stamp = strtotime($d);

$objUserOrderForStatis = new UserOrderForStatis();
$userOrders = $objUserOrderForStatis->getsByltinfo($time_stamp);

$ids = array();
foreach ($userOrders as $tmpV){
	$ids[] = $tmpV['userOrderId'];
}

if(!$ids) exit;

$objUserOrderFront = new UserOrderFront();
$userOrders = $objUserOrderFront->gets($ids);

$objOrderAttrIdxFront = new OrderAttrIdxFront();
$category = linktechPaymentCategory();
foreach ($userOrders as $V){
	$check = 2; # CPS业绩输出2
	$hhmiss = date('His', $V['create_time']); # 业绩产生时间
	$a_id = $V['LTINFO']; # 使用在LTFRONT里生成的 LTINFO的 Cookie 值
	$o_cd = $V['out_trade_no']; # 订单号
	$mbr_id = $V['uid'];

	$ordersLT = array();
	foreach ($V['orderIds'] as $orderId){
		$ordersLT[] = $objOrderAttrIdxFront->getsByOrderId($orderId);
	}

	$product = array();
	$productIdLT = $priceLT = $amountLT = $c_cd= '';
	foreach ($ordersLT as $orderLT){
		foreach ($orderLT as $LT){
			$product[] = array(
				'p_cd'	=> $LT['productId'], # 商品id
				'price'	=> $LT['ssProdAttr']['unit_price'], # 商品对应的价格
				'it_cnt'=> $LT['amount'], # 购买商品对应的数量
			);
		}
	}

	if($V['coupon_money']){
		$c_cd = $category['USERD_PREFERENTIAL'];
	}else{
		$c_cd = $category['NOT_USED_PREFERENTIAL'];
	}

	if($V['status'] == UserOrder::STATUS_PAID || $V['status'] == UserOrder::STATUS_SIGN_AND_PAID){
		$o_stat = 200;
	}else if ($V['status'] == UserOrder::STATUS_CLOSED || $V['status'] == UserOrder::STATUS_HAS_REJECTED){
		$o_stat = 300;
	}else{
		$o_stat = 100;
	}

	foreach ($product as $tmpV) {
		$outpot .= "{$check}\t{$hhmiss}\t{$a_id}\t{$o_cd}\t{$tmpV['p_cd']}\t{$mbr_id}\t{$tmpV['it_cnt']}\t{$tmpV['price']}\t{$c_cd}\t{$o_stat}\n";
	}
}
echo $outpot;
exit;
