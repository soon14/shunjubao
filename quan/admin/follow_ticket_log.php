<?php
	include("config.inc.php");
	include('checklogin.php');
	

	$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");
    switch (get_param('action')){
	
	/*	case 'update':
		$isman = get_param('isman');
		$id = get_param('id');
		   $usql = "update ".tname($tablename)." set isman='".$isman."' where id = ".$id;
			$query = $conn -> Query($usql);
			if($query){
				message('操作成功');			
			}else{
			
				message('操作出错');		
			}

			break;
	
    	*/
			
		case 'delete':
			
			
			$id = get_param('id');
  
			$sql = " delete from follow_ticket_log where id=$id";
			$query = $conn->Query($sql);
			if( $conn->AffectedRows()>0)
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除自动ID（id）:'.$_REQUEST['id']);
				message('删除成功！',"follow_ticket_log.php");
			}else{
				message('删除失败!',"follow_ticket_log.php");
			}

    		break;	
		default:
	
			mysql_query('SET NAMES latin1');
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
			
			$order_id = get_param('order_id');
			if( $order_id!= ''){
				$where .= " and (partent_id=".$order_id." or ticket_id=".$order_id.")";
				$tpl -> assign('order_id',$order_id);
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
			
			$tags = get_param('tags');
			if($tags>0){
				if($tags==1){
					$where .= " and tags=1 ";	
				}elseif($tags==2){
					$where .= " and tags!=1 ";	
				}
				$tpl -> assign('tags',$tags);	
			}
			
			
			$logs = get_param('logs');
			if( $logs!= ''){
				$where .= " and log like '%".$logs."%' ";
				$tpl -> assign('logs',$logs);
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
			
		    $totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM follow_ticket_log where 1  ".$where ),0);
			$sql ='SELECT * FROM follow_ticket_log where 1  '.$where.'  ORDER BY id DESC LIMIT '.$start.','.$pageSize.'';
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{


				$this_logs = unserialize($value["log"]);
				$value["type"]=$this_logs["type"];	
				$value["from"]=$this_logs["from"];
				$value["msg"]=$this_logs["msg"];	
				
				if($value["tags"]!=1){
					$value["tags_show"]="<span style='color:red'>失败</span>";	
				}else{
					$value["tags_show"]="成功";		
				}
				if($value["show_range"]==2){
					$value["show_range"]="跟单";	
				}else{
					$value["show_range"]="所有";		
				}
				

				$value["partent_show"] = show_user_ticket_all($value["partent_id"]);
				$value["ticket_show"] = show_user_ticket_all($value["ticket_id"]);
				
				//$value["follow_ticket_multiple"] = show_follow_ticket_multiple($value["follow_id"],$value["u_id"]);
			
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'follow_ticket_log.php?1=1&u_name='.$u_name.'&tags='.$tags.'&follow_name='.$follow_name.'&s_date='.$s_date.'&e_date='.$e_date.'&tags='.$tags.'&order_id='.$order_id.'&logs='.$logs);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('follow_ticket_log.html');

			break;	

    }


?>