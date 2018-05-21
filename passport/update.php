<?php 
/**
 * passport之：用户信息更新
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
echo_exit('access denied');
if (!Runtime::islogin()) {
	echo '没有登录';
	exit;
}

$user = Runtime::getUser();
#更新类型
$type = Request::p('type');
$info = $_POST;

$objUserMemberFront = new UserMemberFront();
$objUserRealInfoFront = new UserRealInfoFront();

$condition = array();
$condition['u_id'] = $user['u_id'];

switch ($type) {
	#修改密码
	case 'pas':
		$oldPas = $info['oldPas'];
		$newPas = $info['newPas'];
		$rePas = $info['rePas'];
		if ($oldPas != $user['u_pwd']) {
			echo 'pas wrong1';
			exit;
		}
		if ($newPas != $rePas) {
			echo 'pas wrong2';
			exit;
		}
		
		$tmpResult = $objUserMemberFront->updatePasByName($user['u_name'], $newPas);
		if (!$tmpResult) {
			echo 'failed';
			exit;
		}
		
		break;
	#修改会员信息
	case 'member':
		$tmpResult = $objUserMemberFront->modify($info, $condition);
		if (!$tmpResult->isSuccess()) {
			echo $tmpResult->getData();
			exit;
		}
		break;
	#修改扩展信息
	case 'realinfo':
		
		$tmpResult = $objUserRealInfoFront->modify($info, $condition);
		if (!$tmpResult->isSuccess()) {
			echo $tmpResult->getData();
			exit;
		}
		break;
	default:
		echo '错误的类型';
		exit;
}
echo 'success';
exit;
?>