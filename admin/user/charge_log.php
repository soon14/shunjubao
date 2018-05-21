<?php
/**
 * 后台之：第三方充值记录
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$tpl = new Template();
$objUserChargeFront = new UserChargeFront();

$start_time = Request::r('start_time');
$end_time = Request::r('end_time');



$start_time2 = Request::r('start_time2');
$end_time2 = Request::r('end_time2');

$u_name = Request::r('u_name');
$return_message = Request::r('return_message');
$o_uname = Request::r('o_uname');
$manu_income = Request::r('manu_income');


//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

//默认时间
$start_time = $start_time?$start_time:date('Y-m-d', time() - 30*24*3600);
$end_time = $end_time?$end_time:date('Y-m-d', time());

if($start_time<'2018-01-01'){
	$start_time='2018-01-01';
}
if($start_time>$end_time){
	$end_time=$start_time;
}
$start_time2 = $start_time2?$start_time2:'00:00:00';
$end_time2 = $end_time2?$end_time2:'23:59:59';

$charge_status = Request::r('charge_status')?Request::r('charge_status'):UserCharge::CHARGE_STATUS_SUCCESS;
$charge_type = Request::r('charge_type')?Request::r('charge_type'):UserCharge::CHARGE_TYPE_ALIPAY_QR;

$condition = array();
$condition['charge_status'] = $charge_status;
$condition['charge_type'] = $charge_type;

if ($charge_status == 'all') {
	unset($condition['charge_status']);
}
if ($charge_type == 'all') {
	unset($condition['charge_type']);
}

$objUserMemberFront = new UserMemberFront();
if ($u_name) {
	$search_user = $objUserMemberFront->getByName($u_name);
	$condition['u_id'] = $search_user['u_id'];
}
if ($return_message) {
	$condition['return_message'] = $return_message;
}

if ($o_uname) {
	$condition['o_uname'] = $o_uname;
}

if ($manu_income) {
	$condition['manu_income'] = $manu_income;
}

$chargeInfos = $objUserChargeFront->getsByCondtionWithField($start_time . ' '.$start_time2, $end_time . ' '.$end_time2, 'create_time', $condition, $limit, 'create_time desc');

$uids = array();
foreach ($chargeInfos as $value) {
	$uids[] = $value['u_id'];
}

$objUserAccountFront = new UserAccountFront();
$objUserRealInfoFront = new UserRealInfoFront();

$userInfos = $objUserMemberFront->gets($uids);
$tpl->assign('userInfos', $userInfos);
$userAccountInfos = $objUserAccountFront->gets($uids);
$userRealInfos = $objUserRealInfoFront->gets($uids);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('userRealInfos', $userRealInfos);
$tpl->assign('u_name', $u_name);
$tpl->assign('return_message', $return_message);
$tpl->assign('o_uname', $o_uname);
$tpl->assign('manu_income', $manu_income);

$chargeStatusDesc = UserCharge::getChargeStatusDesc();
$chargeTypeDesc = UserCharge::getChargeTypeDesc();
$getCHARGEmanuincomeDesc = UserCharge::getCHARGEmanuincomeDesc();


$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['start_time2'] = $start_time2;
	$args['end_time2'] = $end_time2;	
	$args['charge_status'] = $charge_status;
	$args['charge_type'] = $charge_type;
	if ($u_name) {
		$args['u_name'] = $u_name;
	}
	$previousUrl = jointUrl(ROOT_DOMAIN."/admin/user/charge_log.php", $args);
}

$nextPage = false;
if (count($chargeInfos) > $size) {
	$nextPage = $page + 1;
	array_pop($chargeInfos);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['start_time2'] = $start_time2;
	$args['end_time2'] = $end_time2;		
	$args['charge_status'] = $charge_status;
	$args['charge_type'] = $charge_type;
	if ($u_name) {
		$args['u_name'] = $u_name;
	}
	$nextUrl = jointUrl(ROOT_DOMAIN."/admin/user/charge_log.php", $args);
}



$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);

$tpl->assign('chargeStatusDesc', $chargeStatusDesc);
$tpl->assign('chargeTypeDesc', $chargeTypeDesc);
$tpl->assign('getCHARGEmanuincomeDesc', $getCHARGEmanuincomeDesc);
$tpl->assign('chargeInfos', $chargeInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('start_time2', $start_time2);
$tpl->assign('end_time2', $end_time2);
$tpl->assign('charge_status', $charge_status);
$tpl->assign('charge_type', $charge_type);

//计算本次查询总金额

if (empty($search_user['u_id'])){$u_id=0;}else{$u_id=$search_user['u_id'];}
if ($charge_status==""|| $charge_status=="all"){$charge_status=0;}
if ($charge_type=="" || $charge_type=="all"){$charge_status=0;}
if (empty($start_time)){$start_time=0;}
if (empty($end_time)){$end_time=0;}
if (empty($return_message)){$return_message=0;}
if (empty($o_uname)){$o_uname=0;}
if (empty($manu_income)){$manu_income=0;}


$objUserCharge = new UserCharge();
$total_money = $objUserCharge->getTotalByCondition($start_time . ' '.$start_time2, $end_time . ' '.$end_time2, $charge_status, $charge_type, $u_id,$return_message,$o_uname,$manu_income);
$tpl->assign('total_money', $total_money);

echo_exit($tpl->r('../admin/user/charge_log'));