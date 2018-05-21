TMJF(function($){
	var cdn_i = TMJF.conf.cdn_i;
	var domain = TMJF.conf.domain;
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

	var verify_nowpass = function() {
		if ($.trim($("#nowpas").val()).length < 1) {
			$("#tips1").html('<img src="'+cdn_i+'/w.gif" class="r" /> <i>请您填写目前密码</i>');
			return false;
		} else {
			$("#tips1").html('<img src="'+cdn_i+'/r.gif" class="r" />');
			return true;
		}
	};
	$('#nowpas').blur(verify_nowpass);

	var verify_newpas = function(){	
		if ($.trim($("#newpas").val()).length < 1) {
			$("#tips2").html('<img src="'+cdn_i+'/w.gif" class="r" /> <i>请您填写新密码</i>');
			return false;
		} else{
			$("#tips2").html('<img src="'+cdn_i+'/r.gif" class="r" />');
			return true;
		}
	};
	$('#newpas').blur(verify_newpas);
	
	var verify_repas = function(){
		if ($.trim($("#repas").val()).length < 1) {
			$("#tips3").html('<img src="'+cdn_i+'/w.gif" class="r" /> <i>请您填写新密码</i>');
			return false;;
		}
		
		if($.trim($("#repas").val()) != $.trim($('#newpas').val())){
			$("#tips3").html('<img src="'+cdn_i+'/w.gif" class="r" /> <i>两次输入的密码不同，请输入相同密码</i>');
			return false;;
		}else{
			$("#tips3").html('<img src="'+cdn_i+'/r.gif" class="r" />');
			return true;
		}
	};

	$('#repas').blur(verify_repas);

	$(".bookemail").click(function(){
		$('.blackwindow').css('height',$(document).height());
		$(".popup").fadeIn();
	});	

    $(".cartclose").click(function(){
		$(".popup").fadeOut();
	});	

    $("#return").click(function(){
		$(".popup").fadeOut();
	});	

    $('#change_pass_form').submit(function() {
    	var pass = true;
    	verify_nowpass() || (pass = false);
    	verify_newpas() || (pass = false);
    	verify_repas() || (pass = false);
    	
    	if (!pass)
    		return false;
    	var nowpas = $.trim($('#nowpas').val());
    	var newpas = $.trim($('#newpas').val());
    	var repas = $.trim($('#repas').val());
    	$.post(domain + '/account/edit_show.php'
    		,{action:'editpas', nowpas:nowpas, newpas:newpas,repas:repas}
    		,function(data) {
    			$('#warningpas').html(data.msg);
    			$('#warningpas').fadeOut(2000, function () {
	    			$(this).html("");
	    			$(this).css("display", "block");
	    		});
    		}
    		, 'json'
    	);
    	return false;
	});
});