<?php
/**
 * 查询用户投注情况
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

$field = 'datetime';
$order = $field. ' desc';

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 30* 24 * 3600);
	$end_time 	= date('Y-m-d', time());
}

$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 10;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$u_name = Request::r('user_name');

$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->getByName($u_name);

$u_id = $userInfo['u_id'];

if (!$u_id) {
	$YOKA ['output'] = $tpl->r ('../admin/order/tickets');
	echo_exit ( $YOKA ['output'] );
}

$tpl->assign('userInfo', $userInfo);

$condition = array();
$condition['u_id'] = $u_id;

$objUserTicketAllFront = new UserTicketAllFront();

$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start_time. ' 00:00:00', $end_time. ' 23:59:59', $field, $condition, $limit, $order);

$userTicketIds = array_keys($userTicketInfo);
$objUserTicketLog = new UserTicketLog($u_id);
// $orderTickets = $objUserTicketLog->gets($userTicketIds);//系统票
//投注总金额
$totalTicketMoney = $objUserTicketAllFront->getTotalTicketMoney($start_time. ' 00:00:00', $end_time. ' 23:59:59', $u_id);
//时间段内总奖金
$totalPrizeMoney = $objUserTicketAllFront->getTotalPrizeMoney($start_time. ' 00:00:00', $end_time. ' 23:59:59', $u_id);
// $totalPrize = $objUserTicketAllFront->getTotalPrize($u_id);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = array();
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
	$args['user_name'] = $u_name;
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/order/tickets.php", $args);
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
	$args['user_name'] = $u_name;
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/order/tickets.php", $args);
}

$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$tpl->assign('user_name', $u_name);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('totalTicketMoney', $totalTicketMoney);
$tpl->assign('totalPrizeMoney', $totalPrizeMoney);
// $tpl->assign('totalPrize', $totalPrize);
// $tpl->assign('orderTickets', $orderTickets);
$YOKA ['output'] = $tpl->r ('../admin/order/tickets');
echo_exit ( $YOKA ['output'] );