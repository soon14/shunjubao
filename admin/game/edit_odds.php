<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::GAME_MANAGER,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$sport = Request::r('sport');
$pool = Request::r('pool');
$operate = Request::r('operate');

$tpl = new Template();

$tpl->assign('sport', $sport);
$tpl->assign('pool', $pool);
$tpl->assign('operate', $operate);
$sportAndPoolDesc = UserTicketAll::getSportAndPoolDesc();
unset($sportAndPoolDesc[UserTicketAll::FB_CROSSPOOL]);
unset($sportAndPoolDesc[UserTicketAll::BK_CROSSPOOL]);
$tpl->assign('sportAndPoolDesc', $sportAndPoolDesc);

if (!$operate) {
	echo_exit($tpl->r('../admin/game/edit_odds'));
}

$objOdds = new Odds($sport, $pool);

switch ($operate) {
	case 'show':
		$week = Request::r('week');
		$num = Request::r('num');
		$condition = array();
		$condition['s_code'] = strtoupper($sport);
		$condition['m_num'] = $week.$num;
		$odds = $objOdds->getsByCondition($condition, 1, 'date desc');//只需找最近的一场赛事
		if (!$odds) {
			fail_exit('未发现赛事SP值');
		}
		$odd = array_pop($odds);
		$m_id = $odd['m_id'];
		$objBetting = new Betting($sport);
		$matchInfo = $objBetting->get($m_id);
		$tpl->assign('matchInfo', $matchInfo);
		$tpl->assign('odd', $odd);
		break;
	case 'edit':
		$id = Request::r('id');
		$info = array();
		$info = $_POST;
		$tmpResult = $objOdds->modify($info);
		if (!$tmpResult->isSuccess()) {
			fail_exit('修改失败，原因：'.$tmpResult->getData());
		}
		success_exit();
		break;
}

echo_exit($tpl->r('../admin/game/edit_odds'));