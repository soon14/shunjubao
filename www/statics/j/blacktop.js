function b(){
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('#gotop').show();
	}else{
		$('#gotop').hide();
	}
}
$(document).ready(function(e) {
	b();
	$('#gotop').click(function(){
		$(document).scrollTop(0);	
	})
});

$(window).scroll(function(e){
	b();		
})



function c(){
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('.footbuybox').show();
	}else{
		$('.footbuybox').hide();
	}
}
$(document).ready(function(e) {
	c();
	$('.footbuybox').click(function(){
		$(document).scrollTop(0);	
	})
});

$(window).scroll(function(e){
	c();		
})





	$(function(){
		$("#mainNav li").hover(function(){
			$(this).find("ul").show();
		},function(){
			$(this).find("ul").hide();
		});
		$(".homead1 li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".homead1 li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".shoplist dt").hover(function(){
			$(this).find("strong").show();
		},function(){
			$(this).find("strong").hide();
		});
		$("#brands li").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".showlayer dl").hover(function(){
			$(this).find("strong").show();
		},function(){
			$(this).find("strong").hide();
		});
		$("#brands li").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".img-list li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
/*		$(".history li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});*/
		$(".xiangtong dt").hover(function(){
			$(this).find("b").show();
		},function(){
			$(this).find("b").hide();
		});
		$(".chackshoucang li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".chackshoucang li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".uc").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".kword li").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".pinzhi p").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".youlike li").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
	});