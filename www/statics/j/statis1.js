
// 通过url获取channelid参数的值
// 将这段代码由 statis2.js 移到 statis1.js 的原因是：这个js文件在顶部即被执行。有些依赖于channelid的功能，比如商品详情页的限时促销价，可能依赖于channelid条件。
// 如果计算促销价的js被执行后，channelid还没被种下的话，就没有意义了。
(function($){
	var url = location.href;
	var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
	var paraObj = {};
	for (i=0; j=paraString[i]; i++){
		paraObj[j.substring(0,j.indexOf("=")).toLowerCase()] = j.substring(j.indexOf("=")+1,j.length);
	}
	var channelid = paraObj["channelid".toLowerCase()];
	if (typeof(channelid) != "undefined") {
		$.common.Cookie.set("channelid", channelid, "gaojie.com");
	}
	
	// 对mediav的sem的跟踪
	var sem_adcomp = paraObj["sem_adcomp".toLowerCase()];
	var sem_keyid = paraObj["sem_keyid".toLowerCase()];
	var sem_source = paraObj["sem_source".toLowerCase()];
	var adsense_from = paraObj["adsense_from".toLowerCase()];
	// 我们统计时用adw_attr参数,亿玛SEM监测时用_adwe参数做验证
	var adw_attr = paraObj["adw_attr".toLowerCase()];
	if (typeof(adw_attr) != "undefined" && adw_attr == 1262) {
		$.common.Cookie.set("adsense_from", 'emar_sem', "gaojie.com", 30);
		$.common.Cookie.set("channelid", 8000001, "gaojie.com");
	} else if (typeof(adsense_from) != "undefined") {
		// 不是从亿玛的百度sem过来的，又带有adsense_from参数，说明是从别人推广联盟过来的。
		// 不可能一个用户同时算在两个推广效果上，所以删除掉亿玛订单推送所依赖的条件cookie
		$.common.Cookie.set("_adwe", null, "gaojie.com");
		
		(function () {// 如果cookie里有亿玛的渠道id，则删除
			var channelid = $.common.Cookie.get("channelid");
			if (channelid && channelid == "8000001") {
				$.common.Cookie.set("channelid", null, "gaojie.com");
			}
		})();
	}

	if (typeof(sem_adcomp) != "undefined") {
		$.common.Cookie.set("sem_adcomp", sem_adcomp, "gaojie.com");
	}
	if (typeof(sem_keyid) != "undefined") {
		$.common.Cookie.set("sem_keyid", sem_keyid, "gaojie.com");
	}
	if (typeof(sem_source) != "undefined") {
		$.common.Cookie.set("sem_source", sem_source, "gaojie.com");
	}
	if (typeof(adsense_from) != "undefined") {
		$.common.Cookie.set("adsense_from", adsense_from, "gaojie.com");
	}
})(TMJF);