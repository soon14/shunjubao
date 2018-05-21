<?php
/**
 * 付费系统密码设定页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#判断角色
$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit_g("该页面不允许查看");
}

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$tpl = new Template();

$info = $_POST;
if ($info['email'] && $info['pwd']) {
	#TODO对信息进行过滤处理
	
	$email = $info['email'];
	$pwd = $info['pwd'];
	
	if (!Verify::email($email)) {
		fail_exit("用户邮箱:{$email},格式不正确");
	}
	
	$objSubscribeSecret = new SubscribeSecret();
	$results = $objSubscribeSecret->getByEmail($email);
	
	if (!$results) {
		fail_exit('密码还未设置，不能重置');
	}
	
	$tmpResult = $objSubscribeSecret->updatePwd($email, $pwd);
	if (!$tmpResult) {
		fail_exit('failed');
	}
	success_exit();
} else {
	echo '<h3>重置邮箱密码</h3>';
	echo '</br>';
	echo '<form method="post">';
	echo '请输入订阅邮箱:';
	echo '<input type="text" value="" name="email"/>';
	echo '</br>';
	echo '请输入新密码:(6-20位)';
	echo '<input type="password" value="" name="pwd"/>';
	echo '</br>';
	echo '<input type="submit" value="重置密码"/>';
	echo '</form>';
	exit;
}
