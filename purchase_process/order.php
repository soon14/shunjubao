<?php
/**
 * 购买流程之：下单
 * 生成订单
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objShoppingCart = new ShoppingCart();
$shoppingCart = $objShoppingCart->get();
$listof = $objShoppingCart->getListof();

#判断是否要设置为默认地址
$exist_default = isset($_POST['exist_default']) ? $_POST['exist_default']:'';
if($exist_default != '')
{
	$uid = Runtime::getUid();
	$id = $_POST['address_id'];
	$objConsigneeInfoFront = new ConsigneeInfoFront();
	$objConsigneeInfoFront->setDefault($uid, $id);
}


# 获取选中要购买的购物车商品属性id集
$tmpStrProdAttrIds = $_POST['attrIds'];
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
$tmpExchangeProdKeys =$_POST['ep_keys'];
$exchangeProdInfo_listof = array();
$exchangeProd_salesPromotion = array();
if($tmpExchangeProdKeys) {
	$tmpExchangeProdKeys = str_replace(' ', '', $tmpExchangeProdKeys);
	$tmpExchangeProdKeys = explode(',', $tmpExchangeProdKeys);
	$objSalesPromotionFront = new SalesPromotionFront();
	#分析购物车中的换购商品
	$tmpCart = $objShoppingCart->analysisExchangeProd($shoppingCart);
	foreach ($tmpCart['exchangeProdInfo'] as $key=>$ep_info) {
		#去除购物车中没有被选中的
		if(!in_array($key, $tmpExchangeProdKeys)) {
			unset($tmpCart['exchangeProdInfo'][$key]);
			continue;
		}
		$exchangeProd_salesPromotion[$ep_info['salesPromotionId']] = $objSalesPromotionFront->get($ep_info['salesPromotionId']); 
	}
	#正常情况下，$exchangeProdInfo不会都被剔除
	#数组形式array(ssProdAttrId=>array(ssProdAttrId=>,ep_price=>,ep_amount=>,salesPromotionId=>)...)
	$exchangeProdInfo_listof = $tmpCart['exchangeProdInfo'];
}
if (empty($listof)) {
	fail_exit_g("购物车是空的，无法生成订单", null, array(
		array(
			'title'		=> '查看我的订单',
			'href'		=> ROOT_DOMAIN . '/order/orders.php',
		),
	));
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
	if (!$tmp_salesPromotion->isSuccess()) {
		$objShoppingCart->dropExchangeCodeStr();
		fail_exit_g("购物车发生变动，无法使用兑换码", null, array(
			array(
				'title'		=> '返回购物车',
				'href'		=> PURCHASE_ROOT_DOMAIN . '/cart/show.php',
			),
		));
	}
	$exchangeCode_salesPromotion = $tmp_salesPromotion->getData();
	$exchange_code_money = $exchangeCode_salesPromotion['discount_money'];
	
	# 扣除兑换的商品1件，用来处理促销逻辑
	$discount_ssProdAttrId = $exchangeCode_salesPromotion['discount_ssProdAttrId'];
	$tmp_listof[$discount_ssProdAttrId] = ($tmp_listof[$discount_ssProdAttrId] - 1);
	if ($tmp_listof[$discount_ssProdAttrId] == 0) {
		unset($tmp_listof[$discount_ssProdAttrId]);
	}
	
} while (false);

/***********************
 * 处理代金券的逻辑 - 1
 * @zgos
 */
$coupon_str = $objShoppingCart->getCouponStr();

$context = getContextByQuery($objShoppingCart);
if ($exchange_code_money) {
	$context['price'] = $context['price'] - $exchange_code_money;
}
$coupon = Coupon::findByStr($coupon_str, $context);
if($coupon && Coupon::valid($coupon_str, $context) != Coupon::VALDATE) {
	fail_exit_g("购物车发生变动，无法生成订单", null, array(
		array(
			'title'		=> '查看我的订单',
			'href'		=> ROOT_DOMAIN . '/order/orders.php',
		),
	));
}

