<?php
include_once "../include/init.php";

$s=$_REQUEST["sport"];
$select=$_REQUEST["selsect"];
$multiple=$_REQUEST["multiple"];
$money=$_REQUEST["money"];
$c=$_REQUEST["combination"];
$p=$_REQUEST["pool"];
$uid=$_SESSION["u_id"]?$_SESSION["u_id"]:1;

// 验证用户余额
$sql="select cash,rebate_per from user_account where u_id=$uid";            
$query1=mysql_query($sql,$db_r);
if($odds=mysql_fetch_array($query1)){ 
	$user_cash=$d["cash"];
	$rebate_per=$d["rebate_per"];
}

?>