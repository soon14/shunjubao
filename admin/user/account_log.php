<?php
/**
 * 后台之：账户日志
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

$objUserMemberFront = new UserMemberFront();

$u_name = Request::r('u_name');
$u_id = Request::r('u_id');
$search_user = '';

if ($u_name) {
	$search_user = $objUserMemberFront->getByName($u_name);
}

if ($u_id) {
	$search_user = $objUserMemberFront->get($u_id);
}

if (!$search_user) {
	echo_exit($tpl->r('../admin/user/account_log'));
}

$u_id = $search_user['u_id'];
$objUserAccountLogFront = new UserAccountLogFront($u_id);

$start_time = Request::r('start_time');
$end_time = Request::r('end_time');

//默认时间
$start_time = $start_time?$start_time:date('Y-m-d', time() - 30*24*3600);
$end_time = $end_time?$end_time:date('Y-m-d', time());

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = "{$offset},{$real_size}";

$condition = array();
$condition['u_id'] = $u_id;
$userAccountLogInfos = $objUserAccountLogFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', 'create_time', $condition, $limit, 'log_id desc');

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['u_name'] = $u_name;
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/user/account_log.php", $args);
}

$nextPage = false;
if (count($userAccountLogInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userAccountLogInfos);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['u_name'] = $u_name;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/user/account_log.php", $args);
}

$objUserAccountFront = new UserAccountFront();
$objUserRealInfoFront = new UserRealInfoFront();

$userAccountInfo = $objUserAccountFront->get($u_id);
$tpl->assign('userAccountInfo', $userAccountInfo);
$userRealInfo = $objUserRealInfoFront->get($u_id);
$tpl->assign('userRealInfo', $userRealInfo);

$bankrollChangeType = UserAccountLog::getsBankrollChangeType();
$tpl->assign('bankrollChangeType', $bankrollChangeType);

$tpl->assign('userAccountLogInfos', $userAccountLogInfos);
$tpl->assign('u_name', $u_name);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('../admin/user/account_log'));