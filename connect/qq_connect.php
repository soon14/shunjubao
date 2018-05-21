<?php
/**
 * qq联合登录页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$code = Request::r('code');
if (!is_string($code)) {
	echo_exit('weixin connect failed:para->code wrong');
}

//回跳的url
$redirect_uri_cookie = TMCookie::get(UserConnect::REDIRECT_URI_COOKIE_KEY);
$redirect_uri = $redirect_uri_cookie?$redirect_uri_cookie:ROOT_DOMAIN;

$objQQConnect = new QQConnect();
$access_result = $objQQConnect->getAccessTokenByCode($code);

if (!$access_result->isSuccess()) {
	log_result_error('qq_connect_token error:'.$access_result->getData());
	echo_exit($access_result->getData());
}

$access_info = $access_result->getData();
$openid = $access_info['openid'];//与qq号唯一对应
$access_token = $access_info['access_token'];

$user_info_result = $objQQConnect->getUserInfo($access_info);

if (!$user_info_result->isSuccess()) {
	log_result_error('qq_connect_user_info error:'.$user_info_result->getData());
	echo_exit($user_info_result->getData());
}

$user_info = $user_info_result->getData();

//防止主键冲突
if (isset($user_info['id'])) {
	unset($user_info['id']);
}

/**
 * $user_info
 * Array ( [ret] => 0 [msg] => [is_lost] => 0 
 * [nickname] => 天界马拉多纳 [gender] => 男 [province] => 北京 [city] => 海淀 [year] => 1985 
 * [figureurl] => http://qzapp.qlogo.cn/qzapp/101179991/5D134BA9C5D2C93D804B1A4540076F01/30 
 * [figureurl_1] => http://qzapp.qlogo.cn/qzapp/101179991/5D134BA9C5D2C93D804B1A4540076F01/50 
 * [figureurl_2] => http://qzapp.qlogo.cn/qzapp/101179991/5D134BA9C5D2C93D804B1A4540076F01/100 
 * [figureurl_qq_1] => http://q.qlogo.cn/qqapp/101179991/5D134BA9C5D2C93D804B1A4540076F01/40 
 * [figureurl_qq_2] => http://q.qlogo.cn/qqapp/101179991/5D134BA9C5D2C93D804B1A4540076F01/100 
 * [is_yellow_vip] => 0 [vip] => 0 [yellow_vip_level] => 0 [level] => 0 [is_yellow_year_vip] => 0 ) 
 */

$connect_uid = $openid;

$connect_info = array();

$objUserConnect = new UserConnect();
$result = $objUserConnect->hasBind($connect_uid, UserConnect::TYPE_QQ);

$user_info['c_uid']		= $connect_uid;
$user_info['token'] 	= $access_token;
$user_info['c_name'] 	= $user_info['nickname'];

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
		$condition['type'] 		= UserConnect::TYPE_QQ;
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
		$user_info['type'] 		= UserConnect::TYPE_QQ;
		$user_info['status'] 	= UserConnect::CONNECT_STATUS_NOT_BIND;
		$connect_id 			= $objUserConnect->add($user_info);
		if (!$connect_id) {
			echo_exit('add band info fail');
		}
	}while (false);

	$redirect_uri = ROOT_DOMAIN . '/connect/trans_user.php?connect_id='.$connect_id;
}

redirect($redirect_uri);