<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';


$fp = fopen("lock_auto_send_prize.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {
			
			
$objMySQLite = new MySQLite($CACHE['db']['default']);
$sql ="SELECT * FROM follow_prize where f_status=0 order by id desc limit 0,1";//未分成的订单
$ticket_all_array = $objMySQLite->fetchAll($sql,'id');
//var_dump($ticket_all_array);exit();	
foreach ($ticket_all_array as $key=>$value) {

$id=$value["id"];
$cash=$value["f_prize"];


//跟单的用户
$u_id = $value["u_id"];
$ticket_id = $value["ticket_id"];

$follow_id = $value["follow_id"];
$partent_id = $value["partent_id"];


/*$u_id = 3084;
$follow_id = 3082;
*/

$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($u_id);

$objUserAccountLogFront = new UserAccountLogFront($u_id);
$tmpResult = $objUserAccountFront->consumeCash($u_id, $cash);
$tableInfo = array();
$tableInfo['u_id'] 			= $u_id;
$tableInfo['create_time'] 	= getCurrentDate();
$tableInfo['money'] 		= $cash;
$tableInfo['old_money'] 	= $userAccountInfo['cash'];
$tableInfo['log_type'] 		= BankrollChangeType::FOLLOW_CASH_CONSUME;
$tableInfo['record_table'] 	= 'user_ticket_all';
$tableInfo['record_id'] 	= $ticket_id;
$ticket_log_id = $objUserAccountLogFront->add($tableInfo);


//======================================
$objUserAccountFront = new UserAccountFront();
$userAccountInfo = $objUserAccountFront->get($follow_id);

$objUserAccountLogFront = new UserAccountLogFront($follow_id);
$tmpResult = $objUserAccountFront->addCash($follow_id, $cash);
$tableInfo = array();
$tableInfo['u_id'] 			= $follow_id;
$tableInfo['create_time'] 	= getCurrentDate();
$tableInfo['money'] 		= $cash;
$tableInfo['old_money'] 	= $userAccountInfo['cash'];
$tableInfo['log_type'] 		= BankrollChangeType::FOLLOW_CASH_ADD;
$tableInfo['record_table'] 	= 'user_ticket_all';
$tableInfo['record_id'] 	= $partent_id;
$ticket_log_id = $objUserAccountLogFront->add($tableInfo);

$updatesql = "update follow_prize  set f_time='".getCurrentDate()."',f_status=1 where id='".$id."'";
$objMySQLite->query($updatesql);
	
}

		
			
} else {
   exit();//直接退出
}
fclose($fp);

/*$exc_time =  time()-$stime;
echo "本次执行".$exc_time."秒";*/

?>