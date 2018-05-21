<?php
	include("config.inc.php");
	include('checklogin.php');
	
	$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

		
    switch (get_param('action')){
		
		
	
		default:
		
				
			$status = get_param('status');
			if($status>0){
				if($status==1){
					$where .= " and status=1 and end_time>='".$dtime_detail."'";	
				}elseif($status==2){
					$where .= " and (status!=1  or end_time<='".$dtime_detail."')";	
				}
				
				
				$tpl -> assign('status',$status);	
			}
			
		
		
		
			$m_id = get_param('m_id');
		
			if($m_id!=""){
				$where .= "  and m_id='".$m_id."' ";
				$tpl -> assign('m_id',$m_id);	
			}
			
			$operate_uname = get_param('operate_uname');
			if($operate_uname!=""){
				$where .= " and (operate_uname like'%".$operate_uname."%'  )";
				$tpl -> assign('operate_uname',$operate_uname);	
			}
	
	
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and create_time>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  create_time<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
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
			
		   $totalRecord = $conn -> NumRows($conn -> Query('SELECT * FROM  betting_log where 1   '.$where),0);
		 
			$sql ='SELECT * FROM betting_log where 1  '.$where.'  ORDER BY id DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
			mysql_query('SET NAMES latin1');
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				$pre_log = unserialize($value["pre_log"]);
				$after_log = unserialize($value["after_log"]);
				$str="<span style='color:red'>".$pre_log["num"]."</span>&nbsp;".$pre_log["h_cn"].'vs'.$pre_log["a_cn"].",";
				
			
				if($pre_log["date"]!=$after_log["date"]){//日期不一样
					$str .="日期<span style='color:red'>".$pre_log["date"]."</span>=><span style='color:red'>".$after_log["date"]."</span>,"; 
				}
				
				if($pre_log["time"]!=$after_log["time"]){//日期不一样
					$str .="时间<span style='color:red'>".$pre_log["time"]."</span>=><span style='color:red'>".$after_log["time"]."</span>,"; 
				}
	
				if($pre_log["status"]!=$after_log["status"]){//status
					$str .="状态<span style='color:red'>".$pre_log["status"]."</span>=><span style='color:red'>".$after_log["status"]."</span>,"; 
				}
					
			
				
				if(empty($str)){$str="无修改";}
				$value["mod_log"] =$str ;
				
				
				
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'betting_log.php?1=1&operate_uname='.$operate_uname.'&e_date='.$e_date.'&s_date='.$s_date);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('betting_log.html');

			break;	

    }

?>