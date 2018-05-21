<?

	include("config.inc.php");

	include('checklogin.php');

	

	/*$rights_array = unserialize($_SESSION['rights']);

	$array_right = array();

	foreach($rights_array as $key=>$row){

		$array_right[] = $key;

	}

	

	if(check_admin_right(10000,$array_right)==0){

		echo "对不起，你没有此权限";

		exit();

	}else{

		assign('admin',1);

	}*/
	
	$tablename = "dept";
	
	$action = get_param("action");
	
	//根据ID获取权限名
	function get_right_name( $conn,$id )
	{
		$sql = "select mr_name from ".tname("manage_right")." where mr_id=".$id;
		$query = $conn->Query($sql);
		$res = $conn->FetchArray($query);
		return $res['mr_name'];
	}
	switch($action){

		case 'manage':
			//分页
			$pageSize = 15;
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			//记录总数
			$totalRecord = $conn -> NumRows($conn -> Query('SELECT COUNT(*) FROM '.tname($tablename).''),0);
			
			$sql ='SELECT * FROM '.tname($tablename).' ORDER BY sysid DESC LIMIT '.$start.','.$pageSize.'';
			//echo $sql;die();
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{
				 $sql2 = "select * from ".tname("admin")." where uid=".$value['d_addid'];
				
				$query2 = $conn->Query($sql2);
				$res2 = $conn->FetchArray($query2);
				$value['d_addid'] = $res2['username'];
				$value['d_addtime'] = date("Y-m-d H:i:s",$value['d_addtime']);
				$result[] = $value;
			}
			
			
			//var_dump($result); 
			//die();
			$multi = multi($totalRecord,$pageSize,$page,'dept.php?action=manage');
			
			
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('dept', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('dept.html');

			break;

		

		case 'add':

			$sql =" select mr_id,mr_name from ".tname("manage_right")." order by mr_id asc";

			$result = $conn->query($sql);

			$i=0;

			while($row = $conn->FetchArray($result)){

				if($i>$conn->NumRows($result)){

					break;

				}else{

					$i++;

				}

				

				$row["i"] = $i;

				$row["mr_id"] = $row["mr_id"];

				$row["mr_name"] = $row["mr_name"];

				$per_list[] = $row;

			}

			$tpl -> assign('per_list',$per_list);

			$tpl -> display('dept_add.html');

			break;

		

		case 'add_action':

			$dp_id = get_param("dp_id");

			$dp_name = get_param("dp_name");

			$dp_desc = get_param("dp_desc");

			$time = time();

			$admin = $_SESSION['adminid'];

			

			//$rights = get_param("permission");

			$rights = $_POST['permission'];
			//print_r($rights);die();
			$myarray = array();

			foreach($rights as $key=>$row){
				//print_r($row);
				$myarray[$row] = get_right_name( $conn,$row);

			}

			//print_r($myarray);die();

			$str_array_s = serialize($myarray);

			//print_r($str_array_s);die();
			$arr = array(
					"d_id"=>"$dp_id",
					"d_name"=>"'$dp_name'",
					"d_rights"=>"'$str_array_s'",
					"d_addid"=>"$admin",
					"d_addtime"=>"$time",
					"d_desc"=>"'$dp_desc'",
				);
				
				//print_r($arr);die();
			$res = add_record( $conn, $tablename, $arr);
			
			if($res['rows'] <= 0)
			{
				message('插入失败！');
			}else{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'添加了部门:'.$dp_name);
				message('添加成功!');
			}

			

			break;

		

		case 'edit':



			$did = get_param("id");

			$sql = "select * from ".tname("dept")." where sysid=$did";

			$result = $conn->query($sql);

			$row = $conn->FetchArray($result);

			

			$tpl -> assign('sid',$row["sysid"]);

			$tpl -> assign('dp_id',$row["d_id"]);

			$tpl -> assign('dp_name',$row["d_name"]);

			$tpl -> assign('dp_desc',$row["d_desc"]);

			



			$array_un = unserialize($row["d_rights"]);

			

			$check_myarray =array();

			foreach($array_un as $key =>$row){

				$check_myarray[] = $key;

			}

			$sql_rg ="select mr_id,mr_name from ".tname("manage_right")." order by mr_id asc";

			$result_rg = $conn->query($sql_rg);

			while($row_rg = $conn->FetchArray($result_rg)){

				$array_all[$row_rg["mr_id"]] = $row_rg["mr_name"];

			}



			$tpl -> assign('i',$i);

			$tpl -> assign('cust_checkboxes', $array_all);

			$tpl -> assign('customer_id', $check_myarray);

			$tpl -> assign('sid',$did);

			$tpl -> assign('per_list',$per_list);

			$tpl -> display('dept_edit.html');

			

			break;

			

		case 'edit_action':

			$vid  = get_param("id");

			

			$dp_id = get_param("dp_id");

			$dp_name = get_param("dp_name");

			$dp_desc = get_param("dp_desc");

			$admin = $_SESSION['adminid'];

			

			//$pid = get_param("perid");
			$pid = $_POST['perid'];
			

			$tmp_myarray = array();

			foreach($pid as $key=>$row){

				$tmp_myarray[$row] = get_right_name($conn,$row);

			}

			

			$str_up_array_s = serialize($tmp_myarray);

			$arr = array(
					"d_id"=>"$dp_id",
					"d_name"=>"'$dp_name'",
					"d_rights"=>"'$str_up_array_s'",
					"d_addid"=>"$admin",
					"d_desc"=>"'$dp_desc'",
				);
			//print_r($arr);die();
			$res = update_record( $conn, $tablename, $arr, "and sysid = $vid");
			if( $res > 0)
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'添加了部门:'.$dp_name);
				message('修改成功');
			}else{
				message('修改失败');
			}
			break;

		

		case 'delete':

			$did = get_param("id");

			$sql = "delete from ".tname("dept")." where sysid=$did";

			if($conn->Query($sql)){

				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除了部门（系统id）:'.$did);
				echo "<script>alert('删除成功');location.href='dept.php?action=manage';</script>";

			}else{

				echo "<script>alert('删除失败');history.go(-1);</script>";

			}

			

			break;

	}


?>

