<?php
/**
 * 站内推广统计查询
 */
include_once dirname ( __FILE__ ) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
);

if (!Runtime::requireRole($roles,false)) {
	echo_exit("该页面不允许查看");
}


$tpl = new Template();

$field = 'create_time';

$order = Request::r('order');
if(!$order) $order = 'total_money desc';

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 30* 24 * 3600);
	$end_time = date('Y-m-d', time());
}
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$condition = array();

$create_uname = Request::r('create_uname');

$tpl->assign('create_uname', $create_uname);
if ($create_uname) {
	$condition['create_uname'] = $create_uname;
}

$objSiteFrom = new SiteFrom();
$results = $objSiteFrom->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$previousUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$nextPage = false;
if (count($results) > $size) {
	$nextPage = $page + 1;
	array_pop($results);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$nextUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('results', $results);
$tpl->assign('order', $order);
$tpl->d ('../admin/business/site_from_users');