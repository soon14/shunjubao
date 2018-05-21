<?php
/**
 * 最新中奖榜单
 */
include_once   dirname ( __FILE__ )  . DIRECTORY_SEPARATOR . 'init.php';

$type = Request::r('type');
$limit = Request::r('limit');
$all_types = array(
		1,//最近limit个中奖人信息
// 		2,
// 		3,
);

if (!Verify::int($limit) || $limit >50 ) {
	$limit = 40;
}

if (!in_array($type, $all_types)) {
	$type = 1;
}

$return = array();

$objUserTicketAllFront = new UserTicketAllFront();
switch ($type) {
	case 1:
		$condition = array();
		$condition['prize_state'] = UserTicketAll::PRIZE_STATE_WIN;
		$results = $objUserTicketAllFront->getsByCondition($condition, $limit, 'datetime desc');
		//获取用户名
		$uids = array();
		foreach ($results as $key=>$value) {
			$uids[] = $value['u_id'];
		}
		$objUserMemberFront = new UserMemberFront();
		$users = $objUserMemberFront->gets($uids);
		foreach ($results as $key=>$value) {
			$return[$key]['prize'] = $value['prize'];
			$return[$key]['u_name'] = $users[$value['u_id']]['u_name'];
		}
		break;
}

ajax_success_exit($return);