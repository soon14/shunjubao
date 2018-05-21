<?php
/**
 * passport之：注册界面
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$refer = Request::r('refer');

if (empty($refer)) {
	$refer = Request::getReferer();
}

//防止从登录页过来，导致
if (stripos($refer, 'login.php') !== false || !$refer) {
	$refer = ROOT_DOMAIN;
}

#已登录用户跳转
if (Runtime::isLogin()) {
	redirect($refer);
}

$tpl = new Template ();
if (Request::isPost()) {
	$submitInfo = array();
	$submit = Request::r('submit');
	if (isset($submit)) {
		$msg = array();
		do {
			#验证用户名
			$u_name = Request::p('u_name');
			$submitInfo['u_name'] = $u_name;
			
			
			$Validate_Code = Request::r('Validate_Code');

			/*if($_SESSION['Validate_Code']!=$Validate_Code){
				$msg['Validate_Code'] = '验证码出错';
			}*/
			
			
		/*	
			$code = Request::p('code');//手机验证码
			if(empty($code)){
				$msg['tips100'] = '手机验证码不能为空！';
			}
			
			if ($_SESSION['mcode']!=$code) {
				$msg['tips100'] = '请输入正确的手机验证码！';
			}*/
		
			//var_dump($_SESSION);//exit();
			#1、是否合法
			$tmpVerifyResult = UserMemberFront::verifyName($u_name);
			if (!$tmpVerifyResult->isSuccess()) {
				$msg['u_name'] = $tmpVerifyResult->getData();
			}
			#2、是否已经注册
			$objUserMemberFront = new UserMemberFront();
			$tmpResult = $objUserMemberFront->getByName($u_name);
			if ($tmpResult) {
				$msg['u_name'] = '用户已存在';
			}
			#3、手机是否合法
			$mobile = Request::r('mobile');
			$submitInfo['mobile'] = $mobile;
			if (!Verify::mobile($mobile)) {
				$msg['mobile'] = '手机号不合法';
			}
			#手机是否能够注册
			$objUserRealInfoFront = new UserRealInfoFront();
			$mobileCanReg = $objUserRealInfoFront->isMobileCanRegister($mobile);
			if (!$mobileCanReg) {
				$msg['mobile'] = '手机号已注册';
			}
			#验证密码
			$submitInfo['u_pwd'] = Request::r('u_pwd');
			if (empty ( $submitInfo['u_pwd'] )) {
				$msg['newpas'] = "密码不能为空";
			}
			#验证确认密码
			$repas = Request::r('repas');
			if (empty ( $repas )) {
				$msg['repas'] = "密码不能为空";
			}
			#密码不一致
			if ($submitInfo['u_pwd'] != $repas ) {
				$msg['repas'] = "密码不一致";
			}
			#密码长度
			if ($submitInfo['u_pwd'] == $repas && strlen ( $repas )<6 ) {
				$msg['newpas'] = "密码长度不能小于6位";
			}
			
			
			#注册ip限制
			if (!$objUserMemberFront->isIPCanReg()) {
				$msg['ip'] = "注册功能限制";
			}
		} while ( FALSE );

        #注册用户
		if (!$msg) {
			$objTMPassport = new TMPassport();
			$result = $objTMPassport->register($submitInfo);
			if ($result->isSuccess()) {
				$userInfo = $result->getData();
				//注册送彩金
// 				addGift($userInfo['u_id'], 3);
				$tpl->assign('userInfo', $userInfo);
				$tpl->assign ('refer', $refer);
				$YOKA ['output'] = $tpl->r ('reg_success');
				echo_exit( $YOKA ['output'] );
			} else {
				$msg = $result->getData();
			}
		}
//		pr($msg);exit;
	}
}
#标题
$TEMPLATE ['title'] = "注册 - ";

$tpl->assign ( 'submitInfo', $submitInfo );
#错误信息
if($msg) {
	$tpl->assign ( 'msg', $msg );
}

#埋藏跳转页面
$tpl->assign ( 'refer', $refer );
$YOKA ['output'] = $tpl->r ( 'reg' );
echo_exit ( $YOKA ['output'] );