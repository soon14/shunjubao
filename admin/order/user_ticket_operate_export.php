<?php
/**
 * 用户订单操作列表页
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

ini_set('memory_limit', '-1');

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

$tpl->assign('start_date', $start_date);
$tpl->assign('start_time', $start_time);
$tpl->assign('end_date', $end_date);
$tpl->assign('end_time', $end_time);

$limit = null;

$getTicketCompany = TicketCompany::getTicketCompany();

$operate_uname = Request::r('operate_uname');
$type = Request::r('type');

$condition = array();

if ($type && $type != 'all') {
	$condition['type'] = $type;
}

if ($operate_uname && $operate_uname != 'all') {
	$condition['operate_uname'] = $operate_uname;
}

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
		$userTicketOperateInfo[$key]['prize'] = '';
	}
}

if (count($userTicketOperateInfo)==0) {
	echo_exit('暂无数据');
}

$operateTypeDesc = UserTicketOperate::getTypeDesc();
$operateUnames = UserTicketOperate::getOperateUnames();

############发送头部信息############
$fileName = "订单操作记录导出：".$start_date.'-'.$end_date.".csv";
$fileName = iconv('utf-8', 'gb2312', $fileName);
header("Content-type:text/csv");
header("Content-Disposition:attachment;filename=".$fileName);
header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
header('Expires:0');
header('Pragma:public');
###################################
# 标题

$title = "序号,订单ID,订单金额,中奖信息,出票时间,操作人,操作类型,操作时间\r\n";
echo $title;
$i = 0;
foreach ($userTicketOperateInfo as $key => $value) {
	$i++;
	$info = "{$i},{$value['user_ticket_id']},{$value['money']},{$value['prize']},{$value['datetime']},{$value['operate_uname']},{$operateTypeDesc [$value['type']]['desc']},{$value['create_time']}";
	$info .= "\r\n";
	echo $info;
}
exit;