<?php /* Smarty version 2.6.17, created on 2018-03-04 23:25:45
         compiled from confirm/bk_crosspool.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/bk_crosspool.html', 407, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

var curPool = "crosspool";

var curPos = { gameCode: "bk", gameType: "竞彩篮球", poolName: "混合过关", dataPool: "mnl,hdc,wnm,hilo" };

var matchData = {};

function getDataBack(data) {
					
				if (Number(data.total) == 0) {
		            alert("暂无开售赛事！");
		            return;
		        }

		        var matchNameAry = [];

		        var tmpAry = data.datas;

		        var filterHtm = "";

		        var htmStr = "<tr>";

		        for (var i = 0; i < tmpAry.length; i++) {

		            var obj = tmpAry[i];

		            htmStr += "<div><tr class='time'><td id='tdwin'><div class='DQtime'><b>" + obj.num + "&nbsp;" + obj.day + "</b><span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>&nbsp;显示已隐藏比赛<b>[<label class='hideNum'>0</label>]</b>场</a></strong></div></td></tr>";

		            htmStr += "<tr d='" + i + "'><td><table cellpadding='0' cellspacing='1' id='TabWin'>";

		            var listObj = obj.matchs[0];

		            var count = 0;

		            for (var key in listObj) {

		                count++;

		                var matchObj = listObj[key];

		                matchData[key] = matchObj.wnm;

		                var isFind = -1;

		                for (var j = 0; j < matchNameAry.length; j++) {

		                    if (matchNameAry[j].name == matchObj.l_cn) {

		                        isFind = j;

		                        matchNameAry[j].len++;

		                        break;

		                    }

		                }

		                if (isFind < 0) {

		                    isFind = matchNameAry.length;

		                    matchNameAry.push({ name: matchObj.l_cn, len: 1 });

		                }

		                htmStr += "<tr m='" + isFind + "' id='" + key + "' class='" + ((count % 2 == 0) ? " alt" : "") + ((matchObj.end == 1)?" game_end" : "")+"'>" +
		                
		                "  <td class='d1'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></td>" +

		                "  <td style='width:66px;padding:0;'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</div></td>" +

		                "  <td class='d3' style='width:125px;'>" + matchObj.date + "&nbsp;" + matchObj.time + "</td>" +

		                "  <td><div class='duiName'>" +

		                "      <ul>" +

		                "        <li class='left'><hn>" +matchObj.a_cn+ "</hn></li>" +

		                "        <li class='vs'>VS</li>" +

		                "        <li class='show'><gn>" +matchObj.h_cn+ "</gn></li>" +

		                "      </ul>" +

		                "    </div></td>" +

		                "  <td width='123'><div class='bkcross'>" +

		                "      <ul>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.mnl == undefined) ? "" : matchObj.mnl.a) + "</a></li>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.mnl == undefined) ? "" : matchObj.mnl.h) + "</a></li>" +

		                "      </ul>" +

		                "      <div class='clear'></div>" +

		                "    </div></td>" +

		                "  <td width='200'><div class='bkcross'>" +

		                "      <ul>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hdc == undefined) ? "" : matchObj.hdc.a) + "</a></li>" +

		                "        <li class='activeShow AsK'><b class='line' pool='hdc' href='javascript:void(0);'>" + matchObj.hdc.goalline + "</b></li>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hdc == undefined) ? "" : matchObj.hdc.h) + "</a></li>" +

		                "      </ul>" +

		                "    </div>" +

		                "  <td width='200'><div class='bkcross'>" +

		                "      <ul>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.h) + "</a></li>" +

		                "        <li class='activeShow AsK'><strong class='line' pool='hilo' href='javascript:void(0);'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.goalline) + "</strong></li>" +

		                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.l) + "</a></li>" +

		                "      </ul>" +

		                "    </div>" +

		                "   </td>" +

		                "  <td width='68'><div ><a class='openOtherPool' href='javascript:void(0);'>展开</a></div></td>" +

		                "</tr>" +

		              "<tr a=1>"

		              "</tr>";

		            }

		            htmStr += "</table></td></tr>";

		            htmStr += "</div>";

		            filterHtm += "<em><input type='checkbox' checked />" + obj.num + "[" + count + "]</em>";

		        }

		        htmStr += "</tr>";

		        $("#dataList").html(htmStr);

		        $("#tip").html("");

		        //filterPan

		        $("#fDate").html(filterHtm);

		        filterHtm = "";

		        filterHtm = "";

		        for (var i = 0; i < matchNameAry.length; i++) {

		            filterHtm += "<em><input type='checkbox' checked />" + matchNameAry[i].name + "[" + matchNameAry[i].len + "]</em>";

		        }

		        $("#fMatches").html(filterHtm);



		        //展开按钮

		        $("#dataList .openOtherPool").click(function() {

		            var obj = $(this).closest("tr").next();

		            if (obj.html() == "") {

		                var tmpData = matchData[$(this).closest("tr").attr("id")];

		                if (tmpData == undefined) {

		                    obj.html("<td colspan='9' style='padding:0; margin:0; background:#fff;'><div class='OddsTd noneDade'>没有数据！</div></td>");

		                } else {

		                    obj.html(" <td colspan='9' style='padding:0; margin:0; background:#fff;'>" +

		              "        <div class='bkcrosspool'>" +

		              "            <dl>" +

		              "              <dt style='width:50px;border:none;'><b>分差&nbsp;&nbsp;&nbsp;</b></dt>" +

		              "              <dt><b>1-5</b></dt>" +

		              "              <dt><b>6-10</b></dt>" +

		              "              <dt><b>11-15</b></dt>" +

		              "              <dt><b>16-20</b></dt>" +

		              "              <dt><b>21-25</b></dt>" +

		              "              <dt><b>26+</b></dt>" +

		              "              <dt class='show'><b class='clear'><a class='closeOtherPool' href='javascript:void(0);'>关闭</a></b></dt>" +

		              "            </dl>" +

		              "            <dl>" +

		              "              <dd style='width:50px;border:none;'><strong>客胜</strong></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l1 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l2 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l3 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l4 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l5 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.l6 + "</a></b></dd>" +

		             // "              <dd class='show'><b class='clear'><a class='clearAllOdds' href='javascript:void(0);'>全清</a></b></dd>" +

		              "            </dl>" +

		              "            <dl>" +

		              "              <dd style='width:50px;border:none;'><strong>主胜</strong></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w1 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w2 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w3 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w4 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w5 + "</a></b></dd>" +

		              "              <dd><b><a class='o' href='javascript:void(0);'>" + tmpData.w6 + "</a></b></dd>" +

		              //"              <dd class='show'><b class='clear'><a class='closeOtherPool' href='javascript:void(0);'>关闭</a></b></dd>" +

		              "            </dl>" +

		              "          </div>" +

		              "      </td>");

		                }



		                //全选按钮

		                obj.find(".selAllOdds").click(function() {

		                    var obj = $(this).closest("tr").prev();

		                    var oObj = $(this).closest(".LcOtherC").find(".o");



		                    //selAry

		                    var key = $(this).closest("tr").prev().attr("id");

		                    if (selAry[key] == undefined) {

		                        selAry[key] = {};

		                        if (curPos.gameCode == "fb") {

		                            selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

		                        } else {

		                            selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

		                        }



		                        selAry[key].num = obj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + obj.find(".hideMatch").text();

		                        selAry[key].hostTeam = obj.find("hn").text();

		                        selAry[key].guestTeam = obj.find("gn").text();

		                        //if (curPool == "had") selAry[key].goalLine = obj.attr("l");

		                        //判断场数

		                        if (!checkSelCount()) {

		                            //$(this).removeClass("active");

		                            return;

		                        }

		                    }




		                    oObj.addClass("active");

		                    oObj.each(function() {

		                        var index = oObj.index($(this));

		                        selAry[key].odds[index + 6] = $(this).text();

		                    });

		                    //

		                    fillSelPan();

		                    fillOptionsPan();

		                    calculate();

		                });

		                //全清按钮

		                obj.find(".clearAllOdds").click(function() {

		                    $(this).closest(".LcOtherC").find(".o").removeClass("active");

		                    //selAry

		                    var oObj = $(this).closest(".LcOtherC").find(".o");

		                    var key = $(this).closest("tr").prev().attr("id");

		                    if (selAry[key] != undefined) {

		                        oObj.each(function() {

		                            var index = oObj.index($(this));

		                            selAry[key].odds[index + 6] = 1;

		                        });



		                        if (eval(selAry[key].odds.join("*")) == 1) {

		                            delete (selAry[key]);

		                        }



		                        fillSelPan();

		                        fillOptionsPan();

		                        calculate();

		                    }

		                });

		                //关闭按钮

		                obj.find(".closeOtherPool").click(function() {

		                    $(this).closest("tr").hide();

		                });



		            } else {

		                obj.show();

		            }



		        });

		        //默认第一展开

		        $("#dataList .openOtherPool:eq(0)").click();

		    }
	
</script>
<script src="<?php echo ((is_array($_tmp='publicFunc.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<body>
<!--top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--nav start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--nav end-->
<!--caipiao location start-->
<div class="Cailocation">
  <div class="location_center">
    <h1><b>竞猜篮球&nbsp;&gt;&nbsp;混合过关</b><a href="/basketball/hdc_list.php">让分胜负<em></em></a><a href="/basketball/bk_crosspool.php" class="active">混合过关</a><a href="/basketball/wnm_list.php">胜分差</a><a href="/basketball/hilo_list.php">大小分</a><span style="float:right;font-size:12px;">开停售时间：周一/周二/周五早9:00-晚23:50；周三/周四早7:30-23:50；周六、周日早9:00-次日00:50。</span></h1>
  </div>
</div>
<!--caipiao location end-->

<!--center start-->
<div class="center">
  <div class="BitCenter">
    <div class="touzhuNav">
      <ul>
        <li><a href="<?php echo @ROOT_WEBSITE; ?>
/help/showLgz.html">玩法规则</a></li>
        <li><a href="http://news.zhiying365365.com/saishi/index.php" class="active">销售公告</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <script src="<?php echo ((is_array($_tmp='filter.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
    <div>
      <div class="Kjnav">
        <div class="NavHgg">
          <dl class="one">
            <dt>序号</dt>
          </dl>
          <dl class="two">
            <dt>赛事</dt>
          </dl>
          <dl class="three">
            <dt>截止时间</dt>
          </dl>
          <dl class="four">
            <dt><b>客队</b>&nbsp;&nbsp;VS&nbsp;&nbsp;<b>主队</b></dt>
          </dl>
          <dl class="six">
            <dt>胜负投注区</dt>
            <dd><b>客胜</b><b>主胜</b></dd>
          </dl>
          <dl class="seven">
            <dt class='rfsf'><em>
              <div class="tipBox tipBoxA">
                <div class="hd" style="left:0;"> <s class="arrow arrowT"><s></s></s> </div>
                <div class="bd">负数表示主让客，正数表示客让主，此数值很可能会随时变化，请以实际出票后的票样信息为准。</div>
              </div>
              </em>让分胜负投注区</dt>
            <dd><b>客胜</b><b>让分值</b><b>主胜</b></dd>
          </dl>
          <dl class="eight">
            <dt class="dxf"><em>
              <div class="tipBox tipBoxA">
                <div class="hd" style="left:8px;"> <s class="arrow arrowT"><s></s></s> </div>
                <div class="bd">此数值很可能会随时变化，请以实际出票后的票样信息为准。</div>
              </div>
              </em>大小分投注区</dt>
            <dd><b>大分</b><b>界限值</b><b>小分</b></dd>
          </dl>
          <dl class="nine">
            <dt><b>胜分差<br/>
              投注区</b></dt>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
      <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="1">
      </table>
    </div>
  </div>
  <!--投注center end-->
</div>
<!--mp start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/mp.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--mp end-->
<!--center end-->
<!--确认投注 strat-->
<script src="<?php echo ((is_array($_tmp='betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<!--确认投注 end-->
<!--投注提示 start-->
<div class="Tiptouz">
  <div class="Tiptouzc">
    <p><b>竞彩篮球投注提示：</b></p>
    <p>1、竞猜全场比赛，包含加时赛。</p>
    <p>2、让分只适合“让分胜负”玩法,“+”为客让主，“-”为主让客。</p>
    <p>3、胜负、让分胜负、大小分玩法最多过8关，胜分差玩法最多过4关。</p>
    <p>4、页面中的固定奖金、预设让分数、预设总分数发生变化时，投注和兑奖时均以出票时刻的奖金、让分数、总分数为准。</p>
    <p>5、单场投注，单注最高奖金限额为10万元；2或3场过关投注，单注最高奖金限额为20万元；4或5场过关投注，单注最高奖金限额为50万元；6场过关投注，单注最高奖金限额100万元</p>
    <p>6、单注彩票保底奖金：如果单注奖金不足2元，则补足至2元。</p>
    <p><span>7、竞彩篮球开停售时间：周一/周二/周五早9:00-晚23:50；周三/周四早7:30-23:50；周六、周日早9:00-次日00:50。</span></p>

  </div>
</div>
<!--投注提示 end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>