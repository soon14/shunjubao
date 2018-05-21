<?php
/**
 * 短信发送脚本
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objUserCode = new UserCode();
$result = $objUserCode->verify();


if (!$result->isSuccess()) {
	ajax_fail_exit($result->getData());
}
//确定可以发送，返回用户uid
//$uid = $result->getData();
$mobile = Request::r('mobile');


$Validate_Code = Request::r('Validate_Code');
if($_SESSION['Validate_Code']!=$Validate_Code){
		echo '-1'; // 验证码不正确 	
		exit();
}


$objZYShortMessage = new ZYShortMessage();
$result = $objZYShortMessage->sendOneRealinfo($mobile);
$code = $objZYShortMessage->getCode();
$_SESSION['realinfo_code']=$code;

if (!$result->isSuccess()) {
	ajax_fail_exit($result->getData());
}

//验证码记录
$objUserRealInfoFront = new UserRealInfoFront();
$results = $objUserRealInfoFront->getsByCondition(array('mobile' => $mobile), 1);
$userRealInfo = array_pop($results);
$code_info = array();
$code_info['u_id'] = $userRealInfo['u_id'];
$code_info['mobile'] = $mobile;
$code_info['code']	= $objZYShortMessage->getCode();
$objUserCode->add($code_info);

ajax_success_exit('发送成功');	
?>