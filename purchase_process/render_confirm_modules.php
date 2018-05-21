<?php
/**
 * 渲染订单确认页的某些模块。本功能通过ajax调用，以达到不刷新订单确认页的目的
 * @author gxg@gaojie100.com
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$uid = Runtime::getUid();

$tpl = new Template();

ShoppingCart::tryToInit();

# 获取信息成功时的提示，该值用于引导js端给用户一些通知信息
$success_tips = '';

# 购物车商品信息
$objShoppingCart = new ShoppingCart();
$shoppingCart = $objShoppingCart->get();
$listof = $shoppingCart['listof'];
# 获取选中要购买的购物车商品属性id集
$tmpStrProdAttrIds = Request::r('attrIds');
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
		$shoppingCart['listof'] = $newListOf;
	}
	$listof = $shoppingCart['listof'];
}
#购物车中选中的换购商品
$exchangeProdInfo_selected = array();
if(isset($_REQUEST['ep_keys'])) {
	$tmpExchangeProdKeys = $_REQUEST['ep_keys'];
	$tmpExchangeProdKeys = str_replace(' ', '', $tmpExchangeProdKeys);
	$tmpExchangeProdKeys = explode(',', $tmpExchangeProdKeys);

	#分析购物车中的换购商品
	$tmpCart = $objShoppingCart->analysisExchangeProd($shoppingCart);
	foreach ($tmpCart['exchangeProdInfo'] as $key=>$ep_info) {
		#去除购物车中没有被选中的
		if(!in_array($key, $tmpExchangeProdKeys)) {
			unset($tmpCart['exchangeProdInfo'][$key]);
		}
	}
	#正常情况下，exchangeProdInfo不会都被剔除
	#数组形式array(0=>array(ssProdAttrId=>,ep_price=>,ep_amount=>,salesPromotionId=>)...)
	$exchangeProdInfo_selected = $tmpCart['exchangeProdInfo'];
}

# 不再使用从购物车取出的金额了，因为这个不可信。在下单之前，商品的价格理论上总是存在变因的。
//$money = $shoppingCart['money'];
$total_money = 0;// 存放动态计算的商品总价，扣除了折扣后的。
$total_prods_money = 0;// 商品总金额
$total_discount_money = 0;// 折扣总金额

if (empty($listof)) {
	ajax_fail_exit("购物车是空的，请先去挑选商品");
}

$tmp_listof = $listof;
$exchange_code_money = 0; // 兑换金额
# 兑换码处理逻辑
do {
	$exchangeCodeStr = $objShoppingCart->getExchangeCodeStr();
	if (!$exchangeCodeStr) {
		break;
	}

	$objSalesPromotionFront = new SalesPromotionFront();
	$tmp_salesPromotion = $objSalesPromotionFront->analysisExchageCode($exchangeCodeStr, $listof);
	if (!$tmp_salesPromotion->isSuccess()) { // 兑换码使用失败
		ajax_fail_exit($tmp_salesPromotion->getData());
	}
	$exchangeCode_salesPromotion = $tmp_salesPromotion->getData();
	$exchange_code_money = $exchangeCode_salesPromotion['discount_money'];
	$tpl->assign('exchange_code_money', $exchange_code_money);

	# 扣除兑换的商品1件，用来处理促销逻辑
	$discount_ssProdAttrId = $exchangeCode_salesPromotion['discount_ssProdAttrId'];
	$tmp_listof[$discount_ssProdAttrId] = ($tmp_listof[$discount_ssProdAttrId] - 1);
	if ($tmp_listof[$discount_ssProdAttrId] <= 0) {
		unset($tmp_listof[$discount_ssProdAttrId]);
	}

} while (false);

# 用户信息
$objUserFront = new UserFront();
$userInfo = $objUserFront->get($uid);

# 获取用户使用的代金券信息
$coupon_str = $objShoppingCart->getCouponStr();
$context = getContextByQuery($objShoppingCart);
if ($exchange_code_money) {
	$context['price'] = $context['price'] - $exchange_code_money;
}

$coupon = Coupon::findByStr($coupon_str, $context);
if($coupon && Coupon::valid($coupon_str, $context) == Coupon::VALDATE) {
    $coupon_money = $coupon['coupon_money'];
} else {
    $objShoppingCart->dropCoupon();
    $coupon_money = 0;
    $coupon = null;
}

# 处理促销逻辑
do {
	$discount_listof = array();
	$gifts_listof = array();

	$group_by_salesPromotion = array();
	$tmp_selected_salesPromotionIds = Request::r('selected_salesPromotionIds');
	$objSalesPromotionFront = new SalesPromotionFront();
	if (empty($tmp_selected_salesPromotionIds)) {
		$salesPromotionsOfManjian = $objSalesPromotionFront->getsByStatus(SalesPromotion::STATUS_UNDERWAY, array(SalesPromotion::TYPE_MANJIAN, SalesPromotion::TYPE_MANZENG));
		if(!$salesPromotionsOfManjian) break;
		$tmp_selected_salesPromotionIds = array_keys($salesPromotionsOfManjian);
		$tmp_selected_salesPromotionIds = implode(',', $tmp_selected_salesPromotionIds);
	}

	$tmp_selected_salesPromotionIds = trim($tmp_selected_salesPromotionIds, ',');
	$selected_salesPromotionIds = explode(',', $tmp_selected_salesPromotionIds);
	if (empty($selected_salesPromotionIds)) {
		break;
	}
	$objSalesPromotionFront = new SalesPromotionFront();
	$salesPromotions = $objSalesPromotionFront->gets($selected_salesPromotionIds);
	if (empty($salesPromotions)) {
		break;
	}

	$bb = $objSalesPromotionFront->analysisManjian($tmp_listof, $salesPromotions, false);
	if (empty($bb['discount_listof']) && empty($bb['gifts_listof'])) {
		break;
	}

	$discount_listof = $bb['discount_listof'];
	$gifts_listof = $bb['gifts_listof'];
	if (count($bb['group_by_salesPromotions']) > 1) {
//		ajax_fail_exit("您选择的促销条件互相冲突，请重新选择。");
	}
} while (false);

$tpl->assign('coupon_money', $coupon_money);

$objSSProdAttrFront = new SSProdAttrFront();
$objSSProdFront = new SSProdFront();

# 将礼品清单信息合并进 购物清单$listof 和 折扣清单$discount_listof
foreach ($gifts_listof as $tmp_gift_listof) {
	$tmpSSProdAttrId = $tmp_gift_listof['ssProdAttrId'];
	if (isset($listof[$tmpSSProdAttrId])) {
		$listof[$tmpSSProdAttrId] += $tmp_gift_listof['amount'];
	} else {
		$listof[$tmpSSProdAttrId] = $tmp_gift_listof['amount'];
	}

	if (isset($discount_listof[$tmpSSProdAttrId])) {
		$discount_listof[$tmpSSProdAttrId]['discount_money'] += $tmp_gift_listof['discount_money'];
		$discount_listof[$tmpSSProdAttrId]['amount'] += $tmp_gift_listof['amount'];
		foreach ($tmp_gift_listof['salesPromotions'] as $tmpSalesPromotion) {
			$discount_listof[$tmpSSProdAttrId]['salesPromotions'][$tmpSalesPromotion['id']] = $tmpSalesPromotion;
		}
	} else {
		$discount_listof[$tmpSSProdAttrId] = $tmp_gift_listof;
	}
}
$tpl->assign('discount_listof', $discount_listof);
$tpl->assign('group_by_salesPromotions', $bb['group_by_salesPromotions']);
$tpl->assign('gifts_listof', $bb['gifts_listof']);

# 处理免运费活动文案
$objSalesPromotionFront = new SalesPromotionFront();
$fspSalesPromotion = $objSalesPromotionFront->getsFreeShippingDesc();
$tpl->assign('freeShippingDesc', $fspSalesPromotion);

$ssProdAttrIds = array_keys($listof);
$ssProdAttrs = $objSSProdAttrFront->gets($ssProdAttrIds);

# 获取特卖产品集
$ssProdIds = array();
foreach ($ssProdAttrs as $ssProdAttr) {
	$ssProdIds[] = $ssProdAttr['specialSaleProductId'];
}
$ssProdIds = array_unique($ssProdIds);
$ssProds = $objSSProdFront->gets($ssProdIds);

# 获取特卖集
$specialSaleIds = array();
foreach ($ssProds as $ssProd) {
	$specialSaleIds[] = $ssProd['specialSaleId'];
}
$objSpecialSaleFront = new SpecialSaleFront();
$specialSales = $objSpecialSaleFront->gets($specialSaleIds);

###########################################################################
####### 检查商品属性以及对应的特卖状态、特卖商品状态是否允许购买 ####################
# 有部分商品属性居然没有取到，说明购物车中的商品有问题，比如：已被删除。
# 返回购物车页统一处理
if (array_keys($ssProdAttrs) != $ssProdAttrIds) {
	redirect_to_cart("下单的商品有部分已不存在");
	exit;
}
foreach ($ssProdAttrs as $ssProdAttr) {
	if ($ssProdAttr['amount'] < $listof[$ssProdAttr['id']]) {// 剩余库存数比下单的数量少
		redirect_to_cart("剩余库存数不足");
		exit;
	}
	if (!array_key_exists($ssProdAttr['specialSaleProductId'], $ssProds)) {// 商品属性对应的商品信息没有获取到
		redirect_to_cart("对应的特卖商品不存在");
		exit;
	}
	$ssProd = $ssProds[$ssProdAttr['specialSaleProductId']];
	if (!in_array($ssProd['status'], array(SSProd::STATUS_SHELVES))) {// 不允许下单的特卖商品状态
		redirect_to_cart("特卖商品状态不允许下单");
		exit;
	}

	if (!array_key_exists($ssProd['specialSaleId'], $specialSales)) {// 特卖商品对应的特卖信息没有获取到
		redirect_to_cart("对应的特卖不存在");
		exit;
	}
	$specialSale = $specialSales[$ssProd['specialSaleId']];
	if (!in_array($specialSale['status'], array(SpecialSale::STATUS_UNDERWAY))) {// 不允许下单的特卖状态
		redirect_to_cart("特卖状态不允许下单");
		exit;
	}
}

if($exchangeProdInfo_selected) {
	$ep_ssProdAttrIds = array();
	foreach ($exchangeProdInfo_selected as $ep_info) {
		$ep_ssProdAttrIds[] = $ep_info['ssProdAttrId'];
	}
	$ep_ssProdAttrs = $objSSProdAttrFront->gets($ep_ssProdAttrIds);
	if(!$ep_ssProdAttrs) {
		redirect_to_cart("下单的换购商品已不存在");
		exit;
	}
	if(count($ep_ssProdAttrs) != count($ep_ssProdAttrIds))   {
		redirect_to_cart("下单的换购商品有部分已不存在");
		exit;
	}
	# 获取特卖产品集
	$ep_ssProdIds = array();
	foreach ($ep_ssProdAttrs as $ssProdAttr) {
		$ep_ssProdIds[] = $ssProdAttr['specialSaleProductId'];
	}
	$ep_ssProds = $objSSProdFront->gets($ep_ssProdIds);

	# 获取特卖集
	$ep_specialSaleIds = array();
	foreach ($ep_ssProds as $ssProd) {
		$ep_specialSaleIds[] = $ssProd['specialSaleId'];
	}
	$ep_specialSales = $objSpecialSaleFront->gets($ep_specialSaleIds);
	foreach ($ep_ssProdAttrs as $ep_ssProdAttr) {
		if ($ep_ssProdAttr['amount'] < 1) {// 剩余库存数比下单的数量少
			redirect_to_cart("剩余库存数不足");
			exit;
		}
		if (!array_key_exists($ep_ssProdAttr['specialSaleProductId'], $ep_ssProds)) {// 商品属性对应的商品信息没有获取到
			redirect_to_cart("对应的特卖商品不存在");
			exit;
		}
		$ep_ssProd = $ep_ssProds[$ep_ssProdAttr['specialSaleProductId']];
		if (!in_array($ep_ssProd['status'], array(SSProd::STATUS_SHELVES))) {// 不允许下单的特卖商品状态
			redirect_to_cart("特卖商品状态不允许下单");
			exit;
		}

		if (!array_key_exists($ep_ssProd['specialSaleId'], $ep_specialSales)) {// 特卖商品对应的特卖信息没有获取到
			redirect_to_cart("对应的特卖不存在");
			exit;
		}
		$ep_specialSale = $ep_specialSales[$ep_ssProd['specialSaleId']];
		if (!in_array($ep_specialSale['status'], array(SpecialSale::STATUS_UNDERWAY))) {// 不允许下单的特卖状态
			redirect_to_cart("特卖状态不允许下单");
			exit;
		}
		# 把属性中的金额更新
		$ep_ssProdAttrs[$ep_ssProdAttr['id']]['unit_price'] = $exchangeProdInfo_selected[$ep_ssProdAttr['id']]['ep_price'];
	}

}
###########################################################################

# 收集特卖发货方信息
$specialSaleConsignerIds = array();
$objSSConsignerFront = new SSConsignerFront();

foreach ($listof as $ssProdAttrId => $quantity) {
    $tmpSSProdAttr = $ssProdAttrs[$ssProdAttrId];
    $total_money += ConvertData::toMoney($tmpSSProdAttr['unit_price'] * $quantity - $discount_listof[$ssProdAttrId]['discount_money']);
    $total_prods_money += ConvertData::toMoney($tmpSSProdAttr['unit_price'] * $quantity);
    $total_discount_money += ConvertData::toMoney($discount_listof[$ssProdAttrId]['discount_money']);
	$ssProd = $ssProds[$tmpSSProdAttr['specialSaleProductId']];
    $specialSaleConsignerIds[] = $ssProd['specialSaleConsignerId'];
}
if($exchangeProdInfo_selected) {
	foreach ($exchangeProdInfo_selected as $ep_info) {
		$ssProdAttrId 		= $ep_info['ssProdAttrId'];
		$quantity 			= $ep_info['ep_amount'];
	    $tmpSSProdAttr 		= $ep_ssProdAttrs[$ssProdAttrId];
	    $total_money 		+= ConvertData::toMoney($tmpSSProdAttr['unit_price'] * $quantity);
	    $total_prods_money 	+= ConvertData::toMoney($tmpSSProdAttr['unit_price'] * $quantity);
		$ssProd 			= $ep_ssProds[$tmpSSProdAttr['specialSaleProductId']];
	    $specialSaleConsignerIds[] = $ssProd['specialSaleConsignerId'];
	}
}

$total_money -= $exchange_code_money;

$ssConsigners = $objSSConsignerFront->gets($specialSaleConsignerIds);
$tpl->assign('ssConsigners', $ssConsigners);
#发货方信息
$objConsignerFront = new ConsignerFront();
$consignerData = $objConsignerFront->getsAll();
$tpl->assign('consignerData', $consignerData);

$orders = array();
$objSpecialsaleFront = new SpecialsaleFront();
$objProductFront = new ProductFront();
foreach ($listof as $ssProdAttrId => $quantity) {
    $tmpSSProdAttr = $ssProdAttrs[$ssProdAttrId];
	$ssProd = $ssProds[$tmpSSProdAttr['specialSaleProductId']];

	# 拆单规则调整为按发货方，而不是特卖发货方，即与特卖无关。当前在售商品，凡是同一发货方的，就会是一个相同的系统订单。
    # 把特卖发货方对象降格为只记录发货时间用
    $tmpConsignerId = $ssConsigners[$ssProd['specialSaleConsignerId']]['consignerId'];
    #判断是否含有非高街的发货方
	if (!ConsignerFront::isGaoJei($tmpConsignerId)){
		$other_consigner = 1;
	}
	# 特卖商品能否使用代金券
	$objCouponFront = new CouponFront();
	$canUseCoupon = $objCouponFront->canUseCoupon($ssProd['id']);
	if (!$canUseCoupon) {
		$objShoppingCart->dropCoupon();
	}
    $orders[$tmpConsignerId][] = array(
        'ssProdAttr'     => $tmpSSProdAttr,
        'quantity'  => $quantity,
        'ssProd'   => $ssProd,
    	'canUseCoupon'	=> $canUseCoupon,
    );
}

#添加换购商品信息
if($exchangeProdInfo_selected) {
	foreach ($exchangeProdInfo_selected as $ep_info) {
		$ssProdAttrId 		= $ep_info['ssProdAttrId'];
		$quantity 			= $ep_info['ep_amount'];
	    $tmpSSProdAttr 		= $ep_ssProdAttrs[$ssProdAttrId];
		$ssProd 			= $ep_ssProds[$tmpSSProdAttr['specialSaleProductId']];
		# 拆单规则调整为按发货方，而不是特卖发货方，即与特卖无关。当前在售商品，凡是同一发货方的，就会是一个相同的系统订单。
	    # 把特卖发货方对象降格为只记录发货时间用
	    $tmpConsignerId = $ssConsigners[$ssProd['specialSaleConsignerId']]['consignerId'];
	    #判断是否含有非高街的发货方
		if (!ConsignerFront::isGaoJei($tmpConsignerId)){
			$other_consigner = 1;
		}
		# 特卖商品能否使用代金券
		$canUseCoupon = $objCouponFront->canUseCoupon($ssProd['id']);
		if (!$canUseCoupon) {
			$objShoppingCart->dropCoupon();
		}
	    $orders[$tmpConsignerId][] = array(
	        'ssProdAttr'    => $tmpSSProdAttr,
	        'quantity'  	=> $quantity,
	        'ssProd'   		=> $ssProd,
	    	'canUseCoupon'	=> $canUseCoupon,
	    	'is_ep'				=> 1,//是否换购商品
	    );
	}
}
$ssConsigners = $objSSConsignerFront->gets($specialSaleConsignerIds);
$tpl->assign('specialSaleConsigners', $ssConsigners);
foreach($ssConsigners as $ssconsigner)
{
	$tmpConsigner[] = $ssconsigner['shiptime'];
}
rsort($tmpConsigner);
$tpl->assign('last_time',$tmpConsigner['0']);
# 快递费
$objSalesPromotionFront = new SalesPromotionFront();
$expressfee_data = $objSalesPromotionFront->freeShipping($listof, $total_money);

if (is_array($expressfee_data)) {
	$expressfee = $expressfee_data['expressfee'];
} else {
	$expressfee = $expressfee_data;
}
// 处理包邮兑换商品逻辑
if ($exchangeCode_salesPromotion['exchangeCode']['type'] == ExchangeCode::TYPE_FREESHIPPING) {
	$expressfee = 0;
}


/**************************************************************************
 * 代金券部分的逻辑
 * add @zgos
 */
