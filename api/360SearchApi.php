<?php
/**
 * 360购物订单查询接口 、月对账接口
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$params = Request::getRequestParams();

$bill_month = trim($params['bill_month']); // 这个参数用来判定锁订单查询接口还是月对账接口

$bid = $params['bid'];
$active_time = $params['active_time'];
$sign = $params['sign'];
$cp_key = Qihoo360Connect::CP_KEY;

if ($bid != Qihoo360Connect::BID) {
	echo "合作编号错误！";
	exit;
}

if ($sign != md5("{$bid}#{$active_time}#{$cp_key}")) {
	echo "验签失败！";
	exit;
}

$objUserOrderFront = new UserOrderFront();
$objUserOrderForStatisFront = new UserOrderForStatisFront();
$objOrderAttrIdxFront = new OrderAttrIdxFront();
$objSSCategoryIdx = new SSCategoryIdx();
$objSSProdFront = new SSProdFront();
$objProductFront = new ProductFront();
$objSSCategoryFront = new SSCategoryFront();
$objQihoo360Connect = new Qihoo360Connect();
$qihooStatusDesc = $objQihoo360Connect->getsUserOrderStatus();

$effect_orderAttr_status = array(
	OrderAttrIdx::STATUS_DELIVER_SUCCESS,
	OrderAttrIdx::STATUS_HAS_REPLENISH,
	OrderAttrIdx::STATUS_HAS_SHIPMENT,
	OrderAttrIdx::STATUS_HAS_SHIPMENT_FROM_REPLENISH,
);
$effect_userOrder_status = array(
	UserOrder::STATUS_CONFIRMED,
	UserOrder::STATUS_PAID,
	UserOrder::STATUS_SIGN_AND_PAID,
);

//$params = array(
//	'start_time'	=> '2010-10-07 15:00:00',
//	'end_time'	=> '2012-11-12 23:00:00',
//	'last_order_id' => '1203291263244',
//	'order_ids'	=> '1203291263244',
//);
$ids = $objUserOrderForStatisFront->mall360Search($params);
$userOrders = $objUserOrderFront->gets($ids);

echo '<?xml version="1.0" encoding="utf-8"?><orders>';

foreach ($userOrders as $userOrder) {
	#排除不想给360看到的订单
	$status = 0; // 订单状态
	if ($userOrder['visible'] == 200) { //部分测试订单状态置为已作废
		$status = 6;
	}
	
	$cps_info = $userOrder['qihoo360'];
	if (!trim($cps_info)) {
		continue;
	} else {
		$cps_info = json_decode($cps_info, true);
		$orderIds = $userOrder['orderIds'];
	}
	$total_comm = $server_price = $total_price = 0;
	$commission = $p_info = '';
	foreach ($orderIds as $orderId) {
			$orderAttr = $objOrderAttrIdxFront->getsByOrderId($orderId);
			
			foreach ($orderAttr as $tmpOrderAttr) {
				# MD，对存在退货的订单，把退货的商品排除掉，也就是把有效用户订单中无效的属性去掉
				if (!in_array($tmpOrderAttr['status'], $effect_orderAttr_status) && 
					in_array($userOrder['status'], $effect_userOrder_status)) {
					continue;
				}
				
				$amount = $tmpOrderAttr['amount'];
				$price = ConvertData::toMoney($tmpOrderAttr['money'] / $amount, false);
				
				if ($userOrder['create_time'] >= mktime(0,0,0,11,1,2012)) { // 11月1日之后的分成改成16%
					$atior = (Qihoo360Connect::AFTER_ATIOR * 100).'%'; #分成比例
					$divide = ConvertData::toMoney($price * $amount * Qihoo360Connect::AFTER_ATIOR , false); # 分成
				} else {
					$atior = (Qihoo360Connect::ATIOR * 100).'%'; #分成比例
					$divide = ConvertData::toMoney($price * $amount * Qihoo360Connect::ATIOR , false); # 分成
				}
				$total_comm += $divide;
				
				$tmp_cat = $objSSCategoryIdx->getCategoryIdBySpecialSaleId($tmpOrderAttr['specialSaleId']);
				$categoryId = $tmp_cat[0] ? $tmp_cat[0] : 1;
				$commission .= "{$categoryId},{$atior},{$divide},{$price},{$amount}|";
				
				$category = $objSSCategoryFront->get($categoryId);
				$categoryName = $category['name'];
				
				$product = $objProductFront->get($tmpOrderAttr['productId']);
				$productName = htmlspecialchars($product['name']);
				$SSProd = $objSSProdFront->get($tmpOrderAttr['specialSaleProductId']);
				$url = urlencode("http://www.gaojie.com/product/p{$SSProd['friendlyUrl']}m/");
				
				if ($p_info) {
					$p_info .= '|';
				}
				$p_info .= "{$categoryId},{$productName},{$product['id']},{$price},{$amount},{$categoryName},{$url}";
				
				$total_price += $tmpOrderAttr['money'];
			}
			
	}
	
	$coupon = ConvertData::toMoney($userOrder['coupon_money'] ? $userOrder['coupon_money'] : 0,false);
	// 要求代金券不能大于商品的总价
	if ($coupon > $total_price) $coupon = $total_price;
	
	if ($userOrder['create_time'] >= mktime(0,0,0,11,1,2012)) { // 11月1日之后的分成改成16%
		$total_comm = ConvertData::toMoney($total_comm - $coupon * Qihoo360Connect::AFTER_ATIOR, false);
		$commission = $commission.ConvertData::toMoney($coupon * Qihoo360Connect::AFTER_ATIOR, false);
	} else {
		$total_comm = ConvertData::toMoney(2 + $total_comm - $coupon * Qihoo360Connect::ATIOR, false);
		$commission = $commission.ConvertData::toMoney($coupon * Qihoo360Connect::ATIOR, false)."|+F2";
	}
	
	$total_price = ConvertData::toMoney($total_price - $coupon, false);
	if ($total_price <= 0) $total_comm = 0;
	
	$order_time = date("Y-m-d H:i:s", $userOrder['create_time']);
	$order_updtime = date("Y-m-d H:i:s", $userOrder['update_time']);
	$server_price = ConvertData::toMoney($userOrder['expressfee'], false);
	
	if ($status == 0) {
		$status = $qihooStatusDesc[$userOrder['status']];
	}
	
	if (!$bill_month) { // 订单查询接口返回
		$result  = "<order>";
		$result .= "<bid>{$bid}</bid>";
		$result .= "<qid>{$cps_info['qid']}</qid>";
		$result .= "<qihoo_id>{$cps_info['qihoo_id']}</qihoo_id>";
		$result .= "<ext>{$cps_info['ext']}</ext>";
		$result .= "<order_id>{$userOrder['out_trade_no']}</order_id>";
		$result .= "<order_time>{$order_time}</order_time>";
		$result .= "<order_updtime>{$order_updtime}</order_updtime>";
		$result .= "<server_price>{$server_price}</server_price>";
		$result .= "<total_price>{$total_price}</total_price>";
		$result .= "<coupon>{$coupon}</coupon>";
		$result .= "<total_comm>{$total_comm}</total_comm>";
		$result .= "<commission>{$commission}</commission>";
		$result .= "<p_info><![CDATA[{$p_info}]]></p_info>";
		$result .= "<status>{$status}</status>";
		$result .= "</order>";
	} else { // 月对账接口返回
		$result  = "<order>";
		$result .= "<order_id>{$userOrder['out_trade_no']}</order_id>";
		$result .= "<order_time>{$order_time}</order_time>";
		$result .= "<order_updtime>{$order_updtime}</order_updtime>";
		$result .= "<server_price>{$server_price}</server_price>";
		$result .= "<total_price>{$total_price}</total_price>";
		$result .= "<coupon>{$coupon}</coupon>";
		$result .= "<total_comm>{$total_comm}</total_comm>";
		$result .= "<commission>{$commission}</commission>";
		$result .= "</order>";
	}
	
	echo $result;
}

$result = '</orders>';
echo $result;exit;