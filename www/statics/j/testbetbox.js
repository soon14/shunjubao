document
		.writeln("<div class=\"betbox\">"
				+ "        <div>"
				+ "        <table>"
				+ "        <tr>"
				+ "        <td>"
				+ "        <div class=\"BetsD\">"
				+ "          <div class=\"shedan\"><strong><a id='selPanBtn' href=\"javascript:void(0);\">已选<span>6</span>场</a></strong>"
				+ "            <div id='selPan' class=\"Flaotbox\">"
				+ "              <div class=\"flaotboxtop\">"
				+ "                <ul>"
				+ "                  <li class=\"bianhao\">场次</li>"
				+ "                  <li class=\"zhu\">主队</li>"
				+ "                  <li class=\"ke\">客队</li>"
				+ "                  <li class=\"cc\">我的选择</li>"
				+ "                  <li class=\"clearSel six\"><a href=\"javascript:void(0)\">全删</a></li>"
				+ "                </ul>"
				+ "                <div class=\"clear\"></div>"
				+ "              </div>"
				+ "              <div class=\"FloatC\">"
				+ "              </div>"
				+ "            </div>"
				+ "          </div>"
				+ "        </div>"
				+ "        </td>"
				+ "        <td>"
				+ "        <div class=\"BetCheckC\">"
				+ "        <dl>"
				+ "        <dt>"
				+ "        <ul>"
				+ "        <li>"
				+ "            <div id='options'><b>过<em></em>关：</b>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>2串1</span>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>3串1</span>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>4串1</span>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>5串1</span>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>6串1</span>"
				+ "              <input type=\"checkbox\" name=\"\">"
				+ "              <span>7串1</span>"
				+ "        </div>"
				+ "        </li>"
				+ "        <li>"
				+ "              <div class=\"cMore\"><a href=\"javascript:void(0)\">"
				+ "                <span>更多<b>&uarr;</b></span></a>"
				+ "                <p><strong>&nbsp;</strong><b>过关方式对照表<u><a class='hideMore' href=\"javascript:void(0);\">关闭</a></u></b><span id='optionMorePan'><a href=\"\">2串1</a><br/>"
				+ "                  <a href=\"\">3串1</a><a href=\"\">3串4</a><br/>"
				+ "                  <a href=\"\">4串1</a><a href=\"\">4串2</a><a href=\"\">4串3</a><br/>"
				+ "                  <a href=\"\">2串3</a><a href=\"\">1串2</a><a href=\"\">4串3</a><a href=\"\">1串2</a><br/>"
				+ "                  <a href=\"\">2串3</a><a href=\"\">1串2</a><a href=\"\">1串2</a><a href=\"\">4串3</a><a href=\"\">1串2</a><br/>"
				+ "                  <a href=\"\">1串3</a><a href=\"\">2串3</a><a href=\"\">1串2</a><a href=\"\">1串2</a><a href=\"\">4串3</a><a href=\"\">2串3</a><br/>"
				+ "                  <a href=\"\">3串1</a><a href=\"\">3串4</a><a href=\"\">2串3</a><br/>"
				+ "                  <a href=\"\">4串1</a><a href=\"\">4串2</a><a href=\"\">4串3</a><a href=\"\">1串2</a><br/>"
				+ "                  <a href=\"\">3串1</a><a href=\"\">3串4</a><br/>"
				+ "                  <a href=\"\">4串1</a><a href=\"\">1串2</a><a href=\"\">4串2</a><a href=\"\">4串3</a><br/>"
				+ "                  <a href=\"\">3串1</a><a href=\"\">3串4</a><a href=\"\">2串3</a><br/>"
				+ "                  <a href=\"\">4串1</a><a href=\"\">4串2</a><a href=\"\">4串3</a><br/></span>"
				+ "                  <b><u><a class='hideMore' href=\"javascript:void(0);\">隐藏</a></u></b></p>"
				+ "              </div>"
				+ "        </li>"
				+ "        </ul>"
				+ "        </dt>"
				+ "        <dd>"
				+ "            <div class=\"Tbeishu\">"
				+ "            <ol>"
				+ "            <li class=\"show\">倍数：</li>"
				+ "            <li><a id=\"subBtn\" href=\"javascript:void(0);\" class=\"\">-</a></li>"
				+ "            <li class=\"text\"><input type=\"text\" id=\"Multiple\" autocomplete=\"off\" maxlength=\"7\" value=\"1\" ></li>"
				+ "            <li><a id=\"addBtn\" href=\"javascript:void(0);\" class=\"\">+</a></li>"
				+ "            <li class=\"first\"><u>金额：</u><b id=\"betMoney\">元</b></li>"
				+ "            <li class=\"lx\">奖金：<em><span id=\"betBonus\" href=\"javascript:void(0);\">0元</span></em></li>"
				+ "            <li id=\"mx\">理论奖金</li>"
				+ "            <li class=\"clearSel\"><a href=\"javascript:void(0);\">重选</a></li>"
				+ "            <li class=\"yh\"><a id=\"jjyh\" style=\"color:#fff;\">奖金优化</a></li>"
				+ "            <ol>"
				+ "            </div>"
				+ "          </div><input class=\"none\" id=\"user_select\" value=\"\"/><input class=\"none\" id=\"user_select_count\" value=\"\"/>"
				+ "        </dd>"
				+ "        <div>"
				+ "        </dl>"
				+ "        </td>"
				+ "        <td>"
				+ "        <div class=\"BetCheckT\">"
				+ "          <div class=\"touzhuSub\">"
				+ "            <input type=\"submit\" name=\"\" value=\"立即投注\" id=\"\" value=\"\"/>"
				+ "          </div>"
				+ "        </div>"
				+ "        </td>"
				+ "        <tr>"
				+ "        </table>"
				+ "        </div>"
				+ "      </div>");
