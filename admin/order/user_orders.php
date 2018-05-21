<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
ini_set('memory_limit', '-1');
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

$condition = array();
$pool = Request::r('pool');
switch ($pool) {
	case 'all':
		break;
	case 'all_fb':
		$condition['pool'] 	= UserTicketAll::$allFBPoolDesc;
		$condition['pool'][] = 'crosspool';
		$condition['sport'] = 'fb';
		break;
	case 'all_bk':
		$condition['pool'] 	= UserTicketAll::$allBKPoolDesc;
		$condition['pool'][] = 'crosspool';
		$condition['sport'] = 'bk';
		break;
	case 'all_bd':
		$condition['pool'] 	= UserTicketAll::$allBDPoolDesc;
		break;
	default:
		$condition['pool'] 	= $pool;
		break; 
}

if (substr($pool, 2, 9) == 'crosspool') {
	$condition['pool'] 	= 'crosspool';
	$condition['sport'] = substr($pool, 0, 2);
}

$prize_state = Request::r('prize_state');

if ($prize_state === false) {
	$prize_state = 'all';
}

if ($prize_state != 'all') {
	$condition['prize_state'] 	= $prize_state;
}

$print_state = Request::r('print_state');

if ($print_state != 'all') {
	$condition['print_state'] 	= $print_state;
}

$source = Request::r('source');
if ($source != 'all' && $source) {
	$condition['source'] 	= $source;
}

$company_id = Request::r('company_id');
if ($company_id != 'all' && $company_id>0) {
	$condition['company_id'] = $company_id;
}



//串关数的加入
$select = Request::r('select');

if ($select == '1x1') {
    $condition['select'] = $select;
}

if ($select == '2x1') {
    $condition['select'] = $select;
    $condition['num'] = 2;
}

if ($select == '3x1') {
    $condition['select'] = $select;
    $condition['num'] = 3;
}

if ($select == '4x1') {
    $condition['select'] = $select;
    $condition['num'] = 4;
}
$tpl->assign('select', $select);
$start_money = Request::r('start_money');
if ($start_money>0) {
		$condition['prize'] = SqlHelper::addCompareOperator('>=', $start_money);	
		$tpl->assign('start_money', $start_money);
}

$money = Request::r('money');
if ($money>0) {
		$condition['money'] = SqlHelper::addCompareOperator('>=', $money);	
		$tpl->assign('money', $money);
}

//var_dump($condition);//exit();
$getTicketCompany = TicketCompany::getTicketCompany();
$tpl->assign('getTicketCompany', $getTicketCompany);

$objUserMemberFront = new UserMemberFront();

$user_name = Request::r('user_name');
if ($user_name) {
	$search_user = $objUserMemberFront->getByName($user_name);
	if ($search_user['u_id']) $condition['u_id'] = $search_user['u_id'];
	$tpl->assign('user_name', $user_name);
}

$objUserTicketAllFront = new UserTicketAllFront();

//按出票方订单号查询
$return_id = Request::r('return_id');
if ($return_id) {
	for ($i=0;$i<10;$i++) {
		$objUserTicketLog = new UserTicketLog($i);
		$cond = array();
		$cond['return_id'] = $return_id;
		$results = $objUserTicketLog->getsByCondition($cond, 1);
		if ($results) {
			$orderTicket = array_pop($results);
			$userTicketIds = array($orderTicket['ticket_id']);
			$condition['id'] = $orderTicket['ticket_id'];
			$r = $objUserTicketAllFront->get($orderTicket['ticket_id']);
			$userTicketInfo = array($r);
			break;
		}
	}
} else {
	
	$userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start, $end, $field, $condition, $limit, $order);
}

$userTicketIds = array_keys($userTicketInfo);


$u_ids = array();

