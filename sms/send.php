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

$Validate_Code = trim($_REQUEST['Validate_Code']);
if($_SESSION['Validate_Code']!=$Validate_Code){
	ajax_fail_exit("验证码不对");	
	exit();
}

//检查手机号码是否是后台帐号

$mobile = Request::r('mobile');

log_wap("forgot_mobile.txt",$mobile);

$objZYShortMessage = new ZYShortMessage();
$result = $objZYShortMessage->sendOneResetSecret($mobile);
if (!$result->isSuccess()) {
	ajax_fail_exit($result->getData());
}

//验证码记录
$objUserRealInfoFront = new UserRealInfoFront();
$results = $objUserRealInfoFront->getsByCondition(array('mobile' => $mobile), 1);
if(empty($results)){
	ajax_fail_exit("用户不存在！");	
	exit();	
}

$userRealInfo = array_pop($results);
$code_info = array();
$code_info['u_id'] = $userRealInfo['u_id'];
$code_info['mobile'] = $mobile;
$code_info['code']	= $objZYShortMessage->getCode();
$objUserCode->add($code_info);
$_SESSION['Validate_Code']="";
log_wap("forgot_mobile_suc.txt",$mobile);

ajax_success_exit('发送成功');	


function  log_wap($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}


?>