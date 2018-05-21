document.writeln("<div class=\"betbox\"><div>"+
"<div class=\'bottomBet\'>"+
"        <div class=\"BetsD\">"+
"            <div id='selPan' style=\"\"><b id='selPanBtn'>已选<span>6</span>场</b><strong class=\"clearSel\"><a href=\"javascript:void(0);\">重选</a></strong>"+
"              <div class=\"FloatC\">"+
"              </div>"+
"          </div>"+
"        </div>"+
"<p><a href=\"javascript:void(0)\" onClick=\"document.getElementById('light1').style.display='block'\">下一步</a></p>"+
"<div id=\"light1\" class=\"white_content\">"+
"<h4>确认投注<span><a href=\"javascript:void(0)\" onClick=\"document.getElementById('light1').style.display='none'\">关闭</a></span></h4>"+
"     <table align=\"center\" border=\"0\">"+
"     <tr>"+
"     <td>"+
"     <div class=\"BetCheckC\">"+
"     <div id='options'>"+
"     <dl>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>2串1</dt>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>3串1</dt>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>4串1</dt>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>5串1</dt>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>6串1</dt>"+
"     <dt><input type=\"checkbox\" name=\"\"></dt>"+
"     <dt>7串1</dt>"+
"     </dl>"+
"     </div>"+
"     </div>"+
"     <td>"+
"     </tr>"+
"     <tr>"+
"     <td>"+
"     <div>"+
"        <div><span id='optionMorePan'></span></div>"+
"     <div>"+
"     <td>"+
"     </tr>"+
"     <tr>"+
"     <td>"+
"        <div class=\"Tbeishu\">"+
"            <ol>" +
"            <li class=\"t1\">倍数</li>" +
"            <li class=\"t2\"><a id=\"subBtn\" href=\"javascript:void(0);\">-</a></li>" +
"            <li class=\"t3\"><input type=\"text\" id=\"Multiple\" autocomplete=\"off\" maxlength=\"7\" value=\"1\" ></li>" +
"            <li class=\"t4\"><a id=\"addBtn\" href=\"javascript:void(0);\">+</a></li>" +
"            <ol>" +
"        <input class=\"none\" id=\"user_select\" value=\"\"/><input class=\"none\" id=\"user_select_count\" value=\"\"/>"+
"        </div>"+
"     <td>"+
"     </tr>"+
"     <tr>"+
"        <td><div class=\"betMoney\">金额<b id=\"betMoney\">元</b>奖金<span id=\"betBonus\" href=\"javascript:void(0);\">0元</span></div></td>"+
"     </tr>"+
"     <tr>"+
"     <td>"+
"        <div class=\"BetCheckT\">"+
"          <div class=\"touzhuSub\">"+
"            <input type=\"submit\" name=\"\" value=\"立即投注\" id=\"\" value=\"\"/>"+
"          </div>"+
"        </div>"+
"     <td>"+
"     </tr>"+
"     </table>"+
"</div>"+
"</div>"+
"</div></div>"
);

$("#mx").click(function() {
	if (getSelect() == "") return;
	var obj = $("#selDetailDiv");
//	if (obj.css("display") == "none") {
		$("#fade").show();
		$("#light1").show();
		obj.show();
	    obj.html("&nbsp;&nbsp;计算中，请稍等...（如果浏览器长时间无反应，请刷新页面）");
	    getPrizeDetail();
//	}
});
//隐藏明细
function closemx() {
	$("#fade").hide();
	$("#light1").hide();
}

