<?php
/**
 * 获取赛事信息
 */

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$sport	= Request::r('sport');
if (!$sport) {
	$sport = 'fb';
}
if (!in_array($sport, array('fb','bk'))) {
	echo_exit('sport not exist');
}


$s_date = date('Y-m-d', time() - 86400 *20);

//取当天比赛数据
$b_date = date('Y-m-d', time());
$condition = array(
	'b_date'=> $b_dates,
);

$return = $matchIds = $score_results = array();
$objBetting = new Betting($sport);

$objMySQLite = new MySQLite($CACHE['db']['default']);

$stime =time();
$condition = array();
$condition['date'] = $b_date;
$order = 'b_date asc';
$data = $objBetting->getsByCondition($condition, null, $order);

foreach ($data as $matchInfo) {
	//取此比赛相关的投注记录
	$matchId = $matchInfo['id'];	
	$where  = "combination like '%had|".$matchId."|%'";
	$sql = "select combination from user_ticket_all where  ".$where." and print_state=1";
	$userTicketall = $objMySQLite->fetchAll($sql);
	$matchInfo["ticket"] = $userTicketall;
	$results[] = $matchInfo;
}



$nm = time()-$stime;
foreach ($results as $value) {
	$lotttime 	= $value['b_date'];
	$ballid 	= $value['num'];
	$matchId = $value['id'];//mnl|55706|h
	
	
	$had_nums_h =0;
	$had_nums_d=0;
	$had_nums_a=0;
	$hhad_nums_h=0;
	$hhad_nums_d=0;
	$hhad_nums_a=0;
	foreach ($value['ticket'] as $ticketInfo) {
		
		if(strpos($ticketInfo["combination"],"had|".$matchId."|h") || strpos($ticketInfo["combination"],",had|".$matchId."|h")){
			$had_nums_h +=1;
		}
		if(strpos($ticketInfo["combination"],"had|".$matchId."|d") || strpos($ticketInfo["combination"],",had|".$matchId."|d")){
			$had_nums_d +=1;
		}
		if(strpos($ticketInfo["combination"],"had|".$matchId."|a") || strpos($ticketInfo["combination"],",had|".$matchId."|a")){
			$had_nums_a +=1;
		}
		
		if(strpos($ticketInfo["combination"],"hhad|".$matchId."|h") || strpos($ticketInfo["combination"],",hhad|".$matchId."|h")){
			$hhad_nums_h +=1;
		}
		if(strpos($ticketInfo["combination"],"hhad|".$matchId."|d") || strpos($ticketInfo["combination"],",hhad|".$matchId."|d")){
			$hhad_nums_d +=1;
		}
		if(strpos($ticketInfo["combination"],"hhad|".$matchId."|a") || strpos($ticketInfo["combination"],",hhad|".$matchId."|a")){
			$hhad_nums_a +=1;
		}
	}
	

	$had_nums_h -= $hhad_nums_h;
	$had_nums_d -= $hhad_nums_d;
	$had_nums_a -= $hhad_nums_a;
	
	$all_had_ticke = $had_nums_h+$had_nums_d+$had_nums_a;
	$all_hhad_ticke = $hhad_nums_h+$hhad_nums_d+$hhad_nums_a;
	
	$had_nums_h_rate= (round($had_nums_h/$all_had_ticke,4)*100)."%";
	$had_nums_d_rate= (round($had_nums_d/$all_had_ticke,4)*100)."%";
	$had_nums_a_rate= (round($had_nums_a/$all_had_ticke,4)*100)."%";
	$had_nums_h_rate= (round($hhad_nums_h/$all_hhad_ticke,4)*100)."%";
	$had_nums_d_rate= (round($hhad_nums_d/$all_hhad_ticke,4)*100)."%";
	$had_nums_a_rate= (round($hhad_nums_a/$all_hhad_ticke,4)*100)."%";

	$return[] = array(
		'matchId'	  => $value['id'],
		'num'		  => $value['num'],
		'b_date'	  => $lotttime,
		'l_cn'		  => $value['l_cn'],
		'h_cn'		  => $value['h_cn'],
		'a_cn'		  => $value['a_cn'],
		'date'		  => $value['date'],
		'time'		  => $value['time'],
		'had_nums_h'  => $had_nums_h,
		'had_nums_d'  => $had_nums_d,
		'had_nums_a'  => $had_nums_a,
		'hhad_nums_h' => $hhad_nums_h,
		'hhad_nums_d' => $hhad_nums_d,
		'hhad_nums_a' => $hhad_nums_a,
		'had_nums_h_rate'  => $had_nums_h_rate,
		'had_nums_d_rate'  => $had_nums_d_rate,
		'had_nums_a_rate'  => $had_nums_a_rate,
		'hhad_nums_h_rate' => $hhad_nums_h_rate,
		'hhad_nums_d_rate' => $hhad_nums_d_rate,
		'hhad_nums_a_rate' => $hhad_nums_a_rate,
	);
}




$tpl = new Template();
$tpl->assign('return',$return);
$tpl->assign('sport',$sport);
$tpl->assign('nm',$nm);
$tpl->assign('cur_time',date("Y-m-d H:i:s"));
$tpl->assign('sportPoolFb',$sportPoolFb);
$tpl->assign('sportPoolBk',$sportPoolBk);
$tpl->d('../admin/game/match_rate');





?>