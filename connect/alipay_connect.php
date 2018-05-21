<?php
/**
 * 支付宝联合登录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$params = Request::getRequestParams();
/**
 * $params
 * Array ( 
 * [is_success] => T 
 * [notify_id] => RqPnCoPT3K9%2Fvwbh3InTuvyrMN%2BmjYYHLXczSVEGwrxCZL5pqeF6%2B7PUDlPfR7XnKOLS 
 * [real_name] => 胡世聿 
 * [token] => 20150109f770656d1d6f4b4886e70ee174ee3B49 
 * [user_id] => 2088002949743499 //支付宝平台用户唯一标示
 * [sign] => cd2daafbce76f79a2f3597b0594422f8 
 * [sign_type] => MD5 ) 
 */
//校验参数
$objAlipayConnect = new AlipayConnect();
$result = $objAlipayConnect->verifyNotify($params);

if (!$result) {
	log_result_error('请求未通过校验:'.var_export($params, true));
	echo_exit('请求未通过校验，时间超时');
}

$redirect_uri_cookie = TMCookie::get(UserConnect::REDIRECT_URI_COOKIE_KEY);
$redirect_uri = $redirect_uri_cookie?$redirect_uri_cookie:ROOT_DOMAIN;

//防止主键冲突
if (isset($params['id'])) {
	unset($params['id']);
}

$connect_uid = $params['user_id'];
$access_token = $params['token'];//30分钟有效
$c_name = $params['real_name'];

$connect_info = array();

$objUserConnect = new UserConnect();
$result = $objUserConnect->hasBind($connect_uid, UserConnect::TYPE_ALIPAY);

$user_info = array();
$user_info = $params;
$user_info['c_uid']			= $connect_uid;
$user_info['token'] 		= $access_token;

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
		$condition['type'] 		= UserConnect::TYPE_ALIPAY;
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
		$user_info['type'] 		= UserConnect::TYPE_ALIPAY;
		$user_info['c_name'] 	= $c_name;
		$user_info['status'] 	= UserConnect::CONNECT_STATUS_NOT_BIND;
		$connect_id 			= $objUserConnect->add($user_info);
		if (!$connect_id) {
			echo_exit('add band info fail');
		}
	}while (false);

	$redirect_uri = ROOT_DOMAIN . '/connect/trans_user.php?connect_id='.$connect_id;
}

redirect($redirect_uri);