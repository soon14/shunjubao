<?php
/**
 * passport之：登录界面
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

if (Request::isPost()) {
	$uname = Request::r('u_name');
	$pwd = Request::r('u_pwd');
	$from = Request::r('from');
	do{
		if (empty ( $uname )) {
			$msg['u_name'] = "用户名不能为空";
			break;
		}
		if (empty ( $pwd )) {
			$msg['u_pwd'] = "密码不能为空";
			break;
		}
		#为我保持登录状态
		$loginTime = null;
		#登录页面
		$objTMPassport = new TMPassport();
		$tmpResult = $objTMPassport->login($uname, $pwd,  $loginTime);
		if($uname=="wgxm169"){
			 $msg['loginerror'] = "帐号已冻结";
			
		}elseif ($tmpResult->isSuccess()) {
			$userInfo =  $tmpResult->getData();		
		    redirect($from);
		    exit;
		} else {
		    $msg['loginerror'] = "用户名或密码错误，请重新输入";
		}
	} while (FALSE);

}

$tpl = new Template();
$TEMPLATE['title'] = '登录 - ';
#埋藏跳转页面
$tpl->assign('from', $from);
#出错提示
if ($msg) {
	$tpl->assign('msg', $msg);
}
//种下cookie方便联合登录时的跳转
TMCookie::set(UserConnect::REDIRECT_URI_COOKIE_KEY, $from);
$objUserConnect = new UserConnect();
$connect_urls = $objUserConnect->getLoginUrl();
$tpl->assign('connect_urls', $connect_urls);
$YOKA ['output'] = $tpl->r ( 'login' );
echo_exit ( $YOKA ['output'] );








