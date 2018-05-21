<?php
/**
 * 多麦查询接口
 */
header("Content-type: text/html; charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

# 查询规则：开始时间，结束时间。时间格式：20111129
if( !Verify::unsignedInt(Request::g('start_time')) || strlen(Request::g('start_time')) != 8) {
	echo 'parameter error';
	exit;
}

if( !Verify::unsignedInt(Request::g('end_time')) || strlen(Request::g('end_time')) != 8) {
	echo 'parameter error';
	exit;
}

$start_time = strtotime(Request::g('start_time').'00:00:00');
$end_time = strtotime(Request::g('end_time').'23:59:59');

$objUserOrderFront = new UserOrderFront();
$objUserOrderForStatisFront = new UserOrderForStatisFront();
$objOrderAttrIdxFront = new OrderAttrIdxFront();
$objSSCategoryIdx = new SSCategoryIdx();
$objSSCategoryFront = new SSCategoryFront();
$objProductFront = new ProductFront();
$objSSProdFront = new SSProdFront();

$ids = $objUserOrderForStatisFront->getsOrdersByAdsenseFrom('duomai', $start_time, $end_time);
$userOrders = $objUserOrderFront->gets($ids);

if (!$userOrders) {
	exit;
}

$result = array();
foreach ($userOrders as $userOrder) {
	if (!$userOrder['duomai']){
			continue;
	}

	foreach ($userOrder['orderIds'] as $orderId) {
		$orderAttr = $objOrderAttrIdxFront->getsByOrderId($orderId);

		if (!$orderAttr) {
			$orderAttr = array();
		}

		$price = $amount = 0;
		$productName = $productNum = $productPrice = $rate ='';
		foreach ($orderAttr as $tmpV) {
			$product = $objProductFront->get($tmpV['productId']);
			if ($productName) {
				$productName .= '|';
				$rate .= '|';
			}
			$productName .= $product['name'];
			$rate .= '0.12';

			if ($productNum) $productNum .= '|';
			$productNum .= $tmpV['amount'];

			$SSProduct = $objSSProdFront->get($tmpV['specialSaleProductId']);
			if ($productPrice) $productPrice .= '|';
			$productPrice .= $SSProduct['unit_price'];
		}
	}

	$result[] = array(
		'euid'	=> $userOrder['duomai'],
		'order_sn'	=> $userOrder['out_trade_no'],
		'order_time'	=> date('Y-m-d H:i:s',$userOrder['create_time']),
		'goods_cate'	=> '',
		'goods_ta'	=> $productNum,
		'goods_id'	=> '',
		'goods_name'	=> $productName,
		'goods_price'	=> $productPrice,
		'rate'	=> $rate,
		'order_price'	=> $userOrder['ordersMoney'] - $userOrder['coupon_money'],
		'status'	=> '0',
		'encoding'	=> 'UTF-8',
	);
}

if ($result) {
	echo json_encode($result);
}
exit;