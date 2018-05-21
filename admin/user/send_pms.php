<?php
/**
 * 后台之：发送pms，支持多用户发送
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$type = $_POST['type'];//发送方式，1、按用户名；2、按用户id
$body = Request::r('body');//发送内容
$subject = Request::r('subject');//主题
$user_names = Request::r('user_names');//按换行方式区分

$user_names = explode("\r\n", $user_names);
$uids = $fail_uname = array();

$objUserMemberFront = new UserMemberFront();
$objUserPMSFront = new UserPMSFront();

$tpl = new Template();

switch ($type) {
	case 'user_name':
		foreach ($user_names as $name) {
			$user = $objUserMemberFront->getByName($name);
			if ($user) {
				$tableInfo = array();
				$tableInfo['body'] = $body;
				$tableInfo['receive_uid'] = $user['u_id'];
				$tableInfo['subject'] = $subject;
				$tableInfo['send_uid'] = Runtime::getUid();//当前用户uid为发送人uid
				$result = $objUserPMSFront->addOnePMS($tableInfo);
				if (!$result) {
					$fail_uname[] = $name;
				}
			} else {
				$fail_uname[] = $name;
			}
		}
		
		break;
	case 'u_id':
		foreach ($user_names as $uid) {
			$user = $objUserMemberFront->get($uid);
			if ($user) {
				$tableInfo = array();
				$tableInfo['body'] = $body;
				$tableInfo['receive_uid'] = $user['u_id'];
				$tableInfo['subject'] = $subject;
				$tableInfo['send_uid'] = Runtime::getUid();//当前用户uid为发送人uid
				$result = $objUserPMSFront->addOnePMS($tableInfo);
				if (!$result) {
					$fail_uname[] = $name;
				}
			} else {
				$fail_uname[] = $name;
			}
		}
		break;
	default:
		echo_exit($tpl->r('../admin/user/send_pms'));
		break;
}

if ($fail_uname) {
	fail_exit('有部分用户发送失败:'.implode("\r\n", $fail_uname));
}
success_exit();