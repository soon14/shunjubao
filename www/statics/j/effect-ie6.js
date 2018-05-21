TMJF(function($){
	var cdn_i = TMJF.conf.cdn_i;
	$('<iframe style="background:#fff;z-index:500;position:absolute;width:255px;height:auto;display:none;" id="iframemask" border="0" frameborder="0"></iframe>').appendTo("body");

	$('.proright a').mouseover(function(){
		$(this).css('background','url('+cdn_i+'/ljqg.png) -58px 0  no-repeat');
	});

	$('.proright a').mouseout(function(){
		$(this).css('background','url('+cdn_i+'/ljqg.png) no-repeat');
	});

	$("#nav > li").each(function () {
		$(this).mousemove(function () {
			$(this).addClass("over");
			var ulheight= $(this).children("ul").height();
			var offset= $(this).children("ul").offset();
			if (!offset) {
				return;
			}
			var ultop = offset.top;
			var ulleft = offset.left;

			$('#iframemask').css('top',ultop);
			$('#iframemask').css('left',ulleft);
			$('#iframemask').css('height',ulheight);
			$('#iframemask').css('display','block');
		});
		$(this).mouseout(function () {
			$(this).removeClass("over");
			$('#iframemask').css('display','none');
		});
	});
});