
var domain = 'http://'+document.domain;

// 跟踪记录用户的浏览行为
jQuery(function($) {
	$(".tuanLink").click(function() {
		var tid = $(this).attr("tid");
		$.getJSON(domain + '/log_click.php?tid=' + tid);
	});
});