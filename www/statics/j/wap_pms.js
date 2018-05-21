//读取用户PMS信息
$(document).ready(function(){
	$.post('/pms/operate.php'
            , {
			type : 'getNewPms'
              }
            , function(data) {
                if (data.ok) {
                	showPms(data.msg);
                }
            }
            , 'json'
        );	
});	
function showPms(msg) {
	var h1 = $(".topCenter").find('h1').eq(0);
	if (typeof(h1) == 'undefined' ) return ;
	var html = "<em style=\"display:none;\"><strong>"+msg.subject+"</strong><u><a href=\"\/account\/user_center.php?p=pms\">查看所有</a></u></em>";
	$(h1).append(html);
}