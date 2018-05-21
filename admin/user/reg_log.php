<?php
/**
 * 用户注册统计
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

$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
$u_name = Request::r('u_name');

//默认时间
$start_time = $start_time?$start_time:date('Y-m-d', time() - 30*24*3600);
$end_time = $end_time?$end_time:date('Y-m-d', time());

//$charge_status = Request::r('charge_status')?Request::r('charge_status'):UserCharge::CHARGE_STATUS_SUCCESS;

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = "{$offset},{$real_size}";

$condition = array();

$objUserMemberFront = new UserMemberFront();
$userInfos = $objUserMemberFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', 'u_jointime', $condition, $limit, 'u_jointime desc');

if ($u_name) {
	$search_user = $objUserMemberFront->getByName($u_name);
	$userInfos = array($search_user);
}

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	if ($u_name) $args['u_name'] = $u_name;
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/user/reg_log.php", $args);
}

$nextPage = false;
if (count($userInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userInfos);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	if ($u_name) $args['u_name'] = $u_name;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/user/reg_log.php", $args);
}



$uids = $total = array();
$count = 0;
foreach ($userInfos as $value) {
	$count++;
	$uids[] = $value['u_id'];
}

$objUserAccountFront = new UserAccountFront();
$objUserRealInfoFront = new UserRealInfoFront();

$userInfos = $objUserMemberFront->gets($uids);
$tpl->assign('userInfos', $userInfos);
$userAccountInfos = $objUserAccountFront->gets($uids);

$total_account = $objUserAccountFront->getTotal();

//虚拟帐号
$virtual_account = $objUserAccountFront->getVirtualTotal();

$total['总账户余额'] 		= $total_account['cash'];
$total['真实总账户余额'] 	= $total_account['cash'] - $virtual_account['cash'];
$total['总彩金余额'] 		= $total_account['gift'];
$total['总返点余额'] 		= $total_account['rebate'];
$total['总冻结资金'] 		= $total_account['frozen_cash'];
$total['总人数'] 			= $total_account['count'];

$userRealInfos = $objUserRealInfoFront->gets($uids);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('userRealInfos', $userRealInfos);
$userInfos = $objUserMemberFront->gets($uids);
$tpl->assign('userInfos', $userInfos);
$userAccountInfos = $objUserAccountFront->gets($uids);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('u_name', $u_name);
$tpl->assign('chargeInfos', $userInfos);
$tpl->assign('total', $total);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('../admin/user/reg_log'));