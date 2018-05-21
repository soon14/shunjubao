<?php
/**
 * 北单的确认投注页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$sport 			= $_REQUEST["sport"];
$combination	= $_REQUEST["combination"];
$p 				= strtolower($_REQUEST["pool"]);//需要专成小写的玩法

$select 	= $_REQUEST["select"];
$multiple 	= $_REQUEST["multiple"];
$money 		= $_REQUEST["money"];

$uid 	= Runtime::getUid();
$from 	= $_SERVER['HTTP_REFERER'];

//提交信息不全
if (!$sport || !$combination || !$p || !$select || !$multiple || !$money) {
	redirect($from);
}
$user_select = $_REQUEST["user_select"]?$_REQUEST["user_select"]:$select;
if ($user_select == '1x1') $user_select = '单关';
$chinese_pool = getPoolDesc($sport, $p);

//验证用户余额
if ($uid) {
	$objUserAccountFront = new UserAccountFront();
	$userAccountInfo = $objUserAccountFront->get($uid);
	$user_cash = $userAccountInfo["cash"];
	$rebate_per = $userAccountInfo["rebate_per"];
} else {
	$user_cash = 0;
	$rebate_per = 0;
}

//赛事信息
$matchInfos = $matchInfo = array();
$matchIds = array();

$objBetting = new BettingBD();
$matchs	= explode(',', $combination);
foreach($matchs as $k => $v){
	$mid = explode("|",$v);
	$matchIds[] = $mid[1];
}

$matchInfos = $objBetting->gets($matchIds);
//比赛名称转码
foreach ($matchInfos as $key => $value) {
	$value["h_cn"] 	= $value['hometeam'];
	$value["a_cn"] 	= $value['guestteam'];
	$matchInfos[$value['id']] = $value;
}

foreach($matchs as $k => $v){
	$m 		= explode("|", $v);
	$mid   	= $m[1];
	$pool  	= strtolower($m[0]);//注意大小写
	
	$matchInfo = $matchInfos[$mid];
	$matchInfos[$mid]["num"] 	= show_num(date('N',strtotime($matchInfo["date"])).$matchInfo["matchid"]);
	$matchInfos[$mid]['chinese_pool'] = getPoolDesc($sport, $pool);
	
	$key_str = '';
    $option = explode("&", $m[2]);
	
	$cond = $goalline = array();
	$cond['id'] = $mid;
	
	$objOdds = new OddsBD($p);
	$oddInfos = $objOdds->getsByCondition($cond);
	foreach ($oddInfos as $odds) {
		if ($odds["remark"]) {
			$goalline[$mid][$pool] = $odds["remark"];
		}
	}
	
    foreach($option as $k1 => $v1){
    	$key = explode("#", $v1);
    	$sp = $key[1];
    	$chinese = chinese($key[0],$pool);
    	if ($goalline[$mid][$pool]) $chinese .= '('.$goalline[$mid][$pool].')';  
     	$key_str .= '&nbsp;'.$chinese.'['.$sp.']';
    }
    
    $matchInfos[$mid]['key_str'] = $matchInfos[$mid]['key_str'].$key_str;
}

$tpl->assign('s', $sport);
$tpl->assign('p', $p);
$tpl->assign('c', $combination);

$tpl->assign('chinese_pool', $chinese_pool);
$tpl->assign('select', $select);
$tpl->assign('user_select', $user_select);
$tpl->assign('multiple', $multiple);
$tpl->assign('money', $money);
$tpl->assign('from', $from);
$tpl->assign('matchInfos', $matchInfos);
$tpl->assign('user_cash', $user_cash);
$tpl->assign('rebate_per', $rebate_per);
echo_exit($tpl->r('confirm/confirm'));
