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

	$('#pname').blur(function(){	
		if($(this)[0].value==''){
		$("#tips1").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
		}else{
		$("#tips1").html('<img src="i/r.gif" class="r" />');}
	});

	$('#pdis').blur(function(){	
		if($(this)[0].value==''){
		$("#tips2").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
		}else{
		$("#tips2").html('<img src="i/r.gif" class="r" />');}
	});

	$('#pzipcode').blur(function(){	
		if($(this).val().length < 6){
		$("#tips4").html('<img src="i/w.gif" class="r" /> <i>请您填写准确的邮编</i>');
		}else{
		$("#tips4").html('<img src="i/r.gif" class="r" />');}
	});

	var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;

	$('#pemail').blur(function(){	
		if(!reg.test($(this)[0].value)){
		$("#tips7").html('<img src="i/w.gif" class="r" /> <i>邮箱格式不正确，请检查</i>');
		}else{
		$("#tips7").html('<img src="i/r.gif" class="r" />');}
	});

	$('#pselect1').change(function(){	
		if($('#pselect1')[0].value=='none'){
			$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
		}else{
			if($('#pselect2')[0].value=='none'){
				$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
			}else{
					
				if($('#pselect3')[0].value=='none'){
					$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
				}else{
					$("#tips3").html('');
				}
			}
		}
	});

	$('#pselect2').change(function(){	
		if($('#pselect1')[0].value=='none'){
			$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
		}else{
			if($('#pselect2')[0].value=='none'){
				$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
			}else{
					
				if($('#pselect3')[0].value=='none'){
					$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
				}else{
					$("#tips3").html('');
				}
			}
		}
	});

	$('#pselect3').change(function(){	
		if($('#pselect1')[0].value=='none'){
			$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
		}else{
			if($('#pselect2')[0].value=='none'){
				$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
			}else{
					
				if($('#pselect3')[0].value=='none'){
					$("#tips3").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
				}else{
					$("#tips3").html('');
				}
			}
		}
	});

	

	$('#pphone').blur(function(){	
		if( $('#pphone').val().length < 11 ){
			if( $('#ptel1').val().length < 3 && $('#ptel2').val().length < 7){
				$("#tips6").html('<img src="i/w.gif" class="r" /> <i>请您填写完整信息</i>');
			}
		}
	});


	
	var lentd  = $(".ntborder > .new-addr").length;
	var $t_table = $(".ntborder .new-addr:eq("+(lentd-1)+")");
	
	$(".new-addr").eq(lentd-1).css("display","block");


	

});



