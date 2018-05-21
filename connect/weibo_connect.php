<?php
/**
 * 微博联合登录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$code = Request::r('code');

if (!$code || !is_string($code)) {
	echo_exit('code missing');
}

$objSinaConnect = new SinaConnect();
$token = $objSinaConnect->getAccessToken($code);

if (!$token) {
	echo_exit('token missing');
}

if ($token['error']) {
	log_result_error('weibo_connect_token error:'.var_export($token, true));
	echo_exit($token['error']);
}

/**
 * Array ( [access_token] => 2.00f9HRfCFdQJkD9f99e639c50kX3iQ 
 * [remind_in] => 140520 [expires_in] => 140520 [uid] => 2442175701 ) 
 */
$connect_uid = $token['uid'];
$access_token = $token['access_token'];
$weibo_user_info = $objSinaConnect->getInfo($access_token, $connect_uid);

if (!$weibo_user_info) {
	echo_exit('userInfo missing');
}

if ($weibo_user_info['error']) {
	log_result_error('weibo_connect_user_info error:'.var_export($weibo_user_info, true));
	echo_exit($weibo_user_info['error']);
}

//防止主键冲突
if (isset($weibo_user_info['id'])) {
	unset($weibo_user_info['id']);
}

if (isset($weibo_user_info['status'])) {
	$weibo_user_info['wb_status'] = $weibo_user_info['status'];
	unset($weibo_user_info['status']);
}
$redirect_uri_cookie = TMCookie::get(UserConnect::REDIRECT_URI_COOKIE_KEY);
$redirect_uri = $redirect_uri_cookie?$redirect_uri_cookie:ROOT_DOMAIN;

/**
 * $weibo_user_info
 * Array ( 
 * [id] => 2442175701 
 * [idstr] => 2442175701 
 * [class] => 1 
 * [screen_name] => 天界马拉多纳 //用户昵称
 * [name] => 天界马拉多纳 //用户真实姓名
 * [province] => 11 [city] => 8[location] => 北京 海淀区 [description] => 
 * [url] => http://m profile_image_url] => http://tp2.sinaimg.cn/2442175701/50/40012632777/1 
 * [profile_url] => u/2442175701 
 * [domain] => [weihao] => [gender] => m 
 * [followers_count] => 5 [friends_count] => 124 
 * [pagefriends_count] => 0 
 * [statuses_count] => 12 
 * [favourites_count] => 0 
 * [created_at] => Thu Nov 03 16:43:17 +0800 2011 
 * [following] => 
 * [allow_all_act_msg] => 
 * [geo_enabled] => 1 
 * [verified] => 
 * [verified_type] => -1 
 * [remark] => 
 * [status] => Array ( 
 * [created_at] => Wed Oct 29 16:18:58 +0800 2014 [id] => 3771045355820098 
 * [mid] => 3771045355820098 
 * [idstr] => 3771045355820098 
 * [text] => 小伙伴们，快来围观！我已经升级为V6新版微博，简洁的界面带来更流畅的体验。
 * 			准备好了吗？和我们一起发现新的世界吧！升级猛戳:http://t.cn/R7vgnNI http://t.cn/R7PWmpT 
 * [source_type] => 1 
 * [source] => 微博 weibo.com 
 * [favorited] => [truncated] => [in_reply_to_status_id] => [in_reply_to_user_id] => [in_reply_to_screen_name] => 
 * [pic_urls] => Array ( ) 
 * [geo] => [reposts_count] => 0 [comments_count] => 0 [attitudes_count] => 0 [mlevel] => 0 
 * [visible] => Array ( [type] => 0 [list_id] => 0 ) 
 * [darwin_tags] => Array ( ) 
 * ) 
 * [ptype] => 0 [allow_all_comment] => 1 
 * [avatar_large] => http://tp2.sinaimg.cn/2442175701/180/40012632777/1 
 * [avatar_hd] => http://tp2.sinaimg.cn/2442175701/180/40012632777/1 
 * [verified_reason] => [verified_trade] => 
 * [verified_reason_url] => [verified_source] => [verified_source_url] => 
 * [follow_me] => [online_status] => 0 [bi_followers_count] => 0 
 * [lang] => zh-cn [star] => 0 [mbtype] => 0 [mbrank] => 0 [block_word] => 0 
 * [block_app] => 0 [credit_score] => 80 [urank] => 3 )
 */

$objUserConnect = new UserConnect();
$result = $objUserConnect->hasBind($connect_uid, UserConnect::TYPE_WEIBO_SINA);

$user_info = array();
$user_info = $weibo_user_info;

$user_info['c_uid']			= $connect_uid;
$user_info['token'] 		= $access_token;
$user_info['c_name']		= $weibo_user_info['screen_name']?$weibo_user_info['screen_name']:$weibo_user_info['name'];

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
		$condition['type'] 		= UserConnect::TYPE_WEIBO_SINA;
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
		$user_info['type'] 		= UserConnect::TYPE_WEIBO_SINA;
		$user_info['status'] 	= UserConnect::CONNECT_STATUS_NOT_BIND;
		$connect_id 			= $objUserConnect->add($user_info);
		if (!$connect_id) {
			echo_exit('add band info fail');
		}
	}while (false);

	$redirect_uri = ROOT_DOMAIN . '/connect/trans_user.php?connect_id='.$connect_id;
}

redirect($redirect_uri);
