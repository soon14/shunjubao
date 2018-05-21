var TMJF = jQuery.noConflict(true);


TMJF(function($){
	
	$('table input[type="password"]').focus(function(){
		$(this).css('border','2px solid #63AB00');
		$(this).css('background','#FFFDE4');
		$(this).css('padding','0px');
	});

	$('table input[type="password"]').blur(function(){
		$(this).css('border','1px solid #ccc');
		$(this).css('background','#FFF');
		$(this).css('padding','1px');
	});
	
	$('#newpas').blur(function(){	
		if($(this)[0].value==''){
		$("#tips1").html('<img src="i/w.gif" class="r" /> <i>请您填写新密码</i>');
		}else{
		$("#tips1").html('<img src="i/r.gif" class="r" />');}
	});

	$('#repas').blur(function(){

		if($(this)[0].value==''){
		$("#tips2").html('<img src="i/w.gif" class="r" /> <i>请您重复填写新密码</i>');
		}
		
		if($(this)[0].value != $('#newpas')[0].value){
		$("#tips2").html('<img src="i/w.gif" class="r" /> <i>两次输入的密码不同，请输入相同密码</i>');
		}else{
		$("#tips2").html('<img src="i/r.gif" class="r" />');}

	});


});



