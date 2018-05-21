function checkMobile() {
	var isiPad = navigator.userAgent.match(/iPad/i) != null;
	if (isiPad) {
		return true;
	}

	var isMobile = navigator.userAgent
			.match(/iphone|android|phone|mobile|wap|netfront|java|opera mobi|opera mini|ucweb|windows ce|symbian|symbianos|series|webos|sony|blackberry|dopod|nokia|samsung|palmsource|xda|pieplus|meizu|midp|cldc|motorola|foma|docomo|up.browser|up.link|blazer|helio|hosin|huawei|novarra|coolpad|webos|techfaith|palmsource|alcatel|amoi|ktouch|nexian|ericsson|philips|sagem|wellcom|bunjalloo|maui|smartphone|iemobile|spice|bird|zte-|longcos|pantech|gionee|portalmmm|jig browser|hiptop|benq|haier|^lct|320x320|240x320|176x220/i) != null;
	if (isMobile) {
		return true;
	}
	return false;
}
var system = {
	win : false,
	mac : false,
	xll : false
};
// var p = navigator.platform;
// system.win = p.indexOf("Win") == 0;
// system.mac = p.indexOf("Mac") == 0;
// system.xll = (p == "X11") || (p.indexOf("Linux") == 0);

// if(system.win||system.mac||system.xll){
// }else{
// window.location.href="http://www.shunjubao.com";
// }
var href = document.location.href;

var hostname = document.location.hostname;
if (hostname.match(/www\.zhiying365365\.com/i) && checkMobile()) {

	if(href.indexOf("admin")!=-1){
		//window.location.href = href;
	}else{
		href = href.replace(/www\.zhiying365365\.com/i, "m.zhiying365365.com");
		window.location.href = href;
	}
	
	
	
}
