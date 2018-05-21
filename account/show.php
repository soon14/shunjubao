<?php
/**
 * account之：用户管理界面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = $_GET['from'] ? $_GET['from'] : ROOT_DOMAIN;

if (!Runtime::isLogin()) {
	redirect(ROOT_DOMAIN.'/passport/login.php');
	exit;
}

#用户id
$userInfo = Runtime::getUser();
if (empty($userInfo)) {
	fail_exit_g('该用户不存在');
}

#获取用户信息
$objUserMemberFront = new UserMemberFront();

$tpl = new Template();

$tpl->assign('cur_tab', 'account_show');

# 获取用户扩展信息、余额信息
$objUserRealInfoFront = new UserRealInfoFront();
$objUserAccountFront = new UserAccountFront();

$userRealInfo = $objUserRealInfoFront->get($userInfo['u_id']);
$userAccount = $objUserAccountFront->get($userInfo['u_id']);


#左侧栏样式
$tpl->assign('account_left', 'show' );
$tpl->assign('userInfo', $userInfo );
$TEMPLATE['title'] = '账户信息 -';


$YOKA['output'] = $tpl->r('account_show');
echo_exit($YOKA['output']);
