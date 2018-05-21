<?php
/**
 * passport之：重新登录界面，如果已登录的用户，会被清掉登录状态
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = Request::r('from') ? Request::r('from') : ROOT_DOMAIN;

if (!Request::isGet()) {
	fail_exit_g("只接受get方式请求");
}

if (Runtime::isLogin()) {
	# 清掉登录状态
	$objTMPassport = new TMPassport();
	$objTMPassport->logout();
}

$tpl = new Template();
$TEMPLATE['title'] = '登录 - ';

$tpl->assign('from', $from );

$YOKA['output'] = $tpl->r('login');
echo_exit($YOKA['output']);