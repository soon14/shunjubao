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
		welcome_str += "<a href=\"http://www.shunjubao.com/passport/login.php\"></a><a href=\"http://www.shunjubao.com/account/user_center.php\"></a>&nbsp;&nbsp;&nbsp;<a href=\"http://www.shunjubao.com/\">返回主页</a></h1>";
	} else {
		welcome_str += "<a href=\"http://www.shunjubao.com/passport/login.php\">登录</a></h1>";
}
document.writeln(
"<div class=\"top\">"+
"<div class=\"logo\"><h4><a href=\"/\">智赢圈子</a></h4></div>"+
"  <div class=\"topCenter\">"+
"    <h1>"+ welcome_str +
"  </div>"+
"</div>");