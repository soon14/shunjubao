<?php
/**
 * 检测帐号，并发送验证码
 */
include_once ("config.inc.php");
$u_code = trim((get_param('u_code')));

//检查手机是否存在 不存在则返回1		
$zf_uid = $_SESSION["zf_uid"];

$sql ="SELECT * FROM user_member   where 1  and u_id='".$zf_uid."' and u_code='".$u_code."' LIMIT 0,1";			
$query = $conn -> Query($sql);
$value = $conn -> FetchArray($query);
$u_id = $value["u_id"];
if(empty($u_id)){
	$status=3;
}else{
	$status=1;	
}


$r = array('status'=>$status);	
echo json_encode($r); exit();	
