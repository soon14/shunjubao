<?php
/**
 * 获取指定name的用户信息，若没有该用户则回调空数组。
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$username = Request::g('u_name', Filter::TRIM);

# 因为这个功能仅用于注册时判断该用户是否注册过，所以这个强制把用户名转成小写。
$username = mb_strtolower($username, 'UTF-8');

$objUserFront = new UserMemberFront();
$UserInfo = $objUserFront->getByName($username);

if ( $UserInfo['u_name'] ) {
	ajax_success_exit($UserInfo);
}else {
	ajax_fail_exit(array());
};

