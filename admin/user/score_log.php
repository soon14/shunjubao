<?php
/**
 * 后台之：积分记录
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

$objUserScoreLogFront = new UserScoreLog();

$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
$u_name = Request::r('u_name');
$log_type = Request::r('log_type');

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

$condition = $cond = array();
$condition['log_type'] = $log_type;

$cond = $condition;

if ($log_type == 'all') {
	unset($condition['log_type']);
}

$objUserMemberFront = new UserMemberFront();

if ($u_name) {	
	$search_user = $objUserMemberFront->getByName($u_name);
	if ($search_user) $condition['u_id'] = $search_user['u_id'];
	$tpl->assign('user_name', $u_name);
}

$userScoreLogInfos = $objUserScoreLogFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', 'create_time', $condition, $limit, 'create_time desc');

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $cond;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['u_name'] = $u_name;
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/user/score_log.php", $args);
}

$nextPage = false;
if (count($userScoreLogInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userScoreLogInfos);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['u_name'] = $u_name;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/user/score_log.php", $args);
}

$uids = array();
foreach ($userScoreLogInfos as $value) {
	$uids[] = $value['u_id'];
}

$bankrollChangeType = UserAccountLog::getsBankrollChangeType();
$tpl->assign('bankrollChangeType', $bankrollChangeType);

$objUserAccountFront = new UserAccountFront();
$objUserRealInfoFront = new UserRealInfoFront();

$userInfos = $objUserMemberFront->gets($uids);
$tpl->assign('userInfos', $userInfos);
$userAccountInfos = $objUserAccountFront->gets($uids);
$userRealInfos = $objUserRealInfoFront->gets($uids);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('userRealInfos', $userRealInfos);
$userInfos = $objUserMemberFront->gets($uids);
$tpl->assign('userInfos', $userInfos);
$userAccountInfos = $objUserAccountFront->gets($uids);
$tpl->assign('userAccountInfos', $userAccountInfos);
$tpl->assign('u_name', $u_name);
$tpl->assign('userScoreLogInfos', $userScoreLogInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('log_type', $log_type);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('../admin/user/score_log'));
