$(document).ready(function(){
	$.post('http://www.shunjubao.xyz/prize/getPrize.php', {
		type : 1,
		limit : 40
	}, function(data) {
		var jishi_html = '';
		if(data.ok)
		{
			var data_msg = data.msg;
			jishi_html += "<dl><dt>最新中奖</dt>";
			for(var key in data_msg) {
				jishi_html += "<dd><b>"+data_msg[key].u_name+"</b><span>"+data_msg[key].prize+"元</span></dd>";
			}
			
			jishi_html += "</dl>"
			
		}
		$("#jishi").html(jishi_html);
	}, 'json'
	);
});