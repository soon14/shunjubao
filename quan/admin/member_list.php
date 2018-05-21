<?php
	include("config.inc.php");
	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		

	
	
	include('checklogin.php');
	$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");

    switch (get_param('action')){
	case 'add_save'://设置出票对应地区
		$u_id= get_param('u_id') ;
		$manul_ticket= get_param('manul_ticket') ;
		$description= get_param('description') ;
		
		$manul_ticket_array= explode(",",$manul_ticket);
		$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying_quan");
		
		//先把之前的数据清掉
		$sql = "DELETE FROM  q_member_set_area WHERE u_id=".$u_id;
		$res = $conn->Query($sql);
		
		for($i=0;$i<=count($manul_ticket_array);$i++){
			if($manul_ticket_array[$i]!=0){
				$arr = array(
					"u_id"=> "'$u_id'",
					"u_area"=>"'".$manul_ticket_array[$i]."'",
					"description"=>"'$description'",
					"addid"=>"'$adminid'",
					"addtime"=>"'$dtime'",
					"addip"=>"'$ip'"
				);
				$res = add_record( $conn, "member_set_area", $arr);	
			}
		
		}
		
			
			if(empty($res)){
				message('设置出错！');
				
			}else{
				message('设置成功！',"member_list.php?action=show_area");
			}
		
		
		
		case 'set_area'://设置出票对应地区
			$u_id = get_param('u_id');
		
			$sql ="SELECT * FROM  user_realinfo as a left join user_member  as b on a.u_id=b.u_id where 1  and a.u_id='".$u_id."' order by a.u_id desc limit 0,1";
			mysql_query('SET NAMES latin1');
			$query = $conn2 -> Query($sql);
			$value = $conn2 -> FetchArray($query);
			$tpl -> assign('value',$value);
			
			$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying_quan");
			
	
			$sql = "SELECT * FROM `q_member_set_area` WHERE u_id ='".$u_id."'";
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
				$description = $value["description"];
				$u_area .= $value["u_area"].",";
				
			}
			
			$tpl -> assign('description',$description);
			
			$tpl -> assign('manul_ticket',showbasiclist('manul_ticket',$u_area));

			$tpl -> display('member_set_area.html');
			break;	
		case 'show_area':
			$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying_quan");
			$sql = "SELECT u_id,max(addid) as addid,max(addtime) as addtime,max(addip) as addip,max(description) as description FROM `q_member_set_area` WHERE  1 group by u_id order by addtime desc";
			
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query)){
				
				
				$value["area_info"]=show_area_info($value["u_id"]);
		
				
				$conn2 = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying");
				$sql ="SELECT * FROM  user_realinfo as a left join user_member  as b on a.u_id=b.u_id where 1  and a.u_id='".$value["u_id"]."' order by a.u_id desc limit 0,1";
				mysql_query('SET NAMES latin1');
				$query2 = $conn2 -> Query($sql);
				$info = $conn2 -> FetchArray($query2);			
				$value["u_name"]=$info["u_name"];
				$value["realname"]=$info["realname"];
				$value["mobile"]=$info["mobile"];
				$value["addtime"]=date("Y-m-d H:i:s",$value["addtime"]);
				$result[] = $value;
			}
			
			
			$tpl -> assign('datalist',$result);
			
			$tpl -> display('member_show_area_list.html');
			break;	
		
		case 'delete2':
		
			$mobile = (get_param('mobile'));
			$sql = "SELECT u_id FROM `user_member` WHERE u_id in (SELECT u_id FROM `user_realinfo` where mobile ='".$mobile."' )";
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				$t_u_id .= $value["u_id"].",";
				
			}
			
			$sql = "DELETE FROM  user_member WHERE  u_id in (".substr($t_u_id,0,-1).")";
			
			$conn2->Query($sql);

			$sql = "DELETE FROM  user_realinfo WHERE  u_id in (".substr($t_u_id,0,-1).")";
			$conn2->Query($sql);
			
			$sql = "DELETE FROM  user_account WHERE   u_id in (".substr($t_u_id,0,-1).")";
			$conn2->Query($sql);
			
			$res = $conn2->AffectedRows();
			
			if( $res > 0 )
			{
				message('删除成功！');
			}else{
				message('删除失败!');
			}
			break;
			
			
    	case 'delete_area':		
		
			$u_id = intval(get_param('u_id'));
			$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying_quan");
			$sql = "DELETE FROM  q_member_set_area WHERE  u_id='".$u_id."'";
			$conn->Query($sql);
			$res = $conn->AffectedRows();

			if( $res > 0 )
			{
				message('删除成功！');
			}else{
				message('删除失败!');
			}
		
			
		
    	case 'delete':
			
			$u_id = intval(get_param('u_id'));

			$sql = "DELETE FROM  user_member WHERE  u_id='".$u_id."'";
			$conn2->Query($sql);

			$sql = "DELETE FROM  user_realinfo WHERE  u_id='".$u_id."'";
			$conn2->Query($sql);
			
			$sql = "DELETE FROM  user_account WHERE  u_id='".$u_id."'";
			$conn2->Query($sql);
			
			$res = $conn2->AffectedRows();

			if( $res > 0 )
			{
				message('删除成功！');
			}else{
				message('删除失败!');
			}

    		break;
		default:
			//分页
			$u_id = get_param('u_id');
			if($u_id!=""){
				$where .= " and b.u_id='".$u_id."'";
				$tpl -> assign('u_id',$u_id);	
			}
			$keywords = get_param('keywords');
			if($keywords!=""){
				$where .= " and mobile='".$keywords."'";
				$tpl -> assign('keywords',$keywords);	
			}
			
			
			
			$s_date = get_param('s_date');
			if( $s_date!= ''){
				$where .= " and b.u_jointime>='".$s_date." 00:00:00' ";
				$tpl -> assign('s_date',$s_date);
			}
			
			
			$e_date = get_param('e_date');
			if( $e_date!= ''){
				$where .= " and  b.u_jointime<='".$e_date." 23:59:59' ";
				$tpl -> assign('e_date',$e_date);
			}
			$u_name = get_param('u_name');
			if($u_name!=''){
				$where .= " and  b.u_name like '%".$u_name."%'";
				$tpl -> assign('u_name',$u_name);
			}
		
			
			
			$rz = get_param('rz');
			if( $rz!= ''){
				$where .= " and  a.idcard>0";
				$tpl -> assign('rz',$rz);
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
		    $totalRecord = $conn2 -> NumRows($conn2 -> Query('SELECT * FROM  user_realinfo as a left join user_member  as b on a.u_id=b.u_id  where 1   '.$where),0);
			$sql ='SELECT * FROM  user_realinfo as a left join user_member  as b on a.u_id=b.u_id where 1  '.$where.'  ORDER BY b.u_jointime DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;
		//	mysqli_set_charset($conn2, "latin1");
			mysql_query('SET NAMES latin1');
			$query = $conn2 -> Query($sql);
			while($value = $conn2 -> FetchArray($query)){
				
				
				$sql2 = "SELECT * FROM `user_account` WHERE u_id ='".$value["u_id"]."'";
				$query2 = $conn2 -> Query($sql2);
				$value2 = $conn2 -> FetchArray($query2);
				$value["cash"] =$value2["cash"];
				$value["frozen_cash"] =$value2["frozen_cash"];
				$value["score"] =$value2["score"];
				$value["gift"] =$value2["gift"];
				
				//$value["money"] = "余额:".$value2["cash"].",冻结金额:".$value2["frozen_cash"].",积分:".$value2["score"].",彩金:".$value2["gift"];
				
				
				$result[] = $value;
			}
			
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'member_list.php?1=1&keywords='.$keywords);
			
			//$tpl -> register_function("get_goods_name_byid", "get_goods_name_byid");;
			$tpl -> assign('datalist',$result);
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
		
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('member_list.html');

			break;	

    }
	

	
	function show_area_info($u_id) {
			$conn = new db($MYSQL_HOST,$MYSQL_USER,$MYSQL_PASS,"zhiying_quan");
		$sql = "SELECT * FROM ".tname('member_set_area')." WHERE u_id=$u_id ";
		$query = $conn->Query($sql);
		while($value=$conn->FetchArray($query)){
			$area_info .= show_basicname("manul_ticket",$value["u_area"])." ";	
		}
		return $area_info;
}

	
?>