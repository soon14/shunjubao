<?php /* Smarty version 2.6.17, created on 2018-05-21 23:03:22
         compiled from confirm/hhad_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/hhad_list.html', 161, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "had";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "胜平负/让球胜平负", dataPool: "had,hhad" };

    function getDataBack(data) {

        if (Number(data.total) == 0) {
            alert("暂无开售赛事！");
            return;
        }

        var lineAry = [1000, -1000];

        var matchNameAry = [];

        var tmpAry = data.datas;

        var filterHtm = "";

        var htmStr = "<tr>";

        for (var i = 0; i < tmpAry.length; i++) {

            var obj = tmpAry[i];

            htmStr += "<div><tr class='time'><td id='tdwin'><div class='DQtime'><b>" + obj.num + "&nbsp;" + obj.day + "</b><span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>&nbsp;显示已隐藏比赛<b>[<label class='hideNum'>0</label>]</b>场</a></strong></div></td></tr>";

            htmStr += "<tr d='"+i+"'><td><table cellpadding='0' cellspacing='1' id='TabWin'>";

            var listObj = obj.matchs[0];

            var count = 0;

            for (var key in listObj) {

                count++;

                var matchObj = listObj[key];

                var goalLine = Number((matchObj.hhad == undefined) ? "0" : matchObj.hhad.goalline);

                if (goalLine > lineAry[1]) { lineAry[1] = goalLine } else if (goalLine < lineAry[0]) { lineAry[0] = goalLine };

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

                htmStr += "<tr l='" + goalLine + "' m='" + isFind + "' id='" + key + "' class='" + ((count % 2 == 0) ? " alt" : "") + ((matchObj.end == 1)?" game_end" : "")+"'>" +

                          "<td class='d1'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></td>" +

                          "<td style='width:66px;padding:0;'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</div></td>" +

                          "<td class='d3'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +

                          "<td class='d6'><div class='duiName'>"+ ((matchObj.danguan == 1)? "<span class='danguan'></span>":"")+"<b><hn>" + matchObj.h_cn + "</hn></b><u>" + ((matchObj.score == "") ? "VS" : "<font color='red'>" + matchObj.score + "</font>") + "</u><strong><gn>" + matchObj.a_cn + "</gn></strong></div></td>" +

                          "<td width='247'><div class='OddsList OddsTd "+ ((matchObj.danguan_had == 1)? "dgsaishi":"")+"'>" +

                          "<ul>" +
                	
                 		  "<li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.h) + "</a></li>" +

                     	"<li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.d) + "</a></li>" +

                     	"<li><a class='o' href='javascript:void(0);'>" + ((matchObj.had == undefined) ? "" : matchObj.had.a) + "</a></li>"+
                     
                		"</ul>" +

                          "</div></td>" +

                          "<td><div class='OddsList OddsTd "+ ((matchObj.danguan_hhad == 1)? "dgsaishi":"")+"'>" +

                          "<ul>"+
                          
						  "<li class='color line' pool='hhad'>" + ((matchObj.hhad.goalline == undefined) ? "" : matchObj.hhad.goalline) + "</li>"+
						  
						"<li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.h) + "</a></li>" +

                    	"<li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.d) + "</a></li>" +

                    	"<li><a class='o' href='javascript:void(0);'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.a) + "</a></li>" +

						"</ul>" +
				
                          "</div>" +

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

        for (var i = lineAry[0]; i <= lineAry[1]; i++) {

            var len = $("#dataList tr[l=" + i + "]").length;

            if (len != 0) {

                filterHtm += "<em><input type='checkbox' checked num='" + i + "' />" + ((i > 0) ? "客" : "主") + "让" + Math.abs(i) + "球[" + len + "]</em>";

            }

        }

        $("#fLetBall").html(filterHtm);

        filterHtm = "";

        for (var i = 0; i < matchNameAry.length; i++) {

            filterHtm += "<em><input type='checkbox' checked />"+matchNameAry[i].name+"["+ matchNameAry[i].len +"]</em>";

        }

        $("#fMatches").html(filterHtm);

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
    <h1><b>竞猜足球&nbsp;&gt;&nbsp;胜平负、让球胜平负玩法</b><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php" class="active">胜平负<em></em></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
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
        <li><a href="http://new.shunjubao.xyz/saishi/index.php" class="active">销售公告</a></li>
      </ul>
      <div class="clear"></div>
    </div>
    <script src="<?php echo ((is_array($_tmp='filter.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
    <div>
      <div class="Kjnav">
        <div class="NavZpf">
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
            <dt>胜平负</dt>
            <dd><b>主胜</b><b>平</b><b>&nbsp;客胜</b></dd>
          </dl>
          <dl class="seven">
            <dt class="show">让球胜平负<em>
              <div class="tipBox tipBoxA">
                <div class="hd" style="left:5px;"><s class="arrow arrowT"><s></s></s></div>
                <div class="bd">选项左侧为让球值，负数表示主让客，正数表示客让主。</div>
              </div>
              </em></dt>
            <dd><strong>让球</strong><b>主胜</b><b>&nbsp;平</b><b>&nbsp;&nbsp;客胜</b></dd>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
      <!--读取数据结果-->
      <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="1">
      </table>
      <!--读取数据结果 end-->
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