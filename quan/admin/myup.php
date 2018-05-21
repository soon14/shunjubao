<?PHP

set_time_limit(0);

include_once("config.inc.php");

if($_POST["upload_hidden"] == "1"){
//上传文件
	$file = $_FILES["uploadfilename"];
	$p_myuplodtype = trim($_POST["myuplodtype"]);//保存文件名的文本框名
	$filetype = $UPTYPE["myfiletype"];

	//$newpath = "upload/";//文件存放路径

	$oldpath = $file['tmp_name'];
	$filename=strtolower(basename($file['name']));//取上传文件的小写文件名
	$fileext=explode('.', $filename);//取后缀名
	$arraynum = count($fileext) - 1;

	$file_size = ceil(filesize($oldpath)/1024);//文件大小(K)


	if(!in_array($fileext[$arraynum], $filetype)){//检查文件类型  

		die("<script>alert('upload error!file type Error!');history.back();</script>");

	}

	if($fileext[$arraynum] == 'swf'){
		$newpath = "upload/flash/";	
	}elseif($fileext[$arraynum] == 'wav'){
		$newpath = "upload/record/";	
		
	}else{
		if($file_size>200){//检查文件大小 
			die("<script>alert('上传照片不能超过200K');history.back();</script>");
		}
		$newpath = "upload/images/".date("Y-m-d")."/";
		if (!file_exists($newpath)){
			@umask(0);
			@mkdir($newpath, 0777);
		}


	}

	$newname = time().".".$fileext[$arraynum];//新文件名

	$newpath .=  $newname;//新文件名

	

	if($myfile->cp($oldpath,$newpath,true)){

		//die("<script>parent.return_attachment_div('" .$file['name']. "','" .$newpath. "','" .$newname. "');history.back(-1);<\/script>");

		if( $fileext[$arraynum] == 'swf'){
			die("<script>parent.document.getElementById('".$p_myuplodtype."').value='"."flash/".$newname."';parent.document.getElementById('".$p_myuplodtype."_1').innerHTML='文件已成功上传！';</script>");

		}elseif( $fileext[$arraynum] == 'wav'){
			die("<script>parent.document.getElementById('".$p_myuplodtype."').value='"."record/".$newname."';parent.document.getElementById('show_result').innerHTML='文件已成功上传！';</script>");

		}else{
			die("<script>parent.document.getElementById('".$p_myuplodtype."').value='".$newpath."';parent.document.getElementById('".$p_myuplodtype."_1').innerHTML='<img src=\"".$newpath."\" width=\"100px\"/>';history.back(-1);</script>");
		}



		

	}else{

		die("upload error!");

	}

}

?>