<?php
/**
 * 付费系统密码设定页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

if ($_REQUEST['email']) {
	#验证邮箱
	$email = Request::r('email');
	if (!Verify::email($email)) {
		fail_exit('邮箱不合法');
	}
	
	#生成密码
	$pwd = Request::r('pwd');
	$repwd = Request::r('repwd');
	if (strlen($pwd) > 20) {
		fail_exit('密码过长');
	}
	if (strlen($pwd) < 6) {
		fail_exit('密码过短');
	}
	
	if ($pwd != $repwd) {
		fail_exit('两次密码不一致');
	}
	
	#have pwd
	$objSubscribeSecret = new SubscribeSecret();
	$results = $objSubscribeSecret->getByEmail($email);
	
	$redirect_navs = array(
		array(
			'href'	=> ROOT_DOMAIN . '/show_recommed.php',//必填。url
			'title'	=> '查看订阅推荐',//必填。描述
			'target'	=> '',//非必填。目标，默认是当前页跳转
		)
	);
	
	if ($results) {
		fail_exit('您的密码已设置', $redirect_navs);
	}
	
	$info = array();
	$info['email'] = $email;
	$info['pwd'] = $pwd;
	
	$result = $objSubscribeSecret->add($info);
	if (!$result) {
		fail_exit('生成密码失败');
	}
	success_exit('', $redirect_navs);
}

?>

<?php 
 echo '<form method="post">';
 echo '请输入订阅邮箱:';
 echo '<input type="text" value="" name="email"/>';
 echo '</br>';
 echo '输入密码:';
 echo '<input type="password" value="" name="pwd"/>(6-20位)';
 echo '</br>';
 echo '密码确认:';
 echo '<input type="password" value="" name="repwd"/>';
 echo '</br>';
 echo '<input type="submit" value="提交"/>';
 echo '</form>';
 exit;
?>