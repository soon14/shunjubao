<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();

/**
 * 
 * 生成唯一订单号：即交易号
 */
function createUniqueOutTradeNo() {
	$randNumber = rand('1','999999');
	$rands = str_pad($randNumber,6,'0',STR_PAD_LEFT);
	return 	 date('ymdHis',time()) .  $rands;
	
}

/**
 *
 * 计算运费
 * @param float $ordersMoney
 * @return float
 */
function calcExpressfee($ordersMoney) {
	# 运费。按新的业务逻辑，每笔订单的运费是固定的

	$expressfee = 10;

	return $expressfee;
}



/**
 *
 * 是否允许使用 货到付款的支付方式
 * 条件：
 * 1、商品全部为 高街发货
 * 2、商品金额3000元以下（含3000元）的
 *
 * !!! 3、发货地址在一定区域之内 !!! 该方法不检查这步
 */
function canUseCODPay(array $listof) {
	# 金额阀值
	return InternalResultTransfer::success();
}

/**
 *
 * 根据城市判断是否可以使用货到付款
 * @param unknown_type $city
 * @return 返回InternalResultTransfer对象
 */
function addressCODPay($city)
{
	return InternalResultTransfer::success();
}

/**
 *
 * 有问题，跳转回购物车页面
 */
function redirect_to_cart($msg) {
	$cartShowUrl = ROOT_DOMAIN;
	redirect($cartShowUrl);
	exit;
}

/**
 *
 * 检查用户订单$userOrder是否允许购买
 * @param array $userOrder
 * @return InternalResultTransfer
 */
function checkUserOrderCanBuy(array $userOrder) {

	return InternalResultTransfer::success();
}
