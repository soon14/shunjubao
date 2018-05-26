<?php /* Smarty version 2.6.17, created on 2018-03-04 23:19:27
         compiled from confirm/crs_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/crs_list.html', 376, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "crs";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "比分", dataPool: "crs" };

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

                matchData[key] = matchObj.crs;
                matchData[key].end = matchObj.end;

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



                htmStr += "<tr m='" + isFind + "' id='" + key + "'" + ((count % 2 == 0) ? " class='alt'" : "") + ">" +

                "<td>" +
				
				"<div class='jctsbifen'>" +
				
				"<dl>" +
				
				"<dt class='b1'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></dt>" +
				
				"<dt class='b6' style='background:" + matchObj.l_color + "; color:#fff;'><b>" + matchObj.l_cn + "</b></dt>" +
				
				"<dt class='b2'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</dt>" +
				
				"<dt class='b3'><b><hn>" + matchObj.h_cn + "</hn></b><u>VS</u><strong><gn>" + matchObj.a_cn + "</gn></strong></dt>" +
				
				"<dt class='b4'><a class='crsFoldBtn' href='javascript:void(0);'>显示</a></dt>" +
				
				"</dl>" +
				
				"</div>" +
				
				"</td>" +

                "</tr>"+

                "<tr m='" + isFind + "' style='display:none;' a=1 class='"+ ((matchObj.end == 1)?"game_end" : "")+"'>" +

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

        for (var i = 0; i < matchNameAry.length; i++) {

            filterHtm += "<em><input type='checkbox' checked />" + matchNameAry[i].name + "[" + matchNameAry[i].len + "]</em>";

        }

        $("#fMatches").html(filterHtm);

		$("#dataList .crsFoldBtn").click(function() {

            if ($(this).text() == "显示") {

                var obj = $(this).closest("tr").next();

                obj.show();
                
                $(this).text("隐藏");
               
            }else {

                    $(this).closest("tr").next().hide();

                    $(this).text("显示");

            }

        });
        
        $("#dataList .crsFoldBtn").each(function() {

                var obj = $(this).closest("tr").next();

                    var tmpData = matchData[$(this).closest("tr").attr("id")];

                    if (tmpData == undefined) {

                        obj.html("<td><div class='guoguanbifen OddsTd'>没有数据！</div></td>");

                    } else {
                    	
                    	var htmStr = "<td>" +
						
						"<div class='jcbifen'>" +
						
						"<div class='jcbifenC'>" +
					   
						"<dl>" +
						   
						"<dt>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>1:0</b><br/>" + tmpData["0100"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>2:0</b><br/>" + tmpData["0200"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>2:1</b><br/>" + tmpData["0201"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>3:0</b><br/>" + tmpData["0300"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>3:1</b><br/>" + tmpData["0301"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>3:2</b><br/>" + tmpData["0302"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>4:0</b><br/>" + tmpData["0400"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>4:1</b><br/>" + tmpData["0401"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>4:2</b><br/>" + tmpData["0402"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>5:0</b><br/>" + tmpData["0500"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>5:1</b><br/>" + tmpData["0501"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>5:2</b><br/>" + tmpData["0502"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>胜其他</b><br/>" + tmpData["-1-h"] + "</a></p>" +
							
							"<p class='qx'><a class='crsSelAll' href='javascript:void(0);'>全</a></p>" +
							
						"</dt>" +
						   
						"</dl>" +
						   
						"</div>" +
						
						"<div class='jcbifenC'>" +
					   
					    "<dl>" +
					   
					    "<dt>" +
					    
						"<p><a class='o' href='javascript:void(0);'><b>0:0</b><br/>" + tmpData["0000"] +"</a></p>" +
	
							"<p><a class='o' href='javascript:void(0);'><b>1:1</b><br/>" + tmpData["0101"] + "</a></p>" +
		
							"<p><a class='o' href='javascript:void(0);'><b>2:2</b><br/>" + tmpData["0202"] + "</a></p>" +
		
							"<p><a class='o' href='javascript:void(0);'><b>3:3</b><br/>" + tmpData["0303"] + "</a></p>" +
		
							"<p><a class='o' href='javascript:void(0);'><b>平其他</b><br/>" + tmpData["-1-d"] + "</a></p>" +
							
							"<p class='qx'><a class='crsSelAll' href='javascript:void(0);'>全</a></p>" +
							
						 "</dt>" +
					   
					    "</dl>" +
					   
					    "</div>" +
						
						"<div class='jcbifenC clear'>" +
					   
						"<dl>" +
						   
						"<dt>" +
							
						"<p><a class='o' href='javascript:void(0);'><b>0:1</b><br/>" + tmpData["0001"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>0:2</b><br/>" + tmpData["0002"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>1:2</b><br/>" + tmpData["0102"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>0:3</b><br/>" + tmpData["0003"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>1:3</b><br/>" + tmpData["0103"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>2:3</b><br/>" + tmpData["0203"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>0:4</b><br/>" + tmpData["0004"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>1:4</b><br/>" + tmpData["0104"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>2:4</b><br/>" + tmpData["0204"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>0:5</b><br/>" + tmpData["0005"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>1:5</b><br/>" + tmpData["0105"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>2:5</b><br/>" + tmpData["0205"] + "</a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><b>负其他</b><br/>" + tmpData["-1-a"] + "</a></p>" +
							
							"<p class='qx'><a class='crsSelAll' href='javascript:void(0);'>全</a></p>" +
							
						"</dt>" +
						   
						"</dl>" +
						   
						"</div>" +
						
						"</div>" +

                    	"</td>";
        
        				obj.html(htmStr);



                        obj.find(".crsSelAll").click(function() {

                            var oddsObj = $(this).closest("dl").find("dt");

                            var oddsItem = oddsObj.find("a");
                            
                            if(!oddsItem.hasClass("o")) return;

                            var index = $(this).closest("tr").find(".crsSelAll").index($(this));

                            var rangeAry = [0, 13, 18];

                            var obj = $(this).closest("tr").prev();

                            var key = obj.attr("id");

                            if (oddsObj.find(".active").length == oddsItem.length) {

                                //全不选

                                oddsItem.removeClass("active");

                                //selAry

                                for (var m = 0; m < oddsItem.length-1; m++) {

                                    selAry[key].odds[m + rangeAry[index] + poolOptionIndex[curPool]] = 1;

                                }

                                if (eval(selAry[key].odds.join("*")) == 1) {

                                    delete (selAry[key]);

                                }

                            } else {

                                //全选

                                oddsItem.addClass("active");

                                //selAry

                                if (selAry[key] == undefined) {

                                    selAry[key] = {};

                                    selAry[key].pool = curPool;

                                    selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

                                    selAry[key].num = obj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + obj.find(".hideMatch").text();

                                    selAry[key].hostTeam = obj.find("hn").text();

                                    selAry[key].guestTeam = obj.find("gn").text();


                                    //判断场数

                                    if (!checkSelCount()) {

                                        $(this).removeClass("active");

                                        return;

                                    }

                                }

                                for (var m = 0; m < oddsItem.length-1; m++) {

                                    selAry[key].odds[m + rangeAry[index] + poolOptionIndex[curPool]] = Number(oddsObj.find("a").eq(m).contents().eq(2).text().replace(/ /g, ""));

                                }

                            }

                            fillSelPan();

                            fillOptionsPan();

                            calculate();

                        });

                    }
        });

        //默认第一展开

        $("#dataList .crsFoldBtn:eq(0)").click();

	  };    
</script>
<script src="<?php echo ((is_array($_tmp='publicFunc.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
</head>
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
    <h1><b>竞猜足球&nbsp;&gt;&nbsp;比分</b><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php">胜平负<em></em></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php" class="active">比分</a><span style="float:right;font-size:12px;">开停售时间：周一至周五早9:00-晚23:50；周六、周日早9:00-次日00:50。</span></h1>
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
        <li><a href="http://news.shunjubao.xyz/saishi/index.php" class="active">销售公告</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <script src="<?php echo ((is_array($_tmp='filter.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
    <div>
      <div class="Kjnav">
        <div class="bjdc_bfNav">
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
            <dt>主队<span>VS</span>客队</dt>
          </dl>
          <dl class="five">
            <dt style="line-height:48px;">投注区</dt>
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
<!--确认投注end-->
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