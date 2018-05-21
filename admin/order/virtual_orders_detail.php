<?php
/**
 * 虚拟比赛订单详情页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::CUSTOMER_SERVICE,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}


$ticket_id = Request::r('ticket_id');

$objVirtualTicket = new VirtualTicket();
$userTicketInfo = $objVirtualTicket->get($ticket_id);

if (!$userTicketInfo) {
	fail_exit('用户订单未找到');
}

$tpl = new Template();

$combination = $userTicketInfo['combination'];

$match_ids = $return = array();
//1|h#1.05&a#0.95,2|a#1.05
$c = explode(',', $combination);

foreach ($c as $key=>$value) {
	$cm = explode('|', $value);
	$match_ids[$cm[0]] = $cm[1];// matchid=>h#1.05&a#0.95
}

$objBettingVirtual = new BettingVirtual();
$matchInfos = $objBettingVirtual->gets(array_keys($match_ids));

$resultDesc = BettingVirtual::getResultDesc();

foreach ($match_ids as $key=>$value) {
	$key_str = '';//用户选项 胜[4.8 ](+123) 平[3.7 ] 负[1.55 ]
	$matchInfo = $matchInfos[$key];
	$return[$key]['matchInfo'] = $matchInfo;
	$u_o = explode('&', $value);//h#1.05&a#0.95
	foreach ($u_o as $k=>$v) {
		$v_o = explode('#', $v);
		if ($v_o[0] == $matchInfo['lottery_result']) {
			$key_str .= '<font color="red">'.$resultDesc[$v_o[0]]['desc']. '['. $v_o[1].']</font>';
		} else {
			$key_str .= $resultDesc[$v_o[0]]['desc'] . '['. $v_o[1].']';
		}
		
	}
	if ($matchInfo['remark']) {
		$key_str .= '('.$matchInfo['remark'].')';
	}
	$return[$key]['key_str'] = $key_str;
}

$statusDesc = VirtualTicket::getStatusDesc();
$tpl->assign('statusDesc',$statusDesc);
$tpl->assign('resultDesc',$resultDesc);
$tpl->assign('matchInfos',$matchInfos);
$tpl->assign('return',$return);
$tpl->assign('userTicketInfo',$userTicketInfo);
echo_exit($tpl->r('../admin/order/virtual_orders_detail'));