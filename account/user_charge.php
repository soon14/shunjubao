<?php
/**
 * 用户中心充值页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();
$uid 		= Runtime::getUid();
$tpl = new Template();

#标题
$TEMPLATE ['title'] = "聚宝网充值中心 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网充值中心。';

#埋藏跳转页面



$keyw = "zy3658786787676";
$dtime = time();

//获取当前在用的支付方式
$user_charge=1;//pc支付宝
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_user_charge.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$new_key = json_decode($get_key,true); 
$pc_charge_mark = $new_key["charge_mark"];


//获取当前在用的支付方式
$user_charge=2;//wap支付宝
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_user_charge.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$new_key = json_decode($get_key,true); 
$wap_charge_mark = $new_key["charge_mark"];

//==================================================================================
//判断是否频繁出错帐号，使用聚宝充值帐号
$user_charge=2;//wap支付宝
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_charge_alipay_unusual.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$unusual_list = json_decode($get_key,true); 
//var_dump($unusual_list);
if(in_array($uid,$unusual_list)){
	$wap_charge_mark="ALIPAY";
}

//判断是否频繁出错帐号，使用聚宝充值帐号
$user_charge=1;//wap支付宝
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_charge_alipay_unusual.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$unusual_list = json_decode($get_key,true); 
//var_dump($unusual_list);
if(in_array($uid,$unusual_list)){
	$pc_charge_mark="ALIPAY";
}
//==================================================================================
$tpl->assign('pc_charge_mark', $pc_charge_mark);
$tpl->assign('wap_charge_mark', $wap_charge_mark);




$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);

$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);

$YOKA ['output'] = $tpl->r ( 'user_charge' );
echo_exit ( $YOKA ['output'] );