TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	var cookiename = 'SinaWeibo_FirstLogin';
	var SinaWeibo_FirstLogin = TMJF.common.Cookie.get(cookiename);
	if (SinaWeibo_FirstLogin == 1) {
		TMJF.common.Cookie.set(cookiename, 0);
		//是否发feed
		$('.blackwindow').css('height',$(document).height());
		$(".popup_f").fadeIn();		
		$('#sina_feed').click(function(){
			//是否关注
			var attention = $('#attention').attr('checked');
			if (attention) {attention = 1;}else{attention = 0;}
			$(".popup_f").fadeOut();
			$.get(
				tmpDomain + "/connect/sina_firstlogin.php?attention="+attention
					, function (data) {
						if (data.ok) {								
							//alert(data.msg);	
						} else {		
							//alert(data.msg);
						};
					}			
				, 'json'
			);
			return false;
		});
		
		$(".cartclose,#sina_feed_close").click(function(){
			$(".popup_f").fadeOut();
			return false;
		});
		
	}

});
