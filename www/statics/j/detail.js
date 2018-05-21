TMJF(function($){
	 $(".QuantWindow p").mouseover(function(){
		index2  =   $(".QuantWindow p").index(this);
		$(".QuantWindow p").removeClass("on")
			.eq(index2).addClass("on");
	 }).eq(0).mouseover();	 
	 
	 $(".Quant").mouseover(function(){this.className="Quant over"});
	 $(".Quant").mouseout(function(){this.className="Quant"});
	 $(".Quant").click(function(){this.className="Quant"});
	 $(".QuantWindow p").click(
		 function(){
			document.getElementById("qselected").innerHTML = this.innerHTML;
			}
		 );
});

TMJF(function($){
     $(".cartclose").click(function(){
		$(".popup").css("display","none");
	});	
});

//团购商品购买页面，点击购买后的弹层，点击关闭按钮后执行此段代码
TMJF(function($){
    $(".cartclose").click(function(){    
       $(".popup").css("display","none");
   }); 
});


//该js用于特卖商品展示页面 以及 团购详情页。比如：http://www.gaojie.com/product/pjbiblbcbjjm

var url = location.href;
TMJF(function ($) {
	$.common.CrossDomainAjax.get($.conf.www_root_domain + '/getsUsableSalesPromotions.php', {
		url: url
	}, function (data) {
		if (data.ok) {
			var has_salesPromotions = false;
			$.each(data.msg.salesPromotions, function () {
//				has_salesPromotions = true;
				return false;
			});
			var html = '<div> <img src="' + $.conf.cdn_i + '/youhueihudongimg.jpg" style="position:relative;top:3px;"><p class="p1"> ';
			var arr_show_groups = [];// 按分组展示促销信息
			var group_names = [];// 存放组名。用于控制相同的组只展示一次
			$.each(data.msg.salesPromotions, function (k, v) {
				if (v.group_name) {
					if ($.inArray(v.group_name, group_names) == -1) {
						arr_show_groups.push({
							'name': v.group_name
							, 'url': v.url
						});
						group_names.push(v.group_name);
						has_salesPromotions = true;
					}
				} else {
//					arr_show_groups.push({
//						'name': v.name
//						, 'url': v.url
//					});//没有填写组名的就不显示
				}
			});
			$.each(arr_show_groups, function (k, v) {
				if (v.url) {
					html += "<span>▪</span><a href=\"" + v.url + "\" target=\"_blank\"><font color='#E61678'>" + v.name +  "</font></a><br>";
				} else {
					html += "<span>▪</span><span class='salesPromotionName'>" + v.name + "</span><br>";
				}
			});
			
			html += '</p><div class="clear"></div></div>';
			
			if (has_salesPromotions) {
				$("#usableSalesPromotion_tips").html(html);
			}
			
			if (data.msg.prodNameFrontDesc) {
				$("#frontDesc").html(data.msg.prodNameFrontDesc);
			}
		}
	}, 'json');
});


//该js用于特卖商品展示页面 以及 团购详情页，获取赠品信息。比如：http://www.gaojie.com/product/pjbiblbcbjjm
var url = location.href;
TMJF(function ($) {
	if ($("#auto_ssProd_gift_tips").size() == 0) {
		return;
	}
	
	$.common.CrossDomainAjax.get($.conf.www_root_domain + '/getsUsableGifts_for_ssProd.php', {
		url: url
	}, function (data) {
		if (data.ok) {
			$("#auto_ssProd_gift_tips").html(data.msg);
		}
	}, 'json');
});
