<?php
/**
 * 销售统计
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,true)) {
    fail_exit("该页面不允许查看");
}

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];
$tpl = new Template();

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 50;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";
$order = ' datetime desc ';
$field = 'datetime';

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = $end_time = date('Y-m-d', time());
}

$print_state = Request::r('print_state');
$sport = Request::r('sport');
$pool = Request::r('pool');

$condition = array();
if ($print_state != 'all') $condition['print_state'] = $print_state;
$condition['sport'] = $sport;
$condition['pool'] = $pool;

$objUserTicketAll = new UserTicketAll();
$userTicketsInfo = $objUserTicketAll->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/business/statis.php", $args);
}
$nextPage = false;
if (count($userTicketsInfo) > $size) {
    $nextPage = $page + 1;
    array_pop($userTicketsInfo);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/business/statis.php", $args);
}

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketsInfo', $userTicketsInfo);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
echo_exit($tpl->r('statis'));