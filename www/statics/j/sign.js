TMJF(function($){
	$('table input[type="text"], table input[type="password"]').focus(function(){
		$(this).css('border','1px solid #63AB00');
		$(this).css('background','#FFFDE4');
		var name = $(this).attr('name');
		$('font[class="com '+name+'"]').show();
	});
	$('table input[type="text"], table input[type="password"]').blur(function(){
		$(this).css('border','1px solid #ccc');
		$(this).css('background','#fff');
		var name = $(this).attr('name');
		$('font[class="com '+name+'"]').hide();
	});
	
	var tmpDomain = TMJF.conf.domain;
	var validator = new TMJF.common.Validator();
	validator.setHandle(function(ele, msg, type){
		$(ele).next().html('<i class="' + type + '">' + msg + '</i>');
	});
	validator.add('email', [
		{v:/^.+$/, i:'请输入邮箱地址'}
		, {v:/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/, i:'邮件地址格式不正确'}
		], '&nbsp;');
	validator.add('name', [
		{v:/^.+$/, i:'请输入用户名'}
		, {v:/^[a-zA-Z0-9_\u4e00-\u9fa5]+$/, i:'只允许 中文、_、a-z、A-Z、0-9'} 
		], '&nbsp;');
	validator.add('newpas', [
		{v:/^.+$/, i:'请输入密码'}
		], '&nbsp;', $('#repas')[0]);
	validator.add('newpas', [
		{v:function(input){
		    var passwd = $('#newpas').val();
		    if(!passwd)	{
		    	validator.showErr(input,'请输入密码');
		    	return false;		    	
		    }
		    if(passwd.length<6){
		    validator.showErr(input,'密码长度不能小于6位');
		    	return false;
		    }else{
		    validator.showInfo(input, '&nbsp;');
		        return true;
		    }
		  }}]);
	validator.add('repas', [
		{v:function(input){
			var passwd = $('#newpas').val();
			if(!input.value && !passwd)	return;
			if(input.value != passwd)
			{				
				validator.showErr(input, '密码不一致');
				return false;
			}else{
				validator.showInfo(input, '&nbsp;');
				return true;
			}
		}}]);

	validator.add('code', [
		{v:/^.+$/, i:'请输入验证码'}], '&nbsp;');
	validator.init($('#frm_reg'));
	
	var is_name_ok = false;
	var prev_name = '';
	
	$('#name').blur(function(){
		if ($("#name").val() != prev_name) {
			is_name_ok = false;
			prev_name = $("#name").val(); 
		}
		if (is_name_ok){		
			$('#tips2').html('<i class="info">&nbsp;</i>');
		}else{			
			isnameused();		          						
		}
	});
	function sumStr(str)
	{
		var sum=0;
		var i;
		for(i=0;i<str.length;i++)
		{
			if(str.charCodeAt(i)>=0 && str.charCodeAt(i)<=255)
			{
				sum = sum+1;
			}
			else
			{
				sum = sum+2;
			}
		}
		return sum;
	}
	function isnameused ( cb ) {
		if ($('#u_name').val() == '') {
			return false;
		}
		
		$.get(
				tmpDomain + "/passport/getbyname.php"
				, {
					name: $('#u_name').val()
					, _r: Math.random()
				}
					, function (data) {
						if (data.ok) {	
							is_name_ok = true;
							if ($.isFunction(cb)) {
								cb();
							}
							return true;							
						} else {		
							$('#tips2').html('<i class="err">用户名已被占用</i>');
							is_name_ok = false;	
							return;														
						};
					}			
				, 'json'
			);
		};
	
		$('.radiobutton').focus(function(){
			this.checked = 'checked';
			$('#tips5').html('<i class="info">&nbsp;</i>');					
		});
	
	$('#frm_reg').submit(function(){
		alert(1);
		var bRet = true;
		if(!validator.valid(this))	bRet = false;	
		//验证是否同意服务条款
		if(!$("#serviceTerms").attr('checked'))
		{
			bRet = false;
			$('#tips7').html('<i class="err">请阅读并同意服务条款</i>');	
		}
		if (!is_name_ok) {
			var _this = this;
			isnameused(function () {
				$(_this).trigger("submit");
			});
			return false;
		}		
		
		return bRet;
	});

});



