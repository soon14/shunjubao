<?php
/**
 * 大乐透提交页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$from = Request::r('from');

if (empty($from)) {
	$from = Request::getReferer();
}

if (Runtime::isLogin()==false) {
	redirect('/passport/login.php?from='.$from);
}

$tpl = new Template();
$TEMPLATE['title'] = '大乐透- ';

//种下cookie方便联合登录时的跳转
TMCookie::set(UserConnect::REDIRECT_URI_COOKIE_KEY, $from);
$objUserConnect = new UserConnect();
$objUserAccountFront = new UserAccountFront();
$connect_urls = $objUserConnect->getLoginUrl();
$tpl->assign('connect_urls', $connect_urls);
$userInfo=Runtime::getUser();
$tpl->assign('userinfo',$userInfo);// 用户信息
$tpl->assign('TotalMoney',(Request::r('WagerCount')*2)*Request::r('MultiNum'));
$datajson = urldecode(Request::r('WagerStore'));
$data_arr=json_decode($datajson,true);
$li_data=array();
foreach($data_arr as $key=>$val){
	foreach($val as $key2=>$valson){
		$lid = explode('|',$valson['wager']);
		$qianqu=explode(",",$lid[1]);
		$houqu=explode(",",$lid[2]);
		$li_data[]=array('wc'=>$valson['wc'],'named'=>$lid[0],'qianqu'=>$qianqu,'houqu'=>$houqu);
	}
}
$userAccount = $objUserAccountFront->get($userInfo['u_id']);
$tpl->assign('userAccount', $userAccount);
//echo Request::r('WagerType');die;
$tpl->assign('u_id',Runtime::getUid());
$tpl->assign('MultiNum',Request::r('MultiNum'));
$tpl->assign('WagerCount',Request::r('WagerCount'));
$tpl->assign('WagerType',Request::r('WagerType'));
$tpl->assign('WagerStore',Request::r('WagerStore')); // data_json
$tpl->assign('manner',Request::r('manner'));
$tpl->assign('LotteryNo',Request::r('LotteryNo'));
$tpl->assign('LotteryType',Request::r('LotteryType'));
$tpl->assign('ConsignType',Request::r('ConsignType'));

$tpl->assign('data_shu',$li_data); // data;
//print_r($data_arr);
$YOKA ['output'] = $tpl->r ( 'daletou_true' );
echo_exit ( $YOKA ['output'] );