function chaiMin(typeId){
	$(".chai").hide();
	var obj = $("#min_"+typeId);
	obj.show();
}
function chaiMax(typeId){
	$(".chai").hide();
	var obj = $("#max_"+typeId);
	obj.show();
}
function getPrizeDetail() {
	var urlstr = Domain + '/ticket/detail.php';
	$.post(urlstr
	        , {
		type:'json',
		s:curPos.gameCode,
		select:getSelect(),
		c:getCombination(),
		multiple:getMultiple(),
		money:getMoney()
	          }
	        , function(data) {
	            if (data.ok) {
	            	detail(data.msg);
	            } else {
	            	alert(data.msg);
	            }
	            return;
	        }
	        , 'json'
	    );
}	
function detail(msg) {
	var html = '<h1>奖金计算器<i><a href="javascript:void(0)" onClick="closemx();">关闭</a></i></h1>';
	
	html += '<div>';
	html += '<div class="overlay"><span><img src="'+Domain+'/www/statics/i/mini_warning.png"></span>注：奖金评测的为即时竞彩奖金指数，最终实际奖金请按照出票后票样中的指数计算，该奖金评测计算中已包含单一玩法的奖金，仅供参考。</div>';
	html += '<div>';
	html += '<div class="Mingxibiao">';
	
	html += '<h2>投注方案';
//	html += '<em>过关方式：';
//	for (var key in msg.select){
//		html += msg.select[key] +'&nbsp;&nbsp;';
//	}
//	html += '&nbsp;&nbsp;&nbsp;倍数：<b>'+msg.multiple+'倍</b> 方案总金额：<span>&yen;'+msg.money+'元</span>
//	html += '</em>';
	html += '</h2>';
	html += '</div>';        
	html += '<div>';          
	html += '<table class="hacker" border="0" cellpadding="0" cellspacing="0">';            
	html += '<tr>';            
	html += '<th>赛事编号</th>';
	html += '<th>对阵</th>';
	html += '<th>您的选择</th>';
	html += '<th>最小赔率</th>';
	html += '<th style="border-right:1px solid #545454;">最大赔率</th>';
	html += '</tr>';
	html += '<tr>';
	
	for (var key in msg.matchInfo) {
		html += '<td>'+ msg.matchInfo[key].num + '</td>';
		if(msg.sport == 'bk') {
			html += '<td>'+ msg.matchInfo[key].a_cn + '&nbsp;VS&nbsp;'+ msg.matchInfo[key].h_cn +'</td>';
		} else {
			html += '<td>'+ msg.matchInfo[key].h_cn + '&nbsp;VS&nbsp;'+ msg.matchInfo[key].a_cn +'</td>';
		}
		html += '<td><p>';
		for (var key1 in msg.matchInfo[key].options) {
			html += msg.matchInfo[key].options[key1];
		}
		html += '</p></td>';
		html += '<td>' + msg.spInfo[key].min_sp + '</td>';
		html += '<td style="border-right:1px solid #fff;">' + msg.spInfo[key].max_sp + '</td>';
		html += '</tr>';
	}
	
	html += '<tr>';
	html += '<td colspan="5" style="background:#fff;border-right:1px solid #fff;border-bottom:none;">';
	html += '过关方式：<span style="color:#0B7A01; font-size:14px;">';
	for (var key in msg.select){
		html += msg.select[key] +'&nbsp;&nbsp;';
	}
	html += '</span>';
	html += '倍数：' + msg.multiple + '&nbsp;&nbsp;&nbsp;';
	html += '方案总金额：<span style="color:#dc0000; font-size:14px;">&yen;'  + msg.money + '元</span>';
	html += '</td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';             
	html += '</div>'; 
	html += '<div>';
	html += '<div class="Mingxibiao">';
	html += '<h2>奖金明细</h2>';
	html += '</div>';          
	html += '<div>'; 
	
	html += '<table class="hacker" border="0" cellpadding="0" cellspacing="0" style="border-bottom:none;">';
	html += '<tr>';
	html += '<th width="80">命中场数</th>';              
	html += '<th><div class="zshu">';
	for(var key in msg.select) {
		html += '<p style="color:#fff;">'+msg.select[key] +'</p>';
	}
	html += '</div></th>';
	html += '<th width="350" style="border-right:1px solid #6f6f6f;"><div class="jjFw">';
	html += '<ul>';
	html += '<li>最小</li>';
	html += '<li style="padding:0 40px;">奖金范围</li>';
	html += '<li><span>最大</span></li>';
	html += '</ul>';
	html += '</div></th>';
	html += '</tr>';	
     		
    for (var key in msg.detail){
    	html += '<tr>';
    	html += '<td>' + key + '</td>';
    	html += '<td><div class="jjC"><p>';
    	for (var key1 in msg.select){
    		html += '<strong>' + msg.detail[key][msg.select[key1]].hit_num + '</strong>';
    	}
    	html += '</p></div></td>';
    	html += '<td style="border-right:none;"><div class="MXLisT">';
    	html += '<ul>';
    	html += '<li class="show"><strong>&yen;'+ msg.detail[key].min_money +'元</strong><a href="javascript:void(0);"  onClick="chaiMin('+key+');">明细&nbsp;&rsaquo;</a></li>';
    	html += '<li><b>&yen;'+ msg.detail[key].max_money +'元</b><a href="javascript:void(0);" onClick="chaiMax('+key+');">明细&rsaquo;</a></li>';
    	html += '</ul></div></td></tr>';
    }
    html += '</table></div></div>';
    
	      
//    html += '<div>';
//    html += '<div class="Mingxibiao">';
//    html += '<h2>拆分明细</h2>';
//    html += '</div>';
    
    html += '<div>';
    //最小情况
    for (var key in msg.detail){
    	html += '<table class="hacker chai none" id="min_'+key+'" border="0" cellpadding="0" cellspacing="0" style="margin:12px 0 0 0;">';
        html += '<tr>';
        html += '<th>过关方式</th>';
        html += '<th>中奖注数</th>';
        html += '<th>中奖明细</th>';
        html += '<th>奖金</th>';
        html += '</tr>';
        
        var zhushu = 0;
        var total_sum = 0;
        
        for (var key1 in msg.select){
        	if (msg.detail[key][msg.select[key1]].hit_num > 0){
        	var col_sum = 0;
        
        	html += '<tr>';
            html += '<td>'+ msg.select[key1] +'</td>';
            html += '<td>'+ msg.detail[key][msg.select[key1]].hit_num +'</td>';
            zhushu += msg.detail[key][msg.select[key1]].hit_num;
            html += '<td><div class="jjmxi">';
            for (var key2 in msg.detail[key][msg.select[key1]].prize_detail_min){
            	
            	html += '<p>';
            	var zhu_money = msg.multiple*2;
            	for (var key3 in msg.detail[key][msg.select[key1]].prize_detail_min[key2]){
            		zhu_money *= msg.detail[key][msg.select[key1]].prize_detail_min[key2][key3];
            		html += msg.detail[key][msg.select[key1]].prize_detail_min[key2][key3] +'x';
                 }
                 zhu_money = Math.round(zhu_money * 100)/100;
            	html +=  '2x' + msg.multiple+'倍=<b>&yen;'+ zhu_money +'</b></p>';
            }
            col_sum += zhu_money;
            html += '</div></td>';
            html += '<td style="border-right:none;"><div class="JJa">&yen;' + msg.detail[key][msg.select[key1]].prize_detail_min_money + '元</div></td>';
            html += '</tr>';
        }
        }
        html += '<tr>';
        html += '<td  colspan="4" class="cwhite" align="right" style="padding:0 50px 0 0;border-bottom:none;border-right:none;background:#fff;">合计&nbsp;<span style="color:#0B7A01; font-size:14px;">';
        html += zhushu +'注</span><strong style="font-size:14px;color:#dc0000;">&nbsp;&yen;' + msg.detail[key].min_money + '元</strong></td>';
        html += '</tr>';
        html += '</table>';
    }
    //最大情况
    for (var key in msg.detail){
    	html += '<table class="hacker chai none" id="max_'+key+'" border="0" cellpadding="0" cellspacing="0" style="margin:12px 0 0 0;">';
        html += '<tr>';
        html += '<th>过关方式</th>';
        html += '<th>中奖注数</th>';
        html += '<th>中奖明细</th>';
        html += '<th style="border-right:none;">奖金</th>';
        html += '</tr>';
        
        var zhushu = 0;
        var total_sum = 0;
        
        for (var key1 in msg.select){
        	if (msg.detail[key][msg.select[key1]].hit_num > 0){
        	var col_sum = 0;
        
        	html += '<tr>';
            html += '<td>'+ msg.select[key1] +'</td>';
            html += '<td>'+ msg.detail[key][msg.select[key1]].hit_num +'</td>';
            zhushu += msg.detail[key][msg.select[key1]].hit_num;
            html += '<td><div class="jjmxi">';
            for (var key2 in msg.detail[key][msg.select[key1]].prize_detail_max){
            	
            	html += '<p>';
            	var zhu_money = msg.multiple*2;
            	for (var key3 in msg.detail[key][msg.select[key1]].prize_detail_max[key2]){
            		zhu_money *= msg.detail[key][msg.select[key1]].prize_detail_max[key2][key3];
            		html += msg.detail[key][msg.select[key1]].prize_detail_max[key2][key3] +'x';
                 }
                 zhu_money = Math.round(zhu_money * 100)/100;
            	html +=  '2x' + msg.multiple+'倍=<b>&yen;'+ zhu_money +'</b></p>';
            }
            col_sum += zhu_money;
            html += '</div></td>';
            html += '<td style="border-right:none;"><div class="JJa">&yen;' + msg.detail[key][msg.select[key1]].prize_detail_max_money + '元</div></td>';
            html += '</tr>';
        }
        }
        html += '<tr>';
        html += '<td  colspan="4" class="cwhite" align="right" style="padding:0 50px 0 0;border-bottom:none;border-right:none;background:#fff;">合计&nbsp;<span style="color:#0B7A01; font-size:14px;">';
        html += zhushu +'注</span><strong style="font-size:14px;color:#dc0000;">&nbsp;&yen;' + msg.detail[key].max_money + '元</strong></td>';
        html += '</tr>';
        html += '</table>';
    }   
	html += ' </div>';    
	html += ' </div>';    
	html += ' </div>';
	$("#selDetailDiv").html(html);
}