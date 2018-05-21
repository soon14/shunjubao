<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//查询订单是否已经中奖,并更新对应数据
$objMySQLite = new MySQLite($CACHE['db']['default']);
$dtime = date('Y-m-d H:i:s', time());

$sql ="SELECT * FROM follow_ticket_log where  update_prize_time=0 ";
$follow_ticket_log_array = $objMySQLite->fetchAll($sql,'id');

foreach($follow_ticket_log_array as $key=>$value) {
	
	//var_dump($value);exit();
	$partent_id =$value["partent_id"];//订单id
	$ticket_id =$value["ticket_id"] ;
	$id =$value["id"] ;
	
	if($ticket_id){
		$sql_org = "SELECT * FROM  user_ticket_all where id='".$ticket_id."'   ";
	}else{
		$sql_org = "SELECT * FROM  user_ticket_all where id='".$partent_id."'   ";
	}
	//查询原始订单的详细情况
	$value_org = $objMySQLite->fetchOne($sql_org,'id');
	

	
	if($value_org["prize_state"]==1){//已中奖
		if($ticket_id){//跟单成功的
			 $update_sql ="update follow_ticket_log set money='".$value_org["money"]."',prize_state=1,update_prize_time='".$dtime."',ticket_prize='".$value_org["prize"]."' where id='".$id."' and  update_prize_time=0 ";
			
		}else{//计算错过的金额
			$dingzhi_id=$value["dingzhi_id"];
			if($dingzhi_id>0){
				$sql_dingzhi = "SELECT * FROM  follow_ticket where id='".$dingzhi_id."'  ";
				$value_dingzhi = $objMySQLite->fetchOne($sql_dingzhi,'id');
				$dingzhi_multiple =$value_dingzhi["multiple"]; 
		
				 $org_multiple = $value_org["multiple"];
				 $miss_ticket_prize = round(($value_org["prize"]/$org_multiple)*$dingzhi_multiple,2);
				$update_sql ="update follow_ticket_log set prize_state=1,update_prize_time='".$dtime."',miss_ticket_prize='".$miss_ticket_prize."' where id='".$id."'  and update_prize_time=0 ";
			}
		
		}
		
		
		$objMySQLite->query($update_sql);
		
	}elseif($value_org["prize_state"]==2){//未中奖

		$update_sql ="update follow_ticket_log set money='".$value_org["money"]."',prize_state=2,update_prize_time='".$dtime."'  where id='".$id."'  and   update_prize_time=0 ";
		$objMySQLite->query($update_sql);
	}elseif($value_org["prize_state"]==0){//开奖
		
	}
	
	
	
	
}



