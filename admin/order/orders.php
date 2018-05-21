<?php
/**
 * 系统订单查看
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

$objUserTicketAllFront = new UserTicketAllFront();

$userTicketId = Request::r('userTicketId');
if ($userTicketId) {
	$userTicketInfo = $objUserTicketAllFront->get($userTicketId);
	$u_id = $userTicketInfo['u_id'];
}

$return_id = Request::r('return_id');

if ($return_id) {
	$u_id = Request::r('u_id');	
}

if (!$u_id) {
	fail_exit('无法查询');
}
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);

$condition = array();
$orderTickets = array();
$total = array();

$objUserTicketLog = new UserTicketLog($u_id);

if ($userTicketId) {
	$condition['ticket_id'] = $userTicketId;
	
}
if ($return_id) {
	$condition['return_id'] = $return_id;
}

if ($userTicketInfo['sport'] == 'bd') {
	$total['期数'] = $objUserTicketAllFront->getIssueNumberByUserTicketId($userTicketInfo);
}

$orderTickets = $objUserTicketLog->getsByCondition($condition);
$total['总数'] = count($orderTickets);
$total['总金额'] = $userTicketInfo['money'];


$userTicketPrizeStateDesc = UserTicketAll::getPrizeStateDesc();
$tpl->assign('userTicketPrizeStateDesc', $userTicketPrizeStateDesc);
$userTicketPrintStateDesc = UserTicketAll::getPrintStateDesc();
$tpl->assign('userTicketPrintStateDesc', $userTicketPrintStateDesc);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);
$ticketCompanyDesc = TicketCompany::getTicketCompany();
$tpl->assign('ticketCompanyDesc', $ticketCompanyDesc);
$tpl->assign('userInfo', $userInfo);
$tpl->assign('userTicketInfo', $userTicketInfo);
$tpl->assign('orderTickets', $orderTickets);
$tpl->assign('total', $total);
$YOKA ['output'] = $tpl->r ('../admin/order/orders');
echo_exit ( $YOKA ['output'] );