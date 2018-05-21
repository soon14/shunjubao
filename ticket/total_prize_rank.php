<?php
/**
 * 总体中奖排行
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$num = 10;
$order = 'desc';

$dsn = $CACHE['db']['default'];
$objMySQLite = new MySQLite($dsn);
$sql = "select u_id , sum(prize) as total_prize from user_ticket_all where `prize_state`=".UserTicketAll::PRIZE_STATE_WIN." group by u_id order by total_prize {$order} limit {$num}";
$info = $objMySQLite->fetchAll($sql);

if (!$info) {
	echo_exit('error');
}

$objUserMemberFront = new UserMemberFront();
$rank = array();
$i = 1;
foreach ($info as $value) {
	
	$user = $objUserMemberFront->get($value['u_id']);

	$value['u_name'] = $user['u_name'];
	$value['prize'] = $value['total_prize'];
	$rank[$i] = $value;
	$i++;
}

$tpl = new Template();
$tpl->assign('rank', $rank);
echo_exit($tpl->r('total_prize_rank'));