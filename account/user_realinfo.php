<?php
/**
 * 用户中心实名认证页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();
$userInfo = Runtime::getUser();


$msg_error = '';
$msg_success = '';
$userRealInfo = array();

$tpl = new Template();
$objUserRealInfoFront = new UserRealInfoFront();

if ($_POST) {
	
	$realname 	= Request::p('realname');
    $idcard		= Request::p('idcard');
    $reidcard	= Request::p('reidcard');
	$mobile	= Request::p('mobile');
    $code	= Request::p('code');
	
	
    do {
    	if (mb_strlen($realname) > 40) {
    		$msg_error = '姓名过长';
    		break;
    	}
		
		if ($code!=$_SESSION['realinfo_code']) {
    		$msg_error = '手机验证码不正确';
    		break;
    	}
		
    	if ($idcard != $reidcard) {
    		$msg_error = '两次身份证号不一致';
    		break;
    	}
    	if (mb_strlen($idcard) > 20) {
    		$msg_error = '身份证号不正确';
    		break;
    	}
    	#验证身份证的唯一性
    	$tmpResult = $objUserRealInfoFront->getsByCondition(array('idcard'=>$idcard), 1);
    	if ($tmpResult) {
    		$msg_error = '身份证号已存在不允许绑定';
    		break;
    	}
	    $tableInfo = array();
	    $tableInfo['u_id'] 			= $userInfo['u_id'];
	    $tableInfo['realname'] 		= $realname;
	    $tableInfo['idcard'] 		= $idcard;
	    $tableInfo['mobile'] 		= $mobile;		
		
		
		
	    
	    $tmpResult = $objUserRealInfoFront->modify($tableInfo);
	    if (!$tmpResult->isSuccess()) {
	    	$msg_error = '更新信息失败';
	    	break;
	    }
	    
	    $msg_success = '更新成功';
     }while (false);
} 
$userRealInfo = $objUserRealInfoFront->get($userInfo['u_id']);




if ($userRealInfo['idcard']) {
	//隐去身份证中间几位
	$s_idcard = $userRealInfo['idcard'];
	$userRealInfo['idcard'] = substr($s_idcard, 0, 3) . '*******' . substr($s_idcard, -4, 4);
}

#标题
$TEMPLATE ['title'] = "聚宝网用户实名认证  ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户实名认证。';
$tpl->assign('msg_error', $msg_error);
$tpl->assign('msg_success', $msg_success);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userRealInfo', $userRealInfo);
$tpl->assign('userRealInfoJson', json_encode($userRealInfo));
echo_exit($tpl->r('user_realinfo'));