<?php	
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
Runtime::requireLogin();
$objMySQLite = new MySQLite($CACHE['db']['default']);
$userInfo = Runtime::getUser();
$objUserRealInfo = new UserRealInfo();
$userRealInfo = $objUserRealInfo->get($userInfo['u_id']);
if(empty($userRealInfo["idcard"])){
	$r = array('status'=>"error","mess"=>"您尚未进行实名认证,请先实名认证!<br/><a href='http://www.zhiyingcai.com/account/user_center.php?p=realinfo'>点击实名认证</a>");
	echo json_encode($r); 
	exit();
}


//var_dump($userRealInfo);exit();
$follow_id = Request::r('follow_id');//被定制人
$cycle = Request::r('cycle');
$multiple = Request::r('multiple');
$objMySQLite = new MySQLite($CACHE['db']['default']);	


if(empty($follow_id) || empty($cycle) || empty($multiple)){
	$r = array('status'=>"error","mess"=>"提交出错!");
	echo json_encode($r); 
	exit();
}





$u_id = $userInfo['u_id'];
$u_name=$_COOKIE["u_name"];
$status="1";//默认开通
$create_time  = date("Y-m-d H:i:s");
$start_time=date("Y-m-d H:i:s");


if($follow_id==$u_id){
	$r = array('status'=>"error","mess"=>"禁止定制自己的晒单!");
	echo json_encode($r); 
	exit();
}

if($follow_id==$u_id){
	$r = array('status'=>"error","mess"=>"禁止定制自己的晒单!");
	echo json_encode($r); 
	exit();
}


//根据周期间计算时间
switch($cycle){
	case 1:
		$end_time = date('Y-m-d H:i:s', strtotime('+7 days'));
		break;
	case 2:
		$end_time = date('Y-m-d H:i:s', strtotime('+14 days'));
		break;	
	case 3:
		$end_time = date('Y-m-d H:i:s', strtotime('+30 days'));;
		break;		
	default:
		$end_time = date('Y-m-d H:i:s', strtotime('+7 days'));
		break;
}


//检查是否有定制
$sql ="SELECT count(*) as nums FROM follow_ticket where follow_id='".$follow_id."' and u_id='".$u_id."' and end_time>='".$create_time."' and status=1   ";		
$value = $objMySQLite->fetchOne($sql,'id');

if(!empty($value["nums"])){
	$r = array('status'=>"error","mess"=>"请不要重复定制!");
	echo json_encode($r); 
	exit();
}



 $sql ="INSERT INTO `follow_ticket` (`id`, `follow_id`, `u_id`, `u_name`, `cycle`, `multiple`, `status`, `start_time`, `end_time`, `create_time`) VALUES (NULL, '".$follow_id."', '".$u_id."', '".$u_name."', '".$cycle."', '".$multiple."', '".$status."', '".$start_time."', '".$end_time."', '".$create_time."');";
 $result = $objMySQLite->query($sql);
 

$r = array('status'=>"success");
echo json_encode($r); 	

	




