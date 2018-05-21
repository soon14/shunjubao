//读取用户PMS信息
$(document).ready(function(){
	var url = '/pms/operate.php?type=getNewPmsNum&jsonp_cb=?';
	
	$.getJSON(url, function(data){
		if (data.ok) {
        	showPms(data.msg);
        }
	});
});	
function showPms(msg) {
	var h1 = $("#topCenter");
	if (typeof(h1) == 'undefined' ) return ;
	var html = "<li class=\"xiaoxi\"><b class=\"\">消息<span><a href=\"\/account\/user_center.php?p=pms\">"+msg+"</a></span></b></li>";
	$(h1).append(html);
}