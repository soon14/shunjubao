<?php
/**
 * 返回使用兑换码后，购物车中受到影响的促销
 * @author lishuming@gaojie100.com
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$before_salesPromotionIds = array(); // 未使用兑换码时满足的促销集
$after_salesPromotionIds = array(); // 使用兑换码后满足的促销集
$conflict_salesPromotions = array(); // 冲突的促销集
$is_coupon_conflict = true; // 兑换掉商品后，已使用的代金券是否还能继续使用。默认可以

# 购物车商品信息
$objShoppingCart = new ShoppingCart();
$shoppingCart = $objShoppingCart->get();
$listof = $shoppingCart['listof'];
if (empty($listof)) {
	ajax_fail_exit("购物车是空的，请先去挑选商品");
}
# 获取选中要购买的购物车商品属性id集
$tmpStrProdAttrIds = Request::p('attrIds');
if ($tmpStrProdAttrIds) {
	$tmpStrProdAttrIds = str_replace(' ', '', $tmpStrProdAttrIds);
	$tmpArrProdAttrIds = explode(',', $tmpStrProdAttrIds);
	$newListOf = array();
	foreach ($tmpArrProdAttrIds as $tmpAttrId) {
		if (array_key_exists($tmpAttrId, $listof)) {
			$newListOf[$tmpAttrId] = $listof[$tmpAttrId];
		}
	}
	if ($newListOf) {
		$listof = $newListOf;
	}
}

# 获取可兑换的商品信息
$exchangeCodeStr = Request::p('exchangeCodeStr');

# 检查兑换码
$objExchangeCodeFront = new ExchangeCodeFront();
$tmpResult = $objExchangeCodeFront->checkIsEffectExchangCode($exchangeCodeStr);
if (!$tmpResult->isSuccess()) {
	ajax_fail_exit($tmpResult->getData());
} else {
	$exchangeCode = $tmpResult->getData();
}

# 绑定兑换码 ！！只要是有效的兑换码，就把这个兑换码绑定给用户
$uid = Runtime::getUid();
$objExchangeCodeFront->HasBindExchangeCode($exchangeCode['id'], $uid);

$objSalesPromotionFront = new SalesPromotionFront();
$tmp_salesPromotion = $objSalesPromotionFront->analysisExchageCode($exchangeCodeStr, $listof);
if (!$tmp_salesPromotion->isSuccess()) { // 兑换码使用失败
	ajax_fail_exit($tmp_salesPromotion->getData());
}
$exchangeCode_salesPromotion = $tmp_salesPromotion->getData();

# 扣除满足兑换码的商品1件。TODO 这里并不能满足减多少金额的需求，需要重写
$discount_ssProdAttrId = $exchangeCode_salesPromotion['discount_ssProdAttrId'];
$listof[$discount_ssProdAttrId] = ($listof[$discount_ssProdAttrId] - 1);
if ($listof[$discount_ssProdAttrId] <= 0) {
	unset($listof[$discount_ssProdAttrId]);
}
	
# 处理促销逻辑
do {
	$before_salesPromotionIds = Request::p('selected_salesPromotionIds');
	if (empty($before_salesPromotionIds)) {
		break;
	} else {
		$before_salesPromotionIds = explode(',', $before_salesPromotionIds);
	}
	
	# 获取扣除兑换商品后新的促销集
	$salesPromotionsOfManjian = $objSalesPromotionFront->getsByStatus(SalesPromotion::STATUS_UNDERWAY, array(SalesPromotion::TYPE_MANJIAN, SalesPromotion::TYPE_MANZENG));
	$bb = $objSalesPromotionFront->analysisManjian($listof, $salesPromotionsOfManjian);
	if (!empty($bb['discount_listof'])) {
		$discount_listof = $bb['discount_listof'];
	}
	
	foreach ($bb['group_by_salesPromotions'] as $key => $salesPromotion) {
		if ($salesPromotion['recommend']) {
			$tmp_after_salesPromotionIds = $key;
			break;
		}
	}
	
	if ($tmp_after_salesPromotionIds) {
		$after_salesPromotionIds = explode(',', $tmp_after_salesPromotionIds);
	} else {
		$after_salesPromotionIds = array();
	}
	
	$conflict_salesPromotionIds = array_diff($before_salesPromotionIds, $after_salesPromotionIds);
	$conflict_salesPromotions = $objSalesPromotionFront->gets($conflict_salesPromotionIds);
} while (false);

# 处理代金券逻辑
do {
	if (!$objShoppingCart->getCouponStr()) {
		break;
	}
	
	$ssProdAttrIds = array_keys($listof);
	$objSSProdAttrFront = new SSProdAttrFront();
	$ssProdAttrs = $objSSProdAttrFront->gets($ssProdAttrIds);
	foreach ($listof as $ssProdAttrId => $quantity) {
		$tmpSSProdAttr = $ssProdAttrs[$ssProdAttrId];
    	$new_price += ConvertData::toMoney($tmpSSProdAttr['unit_price'] * $quantity - $discount_listof[$ssProdAttrId]['discount_money']);
	}
	
	$couponStr = $objShoppingCart->getCouponStr();
	$context = array(
		'uid'	=> Runtime::getUid(),
		'price'	=> $new_price,
	);
	$status = Coupon::valid($couponStr, $context);
	if($status != Coupon::VALDATE) {
		$is_coupon_conflict = false; // 兑换掉商品后，与已使用的代金券不再满足条件
	}
	
} while (false);

if (empty($conflict_salesPromotions) && $is_coupon_conflict) {
	ajax_success_exit(); // 其他优惠不受影响，可直接使用兑换码
}

ajax_success_exit(array(
	'conflict_salesPromotions'	=> $conflict_salesPromotions,
	'is_coupon_conflict'	=> $is_coupon_conflict,
));