<?php /* Smarty version 2.6.17, created on 2018-03-05 00:48:30
         compiled from confirm/wnm_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/wnm_list.html', 153, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "wnm";

    var curPos = { gameCode: "bk", gameType: "竞彩篮球", poolName: "胜分差", dataPool: "wnm" };

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

                "  <td class='d2' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</td>" +

                "  <td class='d3'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +

                "  <td class='d10'>"+ ((matchObj.danguan == 1)? "<span class='danguan'></span>":"")+"<b><hn>" +matchObj.a_cn+ "</hn></b>" +

                "    <b><gn>" + matchObj.h_cn + "</gn></b></td>" +

                "  <td class='d13'><b>客胜</b>" +

                "    <b>主胜</b></td>" +

                "  <td><div class='sfctouzhu OddsTd'>" +

                "      <dl>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l1) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l2) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l3) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l4) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l5) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.l6) + "</a></b></dd>" +

                "      </dl>" +

                "      <dl>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w1) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w2) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w3) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w4) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w5) + "</a></b></dd>" +

                "        <dd><b><a class='o' href='javascript:void(0);'>&nbsp;" + ((matchObj.wnm == undefined) ? "" : matchObj.wnm.w6) + "</a></b></dd>" +

                "      </dl>" +

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
    <h1><b>竞猜篮球&nbsp;&gt;&nbsp;胜分差</b><a href="/basketball/hdc_list.php">让分胜负<em></em></a><a href="/basketball/bk_crosspool.php">混合过关</a><a href="/basketball/wnm_list.php" class="active">胜分差</a><a href="/basketball/hilo_list.php">大小分</a><span style="float:right;font-size:12px;">开停售时间：周一/周二/周五早9:00-晚23:50；周三/周四早7:30-23:50；周六、周日早9:00-次日00:50。</span></h1>
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
        <div class="Navsfc">
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
            <dt>客队<br/>
              主队</dt>
          </dl>
          <dl class="five">
            <dt>胜分差</dt>
          </dl>
          <dl class="six">
            <dt>投&nbsp;&nbsp;注&nbsp;&nbsp;区（奖金指数）</dt>
            <dd><b>1-5</b><b>6-10</b><b>11-15</b><b>16-20</b><b>21-25</b><b>26+</b></dd>
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