<?php /* Smarty version 2.6.20, created on 2018-05-10 23:15:53
         compiled from main_index.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>数据统计</title>
<meta name="keywords" content="keywords String">
<meta name="description" content="description String">
<meta name="robots" content="all">
<meta name="author" content="author string">
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" /><meta http-equiv="refresh" content="300" />
<link href="./css/main.css" rel="stylesheet" type="text/css">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<link href="./css/font.css" rel="stylesheet" type="text/css">
<link href="./js/common.css" type="text/css" rel="stylesheet">
<SCRIPT language=javascript src="js/jquery.js"></SCRIPT>
<SCRIPT language=javascript src="js/common.js" ></SCRIPT>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<style>
.myinput {padding: 3px; border: solid 1px #C9C9C9; outline: 0; font: normal 13px/100% Verdana, Tahoma, sans-serif; width: 120px;  } 

input:hover, textarea:hover, input:focus, textarea:focus { border-color:#999999; -webkit-box-shadow: rgba(0, 0, 0, 0.15) 0px 0px 8px; } .form label { margin-left: 10px; color: #999999; } 

.submit input { width: auto; padding: 3px 5px; background: #617798; border: 0; font-size: 14px; color: #FFFFFF; -moz-border-radius: 5px; -webkit-border-radius: 5px; } 
</style>
<script>

function countjf(){

	var tmoney = parseInt($("#money").val());
	var jf = 0;
	var show_fx = 0;
	var fxzf_jf = 0;	
	var show_yuer = 0;	
	var show_totaljifen = 0;
	var beisu = 0;		
	var tips ="";
	
	if(tmoney){
	
		if(parseInt(tmoney)>=25000){
			beisu=3.5;
		}else if(parseInt(tmoney)>=20000 && parseInt(tmoney)<25000){
			beisu=3;
		}else if(parseInt(tmoney)>=15000 && parseInt(tmoney)<20000){
			beisu=2.5;
		}else if(parseInt(tmoney)>=10000 && parseInt(tmoney)<15000){	
			beisu=2;
		}else if(parseInt(tmoney)>=4500 && parseInt(tmoney)<10000){
			beisu=1.5;
		}else{
			beisu=1;
		}
		
		tips = "公式:返现金额=(("+ tmoney +"*"+beisu+")/1000)*50";
		show_totaljifen = (parseInt(tmoney)*beisu);
		fxzf_jf = parseInt((parseInt(tmoney)*beisu)/1000);
		show_fx=fxzf_jf*50;
		show_yuer = show_totaljifen - fxzf_jf*1000;
		
		$('#fanxian').val(show_fx);	
		$('#totaljifen').val(show_totaljifen);		
		$('#yuer').val(show_yuer);	
		
		$('#stips').html(tips);		
		
	}else{
		alert('请录入消费金额!');
	}
	return false;
		
}
</script>
</head>
<body style="margin:0px; padding:0px;">
<table width="100%" border="0" cellspacing="1" cellpadding="0" class="p_table">
  <tr>
    <td width="43%" class=" td_t1"><img src="./images/img1.gif" align="absmiddle" />&nbsp;&nbsp;管理后台</td>
    <td colspan="2" class=" td_t1"><a href="update_data.php" class="fc_4"></a></td>
  </tr>
  
  
 

  
  
 
  
  
 
  
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</body>
</html>