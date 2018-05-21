<?php

if($_SESSION['adminid']=='') {
  echo "<script>top.location.href='index.php';</script>";
  exit();
}
$strsql = "select * from ".tname("admin")." where uid ='".$adminid."' limit 0,1";
$rs = $conn->Query($strsql);
if($conn->NumRows($rs)<1){//找不到用户
	showjsinfo("找不到用户","OLD");
	exit();
}
$row = $conn->FetchArray($rs);
if($row["iflock"]==2){
	showjsinfo("对不起，此用户已被锁定,不能登录!","OLD");
	exit();
}


$rights_array = unserialize($_SESSION['dm_rights']);
$array_right = array();

foreach($rights_array as $key=>$row){
	$array_right[] = $key;
}

?>