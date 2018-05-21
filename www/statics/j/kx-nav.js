TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var statics_base_url = TMJF.conf.cdn_i;
	var loginurl = "http://api.kaixin001.com/oauth2/authorize?response_type=code&client_id=3961292710292cfd0ba3179f25e0cfa8&redirect_uri="+tmpDomain+"/passport/loginkaixin.php&scope=basic send_feed send_sysnews&display=popup&state="+encodeURIComponent(location.href);
	if (TMJF.common.Passport.isKaiXinLogin()) {
	    var currentUser = TMJF.common.Passport.getUserInfo();

	    var kxTmpHtml = '<a href="'+tmpDomain+'/order/orders.php">我的订单<b>(<span id="totalsOfNotPaid">0</span>)</b></a>|<a href="'+tmpDomain+'/cart/show.php?preview=1" target="_blank">购物车<b>(<span id="cart_num" style="color:#E0C21D;">0</span>)</b></a><br>';
	    kxTmpHtml += '欢迎您 <span id="nav_add_vip_img"></span><a href="http://www.kaixin001.com/home/?uid='+currentUser.connect_uid+'" target="_blank">'+currentUser.connect_uname+'</a>';
	    kxTmpHtml += '<a href="'+tmpDomain+'/passport/logout.php?from='+location.href+'&kx=1">[退出]</a>|<a class="last" href="'+tmpDomain+'/order/orders.php">我的账户</a>';

	} else {
	    var kxTmpHtml = '<a href="'+tmpDomain+'/cart/show.php">购物车(<span id="cart_num" style="color:#E0C21D;">0</span>)</a><br>';
	    kxTmpHtml += '您好，欢迎来到名品折扣！ <a href="'+loginurl+'" class="log">登录</a>|<a href="http://reg.kaixin001.com/?url='+encodeURIComponent('http://api.kaixin001.com/interface/restdirect.php?state='+location.href)+'" target="_blank" class="log">注册</a> | <a href="'+tmpDomain+'/order/orders.php">我的账户</a>';
	}

	$("#kxUserInfo").html(kxTmpHtml);


	// 获取未付款订单、购物车商品数等提示
	if (TMJF.common.Passport.isLogin()) {
		$.get(
			tmpDomain + "/getTips.php?_r="+Math.random()
			, function (data) {
				if (data.ok) {
					$("#totalsOfNotPaid").text(data.msg.totalsOfNotPaid);
					$("#cart_num").text(data.msg.cart_num);
				}
			}
			, 'json'
		);
	} else {
		$.get(
            tmpDomain + "/getTips.php?_r="+Math.random()
            , function (data) {
                if (data.ok) {
                    $("#cart_num").text(data.msg.cart_num);
                }
            }
            , 'json'
        );
	}

	/*
	$.get(
            tmpDomain + "/famous.php?_r="+Math.random()
            , function (data) {
            	if(data.ok){
            		var famous = '<span>'+data.msg.words+'</span>By <span><a href="'+data.msg.url+'">'+data.msg.name+'</a></span>';
                    $(".slogen").html(famous);
            	}

            }
            , 'json'
        );
    	*/

	//未登录用户订阅提示弹层
	var cookie_page_name = 'kaixin_scribe_sysnews_page';
	$(window).scroll(function(){
	     if(!TMJF.common.Passport.isKaiXinLogin() && TMJF.common.Cookie.get(cookie_page_name) !='0' && $(document).scrollTop()>200){
	    	 // 用于修复ie7以下浏览器不会随滚动条自动适应的问题
            if ( $.browser.msie && $.browser.version < 7 ){
                $("#kaixin_sysnews_float").css({position:'absolute'});
                $("#kaixin_sysnews_float").css('top', $(document).scrollTop());
            } else {
                $("#kaixin_sysnews_float").css('top', 0);
            }
            TMJF('#kaixin_sysnews_float').css('visibility', 'visible');
			TMJF('#kaixin_sysnews_float').show();
	     } else {
			 TMJF('#kaixin_sysnews_float').hide();
			 TMJF('#kaixin_sysnews_float').css('visibility', 'hidden');
	     }
	 });
	var cookie_page_name = 'kaixin_scribe_sysnews_page';
    var cookie_href_name = 'kaixin_scribe_sysnews_href';
    var auto_scribe_sysnews = 'auto_scribe_sysnews';

    var KaiXin_ScribeSysnews_Page = TMJF.common.Cookie.get(cookie_page_name);
    if (!TMJF.common.Passport.isKaiXinLogin() && KaiXin_ScribeSysnews_Page == null) {
        //首页登录
        TMJF.common.Cookie.set(cookie_page_name, 1, "gaojie.com");
        TMJF.common.Cookie.set(cookie_href_name, window.location.href, "gaojie.com");
    } else if (window.location.href != TMJF.common.Cookie.get(cookie_href_name) && KaiXin_ScribeSysnews_Page != '0') {
        //跳转，页面浏览次数加1
        KaiXin_ScribeSysnews_Page = parseInt(KaiXin_ScribeSysnews_Page);
        KaiXin_ScribeSysnews_Page += 1 ;
        TMJF.common.Cookie.set(cookie_page_name, KaiXin_ScribeSysnews_Page, "gaojie.com");
        TMJF.common.Cookie.set(cookie_href_name, window.location.href, "gaojie.com");
    }
    TMJF('#kaixin_popup_dy').live('click',function(){
    	TMJF.common.Cookie.set(auto_scribe_sysnews, 1, "gaojie.com");
    	window.location = loginurl;
    	return false;
    });

    TMJF('#kaixin_popup_gb').live('click',function(){
        TMJF.common.Cookie.set(cookie_page_name, '0', "gaojie.com");
        TMJF('#kaixin_sysnews_float').hide();
        TMJF('#kaixin_sysnews_float').css('visibility', 'hidden');
        return false;
    });
    //订阅提示内容
    var kaixin_content = '';
