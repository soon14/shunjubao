	
TMJF(function($){
     var len  = $(".pointul > li").length;
	 var index = 0;
	 var adTimer;
	 $(".pointul li").mouseover(function(){
		index  =   $(".pointul li").index(this);
		showImg(index);
	 }).eq(0).mouseover();
	 
	 $('.slide-list').hover(function(){
			 clearInterval(adTimer);
		 },function(){
			 adTimer = setInterval(function(){
			    showImg(index)
				index++;
				if(index==len){index=0;}
			  } , 3000);
	 }).trigger("mouseleave");
});

var showImg = (function ($) {
	return function (index) {
        var adHeight = $(".slide-list").height();
		$(".slider").stop(true,false).animate({top : -adHeight*index},298);
		$(".pointul li").removeClass("on")
			.eq(index).addClass("on");

		$(".slide-text li").removeClass("on")
			.eq(index).addClass("on");
	};
}) (TMJF);
