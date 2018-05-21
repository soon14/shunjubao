$(document).ready(function(){
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
	}
	var welcome_str = "";
	if (u_name != '') {
		welcome_str += "<a href=\"http://shop.zhiying365365.com/person/\">"+u_name+"</a></li>";
		welcome_str +=",欢迎登录智赢商城<a href=\"http://shop.zhiying365365.com\" target=\"_top\" class=\"h\">个人中心</a> <a href=\"http://www.shunjubao.com/passport/logout.php\">退出</a>";
	} else {
		welcome_str += "<a href=\"http://www.shunjubao.com/passport/login.php\" target=\"_top\" class=\"h\">亲，请登录</a> <a href=\"http://www.shunjubao.com/shop/home/register.html\" target=\"_top\">免费注册</a>";
	}
	$("#topMessage").append(welcome_str);
});


document.writeln("<div class=\"topMessage\"><div class=\"menu-hd\" id=\"topMessage\">  </div></div>");
