TMJF(function($){
     var len  = $(".pointul > li").length;
	 var index = 1-len;	
	 $(".slider").css('top',index*350+"px");
	 var adTimer;
	 $(".pointul li").mouseover(function(){
		index  =   $(".pointul li").index(this)-len+1;
		showImg(index,len);
	 }).eq(len).mouseover();
	 
	 $('.slide-list').hover(function(){
			 clearInterval(adTimer);
		 },function(){
			 adTimer = setInterval(function(){
			    showImg(index,len)
				index++;
				if(index==1){index=1-len;}
			  } , 3000);
	 }).trigger("mouseleave");

	function showImg(index,len){
		var adHeight = $(".slide-list").height();
		$(".slider").stop(true,false).animate({top : adHeight*index},300);
		$(".pointul li").removeClass("on")
			.eq(len-1+index).addClass("on");

		$(".slide-text li").removeClass("on")
			.eq(-index).addClass("on");
	}

});
