<?php
	include("config.inc.php");
	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		

	
	
	include('checklogin.php');
	$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");
	$pageSize = 20;
    switch (get_param('action')){
		
		default:
			//分页
			$u_id = get_param('u_id');
			if( $u_id!= ''){
				$where .= " and a.u_id='".$u_id."' ";
				$tpl -> assign('u_id',$u_id);
			}
			
			
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				
				if(strpos($s_date,":")){
					$where .= " and a.datetime>='".$s_date."' ";
				}else{
					$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				}
				$tpl -> assign('s_date',$s_date);
			}else{
				$s_date =  date("Y-m-d",time());
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				if(strpos($e_date,":")){
					$where .= " and  a.datetime<='".$e_date."' ";		
				}else{
					$where .= " and  a.datetime<='".$e_date." 23:59:59' ";	
				}
				
				$tpl -> assign('e_date',$e_date);
			}

			$spage = get_param('spage');
			if($spage){
				$page=1;
			}else{
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
			}
			

			//$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
		  /*  $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1 and a.combination_type=1  '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1  and a.combination_type=1  '.$where.'  ORDER BY a.id DESC LIMIT '.$start.','.$pageSize.'';*/
			 mysql_query('SET NAMES latin1');
			$totalRecord = $conn2 -> NumRows($conn2 -> Query("SELECT a.u_id,b.u_name,COUNT(*) as nums,sum(money) as money,SUM(prize) as prize FROM `user_ticket_all` as a LEFT JOIN user_member as b on a.u_id=b.u_id where 1 $where and a.prize_state=1 GROUP by a.u_id order by nums desc"),0);
			$sql ="SELECT a.u_id,b.u_name,COUNT(*) as nums,sum(money) as money,SUM(prize) as prize FROM `user_ticket_all` as a LEFT JOIN user_member as b on a.u_id=b.u_id where 1 $where and a.prize_state=1 GROUP by a.u_id order by nums desc  LIMIT ".$start.",".$pageSize;
			
			//echo $sql;exit();
		//	mysqli_set_charset($conn2, "latin1");
		
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
				$sql2 = "SELECT count(*) as t_nums,sum(a.money) as t_money FROM `user_ticket_all` as a WHERE 1 $where  and a.u_id ='".$value["u_id"]."' and ( a.print_state=1 or a.print_state=9999)";
				$query2 = $conn2 -> Query($sql2);
				$value2 = $conn2 -> FetchArray($query2);
				$value["t_nums"] =$value2["t_nums"];
				$value["t_money"] =$value2["t_money"];
				
				
				$sql3 = "SELECT count(*) as p_nums,sum(a.money) as p_money FROM `user_ticket_all` as a WHERE 1 $where  and a.u_id ='".$value["u_id"]."' and ( a.print_state=1 or a.print_state=9999) and a.partent_id>0";
				$query3 = $conn2 -> Query($sql3);
				$value3 = $conn2 -> FetchArray($query3);
				$value["p_nums"] =$value3["p_nums"];
				$value["p_money"] =$value3["p_money"];
				
				$value["profit"] =$value["prize"]-$value["t_money"];
				$value["rate"] = round($value["nums"]/$value["t_nums"],4)*100;
				
				$all["nums"] += $value["nums"];
				$all["prize"] += $value["prize"];
				$all["t_nums"] += $value["t_nums"];
				$all["t_money"] += $value["t_money"];
				$result[] = $value;
			}
			
			$orderby = get_param('orderby');
			if(empty($orderby)){
				$orderby="profit";
			}
			
			foreach($result as $val){
				$key_arrays[]=$val[$orderby];
			}
			array_multisort($key_arrays,SORT_DESC,SORT_NUMERIC,$result);
			
			
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'user_ticket_report.php?1=1&orderby='.$orderby.'&s_date='.$s_date.'&e_date='.$e_date);
			$tpl -> assign('orderby',$orderby);
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('all',$all);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_ticket_report.html');

			break;	

    }
	


	
?>