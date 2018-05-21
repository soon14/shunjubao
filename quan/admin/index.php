<?php
include("config.inc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$shop_title?></title>
<link href="images/main.css" rel="stylesheet" type="text/css" />

<style type="text/css">
#lbg {
	background-color: #035b84;
}
#loginbox {
	background-image: url(images/login_bg.jpg);
	background-repeat: no-repeat;
	height: 340px;
	width: 465px;
	margin-right: auto;
	margin-left: auto;
	margin-top: 150px;
}
#loginbox .user {
	color: #FFF;
	padding-top: 85px;
	padding-left: 80px;
	overflow: hidden;
	width: 385px;
}
.user li {
	line-height: 26px;
	height: 26px;
	margin-top: 5px;
}
.user li span {
	float: left;
	width: 50px;
}
.user li .u_name,.user li .u_password,.user li .code{
	vertical-align:  middle;
	line-height: 16px;
	padding: 3px;
	border: 1px solid #026b9d;
	width: 160px;
	float: left;
	color:#035b84
}
.user li img {
	float: left;
	display: inline;
	margin-top: 1px;
	margin-left: 4px;
}
.user li .code{ width:80px}
.user li.cbtn{ margin-top:10px}
.user li .submit,.user li .reset {
	background: transparent  no-repeat;
	height: 25px;
	width: 73px;
	text-indent:-999px;
	overflow:hidden;
	border:0;
	cursor:pointer;
	vertical-align:middle;
	float:left;
	display:inline
}
.user li .submit{background: url(images/login_btn.gif)}
.user li .reset{background: url(images/reset_btn.gif); margin-left:10px}	
</style>

<Script Language=JavaScript>
	
	// 表单提交客户端检测
	function doSubmit(){
		if (document.myform.username.value==""){
			alert("用户名不能为空！");
			document.myform.username.focus();
			return false;
		}
		if (document.myform.password.value==""){
			alert("密码不能为空！");
			document.myform.password.focus();
			return false;
		}
//		if (document.myform.CheckCode.value==""){
//			alert("验证码不能为空！");
//			document.myform.CheckCode.focus();
//			return false;
//		}
		document.myform.submit();
	}
	
	function reflash_image(){
		var el = document.getElementById("code_img");
		el.src="./include/captcha.php";
	}
	</Script>
</head>

<body id="lbg">
<div id="loginbox">
<form action="loginaction.php" method="post" name="myform">
<ul class="user">
<li><span>用户名：</span><input class="u_name" name="username" id="username" type="text" /></li>
<li><span>密&nbsp;&nbsp;&nbsp;&nbsp;码：</span><input class="u_password" name="password" id="password" type="password" /></li>
<li><span>验证码：</span><input class="code" name="CheckCode" id="CheckCode" type="text" /><img id="code_img" src="./include/captcha.php?a=Math.random()" onClick="reflash_image();"  style="cursor:pointer"> <input name="login" type="hidden" id="login" value="yes"></li>
  <li class="cbtn"><span>&nbsp;</span><input name="" class="submit" type="submit" /><input class="reset" name="" type="reset" /> </li>
</ul>
</form>
</div>
</body>
</html>
