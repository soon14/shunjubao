TMJF(function($){
	$(".adclose").click(function(){
		$(".tsad").css('display','none');
		$("#a").css('height','0px');
		$("#k").css('height',"0px");
		$("#kk a").css('height',"0px");
	});
});
TMJF(function($){
	$(".fShow_List>li").hover(function(){
		$(this).find(".imgInf").stop().animate({bottom: '0px'}, 300);
	},function(){
		$(this).find(".imgInf").stop().animate({bottom: '-42px'}, 300);
	});
});

//特卖商品详情页右侧广告 + 预览商品 跟随滚动
TMJF(function($){
	if ($(".sidebar_bottom").length <= 0 || $(".sidebar").length <= 0 || $(".ppgstit").length <= 0
			|| $(".goodsad_bottom").length <= 0 || $(".goodsad").length <= 0) {
		return false;
	}
	
	var sidebar_offset_bottom = $(".sidebar_bottom").offset().top + 600;
	var sidebar_offset_top = $(".sidebar").offset().top + 110;
	$(window).scroll(function(){
		var scrollTop = $(document).scrollTop();
		var sale_square7_top = $(".ppgstit").offset().top - 21;
		var goodsad_bottom = $(".goodsad_bottom").offset().top + 50;
		var goodsad_top = $(".goodsad").offset().top;
		if (sale_square7_top <= goodsad_bottom && scrollTop > goodsad_top) {
			return;
		}
		
		$(".goodsad").css({position:'relative'});
		if (scrollTop > sidebar_offset_bottom) {
	        $(".goodsad").css('top', scrollTop - sidebar_offset_top + 60);
		}
		
        if (scrollTop < sidebar_offset_bottom) {
        	$(".goodsad").css('top', 0);
		}
	});
});
