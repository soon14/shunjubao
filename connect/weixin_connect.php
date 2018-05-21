<?php
/**
 * 微信联合登录
 * 步骤：
 * 1、获取access_token和openid
 * 2、获取用户信息
 * 3、判断是否绑定过主站帐号
 * 
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$code = Request::r('code');
if (!is_string($code)) {
	echo_exit('weixin connect failed:para->code wrong');
}
//回跳的url
$redirect_uri_cookie = TMCookie::get(UserConnect::REDIRECT_URI_COOKIE_KEY);
$redirect_uri = $redirect_uri_cookie?$redirect_uri_cookie:ROOT_DOMAIN;

$objWeiXinConnect = new WeiXinConnect();
$access_info = $objWeiXinConnect->getAccessTokenByCode($code);
//获取token不成功
if (!$access_info) {
	echo_exit('access_info get fail');
}
$errcode = $access_info->errcode;
if ($errcode) {
	log_result_error('weixin_connect_token error:'.$errcode.' errmsg:'.$access_info->errmsg);
	echo_exit('get access error:'.$access_info->errmsg);
}

$access_token = $access_info->access_token;
$openid = $access_info->openid;

$weixin_user_info = $objWeiXinConnect->getUserInfo($access_token, $openid);
//获取用户信息失败
if (!$weixin_user_info) {
	echo_exit('user info get fail');
}
$errcode = $weixin_user_info->errcode;
if ($errcode) {
	log_result_error('weixin_connect_user_info error:'.$errcode.' errmsg:'.$weixin_user_info->errmsg);
	echo_exit('get weixin_user_info error:'.$weixin_user_info->errmsg);
}
//当前应用下用户唯一标示
$connect_uid = $weixin_user_info->unionid;

$objUserConnect = new UserConnect();
$result = $objUserConnect->hasBind($connect_uid, UserConnect::TYPE_WEIXIN);

$user_info = array();
$user_info = $objWeiXinConnect->objUserInfoTOArray($weixin_user_info);

//防止主键冲突
if (isset($user_info['id'])) {
	unset($user_info['id']);
}

$user_info['c_uid']			= $connect_uid;
$user_info['token'] 		= $access_token;
$user_info['refresh_token'] = $access_info->refresh_token;

/**
 * $user_info
 * Array ( [openid] => omegQs6laqdihBlJjxjbT4yvs4gI 
 * [nickname] => 胡世聿 [sex] => 0 [province] => [city] => [country] => 
 * [headimgurl] => 
 * [unionid] => oQYLTstqd_Ie45i2QICcc6uX9tL4 
 * [privilege] => Array ( ) )
 */
//已经绑定，更新各种信息
if ($result) {
	
	$user_info['id'] = $result['id'];
	$objUserConnect->modify($user_info);
	
	$objUserMemberFront = new UserMemberFront();
	$user = $objUserMemberFront->get($result['u_id']);
	
	//为其登录
	$objTMPassport = new TMPassport();
	$objTMPassport->loginByUserInfo($user);
	#TODO更新个人信息,头像等
	
} else {
//未绑定，看情况跳转到中转页面

	do{
		
		//情况1：有过未绑定的记录
		$condition = array();
		$condition['c_uid'] 	= $connect_uid;
		$condition['type'] 		= UserConnect::TYPE_WEIXIN;
		$condition['status'] 	= UserConnect::CONNECT_STATUS_NOT_BIND;
		$user_connect_info 		= $objUserConnect->getsByCondition($condition);
		if ($user_connect_info) {
			$user_connect_info = array_pop($user_connect_info);
			$connect_id 		= $user_connect_info['id'];
			$user_info['id'] 	= $connect_id;
			$objUserConnect->modify($user_info);
			break;
		}
		
		//情况2：没有未绑定的记录
		//添加平台信息但不绑定用户
		$user_info['type'] 		= UserConnect::TYPE_WEIXIN;
		$user_info['c_name'] 	= $user_info['nickname'];
		$user_info['status'] 	= UserConnect::CONNECT_STATUS_NOT_BIND;
		$connect_id 			= $objUserConnect->add($user_info);
		if (!$connect_id) {
			echo_exit('add band info fail');
		}
	}while (false);
	
	$redirect_uri = ROOT_DOMAIN . '/connect/trans_user.php?connect_id='.$connect_id;
}

redirect($redirect_uri);