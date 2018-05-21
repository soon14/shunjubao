TMJF(function($){
	var tmpDomain = TMJF.conf.domain;
	$(".search_my_vip").click(function(){
		$.post(tmpDomain+"/activity/search_vip_ajax.php"
				,{}
				,function(data) {
					if (data.ok) {
						alert(data.msg);
					} else { // 未登录
						if(confirm(data.msg)) {
							window.location.href = tmpDomain+"/passport/login.php?from="+tmpDomain+"/activitys/vip";
						} else {
							return false;
						}
					}
				}
				, 'json'
		);
	})
	
});