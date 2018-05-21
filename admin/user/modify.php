<?php
/**
 * 修改用户资料
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
$u_id = $userInfo['u_id'];

$info = $_POST;
if ($info['submit']) {
	$class_name = $info['class_name'];
	$obj = new $class_name;
	$method = 'modify';
	//可能存在一种情况，用户没有添加支付信息
	if ($class_name == 'UserPaymentFront') {
		$userPaymentInfo = $obj->get($info['id']);
		if (!$userPaymentInfo) {
			$method = 'add';
			$info['default'] = UserPayment::DEFAULT_PAY_TYPE;
		}
	}
	//出错信息
	$msg = '';
	switch ($method) {
		case 'modify':
			$tmpResult = $obj->modify($info);
			if (!$tmpResult->isSuccess()) {
				$msg = $tmpResult->getData();
			}
			break;
		case 'add':
			$id = $obj->add($info);
			if (!$id) {
				$msg = '添加:'.$class_name.' 信息失败';
			}
			break;
		default:
			$msg = '错误的方法';
			break;
	}
	
	if ($msg) {
		fail_exit($msg);
	}
	success_exit();
}

$tpl = new Template();

echo_exit($tpl->r('../admin/user/modify'));