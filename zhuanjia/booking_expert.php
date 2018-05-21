<?php
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$userInfo = Runtime::getUser();
include_once ("config.inc.php");



$return_array=array();
if(!$userInfo){
	$return_array["error"]="no_login";//未登录
	echo json_encode($return_array);
	exit();
}


$id = intval(get_param('id'));
if($id){

	$sql ="SELECT * FROM ".tname("shengqing")."   where 1  and eid='".$id."' ORDER BY sysid DESC LIMIT 0,1";			
	$query = $conn -> Query($sql);
	$value = $conn -> FetchArray($query);
	
	if(empty($value)){
		$return_array["error"]="err_value";//查不到数据	
		echo json_encode($return_array);
		exit();
	}else{
		$objUserMemberFront = new UserMemberFront();
		$tmpResult = $objUserMemberFront->getByName($value["u_name"]);
		

		//返回数据
		$return_array["error"]="Y";
		$return_array["yname"]=$userInfo["u_name"];//您的用户名
		$return_array["ename"]=$tmpResult["u_nick"];//您订阅的专家
		$return_array["single"]=$value["pmoney"];//单场推荐
		
		$return_array["week_money"]=$value["week_money"];
		$return_array["month_money"]=$value["month_money"];
		echo json_encode($return_array);
		exit();
		
	}
		
	
}else{//ID出错	
	$return_array["error"]="err_id";//提交ID出错
	echo json_encode($return_array);
	exit();
	
}






?>