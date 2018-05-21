var TMJF = jQuery.noConflict(true);


TMJF(function($){
	
	$('table input[type="text"]').focus(function(){
		$(this).css('border','2px solid #63AB00');
		$(this).css('background','#FFFDE4');
		$(this).css('padding','0px');
	});

	$('table input[type="text"]').blur(function(){
		$(this).css('border','1px solid #ccc');
		$(this).css('background','#FFF');
		$(this).css('padding','1px');
	});
	
	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;

	$('#email').blur(function(){	
		if(!reg.test($(this)[0].value)){
		$("#tips1").html('<img src="i/w.gif" class="r" /> <i>输入的注册邮件地址有误,请重新输入</i>');
		}else{
		$("#tips1").html('<img src="i/r.gif" class="r" />');}
	});

	$('#name').blur(function(){	
		if($(this)[0].value==''){
		$("#tips2").html('<img src="i/w.gif" class="r" /> <i>输入的用户名不存在</i>');
		}else{
		$("#tips2").html('<img src="i/r.gif" class="r" />');}
	});

	$('#code').focus(function(){		
		$("#yzcode").css("display","table-row");
	});	

	$('#code').blur(function(){	
		$("#yzcode").css("display","none");
		if($(this)[0].value==''){
		$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请输入正确的验证码</i>');
		}else{
		$("#tips3").html('<img src="i/r.gif" class="r" />');}
	});	


});



