<?php	
session_start();	

include("config.inc.php");	
include("checklogin.php");	
$action = get_param("action");
	
	if($_SESSION['adminid']=='') {
		header("Location: login.php");
	}else{
		if( $_SESSION['a_name'] == 'admin')
		{
			$tpl -> assign('admin',1);
		}else
		{
		
		}
		
	
	if($action=='changpass'){
		$tpl -> assign('changepass',1);
	}
		
		
			
		//assign('money_yesterday',$money_yesterday);		
		$tpl -> display("main_index.html");			
   }
?>