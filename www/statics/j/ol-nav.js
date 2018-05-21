TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var purchase_root_domain = TMJF.conf.purchase_root_domain;
	var passport_root_domain = TMJF.conf.passport_root_domain;
	if (TMJF.common.Passport.isLogin()) {
	    var currentUser = TMJF.common.Passport.getUserInfo();
	
	    var tmpHtml = '';
        tmpHtml += '<i>欢迎您 '+currentUser.uname+' </i>';
	    tmpHtml += '<a href="'+passport_root_domain+'/passport/logout.php?from='+location.href+'">[退出]</a> <span>|</span> <a href="'+purchase_root_domain+'/order/orders.php" class="last">我的账户</a>';
        tmpHtml += '<a href="'+purchase_root_domain+'/order/orders.php?status=1000">我的订单<b>(<span id="totalsOfNotPaid" style="color: #96B600;">0</span>)</b></a> <span>|</span> <a href="'+purchase_root_domain+'/cart/show.php">购物车<b>(<span id="cart_num" style="color: #96B600;">0</span>)</b></a>';

	} else {
	    var tmpHtml = '<a href="'+purchase_root_domain+'/cart/show.php">购物车<b>(<span id="cart_num" style="color: #96B600;">0</span>)</b></a>';
	    tmpHtml += '欢迎来到名品！ <span class="logl">|</span> 会员<a href="'+passport_root_domain+'/passport/login.php?from='+location.href+'" class="log">[登录]</a> <span class="logl">|</span> 新用户<a href="'+passport_root_domain+'/passport/reg.php?refer='+location.href+'" class="log">[免费注册]</a>';
	}

	$("#olUserInfo").html(tmpHtml);

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
	// 邮件订阅相关
	var subscribe_email_tips = "输入email,订阅最新消息";
	$("#subscribe_email").val(subscribe_email_tips);
	$("#subscribe_email").click(function () {
		if (subscribe_email_tips == $("#subscribe_email").val()) {
			$(this).val("");
		}
	});
  
	$(".sbtn").click(function () {
        var email = $.trim($("#subscribe_email").val());
        var flag = true;
        var tips = '';
        var html = "<input type='submit' class='modalDialog_ol_ok' id='gotologin' value='好的'/>";
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
	
	$(".modalDialog_ol_ok").live('click',function () {
		$.common.ModalDialog.hide();
//	    iniPmsWin();
	    return false;
	});

	//收藏本站
	$("#addbookmark").click(function () {
		title = "开心名品特卖";
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
		if (TMJF.common.Passport.isLogin()) {
			
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
	var oldomain = 'mall.onlylady.com';
	//组件不允许被单独访问
	if (top == this && document.location.href.match(/preview=1/) == null) {
		top.location = 'http://'+oldomain+'/?state=' + encodeURIComponent(document.location.href);
	}
    // document ready事件
	$(function () {
		var title = $("title").first().html();
		title = encodeURIComponent(title);
		
		// chrome有个奇怪的现象：第一次设置iframe的src属性会生效；后于再改这个src就不生效了，奇怪。
		var src = 'http://'+oldomain+'/agent.php?mtitle='+title;
		var jiframe = $('<iframe src="'+src+'" scrolling="yes" height="0px" width="0px"></iframe>');
        var tmp_iframe = jiframe.appendTo(document.body);
        
        // 清除掉之前构造的iframe标签
        $(tmp_iframe[0]).load(function () {
        	$(this).remove();
        });
	});
}) (TMJF);