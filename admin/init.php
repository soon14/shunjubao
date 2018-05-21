<?php
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'function.inc.php';

$tmpParams = array(
	'from'	=> Request::getCurUrl(),
);
$reLoginUrl = jointUrl(ROOT_DOMAIN . '/passport/relogin.php', $tmpParams);
if (!Runtime::getsRoles()) {
	fail_exit_g("权限不足", "您没有后台权限", array(
		array(
			"title"	=> "重新登录",
			"href"	=> $reLoginUrl,
		),
	));
}
define('SUBSCRIBE_EAMIL_START_DATE', '2014-03-23 00:00:00');