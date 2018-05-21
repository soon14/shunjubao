<?php
/**
 * 后台之：绑定用户查询
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

//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 30* 24 * 3600);
	$end_time = date('Y-m-d', time());
}

$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

$u_name = Request::r('u_name');//我方用户名
$c_name = Request::r('c_name');//平台用户名
$type = Request::r('type');
$status = Request::r('status');

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";
$order = "create_time desc";
$field = 'create_time';

$condition = array();
if ($u_name) {
	$condition['u_name'] = $u_name;
}
if ($c_name) {
	$condition['c_name'] = $c_name;
}
if ($type) {
	$condition['type'] = $type;
}
if ($status) {
	$condition['status'] = $status;
}

$objUserConnect = new UserConnect();
$results = $objUserConnect->getsByCondtionWithField($start_time.' 00:00:00', $end_time. ' 23:59:59', $field, $condition, $limit, $order);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$u_name?$args['u_name'] = $u_name:'';
	$c_name?$args['c_name'] = $c_name:'';
	$type?$args['type'] = $type:'';
	$status?$args['status'] = $status:'';
	$previousUrl = jointUrl(ROOT_DOMAIN."/admin/user/user_connect.php", $args);
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
	$u_name?$args['u_name'] = $u_name:'';
	$c_name?$args['c_name'] = $c_name:'';
	$type?$args['type'] = $type:'';
	$status?$args['status'] = $status:'';
	$nextUrl = jointUrl(ROOT_DOMAIN."/admin/user/user_connect.php", $args);
}

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$typeDesc = UserConnect::getTypesDesc();
$tpl->assign('typeDesc', $typeDesc);
$tpl->assign('results', $results);
$tpl->assign('u_name', $u_name);
$tpl->assign('c_name', $c_name);
$tpl->assign('type', $type);
$tpl->assign('status', $status);
echo_exit($tpl->r('../admin/user/user_connect'));