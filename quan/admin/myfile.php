<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>文件上传</title>

<style type="text/css">

<!--

body {

	margin-left: 0px;

	margin-top: 0px;

	margin-right: 0px;

	margin-bottom: 0px;

}

-->

</style>

<script language="javascript">

function IsExt(url,opt){

	var sTemp;

	var b=false;

	var s=opt.toLowerCase().split("|");

	for (var i=0;i<s.length ;i++ ){

		sTemp=url.substr(url.length-s[i].length-1);

		sTemp=sTemp.toLowerCase();

		s[i]="."+s[i];

		if (s[i]==sTemp){

			b=true;

			break;

		}

	}

	return b;

}



function images_onchanges(){
var tmpmyext = location.href;
//var	myext = tmpmyext.toLowerCase().split("?");

var	myext = tmpmyext.toLowerCase().split("&");

	if(typeof(myext[1]) !="undefined"){

		if(IsExt(document.getElementById("uploadfilename").value,myext[1])){

			return true;

		}else{

			alert('请把文件转成' + myext[1] + '格式');

			return false;

		}

	}else{

		alert("请指定要上传的文件类型！");

		return false;

	}

}

</script>

</head>

<body bgcolor="#EDF6FF">

<form action="myup.php" id="form1" name="form1" onsubmit="return images_onchanges()"   enctype="multipart/form-data" method="post">

  <input name="uploadfilename" id="uploadfilename" onchange="return images_onchanges()" style="width:200px" type="file" />

  <input name="upload_hidden" type="hidden" id="upload_hidden" value="1" />

  <input id="Submit" type="submit" name="Submit" value="Upload" />

  <input name="myuplodtype" type="hidden" id="myuplodtype" value="<?PHP echo($_GET["mytype"]); ?>" />

</form>

</body>

</html>

