<?php
	include("config.inc.php");
	include('checklogin.php');
	$tablename = "admin";//预约表

	$ip = get_ip();//获取IP
	$dtime = time();//当时时间
	$adminid = $_SESSION["adminid"];//管理员ID		
	
    switch (get_param('action')){
		case 'update':
			$real_name = get_param('real_name');
			$newcode = md5(get_param('newcode'));//
			
			$password = md5(get_param('oldcode'));//			
			$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname($tablename)." where uid= ".$adminid." and password='".$password."' limit 0,1"),0);
			
		//	echo $sql;die();
			if($totalRecord==0){
					message('原来密码不对','admin_update.php');	
					exit();		
			}
			
			
			$arr = array(
				"real_name"=>"'$real_name'",
				"password"=>"'$newcode'"
			);
			//print_r($arr);die();
			$res = update_record( $conn, $tablename, $arr, "and uid = $adminid");//
			$query = $conn -> Query($usql);
			
			if( $res > 0){
					message('成功修改资料','admin_update.php');	
					exit();		
				
				}else{
					message('修改资料出错！','admin_update.php');	
					exit();	
				}	
	
			break;
    
		default:
		
			$sql = "SELECT * FROM ".tname($tablename)." where uid= ".$adminid." limit 0,1 ";
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);
	
			$tpl -> assign('username', $value["username"]);
			$tpl -> assign('real_name', $value["real_name"]);
			
			$tpl -> display('admin_update.html');
			break;	

    }

?>