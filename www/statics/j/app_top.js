var u_name = '';var cash = 0.00;
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
		welcome_str += "<b><a href=\"http://app.shunjubao.xyz/passport/login.php\"> " + u_name + "</a>&nbsp;&nbsp;<em><a href=\"http://app.shunjubao.xyz/account/user_center.php\">我的账户</a></em>&nbsp;&nbsp;<a href=\"http://app.shunjubao.xyz/passport/logout.php\">退出</a></b></h1>";
	} else {
		welcome_str += "<b><em><a href=\"http://app.shunjubao.xyz/passport/login.php\">登录</a><span></span><a href=\"http://app.shunjubao.xyz/passport/reg.php\">注册</a></em></b></h1>";
}
document.writeln(
"<div class=\"top\">"+
"<div class=\"logo\"><h1><b>智赢网</b><span>才智聚宝，财富人生</span></h1></div>"+
"  <div class=\"topCenter\">"+
"    <h1>"+ welcome_str +
"  </div>"+
"</div>");