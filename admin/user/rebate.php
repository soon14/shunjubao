<?php
/**
 * 添加账户返点比例
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}
$tpl = new Template();

$info = $_POST;
if ($info['u_name']) {
	$u_name = $info['u_name'];
	$objUserMemberFront = new UserMemberFront();
	$userInfo = $objUserMemberFront->getByName($u_name);
	
	if (!$userInfo) {
		fail_exit('未找到用户');
	}
	
	$rebate = $info['rebate'];
	if ($rebate >= 100 || $rebate < 0) {
		fail_exit('返点比例错误');
	}
	
	$u_id = $userInfo['u_id'];
	
	$objUserAccountFront = new UserAccountFront();
	$userAccountInfo = $objUserAccountFront->get($u_id);
	
	$userAccountInfo['rebate_per'] = ConvertData::toMoney($rebate/100, false);
	
	$tmpResult = $objUserAccountFront->modify($userAccountInfo);
	
	if (!$tmpResult->isSuccess()) {
		fail_exit('修改返点比例失败，原因：'.$tmpResult->getData());
	}
	success_exit('为用户：'.$u_name.'修改返点比例（'.$rebate.'%)成功');
}

echo_exit($tpl->r('../admin/user/rebate'));