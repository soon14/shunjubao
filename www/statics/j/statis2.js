
// 处理用户的入口来源
(function($){
	var entry_referer_url;
	var matches = document.referrer.match(/http:\/\/([^\/]+)\/?/);
	if (matches) {
		if (!matches[1].match(/\.gaojie\.com$/)) {// 外域入口
			entry_referer_url = $.param({
				referer: document.referrer// 来源
				, entry: location.href // 入口
			});
		}
	} else {// 直接访问的
		entry_referer_url = $.param({
			referer: ''// 来源
			, entry: location.href // 入口
		});
	}
	
	if (entry_referer_url) {
		var objImage = new Image();
		objImage.src = $.conf.www_root_domain + "/log_entry_referer_url.php?" + entry_referer_url + "&r=" + Math.random();
	}
})(TMJF);

// 添加统计跟踪代码
(function($){
	var objImage = new Image();
	var params = {
		'title':		$("title").first().html()
		, 'url':		location.href
		, 'host':		location.host
		, 'referer':	document.referrer
		, 'r':			Math.random()
	};
	var channelid = $.common.Cookie.get("channelid");
	if ($.common.Verify.isInt(channelid)) {
		params.channelid = channelid;
	}
	var uuid = $.common.Cookie.get("uuid");
	if (uuid && uuid.length > 0) {
		params.uuid = uuid;
	}
	
	// 对mediav的sem的跟踪
	var sem_adcomp = $.common.Cookie.get("sem_adcomp");
	if (sem_adcomp && sem_adcomp.length > 0) {
		params.sem_adcomp = sem_adcomp;
	}
	var sem_keyid = $.common.Cookie.get("sem_keyid");
	if (sem_keyid && sem_keyid.length > 0) {
		params.sem_keyid = sem_keyid;
	}
	var sem_source = $.common.Cookie.get("sem_source");
	if (sem_source && sem_source.length > 0) {
		params.sem_source = sem_source;
	}
	var adsense_from = $.common.Cookie.get("adsense_from");
	if (adsense_from && adsense_from.length > 0) {
		params.adsense_from = adsense_from;
	}
	objImage.src = "http://statis.gaojie.com/a.gif?"+$.param(params);
})(TMJF);

// 定义google统计的全局变量
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-24738426-1']);
_gaq.push(['_trackPageview']);

//在dom ready事件后才加载统计代码。目的是为了让导航这块的信息被更快加载，提高用户体验
//对上面注释的更正见解：把其它事件往dom ready的后面放，并不能有效的提高用户交互体验。
// 把js往dom的最后面放，然后直接操作dom，而不是等待dom ready事件的到来，才是王道。
// 上面由 gxg 注释
(function() {
	// 加载百度统计
	(function () {
		var bdu = document.createElement('script'); bdu.type = 'text/javascript'; bdu.async = true;
		bdu.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'hm.baidu.com/h.js?1323a9da48ab8625589111e5f299bdb7';
		var bdu_s = document.getElementsByTagName('script')[0]; bdu_s.parentNode.insertBefore(bdu, bdu_s);
	})();
	
	// 加载google统计
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
})();

// 站内广告位统计
TMJF(function ($) {
	var ad_attr_name = "innerAds";
	$("["+ad_attr_name+"]").each(function () {
		var ad_flag = $(this).attr(ad_attr_name);
		var params = {
			'ad_flag': ad_flag
			, 'type': 'pv'
			, 'title':		$("title").first().html()
			, 'url':		location.href
			, 'host':		location.host
		};
		var ads = [];
		$("a", this).each(function () {
			var href = $(this).attr("href");
			if (!href) {
				return;
			}
			var ad_text = $(this).text();// 广告里的文字
			var ad_img = '';// 广告素材图
			var jq_img = $("img", this).first();
			if (jq_img.size() == 1) {
				var ad_img_src = jq_img.attr("src");
				if (ad_img_src) {
					ad_img = ad_img_src;
				}
			}
			ads.push({
				'link': href
				, 'text': ad_text
				, 'img': ad_img
			});
		});
		
		if (ads.length == 0) {// 这个广告位里，压根没有素材，没有记录的必要
			return;
		}
		params.ads = ads;
		$.common.CrossDomainAjax.post(
			"http://statis.gaojie.com/b.gif?_r="+Math.random()
			, {
				'params': $.common.JSON.stringify(params)
			}
		);
	});
	
	$("["+ad_attr_name+"] a").click(function () {
		var href = $(this).attr("href");
		if (!href) {
			return;
		}
		
		var ad_flag = $(this).closest("["+ad_attr_name+"]").attr(ad_attr_name);
		if (!ad_flag) {
			console.log("没有匹配到广告位名称");
			return;
		}
		
		var ad_text = $(this).text();// 广告里的文字
		var ad_img = '';// 广告素材图
		var jq_img = $("img", this).first();
		if (jq_img.size() == 1) {
			var ad_img_src = jq_img.attr("src");
			if (ad_img_src) {
				ad_img = ad_img_src;
			}
		}
		
		var objImage = new Image();
		var params = {
			'ad_flag': ad_flag
			, 'type': 'uv'
			, 'title':		$("title").first().html()
			, 'url':		location.href
			, 'host':		location.host
			, 'referer':	document.referrer
			, 'link': href
			, 'text': ad_text
			, 'img': ad_img
			, '_r':			Math.random()
		};
		objImage.src = "http://statis.gaojie.com/c.gif?"+$.param(params);
	});
});

// 记录站内所有链接的点击
TMJF(function ($) {
	$("a").click(function () {
		var href = $(this).attr("href");
		if (!href) {
			return;
		}
		
		
		var ad_text = $(this).text();// 广告里的文字
		var ad_img = '';// 广告素材图
		var jq_img = $("img", this).first();
		if (jq_img.size() == 1) {
			var ad_img_src = jq_img.attr("src");
			if (ad_img_src) {
				ad_img = ad_img_src;
			}
		}
		
		var objImage = new Image();
		var params = {
			'title':		$("title").first().html()
			, 'url':		location.href
			, 'host':		location.host
			, 'referer':	document.referrer
			, 'link': href
			, 'text': ad_text
			, 'img': ad_img
			, '_r':			Math.random()
		};
		objImage.src = "http://statis.gaojie.com/click.gif?"+$.param(params);
	});
});
