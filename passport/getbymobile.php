<?php
/**
 * 获取指定name的用户信息，若没有该用户则回调空数组。
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$mobile = Request::g('mobile', Filter::TRIM);

# 因为这个功能仅用于注册时判断该用户是否注册过，所以这个强制把用户名转成小写。
$mobile = mb_strtolower($mobile, 'UTF-8');

$objUserFront = new UserRealInfo();
$UserInfo = $objUserFront->getIdByMobile($mobile);

if ( $UserInfo['u_name'] ) {
	ajax_success_exit($UserInfo);
}else {
	ajax_fail_exit(array());
};

