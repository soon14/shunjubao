<?php
/**
 * 虚拟比赛修改相关
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$roles = array(
	Role::ADMIN,
	Role::GAME_MANAGER,
);

if (!Runtime::requireRole($roles,true)) {
	fail_exit("该页面不允许查看");
}

$operate = Request::r('operate');

$tpl = new Template();

$tpl->assign('operate', $operate);

if (!$operate) {
	$operate = 'show';
}

$objBettingVirtual = new BettingVirtual();
$sportDesc = BettingVirtual::getSportDesc();
$tpl->assign('sportDesc', $sportDesc);
$resultDesc = BettingVirtual::getResultDesc();
$tpl->assign('resultDesc', $resultDesc);

$info = array();
$info = $_POST;

switch ($operate) {
	case 'show'://默认展示一些虚拟比赛
		$start_time = Request::r('start_time');
		$end_time = Request::r('end_time');
		
		if (!$start_time || !$end_time) {
			$time = time();
			$start_time = date('Y-m-d', $time - 86400*7);
			$end_time = date('Y-m-d', $time);
		}
		
		$tpl->assign('start_time', $start_time);
		$tpl->assign('end_time', $end_time);
		
		$field = 'create_time';
		$limit = null;
		$order = $field . ' '.Request::r('order');
		
		$results = $objBettingVirtual->getsByCondtionWithField($start_time . ' 00:00:00', $end_time . '23:59:59', $field, array(), $limit, $order);
		$tpl->assign('results', $results);
		break;
	case 'add':
		$info['create_time'] = getCurrentDate();
		$id = $objBettingVirtual->add($info);
		if (!$id) {
			fail_exit('创建比赛失败');
		}
		success_exit();
		break;
	case 'edit':
// 		pr($info);
		$result = $objBettingVirtual->modify($info);
		if (!$result->isSuccess()) {
			fail_exit('修改比赛失败,原因：'.$result->getData());
		}
		success_exit();
		break;
	case 'del':
		$id = Request::r('id');
		$result = $objBettingVirtual->delete(array('id'=>$id));
		if (!$result) {
			fail_exit('删除比赛失败');
		}
		success_exit();
		break;
	default:
		fail_exit('wrong operate');
		break;
}
echo_exit($tpl->r('../admin/game/virtual_game'));