$objSSProdAttrFront = new SSProdAttrFront();
$ssProdAttrs = $objSSProdAttrFront->gets(array_keys($listof));
$ssProdIds = array();
$objCouponFront = new CouponFront();
foreach ($ssProdAttrs as $ssProdAttr) {
	$canUseCoupon = $objCouponFront->canUseCoupon($ssProdAttr['specialSaleProductId']);
	if (!$canUseCoupon && $coupon) {
		fail_exit_g("因含有特例品，该订单不能使用代金券", null, array(
			array(
				'title'		=> '返回购物车',
				'href'		=> PURCHASE_ROOT_DOMAIN . '/cart/show.php',
			),
		));
	}
}
/*
 * end @zgos
 ************************/


$uid = Runtime::getUid();
$uname = Runtime::getUname();
$site = Runtime::getServerNameId();

# 获取提交上来的收货信息
$objConsigneeInfoFront = new ConsigneeInfoFront();
$consignee_info = $objConsigneeInfoFront->get($_POST['address_id']);
if (!$consignee_info) {
	fail_exit_g("获取收货人信息失败", "没有收货人信息，无法完成购买", array(
		array(
			'title'		=> '返回填写收货人信息',
			'href'		=> Request::getReferer(),
		),
	));
}
/*$consignee_info = array(
    'name'  => '高小刚',
    'email' => 'gaoxiaogang@gmail.com',
    'mobile'    => '15201695196',
    'phone'  => '010-65873509-8022',
    'province'  => '北京',
    'city'  => '北京',
    'county'    => '朝阳区',
    'address'   => '时尚大厦6层',
    'postcode'  => '100020',
);

# 获取提交上来的发票信息
$invoice_info = array(
    'type'  => '普通发票',
    'rises' => array(//抬头
        'type'  => '公司',
        'name'  => '北京凯铭风尚网络技术有限公司',
    ),
    'content'   => '办公用品',//发票内容
);*/

# 拆分订单

