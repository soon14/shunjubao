<?php	
	include("config.inc.php");	
	$id = get_param('id');
	$orderby_value = get_param('orderby_value');

	
	if($id>0){
		$sql ="update  ".tname("post")." set orderby ='".$orderby_value."' WHERE id='".$id."' ";
		$query = $conn -> Query($sql);
		
		
	
		$r = array('status'=>"success");	
	}else{
		$r = array('status'=>"error");	
	}

	
	
	
	echo json_encode($r); 	

?>
