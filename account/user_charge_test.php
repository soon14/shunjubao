<?php
/**
 * 用户中心充值页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#必须登录
Runtime::requireLogin();
$userInfo = Runtime::getUser();

$tpl = new Template();

#标题
$TEMPLATE ['title'] = "聚宝网充值中心 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网充值中心。';

#埋藏跳转页面


//获取当前在用的支付方式
$user_charge=1;//pc支付宝
$keyw = "zy3658786787676";
$dtime = time();
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_user_charge.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$new_key = json_decode($get_key,true); 
$pc_charge_mark = $new_key["charge_mark"];


//获取当前在用的支付方式
$user_charge=2;//wap支付宝
$keyw = "zy3658786787676";
$dtime = time();
$sign = md5($user_charge.$keyw.$dtime);
$url="http://quan.shunjubao.xyz/get_user_charge.php?user_charge=$user_charge&dtime=$dtime&sign=$sign";
$get_key = file_get_contents($url);
$new_key = json_decode($get_key,true); 
$wap_charge_mark = $new_key["charge_mark"];





$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);

$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);

$YOKA ['output'] = $tpl->r ( 'user_charge_test' );
echo_exit ( $YOKA ['output'] );