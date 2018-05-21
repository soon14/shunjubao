<?php
/**
 * 获取用户各类信息
 * 可以按照用户名、真实姓名、手机号和身份证号查询
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userInfo = $userInfos = array();


$u_name = Request::r('user_name');

$objUserMemberFront = new UserMemberFront();
if ($u_name) {
	$userInfo = $objUserMemberFront->getByName($u_name);
}

$user_id = Request::r('user_id');

if ($user_id) {
	$userInfo = $objUserMemberFront->get($user_id);
}

$objUserRealInfoFront = new UserRealInfoFront();

$realname = Request::r('realname');
if ($realname) {
	$condition = array();
	$condition['realname'] = $realname;
	$userInfos = $objUserRealInfoFront->getsByCondition($condition);
	if (count($userInfos) >= 2) {
		$uids = array();
		foreach ($userInfos as $value) {
			$uids[] = $value['u_id'];
		}
		ajax_fail_exit('发现同名用户，无法分辨,uid分别为：'.var_export($uids, true));
	}
}

$idcard = Request::r('idcard');
if ($idcard) {
	$condition = array();
	$condition['idcard'] = $idcard;
	$userInfos = $objUserRealInfoFront->getsByCondition($condition);
}

$mobile = Request::r('mobile');
if ($mobile) {
	$condition = array();
	$condition['mobile'] = $mobile;
	$userInfos = $objUserRealInfoFront->getsByCondition($condition);
	if (count($userInfos) >= 2) {
		$uids = array();
		foreach ($userInfos as $value) {
			$uids[] = $value['u_id'];
		}
		ajax_fail_exit('发现同手机号用户，无法分辨,uid分别为：'.var_export($uids, true));
	}
}

if ($userInfos) {
	$userInfo_tmp = array_pop($userInfos);
	$userInfo = $objUserMemberFront->get($userInfo_tmp['u_id']);
}

if (!$userInfo) {
	ajax_fail_exit('用户不存在');
}

$u_id = $userInfo['u_id'];

$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($u_id);
$userRealInfo = $objUserRealInfoFront->get($u_id);

$objUserPaymentFront = new UserPaymentFront();
$userPaymentInfo = $objUserPaymentFront->getDefaultPaymentInfo($u_id);
$return = array();

$return['userInfo'] = $userInfo;
$return['userAccountInfo'] = $userAccountInfo;
$return['userRealInfo'] = $userRealInfo;
$return['userPaymentInfo'] = $userPaymentInfo;
ajax_success_exit($return);