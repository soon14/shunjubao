<?php /* Smarty version 2.6.17, created on 2018-03-05 00:33:05
         compiled from confirm/hilo_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/hilo_list.html', 128, false),)), $this); ?>
﻿<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "hilo";

    var curPos = { gameCode: "bk", gameType: "竞彩篮球", poolName: "大小分", dataPool: "hilo" };

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

                  "<td class='d1'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></td>" +
				  
				  "<td style='width:66px;padding:0;'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</div></td>" +
				  
				  "<td width='138'><div style='width:138px;'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</div></td>" +
				  
				  "<td width='98'><div class='LduiName'>"+ ((matchObj.danguan == 1)? "<span class='danguan'></span>":"")+"<b><hn>"+matchObj.a_cn+"</hn></b><u>VS</u><strong><gn>"+matchObj.h_cn+"</gn></strong></div></td>" +
				  
				  "<td>"+
				  
				  "<div class='dxfOddsTd'>"+
				  
				  "<ul>" +
				  
				  "<li><a class='o' href='javascript:void(0);'><b>大</b><span class='oddsItem'>"+ ((matchObj.hilo == undefined) ? "" : matchObj.hilo.h) +"</span></a></li>"+
					  
				  "<li><a class='o' href='javascript:void(0);'><span class='oddsItem'>"+((matchObj.hilo == undefined) ? "" : matchObj.hilo.l)+"</span><strong>小</strong></a></li>"+
					  
				  "</ul>"+
				  
				  "</div>"+
				  
				  "</td>" +
				  
				  "<td width='101' style='color:#dc0000;'><label class='line' pool='hilo'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.goalline) + "</label></td>" +
				  
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
    <h1><b>竞猜篮球&nbsp;&gt;&nbsp;大小分</b><a href="/basketball/hdc_list.php">让分胜负<em></em></a><a href="/basketball/bk_crosspool.php">混合过关</a><a href="/basketball/wnm_list.php">胜分差</a><a href="/basketball/hilo_list.php" class="active">大小分</a><span style="float:right;font-size:12px;">开停售时间：周一/周二/周五早9:00-晚23:50；周三/周四早7:30-23:50；周六、周日早9:00-次日00:50。</span></h1>
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
        <div class="Navdx">
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
          <dl class="five">
            <dt>投&nbsp;注&nbsp;区（奖金指数)</dt>
            <dd><b>大分</b><b>小分</b></dd>
          </dl>
          <dl class="six">
            <dt class="show"><b>界限</b><em>
              <div class="tipBox tipBoxA">
                <div class="hd" style="left:125px;"> <s class="arrow arrowT"><s></s></s> </div>
                <div class="bd" style="line-height:22px;">此数值很可能会随时变化，请以实际出票后的票样信息为准。</div>
              </div>
              </em></dt>
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