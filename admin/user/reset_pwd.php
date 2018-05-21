<?php
/**
 * 修改用户密码
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$userInfo = Runtime::getUser();

$info = $_POST;
if ($info['submit']) {
	
	$u_name = $info['u_name'];
	
	$objUserMemberFront = new UserMemberFront();
	$user = $objUserMemberFront->getByName($u_name);
	if (!$user) {
		fail_exit('用户：'.$u_name.'未找到');
	}
	$pwd = $info['pwd'];
	$re_pwd = $info['re_pwd'];
	
	if ($pwd != $re_pwd) {
		fail_exit('两次密码不一致');
	}
	$tmpResult = $objUserMemberFront->updatePasByName($u_name, $pwd);
	if (!$tmpResult) {
		fail_exit('更新密码失败');
	}
	
	//操作日志
	$tableInfo = $info;
	$tableInfo['type'] = OperateRecord::OPTYPE_MODIFY_PWD;
	$objOperateRecordFront = new OperateRecordFront();
	$objOperateRecordFront->add($tableInfo);
	
	success_exit();
}
$tpl = new Template();
echo_exit($tpl->r('../admin/user/reset_pwd'));