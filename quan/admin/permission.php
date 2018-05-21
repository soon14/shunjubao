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
	$tablename = "manage_right";
	$action = get_param("action");

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
				$sql2 = "select a_name from game_accounts where sysid=".$value['mr_addid'];
				$query2 = $conn->Query($sql2);
				$res = $conn->FetchArray($query2);
				$value['mr_addid'] = $res['a_name'];
				$value['mr_addtime'] = date("Y-m-d H:i:s",$value['mr_addtime']);
				$result[] = $value;
				//print_r($result);
			}
			
			$multi = multi($totalRecord,$pageSize,$page,'permission.php?action=manage');
			
			//print_r($result);die();
			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('permission', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('permission.html');

			break;

		

		case 'add':

			$tpl -> display('permission_add.html');

			break;

		

		case 'add_action':

			$rg_id = get_param("m_id");

			$rg_name = get_param("name");

			$admin =$_SESSION['adminid'];

			$desc = get_param("desc");

			$time = time();

			$arr = array(
					"mr_id"=>"$rg_id",
					"mr_name"=>"'$rg_name'",
					"mr_addid"=>"$admin",
					"mr_addtime"=>"$time",
					"mr_desc"=>"'$desc'",
				);
			//print_r($arr);die();
			$res = add_record( $conn, $tablename, $arr);
			
			if($res['rows'] <= 0)
			{
				message('插入失败！');
			}else{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'添加了权限:'.$rg_name);
				message('添加成功!');
			}
			break;

		

		case 'edit':

			$pid = get_param("id");
			
			$fields = array('sysid');
			$values = array($pid);
			$result = get_info( $conn, $tablename, $fields, $values );
			
			$tpl -> assign('permission', $result);
			
			$tpl -> display('permission_edit.html');

			break;

			

		case 'edit_action':

			$pid = get_param("id");

			$rg_id = get_param("m_id");

			$rg_name = get_param("name");

			$desc = get_param("desc");

			$admin =$_SESSION['adminid'];
			
			$arr = array(
					"mr_id"=>"$rg_id",
					"mr_name"=>"'$rg_name'",
					"mr_addid"=>"$admin",
					//"mr_addtime"=>"$time",
					"mr_desc"=>"'$desc'",
				);
			$res = update_record( $conn, $tablename, $arr, "and sysid = $pid");
			
			if( $res > 0)
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'修改了权限:'.$rg_name);
				message('修改成功');
			}else{
				message('修改失败');
			}
				
			break;

		

		case 'delete':

			$pid = get_param("id");
			
			$fields = array( 'sysid');
			$values = array( $pid );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
				//admin_log($conn,$_SESSION['a_name'],$_SESSION['a_name'].'删除了权限:'.$name);
				message('删除成功！');
			}else{
				message('删除失败!');
			}

    		break;
			

	}

?>

