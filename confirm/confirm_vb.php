<?php
/**
 * 虚拟比赛订单确认页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();
$combination	= $_REQUEST["combination"];

$multiple 	= $_REQUEST["multiple"];
$money 		= $_REQUEST["money"];

$from 	= $_SERVER['HTTP_REFERER'];
$uid 	= Runtime::getUid();

if ($uid) {
	$objUserAccountFront = new UserAccountFront();
	$userAccountInfo = $objUserAccountFront->get($uid);
	$user_score = $userAccountInfo["score"];
	$tpl->assign('user_score',$user_score);
}

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

$tpl->assign('resultDesc',$resultDesc);
$tpl->assign('matchInfos',$matchInfos);
$tpl->assign('combination',$combination);
$tpl->assign('multiple',$multiple);
$tpl->assign('money',$money);
$tpl->assign('from',$from);
echo_exit($tpl->r('confirm/confirm_vb'));