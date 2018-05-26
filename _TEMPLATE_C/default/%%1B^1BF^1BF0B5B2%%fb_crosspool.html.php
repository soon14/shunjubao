<?php /* Smarty version 2.6.17, created on 2018-03-04 23:05:15
         compiled from confirm/fb_crosspool.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/fb_crosspool.html', 396, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "crosspool";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "混合过关",dataPool:"had,hhad,crs,ttg,hafu" };

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

                matchData[key] = { crs: matchObj.crs, ttg: matchObj.ttg, hafu: matchObj.hafu ,end:matchObj.end};

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

                "  <td class='d3'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +

                "  <td class='d6'><div class='duiName'><b><hn>" + matchObj.h_cn + "</hn></b><u>VS</u><strong><gn>" + matchObj.a_cn + "</gn></strong></div></td>" +

                "  <td width='220'><div class='jchOddList'>" +

                "      <ul>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.h) + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.d) + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.a) + "</a></li>" +

                "      </ul>" +

                "    </div></td>" +

                 "  <td width='260'><div class='jchOddList'>" +

                "      <ul>" +

                "        <li class='first line' pool='hhad'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.goalline) + "</li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.h) + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.d) + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.a) + "</a></li>" +

                "      </ul>" +

                "    </div></td>" +

                "  <td><div><a class='openOtherPool' href='javascript:void(0);'>展开</a></div></td>" +

                "</tr>" +

                "<tr a=1 class='none " + ((matchObj.end == 1)?" game_end" : "")+"'>" +

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

        $("#dataList .openOtherPool").each(function() {

            var obj = $(this).closest("tr").next();


                var tmpData = matchData[$(this).closest("tr").attr("id")];

                if (tmpData == undefined) {

                    obj.html("<td colspan='8' style='padding:0; margin:0; background:#fff;'><div class='guoguanbifen OddsTd'>没有数据！</div></td>");

                } else {
                	
                	var data_html ="<td colspan='7' >" +
					
					"<div class='fbcrosspool'>";
					

					if (tmpData.crs != undefined) {
						
					data_html +=	
					
				"<dl class='bf'>" +
				
				"<dt><b>比分</b><span>(90分钟内，两队的比分)</span></dt>" +
				
				"<dd>" +
							
				"<p><a class='o' href='javascript:void(0);'><b>1:0</b><br/><label class='oddsItem'>" + tmpData.crs["0100"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:0</b><br/><label class='oddsItem'>" + tmpData.crs["0200"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:1</b><br/><label class='oddsItem'>" + tmpData.crs["0201"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>3:0</b><br/><label class='oddsItem'>" + tmpData.crs["0300"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>3:1</b><br/><label class='oddsItem'>" + tmpData.crs["0301"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>3:2</b><br/><label class='oddsItem'>" + tmpData.crs["0302"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>4:0</b><br/><label class='oddsItem'>" + tmpData.crs["0400"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>4:1</b><br/><label class='oddsItem'>" + tmpData.crs["0401"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>4:2</b><br/><label class='oddsItem'>" + tmpData.crs["0402"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>5:0</b><br/><label class='oddsItem'>" + tmpData.crs["0500"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>5:1</b><br/><label class='oddsItem'>" + tmpData.crs["0501"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>5:2</b><br/><label class='oddsItem'>" + tmpData.crs["0502"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>胜其他</b><br/><label class='oddsItem'>" + tmpData.crs["-1-h"] + "</label></a></p>" +
				
				"<p class='cloes'><a class='closeOtherPool' href='javascript:void(0);'>关闭</a></p>" +
				
				"<div class='clear'></div>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:0</b><br/><label class='oddsItem'>" + tmpData.crs["0000"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1:1</b><br/><label class='oddsItem'>" + tmpData.crs["0101"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:2</b><br/><label class='oddsItem'>" + tmpData.crs["0202"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>3:3</b><br/><label class='oddsItem'>" + tmpData.crs["0303"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>平其他</b><br/><label class='oddsItem'>" + tmpData.crs["-1-d"] + "</label></a></p>" +
				
				"<div class='clear'></div>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:1</b><br/><label class='oddsItem'>" + tmpData.crs["0001"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:2</b><br/><label class='oddsItem'>" + tmpData.crs["0002"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1:2</b><br/><label class='oddsItem'>" + tmpData.crs["0102"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:3</b><br/><label class='oddsItem'>" + tmpData.crs["0003"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1:3</b><br/><label class='oddsItem'>" + tmpData.crs["0103"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:3</b><br/><label class='oddsItem'>" + tmpData.crs["0203"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:4</b><br/><label class='oddsItem'>" + tmpData.crs["0004"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1:4</b><br/><label class='oddsItem'>" + tmpData.crs["0104"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:4</b><br/><label class='oddsItem'>" + tmpData.crs["0204"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0:5</b><br/><label class='oddsItem'>" + tmpData.crs["0005"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1:5</b><br/><label class='oddsItem'>" + tmpData.crs["0105"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2:5</b><br/><label class='oddsItem'>" + tmpData.crs["0205"] + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>负其他</b><br/><label class='oddsItem'>" + tmpData.crs["-1-a"] + "</label></a></p>" +
				
				"</dd>" +
				
				"</dl>";
				
				}
					
				if (tmpData.hafu != undefined) {
					
				data_html +=
					
				"<dl class='bqc'>" +
				
				"<dt><b>半全场</b><span>（90分钟内，主队的半场/全场结果）</span></dt>" +
				
				"<dd>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>主-主</b><br/><label class='oddsItem'>" + tmpData.hafu.hh + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>主-平</b><br/><label class='oddsItem'>" + tmpData.hafu.hd + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>主-客</b><br/><label class='oddsItem'>" + tmpData.hafu.ha + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>平-主</b><br/><label class='oddsItem'>" + tmpData.hafu.dh + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>平-平</b><br/><label class='oddsItem'>" + tmpData.hafu.dd + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>平-客</b><br/><label class='oddsItem'>" + tmpData.hafu.da + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>客-主</b><br/><label class='oddsItem'>" + tmpData.hafu.ah + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>客-平</b><br/><label class='oddsItem'>" + tmpData.hafu.ad + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>客-客</b><br/><label class='oddsItem'>" + tmpData.hafu.aa + "</label></a></p>" +
					
				"</dd>" +
				
				"</dl>";
				}
				
				if (tmpData.ttg != undefined) {
					
					data_html +=
					
				"<dl class='zjq'>" +
				
				"<dt><b>总进球</b><span>90分钟内，两队的进球总数</span></dt>" +
				
				"<dd>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>0球</b><br/><label class='oddsItem'>" + tmpData.ttg.s0 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>1球</b><br/><label class='oddsItem'>" + tmpData.ttg.s1 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>2球</b><br/><label class='oddsItem'>" + tmpData.ttg.s2 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>3球</b><br/><label class='oddsItem'>" + tmpData.ttg.s3 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>4球</b><br/><label class='oddsItem'>" + tmpData.ttg.s4 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>5球</b><br/><label class='oddsItem'>" + tmpData.ttg.s5 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>6球</b><br/><label class='oddsItem'>" + tmpData.ttg.s6 + "</label></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><b>7球+</b><br/><label class='oddsItem'>" + tmpData.ttg.s7 + "</label></a></p>" +
				
				"</dd>" +

                "</dl>";
                
				}
				
				data_html +=
					
				"<div class='clear'></div>" +
					
				"</div>" +


                "</td>";

                    obj.html(data_html);

                }



                //全清按钮

                obj.find(".clearAllOdds").click(function() {

                $(this).closest(".OtherWanfa").find(".o").removeClass("active");

                    //selAry

                var oObj = $(this).closest(".OtherWanfa").find(".o");

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

        });
        
        $("#dataList .openOtherPool").click(function() {
            $(this).closest("tr").next().show();
        });
        
        $(".closeOtherPool").click(function() {
            $(this).closest("tr").hide();
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
    <h1><b>竞猜足球&nbsp;&gt;&nbsp;混合过关</b><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php">胜平负<em></em></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php" class="active">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php">比分</a><span style="float:right;font-size:12px;">开停售时间：周一至周五早9:00-晚23:50；周六、周日早9:00-次日00:50。</span></h1>
  </div>
</div>
<!--caipiao location end-->
<!--center start-->
<div class="center">
  <!--投注center start-->
  <div class="BitCenter">
    <div class="touzhuNav">
      <ul>
        <li><a href="<?php echo @ROOT_WEBSITE; ?>
/help/showFgz.html">玩法规则</a></li>
        <li><a href="http://news.zhiying365365.com/saishi/index.php" class="active">销售公告</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <script src="<?php echo ((is_array($_tmp='filter.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
    <div>
      <div class="Kjnav">
        <div class="NavZHg">
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
            <dt><b>主队</b>&nbsp;&nbsp;VS&nbsp;&nbsp;<b>客队</b></dt>
          </dl>
          <dl class="six">
            <dt><b>胜平负</b></dt>
            <dd><b>主胜</b><b>平</b><b>客胜</b></dd>
          </dl>
          <dl class="seven">
            <dt class="show"><b>让球胜平负</b><em>
              <div class="tipBox tipBoxA">
                <div class="hd" style="left:-2px;"><s class="arrow arrowT"><s></s></s></div>
                <div class="bd">选项左侧为让球值，负数表示主让客，正数表示客让主。</div>
              </div>
              </em></dt>
            <dd><strong>让球</strong><b>主胜</b><b>平</b><b>客胜</b></dd>
          </dl>
          <dl class="eight">
            <dt>其他玩法</dt>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/betbox.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--确认投注 end-->
<!--投注提示 start-->
<div class="Tiptouz">
  <div class="Tiptouzc">
    <p><b>竞彩足球投注提示：</b></p>
    <p>1、让球只适合“让球胜平负”玩法，“+”为客让主，“-”为主让客。</p>
    <p><span>2、页面中过关投注固定奖金仅供参考，实际奖金以出票时刻奖金为准。投注区显示的中奖金额=每1元对应中奖奖金。</span></p>
    <p>3、过关投注完场显示的奖金仅指比赛截止投注时的过关奖金，仅供参考，派奖奖金以方案详情中出票时刻的奖金为准。</p>
    <p>4、2或3场过关投注，单注最高奖金限额20万元；4或5场过关投注，单注最高奖金限额50万元；6场和6场以上过关投注，单注最高奖金限额100万元。</p>
    <p>5、单注彩票保底奖金：如果单注奖金不足2元，则补足至2元。</p>
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