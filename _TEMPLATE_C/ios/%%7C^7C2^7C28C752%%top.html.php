<?php /* Smarty version 2.6.17, created on 2016-04-06 15:51:17
         compiled from top.html */ ?>
<script type="text/javascript">
var TMJF = jQuery.noConflict();
TMJF(function($) {
	var u_name = '';
	var cash = 0.00;
	var arrCookie = document.cookie.split(/;\s*/); 
	//遍历cookie数组，处理每个cookie对 
	for(var i=0;i<arrCookie.length;i++){
		var arr = arrCookie[i].split("=");
		//找到名称为userId的cookie，并返回它的值
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
/account/user_center.php\"> " + u_name + "</a>&nbsp;&nbsp;<em><a href=\"<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php\">我的账户</a></em>&nbsp;&nbsp;<a href=\"<?php echo @ROOT_DOMAIN; ?>
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
<div id="fade" class="black_overlay"></div>
<div class="top">
  <div class="logo">
    <h1><b>智赢网</b><span>智取人生</span></h1>
  </div>
  <div class="topCenter">
    <h1></h1>
  </div>
  <div class="clear"></div>
</div>