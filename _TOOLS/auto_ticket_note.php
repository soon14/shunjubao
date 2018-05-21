<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$datetime = getCurrentDate();

$fp = fopen("auto_ticket_note.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {

	$objMySQLite = new MySQLite($CACHE['db']['default']);
	$end_time = date('Y-m-d H:i:s', time());
	//$u_id= array(17615,17617,17621,17414,12635,5841,12010,14106,12367,4342,13834,4454);
	
	//$u_id_str = implode(",",$u_id);
	
	$sql ="SELECT * FROM user_ticket_all where  partent_id=0  and endtime>='".$end_time."' and money>1000   ";	
	$all_follow_ticket_array = $objMySQLite->fetchAll($sql,'id');
	foreach ($all_follow_ticket_array as $key=>$value) {
		
		$sql_check ="SELECT * FROM user_member where u_id='".$value["u_id"]."' limit 0,1";	
		$value_check = $objMySQLite->fetchOne($sql_check,'id');
		$value["u_name"]  = $value_check["u_name"];
	
		//先检测是否
		$sql = "select * from zhiying_quan.q_ticket_note where pid=".$value["id"]." order by sysid desc limit 0,1";
		$ticket_note_array = $objMySQLite->fetchAll($sql,'id');
		
		
		
		
		if(empty($ticket_note_array)){
			$tableInfo = array();
			$tableInfo['u_id'] 				= $value["u_id"];
			$tableInfo['u_name'] 				= $value["u_name"];
			$tableInfo['pid'] 				= $value["id"];
			$tableInfo['pmoney'] 				= $value["money"];
			$tableInfo['dtime'] 		= $datetime;
			$tableInfo['ifnote'] 		= "0";
			$insert_value = implode("','",$tableInfo);
		
		
			$insql = "insert into zhiying_quan.q_ticket_note (u_id,u_name,pid,pmoney,dtime,ifnote) value ('".$insert_value."')";
			$objMySQLite->query($insql);
		}
		
		
	
		
		
	}
	 // 释放锁定
	  flock($fp, LOCK_UN); 
} else {
   exit();//直接退出
}
fclose($fp);
