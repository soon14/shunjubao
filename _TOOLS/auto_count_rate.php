<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//计算更新胜率，一周
$objMySQLite = new MySQLite($CACHE['db']['default']);
$start_time =  date("Y-m-d",(time()-60*60*24*6));//计算开始时间

$sql ="SELECT * FROM  admin_operate   where 1  and type=3  and status=1";
$dingzhi_array = $objMySQLite->fetchAll($sql,'id');

foreach($dingzhi_array as $key =>$value){

	$id = $value["id"];
	$user_info = unserialize($value["extend"]);
	$show_uid= $user_info["show_uid"];
	
	$s_hondanshu = show_prize_state($show_uid,1,0);//所有的红单量
	
	$show_prize_state1 = show_prize_state($show_uid,1,$start_time);//计算一周内红单量
	$show_prize_state2 = show_prize_state($show_uid,2,$start_time);//计算一周内黑单量
		
	$show_prize_rate = round($show_prize_state1/($show_prize_state1+$show_prize_state2),2)*100;//中奖率
	
	$usql="update admin_operate set s_hondanshu='".$s_hondanshu."', show_prize_state1='".$show_prize_state1."',show_prize_state2='".$show_prize_state2."',s_shenglv='".$show_prize_rate."' where id='".$id."' ";
	$objMySQLite->query($usql);	

	
}


function show_prize_state($u_id,$prize_state,$start_time=0){//查会员红单量，黑单量，胜率
	$conn = @mysql_connect("localhost", "root","1q2w3e4R!") or die("Could not connect to database");
	
	@mysql_select_db("zhiying", $conn) or die ("Could not select database");

	if($start_time==0){
		$sql ="SELECT count(*) as nums FROM user_ticket_all where u_id='".$u_id."'  and combination_type=1  and prize_state ='".$prize_state."' group by prize_state ";		
	}else{
		$sql ="SELECT count(*) as nums FROM user_ticket_all where u_id='".$u_id."' and datetime>='".$start_time."' and combination_type=1  and prize_state ='".$prize_state."' group by prize_state ";		
	}
	
	$query = mysql_query($sql,$conn);
	$value = mysql_fetch_array($query);
	return $value["nums"];
}

