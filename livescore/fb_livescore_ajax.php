<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$conn = @mysql_connect("localhost", "root","meijun820526^&LKASI") or die("Could not connect to database");
@mysql_select_db("org_spdata", $conn) or die ("Could not select database");



$mdate = date("Y-m-d");

$sql ="SELECT * FROM fb_result_org where status not in ('Fixture','Played') and DATE_FORMAT(starttime,'%Y-%m-%d')='".$mdate."'";		

$query = mysql_query($sql,$conn);
while($value =mysql_fetch_array($query)){
	

	
	$return["m_id"]=$value["m_id"];
	
	$return["starttime"]=$value["starttime"];

	if(empty($value["half"])){
		$value["half"]="0:0";
	}
	
	$return["minute"]=$value["minute"];
	if(empty($return["minute"])){
		$return["minute"]=$value["status"];
		
	}

	$return["half"]=$value["half"];
	$return["status"]=$value["status"];
	
	$return["live_score"]=$value["full"];
	
	$return["h_rc"]=$value["h_rc"];
	$return["a_rc"]=$value["a_rc"];
	$return["h_yc"]=$value["h_yc"];
	$return["a_yc"]=$value["a_yc"];
	
	
	$live_info[] =$return;
	
	$r[]=$value;
}


//var_dump($r);

if(!empty($live_info)){
	$status="live";
}else{
	$status="none";
}


$r = array('status'=>$status,"live_info"=>$live_info);	
echo json_encode($r); exit();	




?>