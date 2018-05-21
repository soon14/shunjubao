(function () {
	var n =0;
	var t = n = 0, count;
	TMJF(function($){
		
		function showAuto()
		{
			n = n >=(count - 1) ? 0 : ++n;
			$("#index_middle_banner li").eq(n).trigger('click');
		}
		
		$(document).ready(function(){	
			count=$("#index_middle_banner_list a").length;
			if (1 == count) {
				return;
			}
			$("#index_middle_banner_list a:not(:first-child)").hide();
			
			$("#index_middle_banner li").click(function() {
				var i = $(this).text() - 1;//获取Li元素内的值，即1，2，3，4
				n = i;
				if (i >= count) return;
				
				$("#index_middle_banner_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);
				document.getElementById("index_middle_banner").style.background="";
				$(this).toggleClass("on");
				$(this).siblings().removeAttr("class");
			});
			t = setInterval(showAuto, 4000);
			$("#index_middle_banner").hover(function(){clearInterval(t)}, function(){t = setInterval(showAuto, 4000);});
		});
		
		
	});
}) ();

//高街之选半透明特效
TMJF(function($){
	$('.gaojiezhixuan ul').hover(
			function(){
				$(this).css('background-color', '#333333');
				$('.gaojiezhixuan ul li img').each(function(){
					$(this).css('opacity', '0.8');
				});
			}
			, function(){
				$(this).css('background-color', '#FFFFFF');
				$('.gaojiezhixuan ul li img').css('opacity', '1');
			}
	);
	
	$('.gaojiezhixuan ul li img').hover(
		function() {
			var _this = this;
			(function () {
				setTimeout(function() {
					$(_this).css('opacity', '1');
				}, 0);
			})();
		}
		, function(){
			$(this).css('opacity', '0.8');
		}
	);
	
	//特殊情况，解决当当鼠标进过”高街之选“轮播图按钮时透明度失效
	$('.focus2 ol').mousemove(function(){
		$('.gaojiezhixuan ul li img').css('opacity', '0.8');
		$('.focus_ts img').css('opacity', '1');
	});
	$('.focus2 ol').mouseout(function(){
		$('.gaojiezhixuan ul li img').css('opacity', '0.8');
		$('.focus_ts img').css('opacity', '1');
	});
});	

//高街之选 轮播图
TMJF(function($){	
	var fo = $(".focus2 img");
	var fol = $(".focus2 ol li a");
	var n =0;
	var prev_n = 0;
	fo.eq(n).css("display", "block");
	fol.eq(n).addClass("active");
	var img_num = $(".focus2 img").length;
	
	function changeFoucs() {
		n++;
		prev_n = n-1;
		if(n==img_num){
			n=0;
			prev_n = img_num-1;
		}
		
		fo.eq(prev_n).css("display", "none");
		fo.eq(n).css("display", "block");
		
		fol.eq(prev_n).removeClass("active");
		fol.eq(n).addClass("active");
		
	}
	
	setInterval(changeFoucs, 5000);
	
	fol.mouseover(function(){
		
		var fid = this.id;
		var reg1 = /\d+$/;
		var reg1f = fid.match(reg1)-1;
		n = reg1f;
		
		fo.css("display", "none");
		fo.eq(n).css("display", "block");
		
		fol.removeClass("active");
		fol.eq(n).addClass("active");
		
		return false;
	});
	
});

//超级特惠模块
TMJF(function($){
	$('.gaojietehuei ul li').eq(1).show();
	$('.gaojietehuei .cjth').mouseover(function(){
		$('.tjimg').hide();
		$(this).parent().next().show();
	});
});

//首页品牌滚动模块

TMJF(function($){
	var moveWidth = $('.barandlogo .guendongwidth').width();
	var brandsWidth = 0;
	$('.brandScroll li').each(function(){
		brandsWidth += $(this).width();
	});
	
	$('.barandlogo .l2 a').click(function(){
		var lf = $('.brandScroll').css("left").replace('px','');
		if(Number(lf) <= (Number('-'+brandsWidth) + moveWidth)) {
			return false;
		}
		
		if($('.brandScroll').is(":animated")) {
			return false;
		}
		var leftSrcoll = (isNaN(Number(lf)) ? 0 : Number(lf)) + Number("-"+moveWidth);
		$('.brandScroll').animate({left : leftSrcoll+"px"}, 500);
		return false;
	});
	$('.barandlogo .l1 a').click(function(){
		var lff = $('.brandScroll').css("left").replace('px','');
		if(isNaN(lff) || Number(lff) >= 0) {
			return false;
		}
		
		if($('.brandScroll').is(":animated")) {
			return false;
		}
		
		$('.brandScroll').animate({"left":Number(lff) + moveWidth+"px"}, 500);
		return false;
	});
	
	$('.barandlogo ul li a').hover(
		function() {
			$(this).find('span').eq(0).hide();
			$(this).find('span').eq(1).show();
		},
		function() {
			$(this).find('span').eq(1).hide();
			$(this).find('span').eq(0).show();
		}
	);
}); 