# 处理促销逻辑
do {
	$discount_listof = array();
	$gifts_listof = array();
	$exchangeProd_discount_listof = array();
	$group_by_salesPromotion = array();
	$tmp_selected_salesPromotionIds = Request::p('selected_salesPromotionIds');
	if (empty($tmp_selected_salesPromotionIds)) {
		break;
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

	$tmpJumpUrl = jointUrl(PURCHASE_ROOT_DOMAIN . '/purchase_process/confirm.php', array(
		'attrIds'	=> $_POST['attrIds'],
		'ep_keys'	=> $_POST['ep_keys'],
	));
	$discount_listof = $bb['discount_listof'];
	$gifts_listof = $bb['gifts_listof'];
	$exchangeProd_discount_listof = $bb['exchangeProd_discount_listof'];
	if (count($bb['group_by_salesPromotions']) > 1) {
		fail_exit_g("促销条件不能同时存在", "您选择的促销条件互相冲突，请重新选择。", array(
			array(
				'title'		=> '返回订单确认页',
				'href'		=> $tmpJumpUrl.'#sales_promotion',
			),
		));
	}
	$group_by_salesPromotion = array_pop($bb['group_by_salesPromotions']);

	# 限制使用代金券
	if ($coupon && $group_by_salesPromotion['exclusive_coupon']) {
		# 清空券
		$objShoppingCart->dropCoupon();

		fail_exit_g("您选择的这组促销，不允许使用代金券", null, array(
			array(
				'title'		=> '已取消代金券的使用，请返回订单确认页，重新提交',
				'href'		=> $tmpJumpUrl.'#sales_promotion',
			),
		));
	}
} while (false);

$objOrderFront = new OrderFront();
$objOrderAttrIdx = new OrderAttrIdx();

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

$exchangeCode_discount_listof = array(
	$exchangeCode_salesPromotion['discount_ssProdAttrId']	=> $exchangeCode_salesPromotion,
);
$orders = $objOrderFront->splitOrders($listof, $discount_listof, $exchangeCode_discount_listof, $exchangeProdInfo_listof);
//print_r($orders);exit;
if (empty($orders)) {
	fail_exit_g("拆分订单失败", "为方便发货，您的商品会按发货方与发货日期拆分成不单的系统订单。", array(
		array(
			'title'		=> '返回购物车页',
			'href'		=> PURCHASE_ROOT_DOMAIN . '/cart/show.php',
		),
	));
}

## 获取用户选择的支付方式
$pay_type = $_POST['pay_type'];
$op_type = $_POST['op_type'];
$cod_type = $_POST['cod_type'];

if (!UserOrder::isValidPayType($pay_type)) {
	fail_exit_g("请选择支付方式", null, array(
		array(
			'title'		=> '请选择支付方式',
			'href'		=> Request::getReferer(),
		),
	));
}
else
{
	$objUserPayTypeFront = new UserPayTypeFront();
	$info = array(
		'uid'=>Runtime::getUid(),
		'pay_type'=>$pay_type,
	);
	
	if($op_type) $info['op_type'] = $op_type;
	if($cod_type) $info['cod_type'] = $cod_type;
	
	$result = $objUserPayTypeFront->add($info);   ##这里没有做出错判断
}
if($pay_type == UserOrder::PAY_TYPE_OP && !$op_type) {
	fail_exit_g("请选择在线支付方式", null, array(
		array(
			'title'		=> '请选择支付方式',
			'href'		=> Request::getReferer(),
		),
	));
}
# 如果选择的是货到付款，判断下是否符合使用货到付款的条件
if ($pay_type == UserOrder::PAY_TYPE_COD) {
	# TODO 判断用户所选择的收货地址，是否支持 货到付款方式
	$city = $consignee_info['city'];
	$addressCODPay = addressCODPay($city);
	if(!$addressCODPay->isSuccess()){
		fail_exit_g("抱歉，您所在的城市不支持货到付款，请重新选择支付方式。", $addressCODPay->getData(), array(
			array(
				'title'		=> '返回重新选择支付方式',
				'href'		=> Request::getReferer(),
			),
		));
	}
	$tmpCanUseCODPay = canUseCODPay($listof);
	if (!$tmpCanUseCODPay->isSuccess()) {
		fail_exit_g("抱歉，您的订单不符合使用货到付款的条件", $tmpCanUseCODPay->getData(), array(
			array(
				'title'		=> '返回重新选择支付方式',
				'href'		=> Request::getReferer(),
			),
		));
	}
}

# 获取用户填写的　希望送货时间、订单备注等信息
$note_info = $_POST['note'];
$note_info['date'] = trim(strip_tags($note_info['date']));
$note_info['note'] = mb_substr(trim(strip_tags($note_info['note'])), 0, 1000, 'UTF-8');
if (empty($note_info['date'])) {
	fail_exit_g("您还没有指定希望的送货时间", null, array(
		array(
			'title'		=> '返回填写您希望的送货时间',
			'href'		=> Request::getReferer(),
		),
	));
}

$create_time = time();

# 开启事务
$objDBTransaction = new DBTransaction();
$strTransactionId = $objDBTransaction->start();

$orderIds = array();// 存放这次下单生成的订单id集

$tmpPayMoney = 0;//需支付总金额
$amount = 0;// 用户订单里的商品数量

# COD类型，pos机还是现金
if($pay_type == UserOrder::PAY_TYPE_COD) $cod_type = $_POST['cod_type'];
else $cod_type = '';
# 在线支付的类型，即银行或第三方
if($pay_type == UserOrder::PAY_TYPE_OP) $op_type = $_POST['op_type'];
else $op_type = '';

foreach ($orders as $order) {
	$orderInfo = array(
        'uid'                  => $uid,
        'uname'                => $uname,
        'consignee_info'       => $consignee_info,
		'note_info'			   => $note_info,
	    'site'				   => $site,
		'create_time'		   => $create_time,
		# 将用户订单的支付类型、冗余到系统订单
		'pay_type'			   => $pay_type,
    );
    
    if(!empty($cod_type)) 	$orderInfo['cod_type'] = $cod_type;
    if(!empty($op_type)) 	$orderInfo['op_type'] = $op_type;
    
	$tmpResult = $objOrderFront->add($orderInfo, $order);
	if (!$tmpResult->isSuccess()) {
		$objDBTransaction->rollback($strTransactionId);
		fail_exit_g("创建订单失败", $tmpResult->getData(), array(
			array(
				'title'		=> '返回订单确认页，继续下单',
				'href'		=> Request::getReferer(),
			),
		));
	}

	$orderInfo = $tmpResult->getData();
	$amount += $orderInfo['amount'];
	$tmpPayMoney += $orderInfo['money'];

	$orderIds[] = $orderInfo['id'];
}

# 处理免运费的逻辑
$tmpPayMoney = ConvertData::toMoney($tmpPayMoney);
$expressfee = 10;
# 计算运费
$objSalesPromotionFront = new SalesPromotionFront();
$expressfee_data = $objSalesPromotionFront->freeShipping($listof, $tmpPayMoney);
if (is_array($expressfee_data)) {
	$expressfee = $expressfee_data['expressfee'];
	$freeShipping_salesPromotion = $expressfee_data['salesPromotion'];
} else {
	$expressfee = $expressfee_data;
}
// 处理兑换码的包邮逻辑
if ($exchangeCode_salesPromotion['exchangeCode']['type'] == ExchangeCode::TYPE_FREESHIPPING) {
	$expressfee = 0;
}

# 如果选择的是货到付款，判断下是否符合使用货到付款的条件
if ($pay_type == UserOrder::PAY_TYPE_COD) {
	# 待确认
	$userOrderType = UserOrder::STATUS_NOT_CONFIRMED;
} else {
	# 待付款
	$userOrderType = UserOrder::STATUS_NOT_PAID;
}

# 调整了订单的逻辑。之前的支付流水号提升为用户订单号的概念，所以每个用户订单，需要有专门的 收货人信息、订单备注等信息
$objUserOrderFront = new UserOrderFront();
$info = array(
	'orderIds'		=> $orderIds,
	'ordersMoney'	=> $tmpPayMoney,// 订单金额，不包括运费的，即订单内的商品优惠后的总金额
	'money'			=> ConvertData::toMoney($tmpPayMoney + $expressfee),// 总金额，包括运费
	'expressfee'	=> $expressfee,// 运费字段
	'uid'			=> Runtime::getUid(),
	'uname'			=> $uname,
	'consignee_info'	=> $consignee_info,
	'note_info'			=> $note_info,
	'site'				   => $site,
	'create_time'		=> $create_time,
	'amount'		=> $amount,
	'pay_type'		=> $pay_type,
	'status'		=> $userOrderType,
	'uuid'			=> Runtime::getUUID(),// 将uuid存储起来
);

if(!empty($cod_type)) $info['cod_type'] = $cod_type;
if(!empty($op_type)) 	$info['op_type'] = $op_type;

# 有分好组的促销信息
if ($group_by_salesPromotion) {
	$info['group_by_salesPromotion'] = $group_by_salesPromotion;
}
if ($exchangeCode_salesPromotion) {
	$info['exchangeCode_salesPromotion'] = $exchangeCode_salesPromotion;
}
# 免运费的促销信息
if ($freeShipping_salesPromotion) {
	$info['freeShipping_salesPromotion'] = $freeShipping_salesPromotion;
}
# 换购的促销信息
if ($exchangeProd_salesPromotion) {
	$info['exchangeProd_salesPromotion'] = $exchangeProd_salesPromotion;
}
$objRuntime = new Runtime();
$user = $objRuntime->getUser();

######################################################
# 通过合作方产生的订单，把合作方标识记录到订单里
######################################################
$tmp_cps_info = array();
# 如果是从亿起发过来的用户，生成订单中添加以下数据
if($_COOKIE['eqifa_cps']){
	$eqifa = explode('|', $_COOKIE['eqifa_cps']);
	if(count($eqifa) == 3){
		$tmp_cps_info = array(
			'eqifa_src'	=> $eqifa[0],
			'eqifa_cid'	=> $eqifa[1],
			'eqifa_wi'	=> $eqifa[2],
		);
	}
}
# 从领克特过来的用户，订单中添加以下数据
if($_COOKIE['LTINFO']){
	$LTINFO = explode('|', $_COOKIE['LTINFO']);
	if(count($LTINFO) == 4){
		$tmp_cps_info = array(
			'LTINFO'	=> $_COOKIE['LTINFO'],
		);
	}
}
# 从唯一过来的用户，订单中添加以下数据
if(Request::c('weiyi')){
	$tmp_cps_info = array(
		'weiyi'	=> Request::c('weiyi'),
	);
}
if (!Request::c('LTINFO') && Runtime::getLoginType() == UserFront::REGISTER_TYPE_QQ) {
	$tmp_cps_info = array(
		'LTINFO' => "A100136514{$user['connect_uid']}|qq_login|99999|01",
	);
}
# 领克特之 CT专用优惠券
if (in_array($coupon['gen_log_id'], couponBatchsFromCT())) {
	$tmp_cps_info = array(
		'LTINFO' => "A100126293",
	);
}
# 领克特之 139专用优惠券
if (in_array($coupon['gen_log_id'], couponBatchsFrom139())) {
	$tmp_cps_info = array(
		'LTINFO' => "A100106638",
	);
}
# 从360购物过来的用户
if (Request::c('qihoo360')) {
	$tmp_cps_info = array(
		'qihoo360' => Request::c('qihoo360', null),
	);
}
# 从360团购过来的用户
if (Request::c(Qihoo360Connect::TUAN_360_COOKIE_NAME)) {
	$tmp_cps_info = array(
		Qihoo360Connect::TUAN_360_COOKIE_NAME => Request::c(Qihoo360Connect::TUAN_360_COOKIE_NAME, null),
	);
}
# 从duomai过的用户
if (Request::c('duomai')) {
	$tmp_cps_info = array(
		'duomai' => Request::c('duomai', null),
	);
}

$info = array_merge($info, $tmp_cps_info);

# 对广告合作方的跟踪
$adsense_from = Request::c('adsense_from');
if ($adsense_from) {
	$info['adsense_from']	= $adsense_from;
}

# 取得该访客的入口来源信息，存进用户订单表
$objPersistentKVDB = new PersistentKVDB(PersistentKVDB::NS_USER_ENTRY_REFERER_URL);
$uuid = Runtime::getUUID();
$user_entry_referer_url_info = $objPersistentKVDB->get($uuid);
if (is_array($user_entry_referer_url_info)) {// 取到了用户的入口来源信息
	$info['referer'] = $user_entry_referer_url_info['referer'];
	$info['entry'] = $user_entry_referer_url_info['entry'];
	if (Verify::unsignedInt($user_entry_referer_url_info['ts'])) {
		$info['entry_ts'] = $user_entry_referer_url_info['ts'];// 进入时间
	}
}

/***********************
 * 处理代金券的逻辑 - 2
 * @zgos
 */
if($coupon) {//如果发现了购物车中的优惠券
    $info['coupon_str'] = $coupon['coupon_str'];
    $info['coupon_money'] = $coupon['coupon_money'];//重复设置代金券抵代金额，因为代金券的金额在不同时间可能有不同值，但其志应当是在下单那一刻有意义的值
}
/************************
 * end @zgos
 */

//添加渠道id
$channelid = $_COOKIE['channelid'];
if($channelid){
	$info['channelid']	= $channelid;
}

###########################
# 对sem的跟踪
$sem_adcomp = Request::c('sem_adcomp');
if ($sem_adcomp) {
	$info['sem_adcomp']	= $sem_adcomp;
}
$sem_keyid = Request::c('sem_keyid');
if ($sem_keyid) {
	$info['sem_keyid']	= $sem_keyid;
}
$sem_source = Request::c('sem_source');
if ($sem_source) {
	$info['sem_source']	= $sem_source;
}

################################################
# 需做异步推送 （合作方只需要已付款订单信息做推送）
################################################
# 百度
if (Request::c('baidu_tn') == "baidutuan_tg") {
	$info['feedback_baiduTuan'] = serialize(array(
		'tn'	=> Request::c('baidu_tn'),
		'baiduid'	=> Request::c('baiduid'),
	));
}
###########################
$userOrder = $objUserOrderFront->add($info);

if (!$userOrder) {
	fail_exit_g("创建订单失败", null, array(
		array(
			'title'		=> '返回订单确认页，继续下单',
			'href'		=> Request::getReferer(),
		),
	));
}
$userOrderId = $userOrder['id'];
$out_trade_no = $userOrder['out_trade_no'];

# 使用兑换码逻辑
if ($exchangeCode_salesPromotion) {
	$objExchangeCodeFront = new ExchangeCodeFront();
	$tmpResult = $objExchangeCodeFront->bindExchangeCodeToUserOrder($exchangeCode_salesPromotion, $userOrderId);
	if (!$tmpResult->isSuccess()) {
		$objDBTransaction->rollback($strTransactionId);
		$objShoppingCart->dropExchangeCodeStr();
		fail_exit_g("兑换码使用失败！", $tmpResult->getData(), array(
            array(
                'title'		=> '返回购物车页',
                'href'		=> Request::getReferer(),
            ),
        ));
	}
}

/***********************
 * 处理代金券的逻辑 - 3
 * 当userOrder成功生成以后，要把userOrder.id存入代金券中以绑定
 * @zgos
 */
if($coupon) {//如果发现了购物车中的优惠券
    //在这里绑定userOrder.id到coupon!!!
    //并且还需要修改coupon的状态
    $objCouponFront = new CouponFront();
    $couponResult = $objCouponFront->bundleUserOrder($coupon, $userOrder);
    if($couponResult != Coupon::OK) {
        //当优惠券争用的时候，后使用优惠券的订单会下单失败，并且释放购物车占用的优惠券
        $objDBTransaction->rollback($strTransactionId);
        $objShoppingCart->dropCoupon();
        fail_exit_g("创建订单失败", "优惠券不可使用" . " " . $couponResult, array(
            array(
                'title'		=> '返回订单确认页，继续下单',
                'href'		=> Request::getReferer(),
            ),
        ));
    }
}
/************************
 * end @zgos
 */

if (!$objOrderFront->associateUserOrderId($userOrderId, $orderIds)) {
    $objDBTransaction->rollback($strTransactionId);
	fail_exit_g("创建订单失败", "建立订单与用户订单的关联时失败", array(
		array(
			'title'		=> '返回订单确认页，继续下单',
			'href'		=> Request::getReferer(),
		),
	));
}

# 将 userOrderId 与 OrderAttrIdx 关联起来，方便关联查找
$objOrderAttrIdxFront = new OrderAttrIdxFront();
$tmpAssociateResult = $objOrderAttrIdxFront->associateUserOrderIdByOrderIds($userOrderId, $orderIds);
if (!$tmpAssociateResult) {
    $objDBTransaction->rollback($strTransactionId);
	fail_exit_g("创建订单失败", "创建关联时失败", array(
		array(
			'title'		=> '返回订单确认页，继续下单',
			'href'		=> Request::getReferer(),
		),
	));
}

####################################################
# 如果用户无需支付金额，则不管是货到付款、还是在线支付，都直接成交 #
###################################################
$real_pay = Coupon::fix_real_pay($userOrder['money'] - $userOrder['coupon_money']);
## 账户余额逻辑
if($real_pay > 0)
{
    $objAccountFront = new AccountFront();
    $account = $objAccountFront->get($uid);
    if($account && $account['balance']>0)
    {
        $consumeMoney = 0;
        $balanceYuan = ConvertData::toMoney($account['balance']/100);
        if($balanceYuan >= $real_pay)
        {
            $consumeMoney = $real_pay;
            $real_pay = 0;
        }
        else
        {
            $consumeMoney = $balanceYuan;
            $real_pay = $real_pay - $balanceYuan;
        }

        $account_msg = array(
        	'status'=> AccountLogs::MONEY_CONSUME_PAY,
        	'account_log_no' => $userOrderId,
        	'handle_uid'  => Runtime::getUid(),
        	'handle_uname' => Runtime::getUname(),
			'outTradeNo' => $out_trade_no,
        	'reason' 	=> '订单消费'
        );
        $tmpResult = $objAccountFront->consume($uid, sprintf('%.0f', $consumeMoney*100),$account_msg);
        if(!$tmpResult->isSuccess())
        {
        	$objDBTransaction->rollback($strTransactionId);
            fail_exit_g("创建订单失败", "使用账户余额时失败", array(
		        array(
					'title'		=> '返回订单确认页，继续下单',
					'href'		=> Request::getReferer(),
		        ),
	        ));
        }

        ## 将消费账户余额信息添加到用户订单中
        $accountResult = $tmpResult->getData();
        $user_order_account = array(// 帐户余额相关信息
			'accountBalance'	=> ConvertData::toMoney($accountResult['log']['balance']/100),// 已扣除的可用余额
			'accountWidthdraw'	=> ConvertData::toMoney($accountResult['log']['widthdraw']/100),// 已扣除的可提现金额
		);
		$objUserOrderFront = new UserOrderFront();
        $userOrderResult = $objUserOrderFront->setAccountMoney($userOrderId, $user_order_account);
        if(!$userOrderResult->isSuccess())
        {
        	$objDBTransaction->rollback($strTransactionId);
            fail_exit_g("创建订单失败", "使用账户余额时失败", array(
		        array(
					'title'		=> '返回订单确认页，继续下单',
					'href'		=> Request::getReferer(),
		        ),
	        ));
        }
    }
}
## 账户余额逻辑

#####################################
# 计算并保存需要用户支付的金额
#####################################
$tmp_need_pay_money = ConvertData::toMoney($real_pay);
$userOrderResult = $objUserOrderFront->setNeedPayMoney($userOrderId, $tmp_need_pay_money);
#####################################

if ($real_pay == 0) {
	if ($pay_type == UserOrder::PAY_TYPE_COD) {
		$tmpResult = setStatusToConfirmed($userOrder);
		if (!$tmpResult->isSuccess()) {
			$tmpCheckResult = checkUserOrderCanBuy($userOrder);
			if (!$tmpCheckResult->isSuccess()) {
				fail_exit_g("抱歉，您的订单提交失败。", $tmpCheckResult->getData(), array(
					array(
						'title'		=> '返回购物车页，重新下单',
						'href'		=> PURCHASE_ROOT_DOMAIN . '/cart/show.php',
					),
				));
			}

			fail_exit_g("自动确认订单时失败", $tmpResult->getData(), array(
				array(
					'title'		=> '返回订单确认页，继续下单',
					'href'		=> Request::getReferer(),
				),
			));
		}
		$redirectUrl = PURCHASE_ROOT_DOMAIN . '/purchase_process/cod_pay_tips.php?id=' . $out_trade_no;
	} else {// 在线支付
		$money_constituents = array(// 金额组成成分，以后还会有 折扣券之类
			'account'	=> array(),
			'payment'	=> array(),// 支付相关信息
			'coupons'	=> array(),// 代金券相关信息
		);

		$tmpSetStatusToPaid = $objUserOrderFront->setStatusToPaid($userOrderId, $money_constituents);
		if (!$tmpSetStatusToPaid->isSuccess()) {
			fail_exit_g("将用户订单号 {$out_trade_no} 的状态置为成功时，操作失败", $tmpSetStatusToPaid->getData());
		}

		$redirectUrl = PURCHASE_ROOT_DOMAIN . '/purchase_process/pay_success_tips.php?id=' . $out_trade_no;
	}

	if (!$objDBTransaction->commit($strTransactionId)) {
		fail_exit_g("提交事务失败", "提交事务失败", array(
			array(
				'title'		=> '返回订单确认页，继续下单',
				'href'		=> Request::getReferer(),
			),
		));
	}

	# 清空购物车里已下单的库存
	$objShoppingCart->deletes(array_keys($listof));

	/***********************
	 * 处理代金券的逻辑 - 4
	 * 做代金券在下单成功之后的购物车的清理工作
	 * 不管订单的状态是如何的，这里强制清楚购物车里的代金券信息，对用户也是有意义的
	 * @zgos
	 */
	$objShoppingCart->dropCoupon();
	/************************
	 * end @zgos
	 */
	# 清空换购商品
	$objShoppingCart->dropExchangeProdInfo();
	redirect($redirectUrl);
	exit;
}
###################################################


###################################################
# 以下代码是用户需另付款的逻辑 #
###################################################
if ($pay_type == UserOrder::PAY_TYPE_COD) {
	$tmpResult = setStatusToConfirmed($userOrder);
	if (!$tmpResult->isSuccess()) {
		$tmpCheckResult = checkUserOrderCanBuy($userOrder);
		if (!$tmpCheckResult->isSuccess()) {
			fail_exit_g("抱歉，您的订单提交失败。", $tmpCheckResult->getData(), array(
				array(
					'title'		=> '返回购物车页，重新下单',
					'href'		=> PURCHASE_ROOT_DOMAIN . '/cart/show.php',
				),
			));
		}

		fail_exit_g("自动确认订单时失败", $tmpResult->getData(), array(
			array(
				'title'		=> '返回订单确认页，继续下单',
				'href'		=> Request::getReferer(),
			),
		));
	}

	# TODO 指定货到付款的跳转url
	$redirectUrl = PURCHASE_ROOT_DOMAIN . '/purchase_process/cod_pay_tips.php?id=' . $out_trade_no;
} else {
	$redirectUrl = PURCHASE_ROOT_DOMAIN . '/purchase_process/payment.php?id=' . $out_trade_no . "&preview=1";
}
###################################################

if (!$objDBTransaction->commit($strTransactionId)) {
	fail_exit_g("提交事务失败", "提交事务失败", array(
		array(
			'title'		=> '返回订单确认页，继续下单',
			'href'		=> Request::getReferer(),
		),
	));
}

######################################################
# 通过合作方产生的订单，存放到推广通知队列中
######################################################

$objPromotionInformList = new PromotionInformList();
# 亿起发
if(Request::c('eqifa_cps')){
	$eqifa = explode('|', $_COOKIE['eqifa_cps']);
	if(count($eqifa) == 3){
		$feedback = array(
			'adsense'	=> 'eqifa_cps',
			'cid'	=> $eqifa[1],
			'wi'	=> $eqifa[2],
		);
	}
}

# 领克特
if($info['LTINFO']){
	$feedback = array(
		'adsense'	=> 'LTINFO',
		'a_id'	=> $info['LTINFO'],
		'm_id'	=> 'gaojie'
	);
}

# 唯一
if (Request::c('weiyi')) {
	$feedback = array(
		'adsense'	=> 'weiyi',
		'cid'	=> Request::c('weiyi'),
	);
}

# QQ彩贝   条件：用户直接通过本站QQ登录
if (!Request::c('LTINFO') && Runtime::getLoginType() == UserFront::REGISTER_TYPE_QQ) {
	$feedback = array(
		'adsense'	=> 'LTINFO',
		'a_id'	=> 'A100136514'.$user['connect_uid'],
		'm_id'	=> 'gaojie',
		'c_cd'	=> 'qq_login'
	);
}

# QQ彩贝   条件：联合登录
if (Request::c('LTINFO') && Runtime::getLoginType() == UserFront::REGISTER_TYPE_QQ) {
	$feedback = array(
		'adsense'	=> 'LTINFO',
		'a_id'	=> $_COOKIE['LTINFO'],
		'm_id'	=> $_COOKIE['LTINFO_m'],
		'mbr_name' => 'A100136514'.$user['connect_uid'],
	);
}

# 领克特之 CT专用优惠券
if (in_array($coupon['gen_log_id'], couponBatchsFromCT())) {
	$feedback = array(
		'adsense'	=> 'LTINFO',
		'a_id'	=> 'A100126293',
		'm_id'	=> 'gaojie',
	);
}
# 领克特之 139专用优惠券
if (in_array($coupon['gen_log_id'], couponBatchsFrom139())) {
	$feedback = array(
		'adsense'	=> 'LTINFO',
		'a_id'	=> 'A100106638',
		'm_id'	=> 'gaojie',
	);
}

if ($feedback) {
	$objPromotionInformList->add($userOrderId, $feedback);
}
#################################################

# 清空购物车里已下单的库存
$objShoppingCart->deletes(array_keys($listof));

/***********************
 * 处理代金券的逻辑 - 4
 * 做代金券在下单成功之后的购物车的清理工作
 * 不管订单的状态是如何的，这里强制清楚购物车里的代金券信息，对用户也是有意义的
 * @zgos
 */
$objShoppingCart->dropCoupon();
/************************
 * end @zgos
 */
$objShoppingCart->dropExchangeCodeStr();
$objShoppingCart->dropExchangeProdInfo();
redirect($redirectUrl);
exit;
