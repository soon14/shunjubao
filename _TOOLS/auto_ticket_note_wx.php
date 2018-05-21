<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$datetime = getCurrentDate();

$fp = fopen("auto_ticket_note_wx.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {

	$objMySQLite = new MySQLite($CACHE['db']['default']);
	$sql ="SELECT * FROM zhiying_quan.q_ticket_note where   ifnote=0  ";
	$q_ticket_note = $objMySQLite->fetchAll($sql,'id');
	
	
	foreach ($q_ticket_note as $key=>$value) {
			
			//var_dump($value);exit();

			$t_key = 'solanwxjson81339089_kc';
			$wxkey = md5($t_key.$t_date);

		    $template_id= "sOcH_xy3w84FDRW2zfgQy8ceMAM6-76kENF66NzFZ0c";
			$first 		= "您好，拼团成功,团长id:".$value["u_id"]."(".$value["u_name"].")";
		
			$keyword1 	= $value["pid"];//券码
			$keyword2 	= 1;
			$keyword3 	= $value["pmoney"];
			$keyword4 	= $value["dtime"];
			$remark 	= "请尽快至店家消费";
			$wx_openid 	= "oXOS3jn48f_lJsuYa_SBrOk2N-s4,oXOS3jriIrcqxj_EDMK9vqpRCZzg";

			$url 		= "http://www.solanhk.com";
			$send_date=date("Y-m-d");
			$send_time=date("H");
		
			
			foreach(explode(',',$wx_openid) as  $key2 =>  $val){
				$value["type"]				= 'crm_other';
				$value["send_date"]		= $send_date;
				$value["send_time"]		= $send_time;
				$value["openid"]		= $val;
				$value["template_id"]	= $template_id;//模板
				
				$value["first"]			= $first;
				$value["remark"]		= $remark;
				$value["keyword_num"]	= '4';
				$value["keyword1"]		= $keyword1;	
				$value["keyword2"]		= $keyword2;	
				$value["keyword3"]		= $keyword3;
				$value["keyword4"]		= $keyword4;
				$value["url"]			= $url;
				$result1[] = $value;
			}
				
			//var_dump($result1);	exit();
			$data1=json_encode($result1);	
	
			$result = array(
				"date"	=> $t_date,
				"key" 	=> $wxkey,
				"data"	=> "$data1"
			);	
			
		//	var_dump($result);	exit();
			$data=json_encode($result);
			$ch = curl_init('http://www.solan.hk/wx/wx_template_send.php'); //请求的URL地址
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//$data JSON类型字符串
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data)));
			$res = curl_exec($ch);
			$res_show = json_decode($res);
			if($res_show->{'errcode'}=='0'){

				$sql_update ="update zhiying_quan.q_ticket_note set ifnote=1  where  1 and  ifnote=0  and sysid=".$value["sysid"];
				$res = $objMySQLite->query($sql_update);
				echo "发送成功";
			}else{
				
				var_dump($res_show->{'errmsg'});
				echo "出错";
			}
			exit();


	}
} else {
	
	
	
   exit();//直接退出
}





$fp = fopen("auto_ticket_note.txt", "w+");
if (flock($fp, LOCK_EX | LOCK_NB)) {

	$objMySQLite = new MySQLite($CACHE['db']['default']);
	$end_time = date('Y-m-d H:i:s', time());
	$u_id= array(5841,12010,14106,12367);
	
	$u_id_str = implode(",",$u_id);
	
	$sql ="SELECT * FROM user_ticket_all where  partent_id=0  and u_id in ($u_id_str) and endtime>='".$end_time."'   ";//查询晒单	
	$all_follow_ticket_array = $objMySQLite->fetchAll($sql,'id');
	foreach ($all_follow_ticket_array as $key=>$value) {
		
		//先检测是否
		$sql = "select * from zhiying_quan.q_ticket_note where pid=".$value["id"]." order by sysid desc limit 0,1";
		$ticket_note_array = $objMySQLite->fetchAll($sql,'id');
		
		if(empty($ticket_note_array)){
			$tableInfo = array();
			$tableInfo['u_id'] 				= $value["u_id"];
			$tableInfo['pid'] 				= $value["id"];
			$tableInfo['pmoney'] 				= $value["money"];
			$tableInfo['dtime'] 		= $datetime;
			$tableInfo['ifnote'] 		= "0";
			$insert_value = implode("','",$tableInfo);
		
			$insql = "insert into zhiying_quan.q_ticket_note (u_id,pid,pmoney,dtime,ifnote) value ('".$insert_value."')";
			$objMySQLite->query($insql);
		}
		
		
	
		
		
	}
	 // 释放锁定
	  flock($fp, LOCK_UN); 
} else {
   exit();//直接退出
}
fclose($fp);
