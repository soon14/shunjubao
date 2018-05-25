<?php
/**
 * 获取用户票及系统票订单信息
 */
include_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'init.php';

Runtime::requireLogin();

$roles = array(
	Role::ADMIN,
	Role::CUSTOMER_SERVICE,
);
//是否聚宝出票页面
$is_company_zhiying = Request::r('company_zhiying');
$company_zhiying_limit_money = 100;
if ($is_company_zhiying) {
	if ($is_company_zhiying !=4 || !Runtime::requireRole($roles,true)) {
 		fail_exit("该页面不允许查看");
	}
}

$objUserTicketAllFront = new UserTicketAllFront();

$tpl = new Template();

$field = 'datetime';
$order = $field. ' asc';

//验证时间格式
$start_time = date('Y-m-d', time() - 30* 24 * 3600);
$end_time = date('Y-m-d', time());

$company_id = TicketCompany::COMPANY_MANUAL;

$select = Request::r('select');
$use_select = array('1x1','2x1');//可供选择的选项

$objMySQLite = new MySQLite($CACHE['db']['default']);

$condition = array();
$condition['company_id'] = $company_id;
$condition['print_state'] = UserTicketAll::TICKET_STATE_NOT_LOTTERY;

$limit = Request::r('limit');//每页显示的数量

if(!Verify::int($limit)) {
	$limit = 200;
} 

$select_string = '1=1';
if ($select == '234') {
	$select_string = " `select` in ('2x1','3x1','4x1') ";
}


if ($select == '2x1') {
	$select_string = " `select`='{$select}' and num=2 ";
}

if ($select == '1x1') {
	$select_string = " `select`='{$select}' ";
}

$userTicketInfo_other = array();
if ($select == 'other') {
	$select_string = "  `select` != '2x1' and `select` != '3x1' and `select` != '4x1'";
	//找到是2x1但不是两场的
	$where = " company_id={$company_id} && print_state=0 &&  `select` = '2x1' && `num` !=2";
	
	if ($is_company_zhiying) $where .= " && money<={$company_zhiying_limit_money} ";
	else $where .= " && money>{$company_zhiying_limit_money} ";
	
	$sql = "select * from user_ticket_all where {$where} order by {$order} limit {$limit} ";
	$userTicketInfo_other = $objMySQLite->fetchAll($sql,'id');
}

$where = " company_id={$company_id} && print_state=0 && {$select_string} ";
if ($is_company_zhiying) $where .= " && money<={$company_zhiying_limit_money} ";
else $where .= " && money>{$company_zhiying_limit_money} ";

$sql = "select * from user_ticket_all where {$where} order by {$order} limit {$limit} ";

$userTicketInfo = $objMySQLite->fetchAll($sql,'id');
// $userTicketInfo = $objUserTicketAllFront->getsByCondtionWithField($start_time. ' 00:00:00', $end_time. ' 23:59:59', $field, $condition, null, $order);
$userTicketInfo = array_merge($userTicketInfo, $userTicketInfo_other);
//数组合并子后key会重排，必须按照id排列
$sort_userTicketInfo = array();
$u_ids = array();

foreach ($userTicketInfo as $value) {
	$u_ids[$value['u_id']] = $value['u_id'];
	$value['pool_desc'] = getPoolDesc($value['sport'], $value['pool']);
	//混合投注时增加一个逻辑：当所有选项是同一个玩法时，不显示混合投注，显示该玩法
	if ($value['pool'] == 'crosspool') {
		//mnl|55706|h#2.48&a#1.34,mnl|55708|h#1.51&a#2.06
		$combination = $value['combination'];
		$C = explode(',', $combination);
		$pools = array();//玩法集合
		foreach ($C as $v) {
			$M = explode('|', $v);
			$pools[$M[0]] = $M[0];
		}
		if (count($pools) == 1) $value['pool_desc'] = getPoolDesc($value['sport'], $M[0]) . '(<font style="color:red">混</font>)'; 
	}
	
	$sort_userTicketInfo[$value['id']] = $value;
}

ksort($sort_userTicketInfo);
$userTicketInfo = $sort_userTicketInfo;

$objUserMemberFront = new UserMemberFront();
$all_users = $objUserMemberFront->gets($u_ids);

$getTicketCompany = TicketCompany::getTicketCompany();
$tpl->assign('getTicketCompany', $getTicketCompany);

$tpl->assign('company_id', $company_id);
$tpl->assign('all_users', $all_users);
$tpl->assign('select', $select);
$tpl->assign('limit', $limit);
$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);

$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('ticket_num', count($userTicketInfo));
$tpl->assign('is_company_zhiying', $is_company_zhiying);
//页面刷新间隔，单位：秒
$reload_second = 3;
$tpl->assign('reload_second', $reload_second);
$YOKA ['output'] = $tpl->r ('manul_show_ticket');
echo_exit ( $YOKA ['output'] );
