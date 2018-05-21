<?php
/**
 * 日志查询
*/
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$tpl = new Template();
$objZYLog = new ZYLog();
$id = Request::r('id');
$start_time = Request::r('start_time');

$end_time = Request::r('end_time');

$type = Request::r('type');

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

$status = Request::r('status')?Request::r('status'):ZYLog::LOG_STATUS_ERROR;

$condition = array();
$condition['status'] = $status;

if ($status == 'all') {
	unset($condition['status']);
}

if ($id) {
	$condition['id'] = $id;
}
if($type) {
	$condition['type'] = $type;
}

$logInfos = $objZYLog->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', 'create_time', $condition, $limit, 'create_time desc');
$num = $objZYLog->getNum($start_time . ' 00:00:00', $end_time . ' 23:59:59', $status);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['status'] = $status;
	$args['type'] = $type;
	$previousUrl = jointUrl(ROOT_DOMAIN."/admin/system/search_log.php", $args);
}

$nextPage = false;
if (count($logInfos) > $size) {
	$nextPage = $page + 1;
	array_pop($logInfos);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['status'] = $status;
	$args['type'] = $type;
	$nextUrl = jointUrl(ROOT_DOMAIN."/admin/system/search_log.php", $args);
}

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('logInfos', $logInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('status', $status);
$tpl->assign('type', $type);
$tpl->assign('id', $id);
$tpl->assign('num', $num?$num:0);
echo_exit($tpl->r('../admin/system/search_log'));