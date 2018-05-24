<?php
	include("config.inc.php");
	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		

	
	
	include('checklogin.php');
	$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

    switch (get_param('action')){
				

		
	
		default:
			//分页
			
			$id = get_param('id');
			if($id!=""){
				$where .= " and a.id='".$id."'";
				$tpl -> assign('id',$id);	
			}
			
		
			$keywords = get_param('keywords');
			if($keywords!=""){
				$where .= " and mobile='".$keywords."'";
				$tpl -> assign('keywords',$keywords);	
			}
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and a.datetime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  a.datetime<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
			}
			$u_name = get_param('u_name');
			if($u_name!=''){
				$where .= " and  b.u_name like '%".$u_name."%'";
				$tpl -> assign('u_name',$u_name);
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
		    $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id  where 1 and a.combination_type=1 and a.leitai=1  '.$where),0);
			$sql ='SELECT * FROM  user_ticket_all as a left join user_member  as b on a.u_id=b.u_id where 1  and a.combination_type=1 and a.leitai=1  '.$where.'  ORDER BY a.u_id DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
		//	mysqli_set_charset($conn2, "latin1");
			mysql_query('SET NAMES latin1');
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
				/*$sql2 = "SELECT count(*) as gz_nums,sum(money) as gz_money FROM `user_ticket_all` WHERE partent_id ='".$value["id"]."'";
				$query2 = $conn2 -> Query($sql2);
				$value2 = $conn2 -> FetchArray($query2);
				$value["gz_nums"] =$value2["gz_nums"];
				$value["gz_money"] =$value2["gz_money"];*/
				//$value["money"] = "余额:".$value2["cash"].",冻结金额:".$value2["frozen_cash"].",积分:".$value2["score"].",彩金:".$value2["gift"];
				if($value["partent_id"]!=0){
					$value["partent_id"] ='<a target="_blank" href="http://www.shunjubao.xyz/ticket/follow/'.$value["partent_id"].'.html">'.$value["partent_id"].'</a>';
				}else{
					$value["partent_id"] ='';
				}
				
				if($value["prize_state"]==1){
						$value["prize_state_show"] ="<span style=color:red>中奖</span>";
				}elseif($value["prize_state"]==2){
					$value["prize_state_show"] ="未中";
				}else{
					$value["prize_state_show"] ="未开奖";
				}
				
				if($value["recommend"]==1){
						$value["recommend_show"] ="<span style=color:red>推荐</span>";
				}else{
					$value["recommend_show"] ="";
				}
				if($value["combination_type"]==1){
						$value["combination_type_show"] ="<span style=color:red>已晒单</span>";
				}else{
					$value["combination_type_show"] ="";
				}
				
				if($value["leitai"]==1){
						$value["leitai_show"] ="<span style=color:red>擂台</span>";
				}else{
					$value["leitai_show"] ="";
				}
				
				
				
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'user_ticket_all_leitai.php?1=1&keywords='.$keywords.'&s_date='.$s_date.'&e_date='.$e_date.'&u_name='.$u_name);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_ticket_all_leitai.html');

			break;	

    }
	


	
?>