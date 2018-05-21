// 团购详情页js脚本

TMJF(function($){
	$(".detail .detailtxt p img").each(function () {
		if ($(this).width() > 650) {
			$(this).width(650);
		}
	});
});