//  kaixin_content = "<div id='kaixin_auto_send'>";
//	kaixin_content += "<div class='modalDialog_kaixn_open'>";
	kaixin_content += "<div class='modalDialog_kaixn_opencent'>";
	kaixin_content += "恭喜您订阅成功，已将20元代金券（满200元可用）绑定到您的账户。<br/>";
	kaixin_content += "特卖系统消息会定时发送到您的开心系统消息。";
	kaixin_content += "</div>";
	//跳转时自动订阅系统消息
	if (TMJF.common.Cookie.get(auto_scribe_sysnews) == 1) {
		var html = '';
		$.get(
				tmpDomain + "/subscribe_kaixin_sysnews.php?_r=" + Math.random()
				, function (data) {
					if (data.ok) {
						TMJF.common.Cookie.set(auto_scribe_sysnews, 0, "gaojie.com");
						if (data.msg == 'kaixin_coupon') {
							html = kaixin_content;
						} else {
							html = '亲，您已经订阅过消息了，不用重复订阅哦~';
							html += "<br/>";
						}
						html += "<input type='submit' class='modalDialog_kaixn_sub' value='好的'/>";
						TMJF.common.MessageBox.show(html, '开心名品提示', {});
					}
				}
				, 'json'
			);
	}
	// 邮件订阅相关
	var subscribe_email_tips = "输入email,订阅最新消息";
	$("#subscribe_email").val(subscribe_email_tips);
	$("#subscribe_email").click(function () {
		if (subscribe_email_tips == $("#subscribe_email").val()) {
			$(this).val("");
		}
	});

	$("input[name='discount_email']").live('click',function () {
		var discount_email = $("input[name='discount_email']");
		if (discount_email.val() == "折扣优惠信息及时通知") {
			discount_email.val("");
		}
	});

	var firstLog = TMJF.common.Cookie.get('firstLog');
	if (firstLog != null) {
		$('.modalDialog_windows_uname').text(currentUser.connect_uname);
		var firstLoginHtml = $('.modalDialog_windows_center').html();
		$('.modalDialog_windows_center').empty();
		TMJF.common.ModalDialog.show(firstLoginHtml);
	}

	// 给首次访问开心版的用户弹出提示
	TMJF.common.Cookie.set("firstLog", '0', 'gaojie.com', -1);
	$('.subscribe_kaixin_sys').click(function(){
		var email = $("input[name='discount_email']").val();
			$.post(tmpDomain + '/subscribe_email.php'
					, {
					    email: email
					  }
					, function(data) {
					    if (data.ok || data.msg == "亲，此邮箱已订阅过了哦~") {
					    	TMJF.common.ModalDialog.hide();
					    	alert("订阅成功，20元代金券已绑定到您账号。");
					    	$.get(tmpDomain + "/subscribe_kaixin_sysnews.php?_r=" + Math.random()
								, function (data) {
								}
								, 'json'
							);
					    } else {
					    	alert(data.msg);
					    }
					}
					, 'json'
		     );
	});

	$('.modalDialog_windows h1 span a').click(function(){
		TMJF.common.ModalDialog.hide();
	});

	// 邮件系统消息相关
	$("#subscribe_kaixin_sysnews, #subscribe_kaixin_sysnews_ad").click(function () {
		var html = '';
		var tips = '';
		var options = {};
//		backover();
			$.get(
					tmpDomain + "/subscribe_kaixin_sysnews.php?_r=" + Math.random()
					, function (data) {
						if (data.ok) {
							tips = "订阅成功！";
							if (data.msg == 'kaixin_coupon') {
								html = kaixin_content;
							} else if(data.msg == '') {
								tips = '开心名品提示';
						        html = '亲，您已经订阅过消息了，不用重复订阅哦~';
						        html += '<br/>';
							}
						} else {
							$("#gotologin,.close_window,.modalDialog_kaixn_sub").live('click',function () {
								TMJF.common.Cookie.set(auto_scribe_sysnews, 1, "gaojie.com");
								window.location = loginurl;
						    });
							if (data.msg == 'login') {
								tips = '没有订阅成功  :(';
								html = '请您先登录，再订阅系统消息。';
							} else if(data.msg == 'token'){
								tips = '消息订阅';
								html = '希望每日及时收到折扣信息？需要您再次登录确认一下~';
							} else {
								tips = "订阅失败！";
								html = data.msg;
							}
							html += '<br/>';
						}

						html += "<input type='submit' class='modalDialog_kaixn_sub' value='好的'/>";
						$.common.MessageBox.show(html, tips, options);
					}
					, 'json'
				);

	});
	$(".sbtn").click(function () {
//		backover();
        var email = $.trim($("#subscribe_email").val());
        var flag = true;
        var tips = '';
        var html = "<input type='submit' class='modalDialog_kaixn_sub' id='gotologin' value='好的'/>";
        var options = {};
        if (email.length < 1) {
        	tips = "请填写您的email！";
          flag = false;
        }

        if(email == subscribe_email_tips) {
        	tips = subscribe_email_tips;
          flag =  false;
        }
        if (flag) {
	        $.post(tmpDomain + '/subscribe_email.php'
				, {
				    email: email
				  }
				, function(data) {
				    if (data.ok) {
				    	tips = '邮件订阅成功！';
				    } else {
				    	tips = data.msg;
				    }
				    $.common.MessageBox.show(html, tips, options);
				}
				, 'json'
	        );
        } else {
        	$.common.MessageBox.show(html, tips, options);
        }
    });

	$(".kx_pop_close, .close_window,.modalDialog_kaixn_sub,.kx_btn").live('click',function () {
		$.common.ModalDialog.hide();
//	    $("#backover").fadeOut();
//	    $(".kx_pop").fadeOut("fast");
	    iniPmsWin();
	    return false;
	});


