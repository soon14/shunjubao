<?php	
include_once ("config.inc.php");
$qid = get_param('qid');
if(empty($qid)){
		$r = array('status'=>"error","code"=>2);	
}else{

	$strupdate = "update  ".tname("post")." set goodnum=goodnum+1 where  id='".$qid."'  ";	
	$res = $conn->Query($strupdate);

	if($res){
		$r = array('status'=>"success");	
	}else{
		$r = array('status'=>"error","code"=>1);	
	}
}


echo json_encode($r); 	

?>
