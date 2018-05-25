<?php
/**
 * 个人基本信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();
$userInfo = Runtime::getUser();

#错误信息
$msg_error = '';
$tpl = new Template ();
$TEMPLETE['title'] = '聚宝网用户个人基本信息';
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户个人基本信息。';
$objUserMemberFront = new UserMemberFront();
$objUserRealInfoFront = new UserRealInfoFront();
$objUserAccountFront = new UserAccountFront();
$objUserScoreLogFront = new UserScoreLogFront();

$userRealInfo = $objUserRealInfoFront->get($userInfo['u_id']);

#截取字符，不显示具体时间
if (strtotime($userInfo['u_birthday'])) {
	$birthday_date = substr($userInfo['u_birthday'], 0, 10);
}

if ($_POST) {
	#是否需要保存生日
	$birthday_date = Request::p('u_birthday')?Request::p('u_birthday'):$birthday_date;
	$u_address = Request::p('u_address');
	$u_nick = Request::p('u_nick');
	$mobile = Request::p('mobile');
do{
	if ($birthday_date) {
		$userInfo['u_birthday'] = $birthday_date . ' 12:00:00';//加上一个默认的时间
	}
	
	if ($u_address){
		if (strlen($u_address) <= 200) {
			$userInfo['u_address'] = $u_address;
		} else {
			$msg_error = '地址过长';
			break;
		}
	}
	
	if ($u_nick) {
		if (UserMemberFront::verifyName($u_nick)) {
			$userInfo['u_nick'] = $u_nick;
		} else {
			$msg_error = '用户昵称只允许 中文、_、a-z、A-Z、0-9';
			break;
		}
	}
	//手机号为必填
	if (Verify::mobile($mobile)) {
		$userRealInfo['mobile'] = $mobile;
		#保存用户扩展信息
		$tmpResult = $objUserRealInfoFront->modify($userRealInfo);
		if (!$tmpResult->isSuccess()) {
			$msg_error = '保存用户手机号失败';
			break;
		}
	} else {
		$msg_error = '请输入正确用户手机号';
		break;
	}

	#保存用户基本信息
	$tmpResult = $objUserMemberFront->modify($userInfo);
	if (!$tmpResult->isSuccess()) {
		$msg_error = '保存用户信息失败';
		break;
	}
	    
	 $msg_success = '更新成功';
}while (false);
}
$tpl->assign('birthday_date', $birthday_date);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('msg_error', $msg_error);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userInfo', $userInfo);
echo_exit($tpl->r('user_basic'));