<?php
/**
 * 用户中心总览页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$refer = $_GET['from']?$_GET['from']:ROOT_DOMAIN;
$userInfo = Runtime::getUser();

#未登录用户跳转
if (!$userInfo) {
	redirect(ROOT_DOMAIN . '/passport/login.php?from=' . ROOT_DOMAIN . $_SERVER['PHP_SELF']);
	exit;
}

$tpl = new Template();

#标题
$TEMPLATE ['title'] = "聚宝网用户中心 ";

#埋藏跳转页面
$tpl->assign ( 'refer', $refer );

$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();
$objUserScoreLogFront = new UserScoreLogFront();
$objUserPMSFront = new UserPMSFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);
$userScore = $objUserScoreLogFront->get($userInfo['u_id']);
$unRecieviSum = $objUserPMSFront->getUnRecieviSum($userInfo['u_id']);

$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);
$tpl->assign('userScore', $userScore);
$tpl->assign('unRecieviSum', $unRecieviSum);

$YOKA ['output'] = $tpl->r ( 'user_center' );
echo_exit ( $YOKA ['output'] );