foreach ($userTicketInfo as $key=>$value) {
	$u_ids[$value['u_id']] = $value['u_id'];
	//已开奖的不需要手动返奖
	if ($value['prize_state'] != UserTicketAll::PRIZE_STATE_NOT_OPEN) {
		continue;
	}
	//已退款的不需要手动返奖
	if ($value['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_RETURN_MONEY) {
		continue;
	}
	//找到特定状态的系统票，开启手动返奖按钮
	$objUserTicketLog = new UserTicketLog($value['u_id']);
	$cond = array();
	$cond['ticket_id'] = $value['id'];
	$cond['print_state'] = array(
			UserTicketAll::TICKET_STATE_NOT_LOTTERY,
			UserTicketAll::TICKET_STATE_LOTTERY_FAILED,
			UserTicketAll::TICKET_STATE_LOTTERY_TOUZHU_FAILED,
			UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU,
	);
	$results = $objUserTicketLog->getsByCondition($cond, 1);
	if ($results) {
		$userTicketInfo[$key]['manu_prize'] = 1;
	}
}

$all_users = $objUserMemberFront->gets($u_ids);
$all_orderTickets = array();
foreach ($all_users as $key=>$value) {
	$objUserTicketLog = new UserTicketLog($key);
	$orderTickets = $objUserTicketLog->gets($userTicketIds);//系统票;
	$all_orderTickets = array_merge($all_orderTickets, $orderTickets);
}

$userTicketInfoAll = $objUserTicketAllFront->getsByCondtionWithField($start, $end, $field, $condition);//统计各类数据
//初始化
$count = 0;
$total = array();
$total['总投注额度'] = 0;
$total['运营投注额'] = 0;
$total['运营投注额'] = 0;
$total['运营中奖额'] = 0;

foreach ($userTicketInfoAll as $value) {
	
	$count++;
	if ($value['print_state'] == UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU) {
		$total['运营投注额'] += $value['money'];
		$total['运营中奖额'] += $value['prize'] * 100;
	}
	if($value['print_state']!=8){
			$total['总投注额度'] += $value['money'];
			$total['总中奖额度'] += $value['prize'] * 100;
	}

}

$total['真实投注额'] = $total['总投注额度'] - $total['运营投注额'];
$total['真实中奖额'] = ($total['总中奖额度'] - $total['运营中奖额'])/100;//两数值相减会出现无限小数，x100/100解决这个问题
$total['总中奖额度'] = $total['总中奖额度']/100;
$total['运营中奖额'] = $total['运营中奖额']/100;

$total['订单数'] = $count;
$tpl->assign('total', $total);

$previousPage = $page <= $firstPage ? FALSE : $page-1 ;
$args = $condition;
if ($previousPage) {
	$args['page'] = $previousPage;
	$args['start_time'] = $start_time;
	$args['start_date'] = $start_date;
	$args['end_date'] = $end_date;
	$args['end_time'] = $end_time;
	$args['pool'] = $pool;
	$args['prize_state'] = $prize_state;
	$args['print_state'] = $print_state;
	$args['company_id'] = $company_id;
	if ($user_name) {
		$args['user_name'] = $user_name;
	}
    $previousUrl = jointUrl(ROOT_DOMAIN."/admin/order/user_orders.php", $args);
}

$nextPage = false;
if (count($userTicketInfo) > $size) {
    $nextPage = $page + 1;
    array_pop($userTicketInfo);// 删除多取的一个
}

if ($nextPage) {
	$args['page'] = $nextPage;
	$args['start_time'] = $start_time;
	$args['start_date'] = $start_date;
	$args['end_date'] = $end_date;
	$args['end_time'] = $end_time;
	$args['pool'] = $pool;
	$args['prize_state'] = $prize_state;
	$args['print_state'] = $print_state;
	$args['company_id'] = $company_id;
	if ($user_name) {
		$args['user_name'] = $user_name;
	}
    $nextUrl = jointUrl(ROOT_DOMAIN."/admin/order/user_orders.php", $args);
}

$tpl->assign('pool', $pool);
$tpl->assign('prize_state', $prize_state);
$tpl->assign('print_state', $print_state);
$tpl->assign('return_id', $return_id);
$tpl->assign('company_id', $company_id);
$tpl->assign('source', $source);
$tpl->assign('all_users', $all_users);
$tpl->assign('all_orderTickets', $all_orderTickets);

$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);

$tpl->assign('previousUrl', $previousUrl);
$tpl->assign('nextUrl', $nextUrl);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('orderTickets', $orderTickets);
$YOKA ['output'] = $tpl->r ('../admin/order/user_orders');
echo_exit ( $YOKA ['output'] );