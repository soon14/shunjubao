<?php
/**
 * passport之：密码重置界面
 * #TODO本页面5分钟内有效
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = Request::r('from');

if (empty($from)) {
	$from = Request::getReferer();
}

//防止从注册页过来，导致
if (stripos($from, 'reg.php') !== false || !$from) {
	$from = ROOT_DOMAIN;
}

if (Runtime::isLogin()) {
 	redirect($from);
}

$start_time = time();


$mobile = Request::r('mobile');
$code = Request::r('code');

$u_pwd1 = Request::r('u_pwd1');
$u_pwd2 = Request::r('u_pwd2');

$msg = '';

if (Request::isPost() && $u_pwd1 && $u_pwd2) {
	
	do{
		if ($u_pwd1 != $u_pwd2) {
			$msg = '两次输入密码不一致!';
			break;
		}
		
		$objUserCode = new UserCode();
		$result = $objUserCode->isMobileCanReset($mobile);
		if (!$result->isSuccess()) {
			$msg = $result->getData();
			break;
		}
		
		$result = $objUserCode->verifyMobileAndCode($mobile, $code);
		if (!$result->isSuccess()) {
			$msg = $result->getData();
			break;
		}
		
		$objUserRealInfoFront = new UserRealInfoFront();
		$results = $objUserRealInfoFront->getsByCondition(array('mobile'=>$mobile));
		$userRealInfo = array_pop($results);
		$uid = $userRealInfo['u_id'];
		
		$objUserMemberFront = new UserMemberFront();
		$userInfo = $objUserMemberFront->get($uid);
		$result = $objUserMemberFront->updatePasByName($userInfo['u_name'], $u_pwd1);
		
		if (!$result) {
			$msg = $userInfo['u_name'].'更新失败';
			break;
		}
		//更新成功，可以跳转到首页
		$objTMPassport = new TMPassport();
		$tmpResult = $objTMPassport->login($userInfo['u_name'], $u_pwd1);
		
		if (!$tmpResult->isSuccess()) {
			$msg = $tmpResult->isSuccess();
			break;
		}
		redirect(ROOT_DOMAIN);
	} while (FALSE);

}

$tpl = new Template();
$TEMPLATE['title'] = '重置密码 - ';

$tpl->assign('mobile', $mobile);
$tpl->assign('code', $code);

#出错提示
$tpl->assign('msg', $msg);
echo_exit($tpl->r('reset'));