$need_pay_money = Coupon::fix_real_pay($total_money + $expressfee - $coupon_money);

# 用户已经选择使用的券
$tpl->assign('selected_coupon', $coupon);
$tpl->assign('not_use_coupon', Request::r('not_use_coupon'));

do { // 提醒用户可用代金券图标
	$group_by_salesPromotion = array_pop($bb['group_by_salesPromotions']);
	$tpl->assign('group_by_salesPromotion', $group_by_salesPromotion);

	$coupons = $objCouponFront->getsByUid($uid);
	$available_coupons = array();
	foreach($coupons as $tmp_coupon) {
	    if(Coupon::valid($tmp_coupon['coupon_str'], $context) == Coupon::VALDATE) {
	        $available_coupons[$tmp_coupon['coupon_str']] = Coupon::findByStr($tmp_coupon['coupon_str'], $context);
	    }
	}
	if (!$available_coupons) {
		break;
	}

	foreach ($ssProdIds as $tmp_ssProdId) {
		if(!$objSSProdFront->isSpecialCaseGood($tmp_ssProdId)) {
			break;
		}
	}
	if ($coupon) {
		$available_coupons[$coupon['coupon_str']]['is_default'] = true;// 置为默认使用的代金券
	} else {// 选出一张优先使用的券
		$tmp_pre_coupon_money = 0;
		$tmp_default_available_coupon_key = null;
		foreach ($available_coupons as $tmp_available_coupon_key => $available_coupon) {
			if ($available_coupon['coupon_money'] >= $tmp_pre_coupon_money) {
				$tmp_pre_coupon_money = $available_coupon['coupon_money'];
				$tmp_default_available_coupon_key = $tmp_available_coupon_key;
			}
		}

		if (!$group_by_salesPromotion) {
			$available_coupons[$tmp_default_available_coupon_key]['is_default'] = true;// 置为默认使用的代金券
		}
	}

	$tpl->assign('available_coupons', $available_coupons);
} while (false);

