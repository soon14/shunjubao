<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$objMySQLite = new MySQLite($CACHE['db']['default']);


$sql ="SELECT * FROM user_ticket_all where  id>1361719 and max_money<=0 limit 0,1000";//查询晒单	
$ticket_array = $objMySQLite->fetchAll($sql,'id');


foreach ($ticket_array as $key=>$value) {
	
	$sport			= $value["sport"];
	$combination	= $value["combination"];
	$multiple		= $value["multiple"];
	$money			= $value["money"];
	$select			= $value["select"];
	$userTicket		= $value["userTicket"];
	$num			= $value["num"];
	
	$id				= $value["id"];

		
	$max_money = getTheoreticalBonus($sport, $combination, $multiple, $money, $select, $id);
	//$max_money = getTheoreticalBonus("fb", "had|98837|h#2.23,had|98838|h#2.18,had|98839|h#1.66,hhad|98840|h#2.50|-1.00", 5, "10.00","4x1","1360177");
 	$update_max_money = $max_money["detail"][$num]["max_money"];
	
	echo $sql = "update user_ticket_all set max_money='".$update_max_money."' where id = '".$id."'   ";
	$objMySQLite->query($sql);
	


}






