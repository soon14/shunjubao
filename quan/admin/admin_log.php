<?php
	include("config.inc.php");
	include('checklogin.php');
	$tablename = "adminlog";//预约表

	
	
	if($_SESSION["adminid"]!="3"){
	
		$where = " and al_user='".$_SESSION["username"]."'";
	}
	
    switch (get_param('action')){
    	
		case"user_log":
			//分页
			
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			//记录总数
	
		 	$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname($tablename)."   where 1=1 $where"),0);
			
	
			$sql ="SELECT * FROM ".tname($tablename)."   where 1=1  $where ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;
			//print_r($sql);exit();
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query))
			{	
				
				$value["al_create_time"]=date("Y-m-d H:i:s",$value["al_create_time"]);
				
				$result[] = $value;
			}

		//	print_r($sql);die();
			$multi = multi($totalRecord,$pageSize,$page,'admin_log.php?action=user_log');
			

			$tpl -> assign('multi',$multi);
			$tpl -> assign('pageSize',$pageSize);
			$tpl -> assign('totalRecord',$totalRecord);
			$tpl -> assign('datalist', $result);
			$tpl -> assign('page',ceil($totalRecord/$pageSize));
			$tpl -> display('admin_log.html');

			break;	

    }

?>