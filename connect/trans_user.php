<?php
/**
 * 联合登录中转页面
 * 目的：其他平台过来的，且未绑定网站用户的，会有三种情况出现
 * 1、绑定网站已有帐户，建立关联（需要验证密码）
 * 2、绑定网站没有有帐户，但平台用户名跟其他用户的用户名相同，新建帐号并重命名
 * 3、绑定网站没有有帐户,用户名可用，直接创建帐号并绑定
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$connect_id = Request::r('connect_id');

if (!Verify::int($connect_id)) {
	echo_exit('connect_id wrong');
}

$objUserConnect = new UserConnect();
$connect_info = $objUserConnect->get($connect_id);
// $connect_info = $objUserConnect->get(1);
if (!$connect_info) {
	echo_exit('info not found');
}

//必须是未绑定状态
if ($connect_info['status'] != UserConnect::CONNECT_STATUS_NOT_BIND) {
	echo_exit('status wrong');
}

//平台用户名
$c_name = $connect_info['c_name'];
$objUserMemberFront = new UserMemberFront();
//判断是否有同名用户
$same_user = $objUserMemberFront->getByName($c_name);

$tpl = new Template();
$tpl->assign('same_user', $same_user);
$typeDesc = UserConnect::getTypesDesc();
$tpl->assign('typeDesc', $typeDesc);
$tpl->assign('connect_info', $connect_info);
echo_exit($tpl->r('trans_user'));