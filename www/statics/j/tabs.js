/**
 * 热销商品排行
 */
TMJF(function($){
	var o = ".fu_hotRank_left a";
	var _this;
	$(o).hover(function(){
		if (_this == this) return;
			_this = this;
			var tab_id = $(_this).attr('tab');
			var tab = "#tab-" + tab_id;
			
			$(o).each(function(){
				var tab_id = $(this).attr('tab');
				var tab = "#tab-" + tab_id;
				$(this).removeClass("tab_hotRank_hover");
				$(tab).hide();
				
			});
			
			$(_this).addClass("tab_hotRank_hover");
			$(tab).fadeIn("show");
	}, function(){});
});