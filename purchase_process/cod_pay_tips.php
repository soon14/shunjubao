<?php
/**
 * 购物流程之：货到付款方式 支付时的提示
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$out_trade_no = Request::r('id');
if ($out_trade_no < 1) {
	fail_exit_g("请指定用户订单号");
}
$objUserOrderFront = new UserOrderFront();
$id = $objUserOrderFront->getIdByOutTradeNo($out_trade_no);
if ($id < 1) {
	fail_exit_g("请指定用户订单号");
}
$userOrder = $objUserOrderFront->get($id);

if (!$userOrder) {
	fail_exit_g("获取用户订单信息失败");
}

if (Runtime::getUid() != $userOrder['uid']) {
	fail_exit_g("不允许查看别人的订单信息");
}

if ($userOrder['pay_type'] != UserOrder::PAY_TYPE_COD) {
	fail_exit_g("不是货到付款订单");
}

if ($userOrder['status'] != UserOrder::STATUS_CONFIRMED) {
	fail_exit_g("非已确认的订单");
}
# 系统订单信息集用来做SEM
$orderIds = $ssProdIds = array();
if ($userOrder['orderIds']) {
	$orderIds = $userOrder['orderIds'];
}
$orderIds = array_unique($orderIds);
$objOrderFront = new OrderFront();
$orderAttrs = $objOrderFront->getsOrderAttrsByOrderIds($orderIds);
foreach ($orderAttrs as $key=>$orderAtrr) {
	foreach ($orderAtrr as $k=> $tmpV) {
		$ssProdIds[] = $tmpV['specialSaleProductId'];
		$orderAttrs[$key][$k]['money'] = str_replace(".00","",$tmpV['money']);
	}
}
$objSSProdFront = new SSProdFront();
$ssProds = $objSSProdFront->gets($ssProdIds);
$tpl->assign('ssProds', $ssProds);
$tpl->assign('orderIds', $orderIds);
$tpl->assign('orderAttrs', $orderAttrs);

# 从mediav的sem过来的订单
if (Request::c('sem_adcomp') == 'mediav') {
	$tpl->assign('isFromMediavSEM', 1);
}

# 从品友过来的订单
if (Request::c('adsense_from') == 'pyhd_roi') {
	$tpl->assign('pyhd_roi', 1);
}

# 从google的sem过来的订单
if (Request::c('adsense_from') == 'google-sem') {
	$tpl->assign('isFromGoogleSEM', 1);
}

$objOrderAttrIdxFront = new OrderAttrIdxFront();
$orderId = array_shift($userOrder['orderIds']);//获取用户订单的第一件商品的相关信息，用来发feed
$orderAttr = $objOrderAttrIdxFront->getsByOrderId($orderId);
$orderAttr = array_shift($orderAttr);
$statusDesc = UserOrderFront::getStatusDesc();
$tpl->assign('statusDesc', $statusDesc);

$TEMPLATE['title'] = "货到付款提示 - ";

$userOrder['money'] = str_replace(".00","", $userOrder['money']);
$tpl->assign('userOrder', $userOrder);

$site = array(Runtime::getServerNameId(), SpecialSale::SITE_OWNER_ALL);
$objSpecialSaleFront = new SpecialSaleFront();
$specialSale = $objSpecialSaleFront->get($orderAttr['specialSaleId']);
$categoryId = array_shift($specialSale['categoryIds']);
$objSSCategoryFront  =  new SSCategoryFront();
$sscategory = $objSSCategoryFront->get($categoryId);

# 获取进行中的特卖
$cond = array(
	'site'	=> $site,
	'categoryId'	=> null,
	'status'		=> SpecialSale::STATUS_UNDERWAY,
);
$specialSalesOfUnderway = $objSpecialSaleFront->getsByCondition($cond, '4', SSProdSphinx::PARAM_ORDER_TYPE_SS_STARTTIME_DESC);
$tpl->assign('specialSalesOfPreheat', $specialSalesOfUnderway);

$uid = Runtime::getUid();
$objUserFront = new UserFront();
$userInfo = $objUserFront->get($uid);
$login_type = $userInfo['register_type'];
$objConnectBind = new ConnectBind();
$connect_userinfo = $objConnectBind->getInfoByUidAndLoginType(Runtime::getUid(), $login_type);
//这里由开心版的账户管理控制
if ($userInfo['kaixin_feed']) $_COOKIE['autofeed'] = 1;

if ($_COOKIE['autofeed'] && $login_type) {//connect用户自动发购买feed
	$text = $pic_path = '';
	Cookie::setCookie('autofeed', null, null,'/');
	$ssProd = array_shift($ssProds);
	switch ($login_type){
		case UserFront::REGISTER_TYPE_SINA ://新浪购买feed
			$text = "Wow！我刚在@高街时尚网 抢到了 “".$specialSale['name']."” 特卖会的超值商品，总能在这里买到便宜又时髦的商品，太实惠了，有兴趣的朋友们可以去看看哦！".ROOT_DOMAIN.'/'.$sscategory['en_name'].'/'.$specialSale['friendlyUrl'].'?channelid=2300001';
			$pic_path = $specialSale['img_l_662x288'];
			$objSinaConnect = new SinaConnect();
			$objSinaConnect->update($text,$pic_path);
			break;
		case UserFront::REGISTER_TYPE_KAIXIN ://开心购买feed

			$kaixin_feed =array();

			$discoount = sprintf('%.3s',$orderAttr['money']*10/$orderAttr['ssProdAttr']['old_price']);
			//$word = $ssProd['productInfo']['name'].'，才'.$orderAttr['money'].'元，'.$discoount.'折，超值！';
			$pic_path = $orderAttr['ssProdAttr']['prodAttr']['imgs'][0]['b_308x330'];
			$access_token = $connect_userinfo['connect_user_info']['access_token'];
//			$link = ROOT_DOMAIN.'/product/p'.$ssProd['friendlyUrl'].'m?channelid=2300002';
			$link = ROOT_DOMAIN.'/'.$sscategory['en_name'].'/'.$specialSale['friendlyUrl'].'?channelid=2300002';

			$site_name = Runtime::getServerNameId()== SpecialSale::SITE_OWNER_KX?'@开心名品特卖':'高街时尚网';
			$word = "Wow！我刚在 ".$site_name." 抢到了 “".$specialSale['name']."” 特卖会的超值商品，总能在这里买到便宜又时髦的商品，太实惠了，有兴趣的朋友们可以去看看哦！@开心名品特卖";

			$kaixin_feed['access_token'] = $access_token;
			$kaixin_feed['text'] = '在'.$site_name.'抢到好东西了！';
			$kaixin_feed['word'] = $word;
			$kaixin_feed['linktext'] = '去'.$site_name;
			$kaixin_feed['link'] = $link;
			$kaixin_feed['picurl'] = $pic_path;

			$objKaixinClient = new KaixinClient($access_token);
			$tmpResult = $objKaixinClient->sendFeed($kaixin_feed);

			break;
	}

}

#主站主动绑定到新浪weibo的用户 add by gen 20120329
$objConnectBind = new ConnectBind();
$userBindInfo = $objConnectBind->getInfoByUidAndLoginType($uid, UserFront::REGISTER_TYPE_SINA);
if (!empty($userBindInfo['id']) && $login_type == UserFront::REGISTER_TYPE_MAINSITE) {
	#主站用户，且新浪微博已登录
	if ($_COOKIE['autofeed']) {
		$text = $pic_path = '';
		Cookie::setCookie('autofeed', null, null,'/');
		$ssProd = array_shift($ssProds);

//		$text = "刚刚发现了一个购物的好地方－@高街时尚网 那么多又fashion又便宜的好东西，开心死了，还可以用新浪微博直接登录，真叫一个赞，喜欢的朋友可以去瞧瞧哦~ ".ROOT_DOMAIN.'/?channelid=2300001';
		$text = "Wow！我刚在@高街时尚网 抢到了 “".$specialSale['name']."” 特卖会的超值商品，总能在这里买到便宜又时髦的商品，太实惠了，有兴趣的朋友们可以去看看哦！".ROOT_DOMAIN.'/'.$sscategory['en_name'].'/'.$specialSale['friendlyUrl'].'?channelid=2300001';
		$pic_path = $specialSale['img_l_662x288'];
		$objSinaConnect = new SinaConnect();
		$objSinaConnect->update($text,$pic_path);
	}
}

#亿玛sem统计
if($_COOKIE['_adwe']){
	$tpl->assign('emar_adwe', $_COOKIE['_adwe']);
}
$objSSCategoryFront  =  new SSCategoryFront();
$cates = array();
foreach($orderAttrs as $tmp) {
	foreach($tmp as $tmp1) {
		//var_dump($tmp1);
		$specialSale1 = $objSpecialSaleFront->get($tmp1['specialSaleId']);
		$categoryId1 = array_shift($specialSale1['categoryIds']);
		$sscategory1 = $objSSCategoryFront->get($categoryId1);
		$cates[$tmp1['specialSaleId']] = $sscategory1;
	}
}

$tpl->assign('cates', $cates);
#sem统计

$YOKA['output'] = $tpl->r('cod_pay_tips');
echo_exit($YOKA['output']);