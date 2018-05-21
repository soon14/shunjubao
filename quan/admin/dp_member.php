<?php

	include("config.inc.php");

	include('checklogin.php');

	

	/*$rights_array = unserialize($_SESSION['rights']);

	$array_right = array();

	foreach($rights_array as $key=>$row){

		$array_right[] = $key;

	}

*/	

	 $dept_id = $_SESSION['dm_id'];



	$tpl -> assign('dm_id',$dept_id);

	

	$tablename = "dept_member";

	$action = get_param("action");

	switch($action){

		case 'manage':

			//分页
			$pageSize = 15;
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			

			
			//记录总数
			$totalRecord =$conn ->NumRows($conn -> Query('SELECT * FROM '.tname($tablename).''),0);
			
			
			$sql ='SELECT * FROM '.tname($tablename).' ORDER BY sysid DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;die();
			$query = $conn -> Query($sql);

			while($value = $conn -> FetchArray($query)) {

				$sql1 = "select * from ".tname("admin")." where uid=".$value['dm_al_id'];
				$query1 = $conn->Query($sql1);
				$res1 = $conn->FetchArray($query1);
				//print_r($sql1);die();
				$value['a_name'] = $res1['username'];
				$value['real_name'] = $res1['real_name'];
				
				
				if($res1['iflock']==2){
					$value['iflock']="已锁";
				}else{
					$value['iflock']=" ";
				}
				
				
				
				if( $res1['admin_logintme'] != '')
				{
					$value['admin_logintme'] = date("Y-m-d H:i:s",$res1['admin_logintme']);	
				}
				
				$value['a_login_ip'] = $res1['log_ip'];
				
				$sql2 = "select d_name from ".tname("dept")." where d_id=".$value['dm_d_id'];
				$query2 = $conn->Query($sql2);
				$res2 = $conn->FetchArray($query2);
				
				
				$value['dm_d_id'] = $res2['d_name'];
				
				$sql3 = "select * from ".tname("admin")." where uid=".$value['dm_edit_id'];
				$query3 = $conn->Query($sql3);
				$res3 = $conn->FetchArray($query3);
				 //print_r($res3);die();
				$value['dm_edit_id'] = $res3['username'];
				//$value['real_name'] = $res3['real_name'];
				$value['dm_edit_time'] = date("Y-m-d H:i:s",$value['dm_edit_time']);
				
				$result[] = $value;

			}
			
		
			//print_r($result);die();
			$multi = multi($totalRecord,$pageSize,$page,'dp_member.php?action=manage');
		  
			
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('dept_member', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));

			//读取部门列表

			$sql_m = "select d_id,d_name from ".tname("dept")."";

			$result_m = $conn->query($sql_m);

			while($values = $conn->FetchArray($result_m)){

				$values['d_id'] = $values['d_id'];

				$values['d_name'] = $values['d_name'];

				$dp_list[] = $values;

			}

			$tpl -> assign('dp_list',$dp_list);

			$tpl -> display('dp_member.html');

			break;


		case 'add':

			$sql = " select d_id,d_name from ".tname("dept")." order by d_id asc";

			$result = $conn->query($sql);

			while($row = $conn->FetchArray($result)){

				$value['d_id'] = $row["d_id"];

				$value['d_name'] = $row["d_name"];

				$dp_list[] = $value;

			}
			
			

			$tpl -> assign('dept_list',$dp_list);

			

			$dp_id = get_param("dp_id");

			if($dp_id<>''){

				$sql =" select d_rights from ".tname("dept")." where d_id=$dp_id";

				$result = $conn->query($sql);

				while($row = $conn->FetchArray($result)){

					$array_un = unserialize($row["d_rights"]);

				}



				$i = 0;

				$per_data .= "<table><tr>";

				foreach($array_un as $key=>$row_1){

					$per_data .="<td><input type=\"checkbox\" name=\"permission[]\" value=\"".$key."\" checked=\"checked\" />&nbsp;".get_right_name($conn,$key)."</td>";

					if($i==5){

						$per_data .="</tr><tr>";

						$i=0;

					}else{

						$i++;

					}

					

				}

				$per_data .= "</tr></table>";

				//var_dump($per_data);

				$tpl -> assign('per_data',$per_data);

				$tpl -> assign('dp_id',$dp_id);

			}

			$tpl -> display('dp_member_add.html');

			break;

		

		case 'add_action':

			$dm_id = get_param("dept");
			$dm_logname = get_param("logname");
			$real_name = get_param("real_name");

			//$dm_pass = substr(md5(get_param("password")),10,20);
			$dm_pass = md5(get_param("password"));
			$dm_mail = get_param("mail");

			//$if_admin = get_param("if_admin");

			$admin=$_SESSION['adminid'];

			$time =time();
			
			$ip = $_SERVER['REMOTE_ADDR'];
			//$rights = get_param("permission");
			$rights = $_POST['permission'];
			$temp_array = array();

			foreach($rights as $key=>$row){

				$str_array[$row]=get_right_name($conn,$row);

			}

			

			$str_array_s = serialize($str_array);
			$arr = array(
					"username"=> "'$dm_logname'",
					"password"=>"'$dm_pass'",
					"real_name"=>"'$real_name'",
					"log_ip"=>"'$ip'"
				);
				
	
				//print_r($arr);die();
			$res = add_record( $conn, "admin", $arr);
			
			if($res['rows'] <= 0){
				message('插入失败！');
				
			}else{
				$id = $res['id'];
				$arr2 = array(
						"dm_al_id"=>"$id",
						"dm_d_id"=>"$dm_id",
						"dm_rights"=>"'$str_array_s'",
						"dm_edit_time"=>"$time",
						"dm_edit_id"=>"$admin",
					);
				
				//var_dump($arr2);
				//die();
				$res = add_record( $conn, 'dept_member', $arr2);
				if($res['rows'] <= 0)
				{
					message('插入失败');
				}else{
					//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'添加了管理员:'.$dm_logname);
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'添加了管理员资料('.$dm_logname.')');	
					message('添加成功');
				}
			}
			break;

		

		case 'edit':

			$mid = get_param("id");

			$dp_id = get_param("dp_id");
			
			

			$sql = "select * from ".tname("dept")."_member where dm_al_id=$mid";
			$result = $conn->Query($sql);
			$row = $conn->FetchArray($result);
			
			
			//print_r($sql);//die();
			
			$sql2 = "select * from ".tname("admin")." where uid=".$row['dm_al_id'];
			$query = $conn->Query($sql2);
			$res = $conn->FetchArray($query);
			 	
			$dm_id_2 =$row["dm_d_id"];

			$tpl -> assign('sid',$row["uid"]);
	
			if($dp_id==''){

				$tpl -> assign('dm_id',$dm_id_2);

			}else{

				$tpl -> assign('dm_id',$dp_id);

			}
			
			$tpl -> assign('dm_logname',$res["username"]);

			$tpl -> assign('dm_password',$res["a_password"]);

			$tpl -> assign('dm_mail',$res["a_email"]);

			$tpl -> assign('real_name',$res["real_name"]);

			$tpl -> assign('iflock',$res["iflock"]);

			$array_un = unserialize($row["dm_rights"]);

			$array_temp = array();

			foreach($array_un as $key=>$row_b){

				$array_temp[] =$key ;

			}

			

			$sql_dm = " select d_id,d_name from ".tname("dept")." order by d_id asc";

			$result_dm = $conn->Query($sql_dm);

			while($row_dm = $conn->FetchArray($result_dm)){

				$value_1['d_id'] = $row_dm["d_id"];

				$value_1['d_name'] = $row_dm["d_name"];

				$dp_list_1[] = $value_1;

			}
			$tpl -> assign('dept_list_1',$dp_list_1);

			

			if($dp_id==''){

				$sql_rg =" select d_rights from ".tname("dept")." where d_id=".$dm_id_2."";

				$result_rg = $conn->query($sql_rg);

				while($row_rg = $conn->FetchArray($result_rg)){

					$array_all = unserialize($row_rg["d_rights"]);

				}

			}else{

				$sql_rg =" select d_rights from ".tname("dept")." where d_id=$dp_id";

				$result_rg = $conn->query($sql_rg);

				while($row_rg = $conn->FetchArray($result_rg)){

					$array_all = unserialize($row_rg["d_rights"]);

				}

			}

			

			$tpl -> assign('i',$i);

			$tpl -> assign('cust_checkboxes', $array_all);

			$tpl -> assign('customer_id', $array_temp);

			$tpl -> assign('sid',$row['dm_al_id']);

			$tpl -> assign('per_list',$per_list);

			

			$tpl -> display('dp_member_edit.html');

			

			break;

			

		case 'edit_action':

			$vid  = get_param("id");
			$iflock  = get_param("iflock");
			
			if($iflock!=2){
				$iflock =1;
			}
			
			$dm_id = get_param("dept");

			$dm_logname = get_param("logname");
			$real_name = get_param("real_name");
			$dm_pass = md5(get_param("password"));

			$dm_mail = get_param("mail");

			$admin=$_SESSION['adminid'];
			$time = time();
			//$pid = get_param("perid");
			$pid = $_POST['perid'];
			//print_r($pid);die();
			$str_up_array =array();
			foreach($pid as $key=>$row_a){
				$str_up_array[$row_a]=get_right_name($conn,$row_a);
			}

			$str_up_array_s = serialize($str_up_array);

			if(get_param("password")!=''){
				$arr = array(
						"username"=> "'$dm_logname'",
						"password"=>"'$dm_pass'",
						"real_name"=>"'$real_name'",
						"iflock"=>"'$iflock'",
						"a_email"=>"'$dm_mail'"
					);
			}else{
				$arr = array(
						"username"=> "'$dm_logname'",
						"real_name"=>"'$real_name'",
						"iflock"=>"'$iflock'",
						"a_email"=>"'$dm_mail'"
					);
			}
			//print_r($arr);exit();
			$res2 = update_record( $conn, "admin", $arr, "and uid = $vid");
			if( $res2 >= 0)
			{
				$arr2 = array(
						"dm_d_id"=>"$dm_id",
						"dm_rights"=>"'$str_up_array_s'",
						"dm_edit_time"=>"$time",
						"dm_edit_id"=>"$admin",
					);
				
				$res3 = update_record( $conn, "dept_member", $arr2, "and dm_al_id = $vid");
				if( $res3 >= 0)
				{
					//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'修改了管理员:'.$dm_logname);
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'修改了管理员资料('.$dm_logname.')');	
					message('修改成功');
				}else{
					message('修改失败');
				}
			}else{
				message('修改失败');
			}
			break;

		case 'search':
		
			$s_id = get_param("dept_id_s");

			$sql='';
			if($s_id!=''){
				$where .= ' AND dm_d_id="'.$s_id.'" ';
			}
			
			
			 $uname = get_param("uname");
			
			if($uname!=''){
				$sql = "select * from ".tname("admin")." where real_name like '%$uname%'  limit 0 , 1";
				$query = $conn->Query($sql);
				$value = $conn->FetchArray($query);
				if($value["uid"]){
					$where .= ' AND dm_al_id="'.$value["uid"].'" ';
					
					$tpl -> assign('uname',$uname);
				}

			}

			
			//分页
			$pageSize = 15;
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			
			//记录总数
			$totalRecord =$conn ->NumRows($conn -> Query('SELECT * FROM '.tname($tablename).' WHERE 1=1 '.$where.' '),0);
			$sql ='SELECT * FROM '.tname($tablename).' WHERE 1=1 '.$where.' ORDER BY sysid DESC LIMIT '.$start.','.$pageSize.'';
			
			$query = $conn -> Query($sql);

			while($value = $conn -> FetchArray($query)) {

				$sql1 = "select * from ".tname("admin")." where uid=".$value['dm_al_id'];
				$query1 = $conn->Query($sql1);
				$res1 = $conn->FetchArray($query1);
				$value['a_name'] = $res1['username'];
				$value['real_name'] = $res1['real_name'];
				
				
				if($res1['iflock']==2){
					$value['iflock']="已锁";
				}else{
					$value['iflock']=" ";
				}
				
				
				
				if( $res1['admin_logintme'] != '')
				{
					$value['admin_logintme'] = date("Y-m-d H:i:s",$res1['admin_logintme']);	
				}
				
				$value['a_login_ip'] = $res1['log_ip'];
				
				$sql2 = "select d_name from ".tname("dept")." where d_id=".$value['dm_d_id'];
				$query2 = $conn->Query($sql2);
				$res2 = $conn->FetchArray($query2);
				
				
				$value['dm_d_id'] = $res2['d_name'];
				
				$sql3 = "select * from ".tname("admin")." where uid=".$value['dm_edit_id'];
				$query3 = $conn->Query($sql3);
				$res3 = $conn->FetchArray($query3);
				$value['dm_edit_id'] = $res3['username'];
				$value['dm_edit_time'] = date("Y-m-d H:i:s",$value['dm_edit_time']);
				
				$result[] = $value;

			}
			
		
			$multi = multi($totalRecord,$pageSize,$page,'dp_member.php?action=search&dept_id_s='.$s_id);
		  
			
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('dept_member', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));

			//读取部门列表

			$sql_m = "select d_id,d_name from ".tname("dept")."";

			$result_m = $conn->query($sql_m);

			while($values = $conn->FetchArray($result_m)){

				$values['d_id'] = $values['d_id'];
				$values['d_name'] = $values['d_name'];
				$dp_list[] = $values;
			}
			
			//die($s_id);
			$tpl -> assign('dm_id_s',$s_id);
			$tpl -> assign('dp_list',$dp_list);

			$tpl -> display('dp_member.html');

			break;

		case 'delete':

			$mid = get_param("id");

			$sql = " delete from ".tname("dept")."_member where dm_al_id=$mid";
			//echo $sql;die();
			$query = $conn->Query($sql);
			if( $conn->AffectedRows()>0)
			{
				$sql2 = "delete from ".tname("admin")." where uid=$mid";
				//echo $sql2;die();
				$query = $conn->Query($sql2);
				if( $conn->AffectedRows()>0)
				{
					//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除了管理员（管理员ID）:'.$mid);
					admin_log($conn,$_SESSION['username'],$_SESSION['username'].'删除了管理员（管理员ID）:'.$mid);
					message('删除成功',"dp_member.php?action=manage");
				}else{
					message('删除失败2');
				}
			}else{
				message('删除失败3');
			}

			break;

	}

	//根据ID获取权限名
	function get_right_name( $conn,$id )
	{
		$sql = "select mr_name from ".tname("manage_right")." where mr_id=".$id;
		$query = $conn->Query($sql);
		$res = $conn->FetchArray($query);
		return $res['mr_name'];
	}

?>

