TMJF(function($){
	$('table :text, table :password').focus(function(){
		$(this).css('border','2px solid #63AB00');
		$(this).css('background','#FFFDE4');
		$(this).css('padding','0px');
	});
	$('table :text, table :password').blur(function(){
		$(this).css('border','1px solid #ccc');
		$(this).css('background','#FFF');
		$(this).css('padding','1px');
	});
	var tmpDomain = TMJF.conf.domain;
	var dir_i = TMJF.conf.cdn_i;
//	var validator = new TMJF.common.Validator();
//	validator.setHandle(function(ele, msg, type){
//		$(ele).next().html('<i class="' + type + '">' + msg + '</i>');
//	});
//	validator.add('email', [
//		{v:/^.+$/, i:'请输入邮箱地址'}
//		, {v:/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/, i:'**&nbsp;邮件地址格式不正确'}
//		], '&nbsp;');
//	validator.add('true_name', [
//		{v:/^.+$/, i:'请输入用户名'}
//		, {v:/^[a-zA-Z\u4e00-\u9fa5]+$/, i:'只允许 中文、英文'} 
//		], '&nbsp;');
//	validator.add('mobile', [
//	    {v:/^.+$/, i:'请输入手机号'}
//	    , {v:/^[1]{1}[3|5|8]{1}[0-9]{9}$/, i:'手机号不正确'} 
//	    ], '&nbsp;');
//	validator.add('code', [
//	    {v:/^.+$/, i:'请输入验证码'}], '&nbsp;');	
//
//	validator.init($('#container'));
	//return_flag是用户信息是否正确的标志
	var return_flag_name  = false;
	var return_flag_mobile  = false;
	var return_flag_email  = false;
	var err_msg = '';
	$('#true_name').blur(function(){
		isNameOk();
	});
	$('#email').blur(function(){
		isEmailOk();
	});
	$('#mobile').blur(function(){
		isMobileOk();	
	});
//	$('#code').blur(function(){
//		if (isVcfCodeOk()){
//			$('#tips6').html('<i class="info">&nbsp;</i>');
//		}
//	});	
	function isNameOk() {
		var name = $('#true_name').val();
		name = name.replace(/(^\s*)|(\s*$)/g, "");
		if (name == '') { 
			$('#tips1').html('');
			 return false;	
		}
		if(name.length>20){
			err_msg = '姓名过长，';
			$('#tips1').html('**&nbsp;姓名过长');
			return false;
		}
//		var nameStyle = /^[a-zA-Z0-9_\u4e00-\u9fa5]+$/;
		var nameStyle = /<.*?>/;
	    if (nameStyle.test(name)) {
	    	err_msg = '姓名不正确，';
	       $('#tips1').html('**&nbsp;请填写正确的姓名');
	    } else {
	    	$('#true_name').val(name);
	    	$('#tips1').html('');
	    	return_flag_name = true;
		    return true;
	    }
//		$.get(
//				tmpDomain + "/activity/DCT_script/isNameOk.php?true_name="+$('#true_name').val()
//					, function (data) {
//						if (data.ok) {alert(data.msg);
//							$('#tips1').html('');
//						} else {alert(data.msg);
//							$('#tips1').html('**&nbsp;'+data.msg);
//							return_flag = false; 														
//						};
//					}			
//				, 'json'
//			);
	};
	function isMobileOk () {
		if ($('#mobile').val() == '') {
			err_msg = '手机号未填写，';
			$('#tips3').html('**&nbsp;请填写手机号');
			return  false;
		}
		$.get(
				tmpDomain + "/activity/DCT_script/getByMobile.php?mobile="+$('#mobile').val()
					, function (data) {
						if (data.ok) {
							$('#tips3').html('');
							return_flag_mobile = true;
						} else {
							err_msg = '您的手机号已使用，';
							$('#tips3').html('**&nbsp;'+data.msg);
						};
					}			
				, 'json'
			);
	};
	function isEmailOk () {
		if ($('#email').val() == '') {
			return false;
		}
	    var emailStyle = /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/; 
	    if (!emailStyle.test($('#email').val())) {
	    	err_msg = '邮箱格式不正确，';
	       $('#tips2').html('**&nbsp;请填写正确的邮箱地址');
	       return false;
	    }else{
	    	$('#tips2').html('');
	    	return_flag_email = true;
	    	return true;
	    }
	    
	};		
	function isUserInfoOk () {
		isNameOk();isMobileOk();isEmailOk();
		if (return_flag_name && return_flag_mobile && return_flag_email) {
			err_msg = '';
			return true;
		}
		return false;
	};
	$("#get_sm_code").click(function(){
		if (!isUserInfoOk ()) {
			alert(err_msg+'请填写完善正确的用户信息');
			return false;		
		}
		$.get(
				tmpDomain + "/activity/DCT_script/isVcfCodeOk.php?code="+$('#code').val() + '&vcf=' + $('#vcf').val()
					, function (data) {
						if (data.ok) {
							var _this = this;
					    	//加入时间限制，1分钟之后才能再次获取
							_this.disabled = true;
							$.post(
						                tmpDomain + "/activity/DCT_script/getShortMessageCode.php"
						                ,{  mobile:$('#mobile').val(),
						                	vcf:$('#vcf').val(),
						                	code:$('#code').val()
						                }
						                    , function (data) {
						                        if (data.ok) {
						                            //alert(data.msg);
						                            //填埋校验token
						                            $("#DCT_token").val(data.msg);
						                            alert('手机验证码将在60秒内发送到您的手机，请耐心等待。');
						                            auto_change('get_sm_code');
						                            _this.disabled = true;
						                            return true;
						                        } else {
						                        	if (data.msg == 9999) {
						                        		_this.disabled = false;
						                        		alert('手机验证码发送失败，请重新获取');
						                        		//改变状态 9999->0
						                        		setSMSstatus('get_sm_code',0,0);
						                        	} else {
						                        		alert(data.msg);
						                        	}
						                        	//_this.disabled = false;
						                            return false;                                                        
						                        }
						                    }           
						                , 'json'
						            );
							//alert(data.msg);//验证码
						} else {
							alert('您输入的图形码不正确');
							//更换验证码
							setTimeout(function () {
								$("#verify_code_img").attr("src", vfc_url+"&_r="+Math.random());
							}, 0);
							//$('#tips6').html('<i class="err">' + data.msg + '</i>');
						};
					}			
				, 'json'
			)
		
		});
		
	    $("#get_draw_code").click(function(){
	    	if (!isUserInfoOk ()) {
				alert('请填写完善正确的用户信息');
				return false;		
			}
	    	var _this = this;
	    	//防止重复点击
	    	_this.disabled = true;
	        $.post(
	                tmpDomain + "/activity/DCT_script/getDrawCode.php"
	                		,{mobile:$('#mobile').val(),
	                          sm_code:$('#sm_code').val(),
	                          DCT_token:$("#DCT_token").val(),
	                          invite_code:$("#invite_code").val(),
	                          true_name:$("#true_name").val(),
	                          email:$("#email").val()
	                          }
	                     , function (data) {
	                        if (data.ok) {
	                        	_this.disabled = false;
	                        	var dc = data.msg;
	                        	$('.blackwindow').css('height',$(document).height());
	                        	var inhtml = '恭喜，您的抽奖号是'+dc +'，相关信息已发送到您的邮箱。去邀请好友参加吧，钻戒在等着你哦~~';
	                        	$('.infortip').html(inhtml);
	                        	var total_amount = $('#total_amount').html();
	                        	total_amount = parseInt(total_amount) + 1;
	                        	$('#total_amount').html(total_amount);
	                    		$(".popup_d,#floor_d").fadeIn();
	                    		_this.disabled = false;
	                    		$.get(
	                	                tmpDomain + "/activity/DCT_script/getInviteCode.php?mobile=" + $('#mobile').val() + '&draw_code=' + dc
	                	                    , function (data) {
	                	                        if (data.ok) {
	                	                            $("#get_sm_code").disabled = true;
	                	                            $("#friend_url").val(data.msg);
	                	                            $("#share_url").val(data.msg);
	                	                            //alert(data.msg); 
	                	                        } else {
	                	                            alert(data.msg);
	                	                        };
	                	                    }           
	                	                , 'json'
	                	            );
	                            //alert(data.msg);
	                        } else {
	                        	//加入尝试次数限制，最大为3次，3次之后重新获取手机验证码
	                        	if (data.msg == 3) {
	                        		alert('抱歉，手机验证码已经失效，请再次获取手机验证码。祝您梦想成真');
	                        		$("#DCT_token").val('');$('#true_name').val('');$('#mobile').val('');$('#email').val('');$('#code').val('');
	                        		//auto_change('get_draw_code');
	                        		//改变状态3->0,尝试次数置为0
	                        		setSMSstatus('get_draw_code',0,0);
	                        		location.reload();
	                        	} else {
	                        		alert(data.msg);
	                        	}
	                        	_this.disabled = false;                                                        
	                        };
	                    }           
	                , 'json'
	            );
	        return false;
	    });
//	    $('#copy_link').click(function(){
//	    	if ($('#friend_url').val() == '') {
//	    		alert('不要玩了，赶紧参加活动吧，这样才可以有分享链接哦~~');
//	    		return false;
//	    	}
//	    	copyToClipboard($('#friend_url').val());
//	        return false;
//	    });

	    $("#guanbi,#queding,#guanbi_s,#queding_s").click(function(){
	    	$('.blackwindow').css('height',0);
			$(".popup_d, #floor_d,#floor_s").fadeOut();
			return false;
		});
	    $("#search_draw").click(function(){
	    	$.get(
	                tmpDomain + "/activity/DCT_script/searchDrawCode.php"
	                ,{  mobile_s:$('#mobile_s').val(),
	                	email_s:$('#email_s').val()
	                }
	                    , function (data) {
	                        html = data.msg; 
	                        $('#myDrawCode').html(html);
	                        $('.blackwindow').css('height',$(document).height());
	                        $(".popup_d,#floor_s").fadeIn();
	                    }           
	                , 'json'
	            );	    	
	    });
	    $("#mobile_s").click(function(){
	    	var mobile_s = $.trim($("#mobile_s").val());
	    	if (mobile_s == '参加活动的手机号码') $("#mobile_s").val('');
	    }); 
	    $("#email_s").click(function(){
	    	var email_s = $.trim($("#email_s").val());
	    	if (email_s == '参加活动的邮箱地址') $("#email_s").val('');
	    });   
	    function auto_change(id){
	    	var t = 60; //默认倒计时的秒数
	    	for(var i=t;i>=1;i--)    
	    	{
	    		(function (_i,id) {
	    			setTimeout(function (){
		    			doUpdate(_i,id);
		    		}, (t-_i) * 1000);
	    		})(i,id);
	    	}    
	    }
	    function doUpdate(num,id)    
	    {
	    	document.getElementById(id).disabled = true;
	    	document.getElementById(id).src = dir_i+'/dct/nonecode.jpg';
	    	if(num == 1) 
	    	{ 
	    		document.getElementById(id).disabled = false;
	    		document.getElementById(id).src = dir_i+'/dct/shoujiyanzheng.jpg';
	    	}    
	    }	    
	    
	    function setSMSstatus(id,status,try_time){
	    	//置手机短信状态
    		$.post(
	                tmpDomain + "/activity/DCT_script/setSMStatus.php"
	                ,{
	                	mobile:$('#mobile').val(),
	                	status:status,
	                	try_time:try_time,
	                	sm_code:$('#sm_code').val()
	                }
	                    , function (data) {
	                        if (data.ok) {
	                            //alert(data.msg); 
	                            document.getElementById(id).disabled = false;
	                            return;
	                        } else {
	                            alert(data.msg);
	                            return false;                                                        
	                        };
	                    }           
	                , 'json'
	            );
	    }
	    
	    
});
//复制按钮，兼容各种浏览器
//function copyToClipboard(txt) { 
//    if (window.clipboardData) {  
//        window.clipboardData.clearData();  
//        window.clipboardData.setData("Text",txt);  
//    } else if (navigator.userAgent.indexOf("Opera") != -1) {  
//        //do nothing        
//    } else if (window.netscape) {  
//        try {  
//            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");  
//        } catch (e) {  
//            alert("被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将 'signed.applets.codebase_principal_support'设置为'true'");  
//        }  
//        var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);  
//        if (!clip)   return;  
//        var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);  
//        if (!trans) return;  
//        trans.addDataFlavor('text/unicode');  
//        var str = new Object();  
//        var len = new Object();  
//        var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);  
//        var copytext = txt;  
//        str.data = copytext;  
//        trans.setTransferData("text/unicode", str, copytext.length * 2);  
//        var clipid = Components.interfaces.nsIClipboard;  
//        if (!clip)   return false;  
//        clip.setData(trans, null, clipid.kGlobalClipboard);  
//    }  
//    alert("复制链接成功，发送给好友吧，多得抽奖码，钻戒等你来拿哦~~");  
//}     