//    $(".kx_btn").live('click', function () {
//        $("#backover").fadeOut();
//        $(".kx_pop").fadeOut("fast");
//        iniPmsWin();
//    });
	//系统消息绑定代金券函数，升级为开心站点自动邦券
	function _sysBindCoupon() {
		var href = window.location.href;
		//不是由系统消息带来
		if(href.match(/sys_coupon=1/) == null && href.match(/sys_coupon_olympic=1/) == null && href.match(/kaixin_seo_coupon=1/) == null) {
//			return false;
		}
		var action_key = '';
		var send_coupon = false;
		var channelid = $.common.Cookie.get("channelid");
		var tips = '恭喜，20元代金券已绑定到您的账户，可到“我的账户”进行查询，请在有效期内使用。';
		if(href.match(/sys_coupon=1/)) {
			action_key = 'sysnews_coupon';
			send_coupon = true;
		}
		if(href.match(/sys_coupon_olympic=1/)) {
			action_key = 'sysnews_coupon_olympic';
			send_coupon = true;
		}
		if(href.match(/kaixin_seo_coupon=1/)) {
			action_key = '20120815-20120817_kaixin_seo_coupon';
			send_coupon = true;
		}
		if(href.match(/kaixin_qixi_coupon=1/)) {
			action_key = '20120820-20120826_kaixin_qixi_coupon';
			send_coupon = true;
		}
		if(href.match(/sysnews_coupon_forall=1/)) {
			action_key = '20120821_sysnews_coupon';
			send_coupon = true;
		}
		if(href.match(/sys_coupon_regen=1/)) {
			action_key = 'sys_coupon_regen';
			send_coupon = true;
		}
		if(href.match(/kaixin_groupon=1/)) {
			action_key = '20120827-20120831_kaixin_groupon';
			send_coupon = true;
		}
		if(channelid == '2700013'|| channelid == '2700014') {
			action_key = '20121117-20121130_kaixin_qingxi';
			send_coupon = true;
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
					if(data.msg == 'sysnews_coupon_olympic') alert(tips);
					if(data.msg == '20120815-20120817_kaixin_seo_coupon') alert(tips);
					if(data.msg == '20120820-20120826_kaixin_qixi_coupon') alert(tips);
//					alert(data.msg);
				} else {
					//不是由系统消息带来
//					if(data.msg == 'not_sys') {
//						return false;
//					}
					//没登录的需要跳转登录
					if(data.msg == 'login') {
						if(confirm('亲，代金券领取成功，登录后即可绑定到账户哦~')) window.location.href = loginurl;
						return false;
					}
					if(data.msg == 'binded') {
//						alert('抱歉，您已领取过代金券了，不可重复领取哦~');
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

	_sysBindCoupon();

    function backover(){
    	 var modelWindow = $(".kx_pop");
         var positionTop = $(window).height() / 2 - modelWindow.height() / 2 + $(document).scrollTop();
		 positionTop = 200;
         modelWindow.css('top', positionTop);

        var _overwidth = ($(window).width() > $(document).width()) ? $(window).width() : $(document).width();
        var _overheight = ($(window).height() > $(document).height()) ? $(window).height() : $(document).height();
        $("#backover").css({ "background-color": "#000",
            "position": "absolute",
            "top": "0",
            "left": "0",
            "width": _overwidth + "px",
            "height": _overheight + "px",
            "display": "block",
            "z-index": "2800"
        }).animate({ opacity: "0.75" }, 0);
        $(".kx_tit").text('');
    	$(".kx_txt").text('');
        modelWindow.fadeIn();
		return false;

}

	//收藏本站
	$("#addbookmark").click(function () {
		title = "开心名品折扣";
		url = tmpDomain;
		try {
			window.external.addFavorite(url, title);
		} catch (e){
			try {
				window.sidebar.addPanel(title, url, '');
			} catch (e) {
				alert("请按 Ctrl+D 键添加到收藏夹");
			}
		}
	});


	//初始化页面小标签站内信
	//setTimeout(iniPmsWin,3000);
	iniPmsWin();
	function iniPmsWin(){
		//判断是否登录
		if (TMJF.common.Passport.isKaiXinLogin()) {

			$.common.CrossDomainAjax.get(tmpDomain+'/account/user_PMS.php',
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
					    }
					}
					, 'json'
		        );
		}
	}

	//点击个别站内信
	TMJF.del_one_pms = (function(pmsID){
		$.common.CrossDomainAjax.post(tmpDomain+"/account/user_PMS.php",
				  {
				    'action': 'del_one_pms',
				    'pmsId': pmsID
				  }
				, function(data) {
					if(data.msg == 't'){
						$(".ksnotice").hide();
						iniPmsWin();
					}
				}
				, 'json'
	        );

	});

	//关闭按钮
	TMJF.close_pms_win = (function(pmsIDs){
		$.common.CrossDomainAjax.post(tmpDomain+"/account/user_PMS.php",
				  {
				    'action': 'close_pms_win',
				    'pmsIds': pmsIDs
				  }
				, function(data) {
					if (data.msg == 't') {
						$(".ksnotice").hide();
						iniPmsWin();
				    }
				}
				, 'json'
	        );

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
	$(".topsearch-sub").click(function () {
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

	//vip用户初次登录是给出提示
	vipTips();
	function vipTips() {
		$.post(tmpDomain+"/vipTips.php"
				,{}
				,function(data) {
					if (data.ok) {
						var vipTisHtml = '<div class="vip_slice_center"><h1>亲爱的：&nbsp;<span class="vip_name">'+currentUser.connect_uname+'</span></h1><div class="dayinfor"">亲，正确填写您的生日信息，生日会有意外惊喜哦~<form name="date"><p>出生日期：<select class="dateYear" id="dateYear" onchange="TUpdateCal(date.dateYear.value,date.dateMonth.value)"></select>年<select class="dateMonth" id="dateMonth" onchange="TUpdateCal(date.dateYear.value,date.dateMonth.value)"></select>月<select class="dateDay"></select>日</p></form><div class="viptijiao"><input type="submit" class="vipsubmit" value=" " /></div><div class="guangguang"><a href="'+tmpDomain+'">先去逛逛&gt;&gt;</a></div></div></div>';
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

		$.post(tmpDomain+"/vip_birth_date.php"
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
		$.post(tmpDomain+"/nav_add_vip_img.php"
				,{}
				,function(data) {
					if (data.ok) {
						$("#nav_add_vip_img").html("<a href='"+tmpDomain+"/activitys/vip' target='_blank' style='margin:0px;'><img src='"+statics_base_url+"/kx_vip_img.gif'></a>");
					}
				}
				, 'json'
		);
	};
	nav_add_vip_img();
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
	
	$(".backtotop").click(function() {
		$(document).scrollTop(0);
	});
});

(function ($) {
	var kxdomain = 'buy.kaixin001.com';
	//组件不允许被单独访问，若为预览则不跳转
	if (top == this && document.location.href.match(/preview=1/) == null) {
		top.location = 'http://'+kxdomain+'/?state=' + encodeURIComponent(document.location.href);
	}
    // document ready事件
	$(function () {
		var title = $("title").first().html();
		title = encodeURIComponent(title);

		// chrome有个奇怪的现象：第一次设置iframe的src属性会生效；后于再改这个src就不生效了，奇怪。
		var src = 'http://buy.kaixin001.com/agent.php?mtitle='+title;
		var jiframe = $('<iframe src="'+src+'" scrolling="yes" height="0px" width="0px"></iframe>');
        var tmp_iframe = jiframe.appendTo(document.body);

        // 清除掉之前构造的iframe标签
        $(tmp_iframe[0]).load(function () {
        	$(this).remove();
        });
	});
}) (TMJF);
