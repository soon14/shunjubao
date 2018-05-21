TMJF(function($){
	var www_root_domain = TMJF.conf.www_root_domain;
	$("input[name=email]").val("");
//	$("input[name=mobile]").val("");
	$("input[name=email]").blur(function(){
		if ( $(this).val() == '') {
			$(".email_str").html("");
			$(".hidden").hide();
			return false;
		} else {
			var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
			if(!reg.test($(this)[0].value)){
				$(".email_str").html("**邮箱格式有误");
				$(".hidden").show();
			} else {
				$(".email_str").html("");
				$(".hidden").hide();
			}
		}
	});	
/*
	$("input[name=mobile]").blur(function(){
		if ( $(this).val() == '') {
			$(".mobile_str").html("");
			return false;
		} else {
			var reg = /^[1]{1}[3|5|8]{1}[0-9]{9}$/;
			if (!reg.test($(this)[0].value)){
				$(".mobile_str").html("**输入手机号有误");
			} else {
				$(".mobile_str").html("");
			}
		}
	});
*/
	$(".buying-sub").click(function(){
		if ( $(".email_str").html() != "" ) {
			return false;
		}
		if ( $("input[name=email]").val() == "" ) {
			$(".email_str").html("**邮箱格式有误");
			$(".hidden").show();
			return false;
		}
		var email = $("input[name=email]").val();
		$.post(www_root_domain+'/subscribe_email.php' ,
				{email: email},
				function(data) { 
					if (data.ok) {
						var html = $(".modalDialog_body_notice").html();
						$.common.MessageBox.show(html, '邮件订阅成功！');
                    } else {
                        alert(data.msg);
                    }
                }
                , 'json'
        );

	});
});