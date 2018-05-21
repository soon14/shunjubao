<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$fp = fopen("lock_follow_prize.txt", "w+");
		if (flock($fp, LOCK_EX | LOCK_NB)) {
		
		$stime=time();	
		//搜索近5天,跟单，并中奖的投注，然后搜索被跟订单，先记录下来，然后再确认是否需要转移分成操作
		$s_date =  date("Y-m-d",(time()-60*60*24*5));
		$objMySQLite = new MySQLite($CACHE['db']['default']);
		$sql ="SELECT * FROM user_ticket_all where partent_id>0  and prize_state=1 and prize>0 and print_state=1 and return_time>='".$s_date ."'";//中奖的订单
		$ticket_all_array = $objMySQLite->fetchAll($sql,'id');
		
		
		$partent_id = array();
		foreach ($ticket_all_array as $key=>$value) {//把母单查出来，检查是否有分成的需要
			if(!in_array($ticket_all_array[$key]["partent_id"],$partent_id)){
				$partent_id[]=$ticket_all_array[$key]["partent_id"];
			}
		}
		$partent_id_str = implode(",",$partent_id);
		//var_dump($ticket_all_array);exit();
		
		$sql ="SELECT * FROM user_ticket_all where partent_id=0  and prize_state=1  and pay_rate>0 and id in (".$partent_id_str.")";//母单是否有设置分成
		
		$partent_id_array = $objMySQLite->fetchAll($sql,'id');
		
		foreach ($partent_id_array as $key=>$value) {//把对应的子单写到数据表里面去
				
				 $partent_id = $key;//母单
				 $follow_id = $partent_id_array[$key]["u_id"];
				 $pay_rate = $partent_id_array[$key]["pay_rate"]/100;//调成百分数
				 
				 $sql2 ="SELECT * FROM user_ticket_all where  partent_id='".$partent_id."'  and print_state=1  and prize>0 ";
				 $son_id_array = $objMySQLite->fetchAll($sql2,'id');
				 
				 foreach ($son_id_array as $son_key=>$son_value) {
					 $ticket_id = $son_value["id"];
					 //先检查是否已经写过数据了，如果没有直接插入数据库
					$sql_check ="SELECT * FROM follow_prize where ticket_id='".$ticket_id."'  limit 0,1";//检查是否成功跟注过的订单	
					$value_check = $objMySQLite->fetchOne($sql_check,'id');
					if(!empty($value_check)){
						continue;	
					}else{
		
						
						$u_id= $son_value["u_id"];
						$ticket_id= $son_value["id"];
						$print_state= $son_value["print_state"];//出票状态
						$money= $son_value["money"];
						
						$prize_state= $son_value["prize_state"];
						$prize= $son_value["prize"];
						$prize_time= date("Y-m-d H:i:s",time());
					//	提成比例为1%-5%（提成=跟单中奖总额-跟单本金总额，中奖奖金若为正数，提成将从跟单中奖用户中按比例扣除）
						
						$will_f_prize = ($son_value["prize"]-$son_value["money"]);
						if($will_f_prize>0){
							$f_prize = round($pay_rate*$will_f_prize,2);
						}else{
							$f_prize =0;
						}
						
						
						//分成金额
						
						$tableInfo = array();
						$tableInfo['follow_id']    = $follow_id;
						$tableInfo['u_id'] 		   = $u_id;
						$tableInfo['partent_id']   = $partent_id;
						$tableInfo['ticket_id']    = $ticket_id;
						$tableInfo['money']    = $money;
						$tableInfo['print_state']    = $print_state;
						$tableInfo['prize_state']  = $prize_state;
						$tableInfo['prize'] 	   = $prize;
						$tableInfo['prize_time']   = $prize_time;
						$tableInfo['f_prize'] 	   = $f_prize;
						$tableInfo['pay_rate'] 	   = $pay_rate;
				
						//var_dump($tableInfo);exit();
						$insert_value = implode("','",$tableInfo);
						$insql = "insert into follow_prize (follow_id,u_id,partent_id,ticket_id,money,print_state,prize_state,prize,prize_time,f_prize,pay_rate) value ('".$insert_value."')";
						$objMySQLite->query($insql);	
					}	 	
				}
		}
		
		
} else {
   exit();//直接退出
}
fclose($fp);

/*$exc_time =  time()-$stime;
echo "本次执行".$exc_time."秒";*/

?>