<?php
/**
 * 竞彩比赛修改相关
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
		Role::ADMIN,
		Role::GAME_MANAGER,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$sport = Request::r('sport');
$operate = Request::r('operate');

$tpl = new Template();

$tpl->assign('sport', $sport);
$tpl->assign('operate', $operate);
$statusDesc = Betting::getStatusDesc();
$tpl->assign('statusDesc', $statusDesc);
if (!$operate) {
	echo_exit($tpl->r('../admin/game/edit_game'));
}

$objBetting = new Betting($sport);

switch ($operate) {
	case 'show':
		$week = Request::r('week');
		$num = Request::r('num');
		$id = Request::r('id');
		$condition = array();
		$condition['s_code'] = strtoupper($sport);
		$condition['num'] = $week.$num;
		
		if(!empty($id)){
			$condition = array();
			$condition['id'] = $id;
		}
		
		$matchInfos = $objBetting->getsByCondition($condition, 1, 'date desc');//只需找最近的一场赛事
		if (!$matchInfos) {
			fail_exit('未发现赛事');
		}
		$matchInfo = array_pop($matchInfos);
		$tpl->assign('matchInfo', $matchInfo);
		
		$condition = array();
		$condition['sport'] = $sport;
		$condition['matchid'] = $matchInfo['id'];
		$objDanguanBetting = new DanguanBetting();
		$dgInfo = $objDanguanBetting->findBy($condition);
		
		$danguanInfo = array();
		foreach ($dgInfo as $key=>$value) {
			$danguanInfo[$value['pool']] = $value['pool'];
		}
		$tpl->assign('danguanInfo', $danguanInfo);
		break;
	case 'edit':
		//把修改前的内容和修改后的内容别记录下来
		$id = Request::r('id');
		$condition['id'] = $id;
		$matchInfos = $objBetting->getsByCondition($condition, 1, 'date desc');//只需找最近的一场赛事
		$pre_log = serialize($matchInfos[$id]);
			
		$info = array();
		$info = $_POST;
		$tmpResult = $objBetting->modify($info);
		if (!$tmpResult->isSuccess()) {
			fail_exit('修改失败，原因：'.$tmpResult->getData());
		}
		$matchInfos = $objBetting->getsByCondition($condition, 1, 'date desc');//只需找最近的一场赛事
		$after_log = serialize($matchInfos[$id]);
		
		
			$objBettingLog = new BettingLog();
			$info = array();
			$info['m_id'] = $id;
			$info['pre_log'] = $pre_log;
			$info['after_log'] = $after_log;
			$tmpResult = $objBettingLog->add($info);
	
		success_exit();
		break;
	case 'add_danguan':
		$info = array();
		$info = $_POST;
		$all_pools = $info['pool'];
		unset($info['pool']);
		
		$objDanguanBetting = new DanguanBetting();
		//清除掉这场比赛以前的单关
		$objDanguanBetting->delete(array('sport'=>$info['sport'],'matchid'=>$info['matchid']));
		foreach ($all_pools as $pool) {
			$info['pool'] = $pool;
	
			
			$id = $objDanguanBetting->add($info);
			if (!$id) {
				fail_exit('添加单关赛事失败，玩法：'.$pool);
			}
		}
		
		success_exit();
		break;
}

echo_exit($tpl->r('../admin/game/edit_game'));