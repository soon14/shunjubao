<?php
	include("config.inc.php");
	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		

	
	
	include('checklogin.php');
	$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

    switch (get_param('action')){
		case "update";
			
			$s_hondanshu = get_param('s_hondanshu');
			$s_shenglv = get_param('s_shenglv');
			$s_recomond = get_param('s_recomond');
			$id = get_param('id');	
			
			if(empty($s_hondanshu) && empty($s_shenglv )&& empty($s_recomond)){
				$r = array('status'=>"error","mess"=>"出错,胜率或单数或推荐不能同时为空!".$dtime_detail);
				echo json_encode($r); 
				exit();
			}

				$sql = "update  admin_operate set s_hondanshu='".$s_hondanshu."',s_shenglv='".$s_shenglv."' ,s_recomond='".$s_recomond."' WHERE  id='".$id."'  ";
				$res = $conn2->Query($sql);
				if($res){
					$r = array('status'=>"error","mess"=>"修改成功!".$dtime_detail);
				}else{
					$r = array('status'=>"error","mess"=>"修改出错!".$dtime_detail);
				}
			echo json_encode($r); 
				exit();
			break;		

		
	
		default:
			//分页
			
			/*$id = get_param('id');
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
			
		*/
			
			$u_name = get_param('u_name');
			if($u_name!=''){
				$where .= " and extend like '%".$u_name."%'";
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
		    $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM   admin_operate   where 1 and type=3  and status=1 '.$where),0);
			$sql ='SELECT * FROM  admin_operate   where 1  and type=3  and status=1  '.$where.'  ORDER BY s_recomond DESC,s_shenglv desc,s_hondanshu desc LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
		//	mysqli_set_charset($conn2, "latin1");
			mysql_query('SET NAMES latin1');
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
				$user_info = unserialize($value["extend"]);
				$value["s_u_name"] = $user_info["u_name"];	
				$value["s_u_id"] = $user_info["show_uid"];	
				
				
				$value["show_follow_ticket_nums"]=show_follow_ticket_nums($value["s_u_id"]);
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'user_dingzhi.php?1=1&u_name='.$u_name);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('user_dingzhi.html');

			break;	

    }
	


	
?>