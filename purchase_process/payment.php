<?php
/**
 * 支付页面
 */

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$out_trade_no = Request::r('id');
if ($out_trade_no < 1) {
	fail_exit_g("没有用户的订单号");
}
$objUserOrderFront = new UserOrderFront();
$userOrderId = $objUserOrderFront->getIdByOutTradeNo($out_trade_no);
if ($userOrderId < 1) {
	fail_exit_g("没有用户的订单号");
}
$userOrder = $objUserOrderFront->get($userOrderId);
if (empty($userOrder)) {
	fail_exit_g("没有用户的订单信息");
}

if (Runtime::getUid() != $userOrder['uid']) {
	fail_exit_g("不允许支付别人的订单");
}

if ($userOrder['status'] == UserOrder::STATUS_PAID) {
	fail_exit_g("该订单已支付过，不允许重复支付");
}
if ($userOrder['status'] == UserOrder::STATUS_CLOSED) {
	fail_exit_g("该订单已关闭，不允许支付");
}
$tpl = new Template();
$TEMPLATE['title'] = "选择付款方式 - ";

$userOrder['money'] = str_replace(".00",'',$userOrder['money']);

# 所有的在线支付方式
$op_types = include ROOT_PATH.'/include/op_type.php';
# 支付宝、财付通，都有要求对connect用户做支付方式的排它处理
$login_type = Runtime::getLoginType();

switch ($login_type) {
	case UserFront::REGISTER_TYPE_ALIPAY:
		$op_types = array($op_types[1]);
		$tpl->assign('alipay_connect', 1);
		break;
	case UserFront::REGISTER_TYPE_QQ:
		if (Request::c('tenpay_connect') == 1) {
			unset($op_types[1]);
			$tpl->assign('tenpay_connect', 1);
		}
		break;
}

# 从google的sem过来的订单
if (Request::c('adsense_from') == 'google-sem') {
	$tpl->assign('isFromGoogleSEM', 1);
}

$tpl->assign('money', $userOrder['money']);
$tpl->assign('need_pay_money', $userOrder['need_pay_money']);
$tpl->assign('out_trade_no', $out_trade_no);  //此值为out_trade_no

#亿玛sem统计
if($_COOKIE['_adwe']){
	$tpl->assign('emar_adwe', $_COOKIE['_adwe']);
}
$tpl->assign('userOrder', $userOrder);

$orderIds = $ssProdIds = $attrIds = array();
if ($userOrder['orderIds']) {
	$orderIds = $userOrder['orderIds'];
}
$orderIds = array_unique($orderIds);
$objOrderFront = new OrderFront();
$orderAttrs = $objOrderFront->getsOrderAttrsByOrderIds($orderIds);
foreach ($orderAttrs as $key=>$orderAtrr) {
	foreach ($orderAtrr as $k=> $tmpV) {
		$attrIds[] = $tmpV['ssProdAttrId'];
		$ssProdIds[] = $tmpV['specialSaleProductId'];
		$orderAttrs[$key][$k]['money'] = str_replace(".00","",$tmpV['money']);
	}
}
$objSSProdFront = new SSProdFront();
$ssProds = $objSSProdFront->gets($ssProdIds);
$tpl->assign('ssProds', $ssProds);
$tpl->assign('orderIds', $orderIds);
$tpl->assign('orderAttrs', $orderAttrs);
$tpl->assign('attrIds', implode(',', $attrIds));

$objSSCategoryFront  =  new SSCategoryFront();
$objSpecialSaleFront = new SpecialSaleFront();
$cates = array();
foreach($orderAttrs as $tmp) {
	foreach($tmp as $tmp1) {
		$specialSale1 = $objSpecialSaleFront->get($tmp1['specialSaleId']);
		$categoryId1 = array_shift($specialSale1['categoryIds']);
		$sscategory1 = $objSSCategoryFront->get($categoryId1);
		$cates[$tmp1['specialSaleId']] = $sscategory1;
	}
}

$tpl->assign('cates', $cates);
#sem统计

#取得当前订单下的特卖商品属性
$objOrderAttrIdxFront = new OrderAttrIdxFront();
$OrderAttrIdx = $objOrderAttrIdxFront->getsByUserOrderId($userOrderId);
$listof = array();
foreach($OrderAttrIdx as $item) {
	$listof[$item['ssProdAttrId']] = $item['amount'];
}
$result_pay = canUseCODPay($listof);
$enableCity = include ROOT_PATH.DIRECTORY_SEPARATOR.'include/enableCity.php';
$codpay = $result_pay->isSuccess() ? 1 : 0;
if (!empty($codpay) && in_array(trim($userOrder['consignee_info']['city']),$enableCity)) {
	$codpay_text = "<div class=\"cwotherbtntips\">温馨提示：<p>在线支付遇到困难，可以使用<strong>“货到付款”</strong>重新下单哦~</p></div>";
	$tpl->assign('codpay', $codpay_text);
}

# 含有在线支付的处理促销逻辑
do {
	if(Runtime::getServerNameId() == SpecialSale::SITE_OWNER_ONLYLADY) break;//ol站没有促销
	$sp_op = array();//在线支付的促销信息
	$objSalesPromotionFront = new SalesPromotionFront();
	$salesPromotionsOfManjian = $objSalesPromotionFront->getsByStatus(SalesPromotion::STATUS_UNDERWAY, array(SalesPromotion::TYPE_MANJIAN, SalesPromotion::TYPE_MANZENG));
	if(!$salesPromotionsOfManjian) break;
	//含有在线支付的促销信息集中到一起，用于页面展示
	$sp_op = $objSalesPromotionFront->getSpOpInfo($salesPromotionsOfManjian);
	if($sp_op) {
		foreach ($sp_op as $sp_info) {
			$sp_op_ids[] = $sp_info['sp_id'];
		}
		$sp_op_ids = implode(',', array_unique($sp_op_ids));
	}
} while (false);

$tpl->assign('sp_op', $sp_op);
$tpl->assign('sp_op_ids', $sp_op_ids);
$tpl->assign('op_types', $op_types);
$YOKA['output'] = $tpl->r('paymemt');
echo_exit($YOKA['output']);
