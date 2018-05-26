<?php /* Smarty version 2.6.17, created on 2018-03-04 23:15:44
         compiled from confirm/ttg_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/ttg_list.html', 136, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "ttg";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "总进球", dataPool: "ttg" };

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

               "<td style='width:66px;padding:0;'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</div></td>" +

                "  <td class='d3'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +

                "  <td class='206'><div class='duiNamE'>"+ ((matchObj.danguan == 1)? "<span class='danguan'></span>":"")+"<b><hn>" + matchObj.h_cn + "</hn></b><u>VS</u><strong><gn>" + matchObj.a_cn + "</gn></strong></div></td>" +

                "  <td><div class='zjqOddsList OddsTd'>" +

                "      <ul>" +
                
                "<li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s0 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s1 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s2 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s3 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s4 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s5 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s6 + "</a></li>" +

                    "        <li><a class='o' href='javascript:void(0);'>" + matchObj.ttg.s7 + "</a></li>" +
                
                "      </ul>" +

                "      <div class='clear'></div>" +

                "    </div></td>" +

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

    }
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
    <h1><b>竞猜足球&nbsp;&gt;&nbsp;总进球</b><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php">胜平负<em></em></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php" class="active">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
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
        <div class="NavZJq">
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
            <dt>投&nbsp;&nbsp;&nbsp;注&nbsp;&nbsp;&nbsp;区（奖金指数）</dt>
            <dd><b>0球</b><b>1球</b><b>2球</b><b>3球</b><b>4球</b><b>5球</b><b>6球</b><b>7+球</b></dd>
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