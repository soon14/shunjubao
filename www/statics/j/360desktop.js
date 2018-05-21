TMJF(function ($) {
	var from_360desktop = TMJF.common.Cookie.get("from_360desktop");
	if (typeof(from_360desktop) != "undefined" && 1==from_360desktop) 
	{
		$.each($("a"), function() {
			var tmpHref = $(this).attr("href");
			if (typeof(tmpHref) != "undefined" && (tmpHref.indexOf("gaojie.com") != -1 || '/'==tmpHref.substr(0, 1))) {
				$(this).attr('target', '_self');
			}
		});
	}
});