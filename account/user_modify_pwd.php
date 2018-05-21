<?php
/**
 * 密码修改
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();
$userInfo = Runtime::getUser();

$msg_error = '';
$msg_success = '';

if ($_POST) {
	$old_pwd = $_POST['old_pwd'];
	$new_pwd = $_POST['new_pwd'];
	$re_pwd = $_POST['re_pwd'];
	$u_name = $userInfo['u_name'];
	
	do {
		if ($new_pwd != $re_pwd) {
			$msg_error = '新旧密码不一致';
			break;
		}
		$objUserMemberFront = new UserMemberFront();
		$tmpResult = $objUserMemberFront->getByNameAndPassword($u_name, $old_pwd);
		if (!$tmpResult->isSuccess()) {
			$msg_error = '原始密码错误';
			break;
		}
		
		$tmpResult = $objUserMemberFront->updatePasByName($u_name, $new_pwd);
		if (!$tmpResult) {
			$msg_error = '修改密码失败';
			break;
		}
		$msg_success = '修改成功';
	} while (false);
}

$tpl = new Template ();
$TEMPLATE['title'] = '智赢网用户中心-密码修改';
$TEMPLATE['keywords'] = '智赢竞彩,智赢网,智赢用户中心';
$TEMPLATE['description'] = '智赢网用户中心修改密码。';
$tpl->assign('msg_error', $msg_error);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('msg_success', $msg_success);
echo_exit($tpl->r('user_modify_pwd'));