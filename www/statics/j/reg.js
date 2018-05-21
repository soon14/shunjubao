TMJF(function($){
var tips1 = '';
var tips2 = '';
var tips3 = '';
var tips4 = '';
var tips5 = '';
//验证用户名
$("#u_name").blur(function(){
	//防止重复查询文件需要设置间隔时间TODO
	$.get(
			Domain + "/passport/getbyname.php"
			, {
				u_name: $('#u_name').val()
				, _r: Math.random()
			}
				, function (data) {
					if (!data.ok) {
						$("#tips1").removeClass("none");
						//正则验证
						if (!$('#u_name').val().match(/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/)) {
							$('#tips1').html("<span class=''>只允许 中文、_、a-z、0-9</span>");
							tips1 = '只允许 中文、_、a-z、A-Z、0-9';
						} else {
							$('#tips1').html("<u class=''>可以使用</u>");
							tips1 = '';
						}
						return;
					} else {
						$("#tips1").removeClass("none");
						$('#tips1').html("<span class=''>已被占用</span>");
						tips1 = '用户名已被占用，请重新输入';
						return;														
					};
				}			
			, 'json'
		);
	
});
//验证密码
var passwd = '';
$("#u_pwd").blur(function(){
	passwd = $('#u_pwd').val();
	$("#tips2").removeClass("none");
	if(!passwd)	{
		$('#tips2').html("<span class=''>请输入密码</span>");
		tips2 = '请输入密码';
	} else if(passwd.length<6) {
		$('#tips2').html("<span class=''>不能小于6位</span>");
		tips2 = '不能小于6位';
	} else {
		$('#tips2').html("<u class='' >密码可用</u>");
		tips2 = '';
	}
	
	return false;
});
var repas = '';
$("#repas").blur(function(){
	repas = $('#repas').val();
	$("#tips3").removeClass("none");
	if(repas != $('#u_pwd').val())	{
		$('#tips3').html("<span class=''>密码不一致</span>");
		tips3 = '密码不一致';
	} else {
		$('#tips3').html("<u class='' >密码可用</u>");
		tips3 = '';
	}
	
	return false;
});

//验证手机号
$("#mobile").blur(function(){
	$("#tips4").removeClass("none");
	if (!$('#mobile').val().match(/^1[3|4|5|7|8][0-9]\d{8}$/)) {
		$('#tips4').html("<span class=''>手机号格式不正确</span>");
		tips4 = '手机号格式不正确';
	} else {
		//增加判断手机号码是否存在
		
		$.get(
			Domain + "/passport/getbymobile.php"
			, {
				mobile: $('#mobile').val()
				, _r: Math.random()
			}
				, function (data) {
					if (!data.ok) {
						$("#tips4").removeClass("none");
						$('#tips4').html("<u class=''>可以使用</u>");
						tips4 = '';
						return;
					} else {
						
						$("#tips4").removeClass("none");
						$('#tips4').html("<span class=''>手机号已被注册</span>");
						tips4 = '手机号已被注册，请重新输入';
						return;														
					};
				}			
			, 'json'
		);
		
		
		
		/*$('#tips4').html("<u class=''>可以使用</u>");
		tips4 = '';*/
	}
	
	return false;
});

$("#frm_reg").submit(function(){
	if (tips1 != '') {
		alert(tips1);
		return false;
	}
	if (tips2 != '') {
		alert(tips2);
		return false;
	}
	if (tips3 != '') {
		alert(tips3);
		return false;
	}
	if (tips4 != '') {
		alert(tips4);
		return false;
	}
	if (tips5 != '') {
		alert(tips5);
		return false;
	}	
	/*var code = $('#code').val();
	if(!code){	
		$("#tips100").removeClass("none");
		$('#tips100').html("<span class=''>请输入手机验证码！</span>");
		return false;
	}*/
	return true;
});

});