<?php
	include("config.inc.php");
	include('checklogin.php');
	
	$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

		
    switch (get_param('action')){
		
		
		case 'update':
		$status = get_param('status');
		$id = get_param('id');
		   $usql = "update follow_ticket set status='".$status."' where id = ".$id;
			$query = $conn -> Query($usql);
			if($query){
				message('操作成功');			
			}else{
			
				message('操作出错');		
			}

			break;
	
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
	
    	case 'delete':
			
			$fields = array( 'id');
			$values = array( intval(get_param('id')) );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除了护腕（id）:'.$_REQUEST['id']);
				message('删除成功！');
			}else{
				message('删除失败!');
			}

    		break;*/
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
				$where .= " and (u_name like'%".$u_name."%'  )";
				$tpl -> assign('u_name',$u_name);	
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
			
		   $totalRecord = $conn -> NumRows($conn -> Query('SELECT * FROM  follow_ticket where 1   '.$where),0);
		 
			$sql ='SELECT * FROM follow_ticket where 1  '.$where.'  ORDER BY id DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
			mysql_query('SET NAMES latin1');
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				if($value["cycle"]==1){
					$value["cycle_show"]="一周";
				}elseif($value["cycle"]==2){
					$value["cycle_show"]="两周";
				}elseif($value["cycle"]==3){
					$value["cycle_show"]="一个月";
				}else{
					$value["cycle_show"]="一周";
				}
				
				
				$value["enable"]=1;
				if($value["status"]==2){
				
					$value["status_show"]="<span style='color:red'>停止</span>";	
				}else{
						
					if($value["end_time"]<$dtime_detail){
						$value["enable"]=2;
						$value["status_show"]="<span style='color:red'>已结束</span>";	
					}else{
						$value["status_show"]="正常";		
					}
	
				}
				
				
				
				if($value["end_time"]<$dtime_detail){
					$value["end_time"]="<span style='color:red'>".$value["end_time"]."</span>";	
				}
				
				$value["suc_nums"]=0;
				//查询跟单成功数据
				$sql2 = "SELECT count(*) as nums,sum(ticket_prize) as ticket_prize FROM  follow_ticket_log where  dingzhi_id='".$value["id"]."'and tags=1  ";
				$query2 = $conn->Query($sql2);
				$value2 = $conn -> FetchArray($query2);
				$value["suc_nums"]=$value2["nums"];	
				$value["ticket_prize"]=$value2["ticket_prize"];	
			
				$sql2 = "SELECT count(*) as nums FROM  follow_ticket_log where  dingzhi_id='".$value["id"]."'and tags=0  ";
				$query2 = $conn->Query($sql2);
				$value2 = $conn -> FetchArray($query2);
				$value["miss_nums"]=$value2["nums"];	
				
				
				
				
				
				
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'follow_ticket.php?1=1&u_name='.$u_name.'&follow_name='.$follow_name.'&status='.$status);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('follow_ticket.html');

			break;	

    }

?>