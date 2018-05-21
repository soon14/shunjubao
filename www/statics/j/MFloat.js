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
    setTimeout(c, 1000);
    $('#gotop').click(function() {
        $(document).scrollTop(0);
    })
});

$(window).scroll(function(e){
b();
c();	
})



function c() {
    /*
	h = $(window).height();
	t = $(document).scrollTop();
	if(t > h){
		$('.footbuybox').show();
	}else{
		$('.footbuybox').hide();
	}
	*/
    if ($(".footer").position().top < ($(document).scrollTop() + $(window).height()) && $(".betbox").css("position") == "fixed") {
        $(".betbox").css({ "position": "relative", "": 998 });
    } else if ($(".footer").position().top > ($(document).scrollTop() + $(window).height() + 78) && $(".betbox").css("position") != "fixed") {
        $(".betbox").css({ "position": "fixed", "width": "100%" });
    }
	

}
$(document).ready(function(e) {
    /*
    $('.footbuybox').click(function(){
    $(document).scrollTop(0);	
    })
    */
});


	$(function(){
		$(".nav li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".DangQian li").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
		$(".shedan").hover(function(){
			$(this).find(".Flaotbox").show();
		},function(){
			$(this).find(".Flaotbox").hide();
		});
		$(".cMore").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".R").hover(function(){
			$(this).find("b em").show();
		},function(){
			$(this).find("b em").hide();
		});
		$(".jiexian").hover(function(){
			$(this).find("em").show();
		},function(){
			$(this).find("em").hide();
		});
		$(".LancaiWanFa").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".activeShow").hover(function(){
			$(this).find("em").show();
		},function(){
			$(this).find("em").hide();
		});
		$(".LchuenheTop").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".LancaiWanFa").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".jxTop").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".WanFa").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".accoutList").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
	});
	
$(document).ready(function(){ 
	$(".stripe tr").mouseover(function(){      
	  $(this).addClass("over");}).mouseout(function(){    
			$(this).removeClass("over");}) 
  $(".stripe tr:even").addClass("alt");   
  });


 $(document).ready(function(){
       var topMain=$(".header").height()+200//
       var Kjnav=$(".Kjnav");
           $(window).scroll(function(){
            if ($(window).scrollTop()>topMain){//
                     Kjnav.addClass("Kjnav_scroll");
                    }
                    else
                    {
                        Kjnav.removeClass("Kjnav_scroll");
                    }
                });
     
        })
 
  $(document).ready(function(){
       var topMain=$(".header").height()+200//
       var Kjnav=$(".guize");
           $(window).scroll(function(){
            if ($(window).scrollTop()>topMain){//
                     Kjnav.addClass("guizeHind");
                    }
                    else
                    {
                        Kjnav.removeClass("guizeHind");
                    }
                });
     
        })
 
function AutoScroll(obj){
        $(obj).find("ul:first").animate({
                marginTop:"-25px"
        },800,function(){
                $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
        });
}
$(document).ready(function(){
setInterval('AutoScroll("#scrollDiv")',2000)
});
 