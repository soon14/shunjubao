TMJF(function($){
	$(".propic").live({
		mouseover : function () {
			if (typeof($(this).find(".pic2").attr("src")) != "undefined") {
				$(this).find(".pic1").hide();
			}
		}, mouseout : function () {
			$(this).find(".pic1").show();
		}
	});
	$(".size_search").change(function (){
		$("#ss_category").trigger("submit");
	});
	$("#ss_category").submit(function (){
		return true;
	});
});

//该js用于特卖列表页面，获取赠品信息。比如：http://www.gaojie.com/home/dehimefcf
var url = location.href;
TMJF(function ($) {
	if ($("#auto_ss_gift_tips").size() == 0) {
		return;
	}
	
	$.common.CrossDomainAjax.get($.conf.www_root_domain + '/getsUsableGifts_for_ss.php', {
		url: url
	}, function (data) {
		if (data.ok) {
			$("#auto_ss_gift_tips").html(data.msg);
		}
	}, 'json');
});