## 获取活动文案信息（confirm.php 中有同样的逻辑）
$start_time = mktime(0,0,0,7,11,2012); // 活动开始时间
$end_time = mktime(23,59,59,7,15,2012); // 活动结束时间
$tmp_activity_info = array();
if(time() >= $start_time && time() <= $end_time) {
	if ($need_pay_money < 350) {
		$tmp_activity_info['val'] = 350 - $need_pay_money;
		$tmp_activity_info['desc'] = '满350元返350元券';
	} else if ($need_pay_money < 650) {
		$tmp_activity_info['val'] = 650 - $need_pay_money;
		$tmp_activity_info['desc'] = '满650元返650元券';
	}
	$tpl->assign('tmp_activity_info', $tmp_activity_info);
}

## 账户余额逻辑
$consumeMoney = 0;
if($need_pay_money > 0)
{
    $objAccountFront = new AccountFront();
    $account = $objAccountFront->get($uid);
    if($account && $account['balance']>0)
    {
        $balanceYuan = ConvertData::toMoney($account['balance']/100);
        if($balanceYuan >= $need_pay_money)
        {
            $consumeMoney = $need_pay_money;
            $need_pay_money = 0;
        }
        else
        {
            $consumeMoney = $balanceYuan;
            $need_pay_money = $need_pay_money - $balanceYuan;
        }
    }
}
$tpl->assign('consumeMoney', $consumeMoney);
## 账户余额逻辑
$tpl->assign('need_pay_money', $need_pay_money);
$tpl->assign('has_saved',0);  	//判断用户信息是否已经保存过
/* end @zgos */
/*************************************************************************/

$cur_date = date("Ymd");
$able_date = array('20120516', '20120517', '20120518');
if (in_array($cur_date, $able_date)) {
	$promotion_ad_data = "<span><a style=\"color:#E61478\" href=\"".ROOT_DOMAIN."/activitys/zhifufanquan\" target=\"_blank\">5月16-18号，在线支付就返券，多买多返>></a></span>";
	$tpl->assign('promotion_ad_data',$promotion_ad_data);
}

$tpl->assign('attrIds', join(',', $ssProdAttrIds));
$tpl->assign('orders', $orders);
$total_money = str_replace(".00",'',$total_money);
$tpl->assign('total_money', $total_money);
$tpl->assign('total_prods_money', $total_prods_money);
$tpl->assign('total_discount_money', $total_discount_money);
$tpl->assign('expressfee', $expressfee);			#运费

ajax_success_exit(array(
	'modules_billing_info'	=> $tpl->r('purchase_confirm_modules_billing_info'),// 结算信息
	'modules_prods_info'	=> $tpl->r('purchase_confirm_modules_prods_info'),// 结算信息
	'success_tips'			=> $success_tips,
));