$("#mx").click(function() {
	if (getSelect() == "")
		return;
	var obj = $("#selDetailDiv");
	// if (obj.css("display") == "none") {
	$("#fade").show();
	$("#light1").show();
	obj.show();
	obj.html("&nbsp;&nbsp;计算中，请稍等...（如果浏览器长时间无反应，请刷新页面）");
	getPrizeDetail();
	// }
});
// 隐藏明细
function closemx() {
	$("#fade").hide();
	$("#light1").hide();
}

function chaiMin(typeId) {
	$(".chai").hide();
	var obj = $("#min_" + typeId);
	obj.show();
}
function chaiMax(typeId) {
	$(".chai").hide();
	var obj = $("#max_" + typeId);
	obj.show();
}
function getPrizeDetail() {
	var urlstr = Domain + '/ticket/detail.php';
	$.post(urlstr, {
		type : 'json',
		s : curPos.gameCode,
		select : getSelect(),
		c : getCombination(),
		multiple : getMultiple(),
		money : getMoney()
	}, function(data) {
		if (data.ok) {
			detail(data.msg);
		} else {
			alert(data.msg);
		}
		return;
	}, 'json');
}
function detail(msg) {
	var html = '<h1>奖金计算器<i><a href="javascript:void(0)" onClick="closemx();">关闭</a></i></h1>';

	html += '<div>';
	var tips = '注：奖金评测的为即时竞彩奖金指数，最终实际奖金请按照出票后票样中的指数计算，该奖金评测计算中已包含单一玩法的奖金，仅供参考。';
	if (msg.sport == 'bd') {
		tips = '注：奖金评测的为北单即时奖金指数，最终实际奖金按照北单官方给定的指数计算，仅供参考。';
	}

	html += '<div class="overlay"><span><img src="' + Domain
			+ '/www/statics/i/mini_warning.png"></span>' + tips + '</div>';
	html += '<div>';
	html += '<div class="Mingxibiao">';

	html += '<h2>投注方案</h2>';
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

	for ( var key in msg.matchInfo) {
		html += '<td>' + msg.matchInfo[key].num + '</td>';
		if (msg.sport == 'bk') {
			html += '<td>' + msg.matchInfo[key].a_cn + '&nbsp;VS&nbsp;'
					+ msg.matchInfo[key].h_cn + '</td>';
		} else {
			html += '<td width="220"><div class="Dname"><b>'
					+ msg.matchInfo[key].h_cn + '</b><span>VS</span><strong>'
					+ msg.matchInfo[key].a_cn + '</strong></div></td>';
		}
		html += '<td><p>';
		for ( var key1 in msg.matchInfo[key].options) {
			html += msg.matchInfo[key].options[key1];
		}
		html += '</p></td>';
		html += '<td>' + msg.spInfo[key].min_sp + '</td>';
		html += '<td style="border-right:1px solid #fff;">'
				+ msg.spInfo[key].max_sp + '</td>';
		html += '</tr>';
	}

	html += '<tr>';
	html += '<td colspan="5" class="tdcc" style="border-bottom:none;border-right:none;">';
	html += '过关方式：';
	for ( var key in msg.select) {
		html += msg.select[key] + '&nbsp;&nbsp;';
	}
	html += '倍数：' + msg.multiple + '&nbsp;&nbsp;&nbsp;';
	html += '方案总金额：<span>'
			+ msg.money + '元</span>';
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
	for ( var key in msg.select) {
		html += '<p style="color:#fff;">' + msg.select[key] + '</p>';
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

	for ( var key in msg.detail) {
		html += '<tr>';
		html += '<td>' + key + '</td>';
		html += '<td style="border-right:none;"><div class="jjC"><p>';
		for ( var key1 in msg.select) {
			html += '<strong>' + msg.detail[key][msg.select[key1]].hit_num
					+ '</strong>';
		}
		html += '</p></div></td>';
		html += '<td style="border-right:none;"><div class="MXLisT">';
		html += '<ul>';
		html += '<li><strong>' + msg.detail[key].min_money
				+ '</strong><a href="javascript:void(0);"  onClick="chaiMin('
				+ key + ');">明细</a></li>';
		html += '<li class="show"><b>' + msg.detail[key].max_money
				+ '</b><a href="javascript:void(0);" onClick="chaiMax(' + key
				+ ');">明细</a></li>';
		html += '</ul></div></td></tr>';
	}
	html += '</table></div></div>';

	html += '<div>';
	// 最小情况
	for ( var key in msg.detail) {
		html += '<table class="hacker chai none" id="min_'
				+ key
				+ '" border="0" cellpadding="0" cellspacing="0" style="margin:12px 0 0 0;">';
		html += '<tr>';
		html += '<th>过关方式</th>';
		html += '<th>中奖注数</th>';
		html += '<th>中奖明细</th>';
		html += '<th style="border-right:none;">奖金</th>';
		html += '</tr>';

		var zhushu = 0;
		var total_sum = 0;

		for ( var key1 in msg.select) {
			if (msg.detail[key][msg.select[key1]].hit_num > 0) {
				var col_sum = 0;

				html += '<tr>';
				html += '<td>' + msg.select[key1] + '</td>';
				html += '<td>' + msg.detail[key][msg.select[key1]].hit_num
						+ '</td>';
				zhushu += msg.detail[key][msg.select[key1]].hit_num;
				html += '<td><div class="jjmxi">';
				for ( var key2 in msg.detail[key][msg.select[key1]].prize_detail_min) {

					html += '<p>';
					var zhu_money = msg.multiple * 2;
					if(msg.sport == 'bd') zhu_money = zhu_money * 0.65;//北单需要×65%
					
					for ( var key3 in msg.detail[key][msg.select[key1]].prize_detail_min[key2]) {
						zhu_money *= msg.detail[key][msg.select[key1]].prize_detail_min[key2][key3];
						html += msg.detail[key][msg.select[key1]].prize_detail_min[key2][key3]
								+ 'x';
					}
					zhu_money = Math.round(zhu_money * 100) / 100;
					if(msg.sport == 'bd') {
						html += '2x' + msg.multiple + '倍x65%=<b>&yen;' + zhu_money
						+ '</b></p>';
					} else {
						html += '2x' + msg.multiple + '倍=<b>&yen;' + zhu_money
						+ '</b></p>';
					}
				}
				col_sum += zhu_money;
				html += '</div></td>';
				html += '<td style="border-right:none;"><div class="JJa">'
						+ msg.detail[key][msg.select[key1]].prize_detail_min_money
						+ '</div></td>';
				html += '</tr>';
			}
		}
		html += '<tr>';
		html += '<td  colspan="4" class="tdcc" style="border-bottom:none;border-right:none;">合计';
		html += zhushu
				+ '注<span>'
				+ msg.detail[key].min_money + '元</span></td>';
		html += '</tr>';
		html += '</table>';
	}
	// 最大情况
	for ( var key in msg.detail) {
		html += '<table class="hacker chai none" id="max_'
				+ key
				+ '" border="0" cellpadding="0" cellspacing="0" style="margin:12px 0 0 0;">';
		html += '<tr>';
		html += '<th>过关方式</th>';
		html += '<th>中奖注数</th>';
		html += '<th>中奖明细</th>';
		html += '<th style="border-right:none;">奖金</th>';
		html += '</tr>';

		var zhushu = 0;
		var total_sum = 0;

		for ( var key1 in msg.select) {
			if (msg.detail[key][msg.select[key1]].hit_num > 0) {
				var col_sum = 0;

				html += '<tr>';
				html += '<td>' + msg.select[key1] + '</td>';
				html += '<td>' + msg.detail[key][msg.select[key1]].hit_num
						+ '</td>';
				zhushu += msg.detail[key][msg.select[key1]].hit_num;
				html += '<td><div class="jjmxi">';
				for ( var key2 in msg.detail[key][msg.select[key1]].prize_detail_max) {

					html += '<p>';
					var zhu_money = msg.multiple * 2;
					if(msg.sport == 'bd') zhu_money = zhu_money * 0.65;//北单需要×65%

					for ( var key3 in msg.detail[key][msg.select[key1]].prize_detail_max[key2]) {
						zhu_money *= msg.detail[key][msg.select[key1]].prize_detail_max[key2][key3];
						html += msg.detail[key][msg.select[key1]].prize_detail_max[key2][key3]
								+ 'x';
					}
					zhu_money = Math.round(zhu_money * 100) / 100;
					if(msg.sport == 'bd') {
						html += '2x' + msg.multiple + '倍x65%=<b>&yen;' + zhu_money
						+ '</b></p>';
					} else {
						html += '2x' + msg.multiple + '倍=<b>&yen;' + zhu_money
						+ '</b></p>';
					}
				}
				col_sum += zhu_money;
				html += '</div></td>';
				html += '<td colspan="4"><span>'
						+ msg.detail[key][msg.select[key1]].prize_detail_max_money
						+ '元</span></td>';
				html += '</tr>';
			}
		}
		html += '<tr>';
		html += '<td  colspan="4" class="tdcc" style="border-bottom:none;border-right:none;">合计';
		html += zhushu
				+ '注<span>'
				+ msg.detail[key].max_money + '元</span></td>';
		html += '</tr>';
		html += '</table>';
	}
	html += ' </div>';
	html += ' </div>';
	html += ' </div>';
	$("#selDetailDiv").html(html);
}