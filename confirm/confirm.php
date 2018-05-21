<?php
/**
 * 确认投注页面
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$tpl = new Template();

$sport 			= $_REQUEST["sport"];
$combination	= $_REQUEST["combination"];
$p 				= $_REQUEST["pool"];

$select 	= $_REQUEST["select"];
$multiple 	= $_REQUEST["multiple"];
$money 		= $_REQUEST["money"];

$uid 	= Runtime::getUid();
$from 	= $_SERVER['HTTP_REFERER'];

$prize = Request::r('prize');

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

$objBetting = new Betting($sport);
$matchs	= explode(',', $combination);
foreach($matchs as $k => $v){
	$mid = explode("|",$v);
	$matchIds[] = $mid[1];
}

$matchInfos = $objBetting->gets($matchIds);
//比赛名称转码
foreach ($matchInfos as $key => $value) {
// 	$value["h_cn"] 	= ConvertData::gb2312ToUtf8($value['h_cn']);
// 	$value["a_cn"] 	= ConvertData::gb2312ToUtf8($value['a_cn']);
	$matchInfos[$value['id']] = $value;
}

foreach($matchs as $k => $v){
	$m 		= explode("|", $v);
	$mid   	= $m[1];
	$pool  	= $m[0];
	
	$matchInfo = $matchInfos[$mid];
	$matchInfos[$mid]["num"] 	= show_num($matchInfo["num"]);
	$matchInfos[$mid]['chinese_pool'] = getPoolDesc($sport, $pool);
	
	$key_str='';
    $option = explode("&", $m[2]);
	
	$cond = $goalline = array();
	$cond['m_id'] = $mid;
	
	$objOdds = new Odds($sport, $pool);
	$oddInfos = $objOdds->getsByCondition($cond);
	foreach ($oddInfos as $odds) {
		$g = '';
		if ($odds["goalline"]) {//+1.00 -3.50
			$g3 = substr($odds["goalline"], 0, -3);
			$g1 = substr($odds["goalline"], 0, -1);
			if ($g3 != $g1) $g = $g1;
			else $g = $g3;
			$goalline[$mid][$pool] = $g;
		}
	}
	
    foreach($option as $k1 => $v1){
    	$key = explode("#", $v1);
    	$sp = $key[1];
    	$chinese = chinese($key[0],$pool);
    	if ($goalline[$mid][$pool]) $chinese .= '('.$goalline[$mid][$pool].')';  
     	$key_str .= '&nbsp;'.$chinese.'['.$sp.' ]';
    }
    
    $matchInfos[$mid]['key_str'] = $matchInfos[$mid]['key_str'].$key_str;
}

 $log_confirm =  array();
 $log_confirm["uid"] = $uid;  
 $log_confirm["sport"] = $sport; 
 $log_confirm["select"] = $select;  
 $log_confirm["user_select"] = $user_select;   
 $log_confirm["multiple"] = $multiple;  
 $log_confirm["money"] = $money;  
 $log_confirm["combination"] = $combination;  
 $log_confirm["pool"] = $pool;  
 $log_confirm["from"] = $from;  
 log_result(json_encode($log_confirm), 'log_confirm', true);

$tpl->assign('s', $sport);
$tpl->assign('p', $p);
$tpl->assign('c', $combination);
$tpl->assign('prize', $prize);

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
