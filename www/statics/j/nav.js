TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	var passport_root_domain = TMJF.conf.passport_root_domain;
	var www_root_domain = TMJF.conf.www_root_domain;
	var statics_base_url = TMJF.conf.cdn_i;
	if (TMJF.common.Passport.isLogin()) {
	    var currentUser = TMJF.common.Passport.getUserInfo();

	    var tmpHtml = '<a href="'+purchase_root_domain+'/order/orders.php?status=1000">我的订单<b>(<span id="totalsOfNotPaid" style="color: #96B600;">0</span>)</b></a> <span>|</span> <a href="'+purchase_root_domain+'/cart/show.php">购物车<b>(<span id="cart_num" style="color: #96B600;">0</span>)</b></a><br />';
	    switch (currentUser.login_type) {
	    	case '3':
	    		tmpHtml += '<i>欢迎您 <span id="nav_add_vip_img"></span><a href="http://www.kaixin001.com/home/?uid='+currentUser.connect_uid+'" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '2':
	    		tmpHtml += '<i>欢迎您 <span id="nav_add_vip_img"></span><a href="http://weibo.com/'+currentUser.connect_uid+'" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '4':
	    		tmpHtml += '<i>欢迎您,支付宝用户 <span id="nav_add_vip_img"></span><a href="http://www.alipay.com" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '5':
	    		tmpHtml += '<i>欢迎您,<img style="position:relative;top:3px;padding:0 0 0 3px;" src="'+TMJF.conf.cdn_i+'/qq.png" /><span id="nav_add_vip_img"></span>'+currentUser.connect_uname+' </i>';
	    		break;
	    	case '6':
	    		tmpHtml += '<i>欢迎您,360用户 <span id="nav_add_vip_img"></span><a href="http://www.360.cn/" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '7':
	    		tmpHtml += '<i>欢迎您,百度用户 <span id="nav_add_vip_img"></span><a href="http://www.baidu.com" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '8':
	    		tmpHtml += '<i>欢迎您,瑞丽用户 <span id="nav_add_vip_img"></span><a href="http://www.rayli.com.cn/" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	case '9':
	    		tmpHtml += '<i>欢迎您 <span id="nav_add_vip_img"></span>'+currentUser.connect_uname+' </i>';
	    		break;
	    	case '10':
	    		tmpHtml += '<i>欢迎您,网易用户 <span id="nav_add_vip_img"></span><a href="http://www.163.com/" target="_blank">'+currentUser.connect_uname+'</a> </i>';
	    		break;
	    	default:
	    		tmpHtml += '<i>欢迎您 <span id="nav_add_vip_img"></span>'+currentUser.uname+' </i>';
	    }
	    tmpHtml += '<a href="'+passport_root_domain+'/passport/logout.php?from='+location.href+'">[退出]</a> <span>|</span> <a href="'+purchase_root_domain+'/order/orders.php" class="last">我的账户</a>';

	} else {
	    var tmpHtml = '<a href="'+purchase_root_domain+'/cart/show.php">购物车<b>(<span id="cart_num" style="color: #96B600;">0</span>)</b></a><br />';
	    tmpHtml += '欢迎来到高街！ <span class="logl">|</span> 会员<a href="'+passport_root_domain+'/passport/login.php?from='+location.href+'" class="log">[登录]</a> <span class="logl">|</span> 新用户<a href="'+passport_root_domain+'/passport/reg.php?refer='+location.href+'" class="log">[免费注册]</a>';
	}

	$("#userInfo").html(tmpHtml);

	// 获取未付款订单、购物车商品数等提示
	if (TMJF.common.Passport.isLogin()) {
		$.common.CrossDomainAjax.get(
			www_root_domain + "/getTips.php?_r="+Math.random()
			, function (data) {
				if (data.ok) {
					$("#totalsOfNotPaid").text(data.msg.totalsOfNotPaid);
					$("#cart_num").text(data.msg.cart_num);
				}
			}
		);
	} else {
		$.common.CrossDomainAjax.get(
			www_root_domain + "/getTips.php?_r="+Math.random()
            , function (data) {
                if (data.ok) {
                    $("#cart_num").text(data.msg.cart_num);
                }
            }
            , 'json'
        );
	}
	/*
	$.common.CrossDomainAjax.get(
            www_root_domain + "/famous.php?_r="+Math.random()
            , function (data) {
            	if(data.ok){
            		var famous = '<span>'+data.msg.words+'</span>By <span><a href="'+data.msg.url+'">'+data.msg.name+'</a></span>';
                    $(".slogen").html(famous);
            	}

            }
            , 'json'
        );
    	*/
	// 邮件订阅相关
	var subscribe_email_tips = "输入email,订独家打折消息";
	$("#sinput,#sinput_t,#effortTxt").val(subscribe_email_tips);
	$("#subscribe_email").click(function () {
		var email = $.trim($("#sinput").val());
		submit_subcribe(email);
		return false;
	});
	$("#sinput").click(function () {
		if (subscribe_email_tips == $("#sinput").val()) {
			$("#sinput").val("");
		}
	});
	$("#subscribe_email_t").click(function () {
		var email = $.trim($("#sinput_t").val());
		submit_subcribe(email);
		return false;
	});
	$("#effortTxt").click(function () {
		if (subscribe_email_tips == $("#effortTxt").val()) {
			$("#effortTxt").val("");
		}
	});
	$("#effortSub").click(function () {
		var email = $.trim($("#effortTxt").val());
		submit_subcribe(email);
		return false;
	});
	$("#sinput").click(function () {
		if (subscribe_email_tips == $("#sinput").val()) {
			$("#sinput").val("");
		}
	});
	var search_default = "输入您要找的商品";
	$("#search_default").click(function () {
		if (search_default == $("#search_default").val()) {
			$("#search_default").val("");
		}
	});
	$("#search_default").keydown(function (e) {
		if(e.keyCode==13){
			var searchUrl = tmpDomain + '/search/';
			var keyWord = $("input[name=keyWord]").val();

			if (keyWord == '') {
				$("#search_default").val(search_default);
				return false;
			}
			if (keyWord == search_default) {
				return false;
			}
			window.location.href = searchUrl+encodeURIComponent(keyWord)+"?record=1";
		}
	});
	$(".search-sub").click(function () {
		var searchUrl = tmpDomain + '/search/';
		var keyWord = $("input[name=keyWord]").val();

		if (keyWord == '') {
			$("#search_default").val(search_default);
			return false;
		}
		if (keyWord == search_default) {
			return false;
		}
		window.location.href = searchUrl+encodeURIComponent(keyWord)+"?record=1";
	});

	function submit_subcribe (email){
		if (email.length < 1) {
			alert("请填写您的email");
			return false;
		}
		if (email == subscribe_email_tips) {
			alert(subscribe_email_tips);
			return false;
		}
		$.common.CrossDomainAjax.post(www_root_domain + '/subscribe_email.php'
			, {
			    email: email
			  }
			, function(data) {
			    if (data.ok) {
			        alert("邮件订阅成功");
			    } else {
			        alert(data.msg);
			    }
			}
			, 'json'
        );
	}

	$.common.CrossDomainAjax.get(www_root_domain+'/global_for_browser_visit.php'
		, function(data) {
			iniPmsWin();
		}
		, 'json'
	);

	//初始化页面小标签站内信
	//setTimeout(iniPmsWin,3000);
	iniPmsWin();
	function iniPmsWin(){
		//判断是否登录
		if (TMJF.common.Passport.isLogin()) {

			$.common.CrossDomainAjax.get(www_root_domain+'/account/user_PMS.php',
					  {
					    'action': 'show_pms'
					  }
					, function(data) {
						if (data.ok) {
							var pms_data = data.msg.pms_data.split('@@');
							var txt = "<p onclick ='TMJF.close_pms_win(\""+data.msg.idstr+"\");'><a href='#' class='ksnotice_close'></a></p>" +
					    			"<div class='ksnotice_em' ></div><ol>";
					    	for (var i=0 ;i<pms_data.length-1 ;i++){

					    		var pms_data_one = pms_data[i].split('|');

					    		txt = txt + "<li><b title='"+pms_data_one[1]+"' onclick ='TMJF.del_one_pms("+pms_data_one[0]+");'>"+pms_data_one[1]+"</b>";

					    		if(pms_data_one[2] != '' && pms_data_one[2] != undefined){
					    			txt = txt +"<span><a href='"+pms_data_one[2]+"' id='"+pms_data_one[0]+"' onclick ='TMJF.del_one_pms("+pms_data_one[0]+");' target='_blank'>查看详细&gt;&gt;</a></span> ";
					    		}
					    		txt = txt + '</li>';
					    	}
					    	txt = txt + '</ol>';
					    	$(".ksnotice").html(txt);
							$(".ksnotice").show();
							$(".nav-search").hide();
					    }
					}
					, 'json'
		        );
		}
	}

	//点击个别站内信
	TMJF.del_one_pms = (function(pmsID){
		$.common.CrossDomainAjax.post(www_root_domain+"/account/user_PMS.php",
				  {
				    'action': 'del_one_pms',
				    'pmsId': pmsID
				  }
				, function(data) {
					if(data.msg == 't'){
						$(".ksnotice").hide();
						iniPmsWin();
						$(".nav-search").show();
					}
				}
				, 'json'
	        );

	});

	//关闭按钮
	TMJF.close_pms_win = (function(pmsIDs){
		$.common.CrossDomainAjax.post(www_root_domain+"/account/user_PMS.php",
				  {
				    'action': 'close_pms_win',
				    'pmsIds': pmsIDs
				  }
				, function(data) {
					if (data.msg == 't') {
						$(".ksnotice").hide();
						iniPmsWin();
						$(".nav-search").show();
				    }
				}
				, 'json'
	        );

	});

	// QQ彩贝联合登录提示语
	var qq_cb_msg = TMJF.common.Cookie.get('qq_cb_msg');
	if ( TMJF.common.Passport.isLogin() && qq_cb_msg ) {
		var qq_cb_array = eval('('+qq_cb_msg+')');
		var topHtml = "<div class='hd_information'><div class='hd_lf'>QQ彩贝联盟商家：高街-QQ会员购物成功最高返8.1%彩贝积分，普通用户最高返5.4%彩贝积分<a href='http://fanli.qq.com/gaojie/' target='_blank'>(详情)</a></div><div class='hd_rig'><span>" + qq_cb_array.cb_showmsg + "</span>|<a href='http://cb.qq.com/my/my_jifen_source.html' target='_blank'>我的彩贝积分</a></div></div>";
		$(".head_top").html(topHtml);
	}

	//自动邦券
	function _autoBindCoupon() {
		var href = window.location.href;
		var loginurl = www_root_domain + '/passport/login.php?from=' + encodeURIComponent(href);
		var action_key = '';
		var send_coupon = false;
		var tips = '恭喜，20元代金券已绑定到您的账户，可到“我的账户”进行查询，请在有效期内使用。';
		if(href.match(/wasai_ad_coupon=1/)) {
			action_key = '20120821-20120831_wasai_ad_coupon';
			send_coupon = true;
		}
		var reg = false;//是否注册页面
		if(href.match(/reg.php/)) {
			reg = true;
		}
		//不是由特定渠道来的不发券
		if(!send_coupon) return false;
		$.post(tmpDomain+"/activity/sysnews_send_coupon.php"
			,{href:href,
			action_key:action_key
		}
			, function(data) {
				if (data.ok) {
					iniPmsWin();
					if(data.msg == '20120821-20120831_wasai_ad_coupon') alert(tips);
//					alert(data.msg);
				} else {
					//没登录的需要跳转登录
					if(data.msg == 'login' && !reg) {
						if(confirm('亲，代金券领取成功，登录后即可绑定到账户哦~')) window.location.href = loginurl;
						return false;
					}
					if(data.msg == 'binded') {
						alert('抱歉，您已领取过代金券了，不可重复领取哦~');
						return false;
					}
					//其他失败的情况
//					alert(data.msg);
					return false;
				}
			}
				, 'json'
		);
	}

	_autoBindCoupon();
	
	//推广渠道登录自动发券，没登录则发站短
	function _autoBindCouponByChannelid() {
		var channelid = $.common.Cookie.get("channelid");
		//没有渠道的不理会
		if (!$.common.Verify.isInt(channelid)) {
			return false;
		}
		$.post(tmpDomain+"/activity/login_gencoupon_channelid.php"
				,{}
				, function(data) {
					if (data.ok) {
						iniPmsWin();
					} else {
						if(data.msg == 'binded') {
							return false;
						}
						if(data.msg == 'channelid') {
							return false;//非指定渠道	
						}
						if(data.msg == 'login') {
							var txt = "<p><a href='#' class='ksnotice_close' style=''></a></p><div class='ksnotice_em' ></div><ol>";
							txt += "<li><span style='color:red;font-weight:600;'>";
							txt += "登录即有机会获得【10元代金券】";
							txt += '</span>';
							txt += '</li></ol>';
					    	$(".ksnotice").html(txt);
							$(".ksnotice").show();
							$(".nav-search").hide();
							return false;
						}
						return false;
					}
				}
					, 'json'
		);
	}
	
	_autoBindCouponByChannelid();
	$(".ksnotice_close").live('click',function() {
		$(".ksnotice").hide();
		$(".nav-search").show();
	});
	//vip用户初次登录是给出提示
	vipTips();
	function vipTips() {
		$.common.CrossDomainAjax.post(www_root_domain+"/vipTips.php"
				,{}
				,function(data) {
					if (data.ok) {
						var uname = currentUser.uname ? currentUser.uname : currentUser.connect_uname;
						var vipTisHtml = '<div class="vip_slice_center"><h1>亲爱的：&nbsp;<span class="vip_name">'+uname+'</span></h1><div class="dayinfor"">亲，正确填写您的生日信息，生日会有意外惊喜哦~<form name="date"><p>出生日期：<select class="dateYear" id="dateYear" onchange="TUpdateCal(date.dateYear.value,date.dateMonth.value)"></select>年<select class="dateMonth" id="dateMonth" onchange="TUpdateCal(date.dateYear.value,date.dateMonth.value)"></select>月<select class="dateDay"></select>日</p></form><div class="viptijiao"><input type="submit" class="vipsubmit" value=" " /></div><div class="guangguang"><a href="'+www_root_domain+'">先去逛逛&gt;&gt;</a></div></div></div>';
						TMJF.common.ModalDialog.show(vipTisHtml);
						vip_date_liandong();
					}
				}
				, 'json'
		);
	}

	//vip 出生日期提交
	$(".vipsubmit").live('click', function(){
		var dateYear = $(".dateYear").val();
		var dateMonth = $(".dateMonth").val();
		var dateDay = $(".dateDay").val();
		if (dateYear == "" || dateMonth == "" || dateDay == "") {
			alert("请正确填写您的生日信息，生日会有意外惊喜哦~");
			return false;
		}
		$tmpResult = confirm("亲，生日信息提交后就不能修改了，您确定您提交的生日信息是： "+dateYear+"-"+dateMonth+"-"+dateDay+" 吗？");
		if(!$tmpResult) {
			return false;
		}

		$.post(www_root_domain+"/vip_birth_date.php"
				,{
					year : dateYear
					,month : dateMonth
					,day : dateDay
				}
				,function(data) {
					TMJF.common.ModalDialog.hide();
					alert("谢谢亲对我们的支持，开始超值购物吧，祝亲心情愉快~~");
				}
				, 'json'
		);
	});

	var nav_add_vip_img = function () {
		$.common.CrossDomainAjax.post(www_root_domain+"/nav_add_vip_img.php"
				,{}
				,function(data) {
					if (data.ok) {
						$("#nav_add_vip_img").html("<a href='"+www_root_domain+"/activitys/vip' target='_blank'><img src='"+statics_base_url+"/main_vip_img.gif'></a>");
					}
				}
				, 'json'
		);
	};
	nav_add_vip_img();
	
	$(".backtotop").click(function() {
		$(document).scrollTop(0);
	});
});