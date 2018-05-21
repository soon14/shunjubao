<?php
/**
 * passport之：密码重置
 * 
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = Request::r('from');

if (empty($from)) {
	$from = Request::getReferer();
}

//防止从注册页过来，导致
if (stripos($from, 'reg.php') !== false || !$from) {
	$from = ROOT_DOMAIN;
}

if (Runtime::isLogin()) {
 	redirect($from);
}

$tpl = new Template();
$TEMPLATE['title'] = '忘记密码 - ';
#埋藏跳转页面
#出错提示
$tpl->assign('msg', $msg);
echo_exit($tpl->r('forgot'));