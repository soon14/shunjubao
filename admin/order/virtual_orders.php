<?php
/**
 * 积分投注查询页
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

$field = 'create_time';

$order = $field. ' desc';

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

$limit = "{$offset},{$real_size}";

$condition = array();

$status = Request::r('status');
$status?$status:$status = 'all';
$tpl->assign('status', $status);

if ($status != 'all') {
	$condition['status'] = $status;
}

$source = Request::r('source');

$source?$source:$source = 'all';
$tpl->assign('source', $source);

if ($source != 'all') {
	$condition['source'] = $source;
}
$user_name = request::r('user_name');
$tpl->assign('user_name', $user_name);
if ($user_name) {
	$condition['u_name'] = $user_name;
}


$id = request::r('id');
$tpl->assign('id', $id);
if ($id) {
	$condition['id'] = $id;
}

$objVirtualTicket = new VirtualTicket();
$userTicketInfo = $objVirtualTicket->getsByCondtionWithField($start_time. ' 00:00:00', $end_time.' 23:59:59', $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	if ($user_name) {
		$args['user_name'] = $user_name;
	}
	$previousUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$nextPage = false;
if (count($userTicketInfo) > $size) {
	$nextPage = $page + 1;
	array_pop($userTicketInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	if ($user_name) {
		$args['user_name'] = $user_name;
	}
	$nextUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}


$resutlDesc = BettingVirtual::getResultDesc();
$sportDesc 	= BettingVirtual::getSportDesc();
$statusDesc = VirtualTicket::getStatusDesc();

$tpl->assign('resutlDesc', $resutlDesc);
$tpl->assign('sportDesc', $sportDesc);
$tpl->assign('statusDesc', $statusDesc);

$sourceDesc = UserMember::getSourceDesc();
$tpl->assign('sourceDesc', $sourceDesc);

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->d ('../admin/order/virtual_orders');