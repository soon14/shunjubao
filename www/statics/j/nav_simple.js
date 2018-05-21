TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	var passport_root_domain = TMJF.conf.passport_root_domain;
	var www_root_domain = TMJF.conf.www_root_domain;
	var statics_base_url = TMJF.conf.cdn_i;
	
	var title = '高街';
	var login_url = passport_root_domain+'/passport/login.php?from='+location.href;
	var reg_html = '<span class="logl">|</span> 新用户<a href="'+passport_root_domain+'/passport/reg.php?refer='+location.href+'" class="log hoverC">[免费注册]</a>';
	var login_html = '  会员<a href="'+login_url+'" class="log hoverC">[登录]</a>';
	
	if(tmpDomain.match(/kaixin001/)) {
		title = '名品折扣';
		login_url = "http://api.kaixin001.com/oauth2/authorize?response_type=code&client_id=3961292710292cfd0ba3179f25e0cfa8&redirect_uri="+tmpDomain+"/passport/loginkaixin.php&scope=basic send_feed send_sysnews&display=popup&state="+encodeURIComponent(location.href);
		login_html = '  开心帐号<a href="'+login_url+'" class="log hoverC">[登录]</a>';
		reg_html = '';
	} else if(tmpDomain.match(/onlylady/)) {
		title = '名品';
	}
	
	if (TMJF.common.Passport.isLogin()) {
	    var currentUser = TMJF.common.Passport.getUserInfo();

	    var tmpHtml = '<i>欢迎您 ';
	    var accountHtml = '<a href="'+tmpDomain + '/account/show.php" target="_blank" class="hoverC">';
	    var uname = currentUser.connect_uname;
	    switch (currentUser.login_type) {
	    	case '3':
	    		tmpHtml += '';
	    		break;
	    		//sina
	    	case '2':
	    		tmpHtml += '';
	    		break;
	    		//kaixin
	    	case '4':
	    		tmpHtml += ',支付宝用户 ';
	    		break;
	    	case '5':
	    		tmpHtml += ',<img style="position:relative;top:3px;padding:0 0 0 3px;" src="'+TMJF.conf.cdn_i+'/qq.png" />';
	    		break;
	    		//qq
	    	case '6':
	    		tmpHtml += ',360用户 ';
	    		break;
	    	case '7':
	    		tmpHtml += ',百度用户 ';
	    		break;
	    	case '8':
	    		tmpHtml += ',瑞丽用户 ';
	    		break;
	    	case '9':
	    		tmpHtml += '';
	    		break;
	    		//领克特
	    	case '10':
	    		tmpHtml += ',网易用户 ';
	    		break;
	    	default:
	    		uname = currentUser.uname;
	    		tmpHtml += '';
	    }
	    tmpHtml += '<span id="nav_simple_add_vip_img"><a></a></span>' + accountHtml + uname + '</a>';
	    tmpHtml += '</i>';
	    tmpHtml += '<a href="'+passport_root_domain+'/passport/logout.php?from='+location.href+'" class="nav_exit">[退出]</a> <span>|</span> <a href="'+purchase_root_domain+'/order/orders.php" class="hoverC" target="_blank">我的账户</a> <span>|</span> ';
	    tmpHtml += '<a href="'+purchase_root_domain+'/order/orders.php?status=1000" class="hoverC" target="_blank">我的订单<b>(<span id="totalsOfNotPaid" >0</span>)</b></a>';
	} else {
	    var tmpHtml = '<a href="'+purchase_root_domain+'/cart/show.php">购物车<b>(<span id="cart_num" style="color: #96B600;">0</span>)</b></a>';
	    tmpHtml += '<span style="padding-left:3px;"><a></a></span>欢迎来到'+title+'！';
	    tmpHtml += login_html;
	    tmpHtml += reg_html;
	}
	tmpHtml += '<span class="nav_kefu">客服热线：400-0816-999</span>';
	$("#userInfo_simple").html(tmpHtml);
	//vip用户添加图片
	var nav_simple_add_vip_img = function () {
		$.common.CrossDomainAjax.post(www_root_domain+"/nav_add_vip_img.php"
				,{}
				,function(data) {
					if (data.ok) {
						$("#nav_simple_add_vip_img").html("<a href='"+www_root_domain+"/activitys/vip' target='_blank'><img src='"+statics_base_url+"/main_vip_img1.gif'></a>");
						$("#nav_simple_add_vip_img").css('padding-left','25px');
					}
				}
				, 'json'
		);
	};
	nav_simple_add_vip_img();
});