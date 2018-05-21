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
	$('#gotop').click(function(){
		$(document).scrollTop(0);	
	})
});


function c(){
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



$(window).scroll(function(e){
b();
c();	
})


$(function(){
$(".tdBorder tr:odd").css("background-color","#fff");
$(".tdBorder tr:even").css("background-color","#f3f3f3");
});
$(document).ready(function(e) {
	c();
	$('.footbuybox').click(function(){
		$(document).scrollTop(0);	
	})
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
		$(".Ashow").hover(function(){
			$(this).find("em").show();
		},function(){
			$(this).find("em").hide();
		});
		$(".NavHggs .seven").hover(function(){
			$(this).find(".show em").show();
		},function(){
			$(this).find(".show em").hide();
		});
		$(".NavHgg .seven").hover(function(){
			$(this).find(".rfsf em").show();
		},function(){
			$(this).find(".rfsf em").hide();
		});
		$(".NavHgg .eight").hover(function(){
			$(this).find(".dxf em").show();
		},function(){
			$(this).find(".dxf em").hide();
		});
		$(".Navdx .six").hover(function(){
			$(this).find(".show em").show();
		},function(){
			$(this).find(".show em").hide();
		});
		$(".jxTop").hover(function(){
			$(this).find("u em").show();
		},function(){
			$(this).find("u em").hide();
		});
		$(".NavZpf .seven").hover(function(){
			$(this).find(".show em").show();
		},function(){
			$(this).find(".show em").hide();
		});
		$(".NavZHg .seven").hover(function(){
			$(this).find(".show em").show();
		},function(){
			$(this).find(".show em").hide();
		});
		$(".accoutList").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		
		$(".sitemap").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		
		$(".topCenter ol li").hover(function(){
			$(this).find("p").show();
		},function(){
			$(this).find("p").hide();
		});
		$(".zjfengyunbang dl dt p span").hover(function(){
			$(this).find("a").show();
		},function(){
			$(this).find("a").hide();
		});
		$(".zjlist p").hover(function(){
			$(this).find("span").show();
		},function(){
			$(this).find("span").hide();
		});
	});	
	
$(document).ready(function(){ //投注表单样式js
	$(".stripe tr").mouseover(function(){   
	   //如果鼠标移到class为stripe的表格的tr上时，执行函数   
	$(this).addClass("over");}).mouseout(function(){   
			//给这行添加class值为over，并且当鼠标一出该行时执行函数   
	$(this).removeClass("over");}) //移除该行的class   
	$(".stripe tr:even").addClass("alt");   
	//给class为stripe的表格的偶数行添加class值为alt
	
    //投注确认隔行换色
    $('tr').addClass('odd');
    $('tr:even').addClass('even'); //奇偶变色，添加样式     
});

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
        setInterval('AutoScroll("#scrollDiv")',2000); 
});

$(document).ready(function(){ 
    var topMain=$(".header").height()+80//是头部的高度加头部与Kjnav导航之间的距离。
    var Kjnav=$(".Kjnav");
        $(window).scroll(function(){
         if ($(window).scrollTop()>topMain){//如果滚动条顶部的距离大于topMain则就Kjnav导航就添加类.Kjnav_scroll，否则就移除。
                  Kjnav.addClass("Kjnav_scroll");
                 }
                 else
                 {
                     Kjnav.removeClass("Kjnav_scroll");
                 }
             });
});

 //中奖滚动
function AutoScroll(obj){
        $(obj).find("ul:first").animate({
                marginTop:"-25px"
        },800,function(){
                $(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
        });
}


//首页tab

$(document).ready(function(){
	$(".menu > li").click(function(e){
		switch(e.target.id){
			case "news":
				//change status & style menu
				$("#news").addClass("active");
				$("#tutorials").removeClass("active");
				//display selected division, hide others
				$("div.news").fadeIn();
				$("div.tutorials").css("display", "none");
			break;
			case "tutorials":
				//change status & style menu
				$("#news").removeClass("active");
				$("#tutorials").addClass("active");
				//display selected division, hide others
				$("div.tutorials").fadeIn();
				$("div.news").css("display", "none");
			break;
		}
		//alert(e.target.id);
		return false;
	});
});