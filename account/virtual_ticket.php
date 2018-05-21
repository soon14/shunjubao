<?php
/**
 * 积分投注详情页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$userTicketId = Request::r('userTicketId');
$showAllUserTicket = false;//后台人员查看某人的用户票功能

if (!$userTicketId) {
	echo_exit('请输入正确ID');
}

$objVirtualTicket = new VirtualTicket();
$userTicketInfo = $objVirtualTicket->get($userTicketId);

if (!$userTicketInfo) {
	echo_exit('请输入正确ID');
}

$u_id = $userTicketInfo['u_id'];
$objUserMemberFront = new UserMemberFront();
$userInfo = $objUserMemberFront->get($u_id);

$roles = array(
		Role::ADMIN,
);

if (Runtime::requireRole($roles,false)) {
	$showAllUserTicket = true;
}

if ($u_id != Runtime::getUid() && !$showAllUserTicket) {
	echo_exit('不允许查看');
}

$combination = $userTicketInfo['combination'];
$match_ids = array();
//1|h#1.05&a#0.95,2|a#1.05
$c = explode(',', $combination);

foreach ($c as $key=>$value) {
	$cm = explode('|', $value);
	$match_ids[$cm[0]] = $cm[1];// matchid=>h#1.05&a#0.95
}

$objBettingVirtual = new BettingVirtual();
$matchInfos = $objBettingVirtual->gets(array_keys($match_ids));

$resultDesc = BettingVirtual::getResultDesc();

foreach ($matchInfos as $key=>$value) {
	$key_str = '';//用户选项 胜[4.8 ](+123) 平[3.7 ] 负[1.55 ]
	$u_o = explode('&', $match_ids[$key]);//h#1.05&a#0.95
	foreach ($u_o as $k=>$v) {
		$v_o = explode('#', $v);
		$key_str .= $resultDesc[$v_o[0]]['desc'] . '['. $v_o[1].']';
	}
	if ($value['remark']) {
		$key_str .= '('.$value['remark'].')';
	}
	$matchInfos[$key]['key_str'] = $key_str;
}

$tpl = new Template();

$tpl->assign('resultDesc',$resultDesc);
$tpl->assign('matchInfos',$matchInfos);
$tpl->assign('combination',$combination);

$TEMPLATE['title'] = '方案详情';

$tpl->assign('userInfo', $userInfo);
$tpl->assign('userTicketInfo', $userTicketInfo);
echo_exit($tpl->r('virtual_ticket'));