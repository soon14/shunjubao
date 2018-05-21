<?php
/**
 * 晒单iframe页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$order = 'endtime desc, datetime desc';

$limit = 30;

$show_uids = array();
$objAdminOperate = new AdminOperate();
$condition = array();
$condition['status'] = AdminOperate::STATUS_AVILIBALE;
$condition['type'] = AdminOperate::TYPE_SHOW_TICKET;
$show_users = $objAdminOperate->getsByCondition($condition, null, 'create_time asc');
foreach ($show_users as $value) {
	$show_uids[] = $value['show_uid'];
}

$objUserTicketAllFront = new UserTicketAllFront();
$condition = array();
$condition['print_state'] 	= array(UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS, UserTicketAll::TICKET_STATE_LOTTERY_VIRTUAL_TOUZHU);
$condition['combination_type'] = array(UserTicketAll::COMBINATION_TYPE_NOT_OPEN, UserTicketAll::COMBINATION_TYPE_OPEN);
$condition['u_id'] 			= $show_uids;
$condition['partent_id']	= 0;//非跟单的单
$show_tickets = $objUserTicketAllFront->getsByCondition($condition, $limit, $order);

$sportDesc = UserTicketAll::getSportDesc();

foreach ($show_tickets as $key=>$value) {
	$follow_info = $objUserTicketAllFront->getFollowInfo($value['id']);
	$show_tickets[$key]['follow_num'] = $follow_info['total_sum'];
}
$objUserMemberFront = new UserMemberFront();
$show_users_info = $objUserMemberFront->gets($show_uids);

$tpl = new Template();
$tpl->assign('show_tickets', $show_tickets);
$tpl->assign('sportDesc', $sportDesc);
$tpl->assign('show_users_info', $show_users_info);
echo_exit($tpl->r('show_iframe'));