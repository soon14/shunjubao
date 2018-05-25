<?php
/**
 * 用户中心账户明细页之派奖
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

#必须登录
Runtime::requireLogin();

$tpl = new Template();

$userInfo = Runtime::getUser();
$u_id = $userInfo['u_id'];

$condition = array();
$condition['u_id'] = $u_id;
$condition['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;

//待查询的日期
$start_time = Request::r('start_time');
$end_time = Request::r('end_time');
//验证时间格式
if (!strtotime($start_time) || !strtotime($end_time)) {
	$start_time = date('Y-m-d', time() - 90 * 24 * 3600);
	$end_time = date('Y-m-d', time());
}

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 10;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$field = 'datetime';
$order = $field . ' asc';
$limit = " {$offset},{$real_size} ";

#返奖记录9
//$objUserTicketLog = new UserTicketLog($u_id);
//$userTicketInfos = $objUserTicketLog->getsByCondtionWithField($start_time, $end_time, $field, $condition, $limit, $order);
$objUserTicketAllFront = new UserTicketAllFront();
$userTicketInfos = $objUserTicketAllFront->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . ' 23:59:59', $field, $condition, $limit, $order);
foreach ($userTicketInfos as $key=>$value) {
	//查找赛事信息
	;
}
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $previousUrl = jointUrl(ROOT_DOMAIN."/account/user_ticket_log.php", $args);
}
$nextPage = false;
if (count($userTicketInfos) > $size) {
    $nextPage = $page + 1;
    array_pop($userAccountLogInfos);// 删除多取的一个
}
if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['end_time'] = $end_time;
    $nextUrl = jointUrl(ROOT_DOMAIN."/account/user_ticket_log.php", $args);
}

#标题
$TEMPLATE ['title'] = "聚宝网用户账户奖金派送 ";
$TEMPLATE['keywords'] = '聚宝竞彩,聚宝网,聚宝用户中心';
$TEMPLATE['description'] = '聚宝网用户账户奖金派送。';
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userTicketInfos', $userTicketInfos);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_time', $end_time);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
echo_exit($tpl->r('user_ticket_log'));