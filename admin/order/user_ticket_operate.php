<?php
/**
 * 用户订单操作列表页
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
);

if (!Runtime::requireRole($roles,false)) {
	ajax_fail_exit("该页面不允许查看");
}

$tpl = new Template();

$field = Request::r('field');
if (!$field) $field = 'datetime';

$tpl->assign('field', $field);

$order = $field. ' desc';

//待查询的日期，允许精确到秒
$start_date = Request::r('start_date');
$start_time = Request::r('start_time');
$end_date = Request::r('end_date');
$end_time = Request::r('end_time');

if($start_date<'2018-01-01'){
		$start_date='2018-01-01';
}
if($start_date>$end_date){
	$end_date=$start_date;
}

$start = $start_date . ' ' . $start_time;
$end = $end_date . ' ' . $end_time;

//验证时间格式
if (!$start_date || !$start_time || !$end_date || !$end_time || !strtotime($start) || !strtotime($end)) {
	$start_time = '00:00:00';
	$end_time = '23:59:59';
	$start_date = date('Y-m-d', time() - 7 * 24 * 3600);
	$end_date = date('Y-m-d', time());
	$start = $start_date . ' ' . $start_time;
	$end = $end_date . ' ' . $end_time;
}

if($start_date<'2018-01-01'){
	$start_date='2018-01-01';
}
if($start_date>$end_date){
	$end_date=$start_date;
}

$tpl->assign('start_date', $start_date);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_date', $end_date);
$tpl->assign('end_time', $end_time);

//判断是否上一页时用到了$firstPage
$firstPage = 1;
$page = Request::varGetInt('page', $firstPage);
//判断是否下一页时用到了$size
$size = 20;
$offset = ($page-1) * $size;
$real_size = $size + 1;// 用于判断是否还有下一页，多取一条记录

$limit = " {$offset},{$real_size} ";

$getTicketCompany = TicketCompany::getTicketCompany();
$tpl->assign('getTicketCompany', $getTicketCompany);

$operate_uname = Request::r('operate_uname');
$tpl->assign('operate_uname', $operate_uname);
$type = Request::r('type');
$tpl->assign('type', $type);

$condition = array();

if ($type && $type != 'all') {
	$condition['type'] = $type;
}

if ($operate_uname && $operate_uname != 'all') {
	$condition['operate_uname'] = $operate_uname;
}
//var_dump($condition);//exit();
$objUserTicketOperate = new UserTicketOperate();
$userTicketOperateInfo = $objUserTicketOperate->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);

$ids = array();

foreach ($userTicketOperateInfo as $value) {
	$ids[] = $value['user_ticket_id'];
	
}



$objUserTicketAll = new UserTicketAll();
$cond = array();
$cond['id'] = $ids;
$cond['prize_state'] = SqlHelper::addCompareOperator('!=', UserTicketAll::PRIZE_STATE_NOT_OPEN);
$userTicketInfo = $objUserTicketAll->findBy($cond,'id');
foreach ($userTicketOperateInfo as $key=>$value) {
	if (isset($userTicketInfo[$value['user_ticket_id']])) {
		$userTicketOperateInfo[$key]['prize'] = $userTicketInfo[$value['user_ticket_id']]['prize'];	
	} else {
		//未开奖的奖金为-1,原因：user_ticket_operate的prize为0,无法区分未中奖和未开奖
		$userTicketOperateInfo[$key]['prize'] = -1;
	}
}



//echo $_tmp_total_prize;exit();
$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['start_date'] = $start_date;
	$args['end_date'] = $end_date;
	$args['end_time'] = $end_time;
	$previousUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$nextPage = false;
if (count($userTicketOperateInfo) > $size) {
	$nextPage = $page + 1;
	array_pop($userTicketOperateInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['start_date'] = $start_date;
	$args['end_date'] = $end_date;
	$args['end_time'] = $end_time;
	$nextUrl = jointUrl(ROOT_DOMAIN.$_SERVER['SCRIPT_NAME'], $args);
}

$operateTypeDesc = UserTicketOperate::getTypeDesc();
$tpl->assign('operateTypeDesc', $operateTypeDesc);

$operateUnames = UserTicketOperate::getOperateUnames();
$tpl->assign('operateUnames', $operateUnames);
//echo $end;
//计算当前条件下出票总量和返奖情况
$total = array('总金额'=>0, '总奖金'=>0);
if(in_array($operate_uname, $operateUnames) && array_key_exists($type, $operateTypeDesc)) {
	$totalInfo = $objUserTicketOperate->getTotalByCondition2($start, $end, $field, $operate_uname, $type);
	
	
	//var_dump($totalInfo);exit();
	
	$total['total_money'] = $totalInfo['total_money'];
	$total['total_prize'] = $totalInfo['total_prize'];
}

$tpl->assign('total', $total);
$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketOperateInfo', $userTicketOperateInfo);
$YOKA ['output'] = $tpl->r ('../admin/order/user_ticket_operate');
echo_exit ( $YOKA ['output'] );