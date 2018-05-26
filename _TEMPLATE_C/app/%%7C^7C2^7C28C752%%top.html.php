<?php /* Smarty version 2.6.17, created on 2016-02-18 18:12:18
         compiled from top.html */ ?>
<script type="text/javascript">
var TMJF = jQuery.noConflict();
TMJF(function($) {
	var u_name = '';
	var cash = 0.00;
	var arrCookie = document.cookie.split(/;\s*/);  
	for(var i=0;i<arrCookie.length;i++){
		var arr = arrCookie[i].split("=");
		if("u_name" == arr[0]){
			u_name = decodeURIComponent(arr[1]); 
		}
		if("cash" == arr[0]){
			cash = arr[1];
		}
	}
	var welcome_str = "&nbsp;";
	if (u_name != '') {
		welcome_str += "<b><a href=\"<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php\"> " + u_name + "</a><em><a href=\"<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php\">我的账户</a></em><a href=\"<?php echo @ROOT_DOMAIN; ?>
/passport/logout.php\">退出</a></b></h1>";
	} else {
		welcome_str += "<b><em><a href=\"<?php echo @ROOT_DOMAIN; ?>
/passport/login.php\">登录</a><span></span><a href=\"<?php echo @ROOT_DOMAIN; ?>
/passport/reg.php\">注册</a></em></b></h1>";
	}
	$(".topCenter").find("h1").eq(0).html(welcome_str);
	
	$(".accoutList").hover(function(){
		$(this).find("p").show();
	},function(){
		$(this).find("p").hide();
	});
	$(".nav li").hover(function(){
		$(this).find("span").show();
	},function(){
		$(this).find("span").hide();
	});
});
var $ = jQuery.noConflict(true);
</script>
<div class="top">
  <div class="logo">
    <h1><b><a href="javascript:history.go(-1)">&lt;&nbsp;<span>返回</span></a></b></h1>
  </div>
  <div class="topCenter">
    <h1></h1>
  </div>
  <div class="clear"></div>
</div>