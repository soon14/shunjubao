<?php
	include("config.inc.php");
	include('checklogin.php');
	

	$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");
    switch (get_param('action')){
			

		default:
		
			$follow_name = get_param('follow_name');
			if($follow_name!=""){
				$sql3 ="SELECT * FROM user_member where 1  and  u_name like '%".$follow_name."%'   ";
				mysql_query('SET NAMES latin1');
				$query3 = $conn -> Query($sql3);
				while($value3 = $conn -> FetchArray($query3)){
						$result3[]=$value3["u_id"];
				}
		
				if(!empty($result3)){
						$where .= " and follow_id in (".implode(",",$result3).")";
				}
		
				$tpl -> assign('follow_name',$follow_name);	
			}
			
		
			
			$u_name = get_param('u_name');
			if($u_name!=""){
				$sql2 ="SELECT * FROM user_member where 1  and  u_name like '%".$u_name."%'   ";
				mysql_query('SET NAMES latin1');
				$query2 = $conn -> Query($sql2);
				while($value2 = $conn -> FetchArray($query2)){
						$result2[]=$value2["u_id"];
				}
		
				if(!empty($result2)){
						$where .= " and u_id in (".implode(",",$result2).")";
				}
		
				$tpl -> assign('u_name',$u_name);	
			}
			
			$sid = get_param('sid');
			if( $sid!= ''){
				$where .= " and ( partent_id='".$sid."' or ticket_id='".$sid."')  ";
				$tpl -> assign('sid',$sid);
			}
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and f_time>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  f_time<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
			}
			
			$f_status = get_param('f_status');
			if($f_status>0){
				if($f_status==1){
					$where .= " and f_status=1 ";	
				}elseif($f_status==2){
					$where .= " and (f_status is null or f_status!=1) ";	
				}
				$tpl -> assign('f_status',$f_status);	
			}
			
			
		
	
			$spage = get_param('spage');
			if($spage){
				$page=1;
			}else{
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
			}
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
			
			
			$sql ='SELECT sum(f_prize) as f_prize FROM follow_prize where 1  '.$where.'  ';
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);
			$dingzhi_total_f_prize = $value["f_prize"];
			$tpl -> assign('dingzhi_total_f_prize',$dingzhi_total_f_prize);
			
			
			
			
		    $totalRecord = $conn -> NumRows($conn -> Query('SELECT * FROM  follow_prize where 1   '.$where),0);
			$sql ='SELECT * FROM follow_prize where 1  '.$where.'  ORDER BY id DESC LIMIT '.$start.','.$pageSize.'';

			mysql_query('SET NAMES latin1');
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{

				if($value["f_status"]!=1){
					$value["f_status_show"]="未";	
				}else{
					$value["f_status_show"]="<strong>已分</strong>";		
				}
				if($value["print_state"]==1){
					$value["print_state"]="已出票";	
				}
			/*	
				$value["partent_show"] = show_user_ticket_all($value["partent_id"]);
				$value["ticket_show"] = show_user_ticket_all($value["ticket_id"]);*/
				
				
				//$value["partent_show"] = show_user_ticket_all($value["partent_id"]);
				$value["ticket_show"] = show_user_ticket_all($value["ticket_id"]);
				
				//$value["follow_ticket_multiple"] = show_follow_ticket_multiple($value["follow_id"],$value["u_id"]);
				$total_prize +=$value["prize"];
				$total_money +=$value["money"];
				$total_f_prize +=$value["f_prize"];	
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'follow_prize.php?1=1&u_name='.$u_name.'&tags='.$tags.'&follow_name='.$follow_name.'&s_date='.$s_date.'&e_date='.$e_date.'&tags='.$tags.'&sid='.$sid);
			
		
			$tpl -> assign('datalist',$result);
			$tpl -> assign('total_prize',$total_prize);
			$tpl -> assign('total_money',$total_money);
			$tpl -> assign('total_f_prize',$total_f_prize);

			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('follow_prize.html');

			break;	

    }


?>