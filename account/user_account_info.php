<?php
/**
 * 用户中心之账户信息总览页，默认页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$refer = $_GET['from']?$_GET['from']:ROOT_DOMAIN;
$userInfo = Runtime::getUser();

$tpl = new Template();
#标题
$TEMPLATE ['title'] = "账户信息 - ";

$tpl->assign('userInfo', $userInfo);

$objUserRealInfo = new UserRealInfo();
$objUserAccountFront = new UserAccountFront();
$objUserScoreLogFront = new UserScoreLogFront();

$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);
$userScore = $objUserScoreLogFront->get($userInfo['u_id']);

$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userAccount', $userAccount);
$tpl->assign('userScore', $userScore);

$YOKA ['output'] = $tpl->r ( 'user_account_info' );
echo_exit ( $YOKA ['output'] );