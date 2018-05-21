<?php	
include_once ("config.inc.php");
$postid = get_param('postid');
if(empty($postid)){
		$r = array('status'=>"error","code"=>2);	
}else{

	$strupdate = "update  ".tname("post_reply")." set goodnum=goodnum+1 where  id='".$postid."'  ";	
	$res = $conn->Query($strupdate);

	if($res){
		$r = array('status'=>"success");	
	}else{
		$r = array('status'=>"error","code"=>1);	
	}
}


echo json_encode($r); 	

?>
