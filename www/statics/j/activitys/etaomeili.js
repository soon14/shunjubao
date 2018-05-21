TMJF(function($){
	var tmpDomain = TMJF.conf.domain; 
	$(".get_coupon").click(function(){
		$.post(tmpDomain+"/activity/etaomeili.ajax.php"
				,{}
				,function(data) {
					if (data.ok) {
						alert(data.msg);
					} else { // 未登录
						if(confirm(data.msg)) {
							window.location.href = tmpDomain+"/passport/login.php?from="+tmpDomain+"/activitys/etaomeili";
						} else {
							return false;
						}
					}
				}
				, 'json'
		);
	})
});