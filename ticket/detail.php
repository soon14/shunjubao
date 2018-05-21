<?php
/**
 * 奖金明细
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$type = Request::r('type');//展示方式：json或页面
$combination = Request::r('c');
$sport = Request::r('s');
$multiple = Request::r('multiple');
$money = Request::r('money');
$select = Request::r('select');

$userTicketId = Request::r('userTicketId');
// $userTicketId = 1075;
if (Verify::int($userTicketId)) {
	$objUserTicketAllFront = new UserTicketAllFront();
	$userTicket = $objUserTicketAllFront->get($userTicketId);
	if ($userTicket) {
		$combination = $userTicket['combination'];
		$sport = $userTicket['sport'];
		$multiple = $userTicket['multiple'];
		$money = $userTicket['money'];
		$select = $userTicket['select'];
		if (Runtime::getUid() != $userTicket['u_id']) {
// 			fail_exit('不允许查看别人的明细');
		}
	}
}

$return = getTheoreticalBonus($sport, $combination, $multiple, $money, $select, $userTicket);

switch ($type) {
	case 'json':
		ajax_success_exit($return);
		break;
	default:
		$TEMPLATE['title'] = '智赢网投注奖金明细';
		$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,智赢网跟单,智赢网竞猜跟单,竞彩投注,智赢晒单中心,大力水手,王忠仓,寻鸡情求鸭迫,红姐,智赢红姐。 ';
		$TEMPLATE['description'] = '智赢网奖金评测的为即时竞彩奖金指数，最终实际奖金请按照出票后票样中的指数计算，该奖金评测计算中已包含单一玩法的奖金，仅供参考。';
		$tpl = new Template();
		$tpl->assign('return', $return);
		echo_exit($tpl->r('detail'));
		break;
}
