<?php /* Smarty version 2.6.17, created on 2018-03-04 23:14:25
         compiled from beidan/jqs.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'beidan/jqs.html', 137, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "JQS";

    var curPos = { gameCode: "bd", gameType: "北京单场", poolName: "进球数", dataPool: "JQS" };

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

            htmStr += "<div><tr class='time'><td id='tdwin'><div class='DQtime'><b>" + obj.num + "&nbsp;" + obj.day + "&nbsp;[11:30 -- 次日 11:30]</b><span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>&nbsp;显示已隐藏比赛<b>[<label class='hideNum'>0</label>]</b>场</a></strong></div></td></tr>";

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


                htmStr += "<tr m='" + isFind + "' id='" + key + "'" + ((count % 2 == 0) ? " class='alt'" : "") + ">" +

                "<td class='dc1'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></td>" +
						  
				"<td class='dc3'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.name + "</div></td>" +
						  
				"<td class='dc4'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +
						  
				"<td class='dc5'><div class='duiNamE'><b><hn>" + matchObj.h_cn + "</hn></b><u>" + "VS </u><em><gn>" + matchObj.a_cn + "</gn></em></div></td>" +
				
				"<td>" +
				
				"<div class='bdboxzjq'>" +
				
				"      <ul>" +
                
                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s0 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s1 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s2 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s3 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s4 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s5 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s6 + "</a></li>" +

                "        <li><a class='o' href='javascript:void(0);'>" + matchObj.JQS.s7 + "</a></li>" +

                "      </ul>" +
				
				"</div>" +
				
				"</td>" +

                "</tr>";

            }

            htmStr += "</table></td></tr>";


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
<script src="<?php echo ((is_array($_tmp='publicFunc_bd.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
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
    <h1><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/spf.php">胜平负</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/sf.php">胜负过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/jqs.php" class="active">进球数</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bqc.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bf.php">比分</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/sxds.php">上下单双</a></h1>
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
        <div class="zqj_bfNav">
          <dl class="one">
            <dt>序号</dt>
          </dl>
          <dl class="three">
            <dt>赛事</dt>
          </dl>
          <dl class="four">
            <dt>截止时间</dt>
          </dl>
          <dl class="five">
            <dt>主队<span>VS</span>客队</dt>
          </dl>
          <dl class="six">
            <dt>投注区(奖金指数)</dt>
            <dd class="zj">0球</dd>
            <dd class="zj">1球</dd>
            <dd class="zj">2球</dd>
            <dd class="zj">3球</dd>
            <dd class="zj">4球</dd>
            <dd class="zj">5球</dd>
            <dd class="zj">6球</dd>
            <dd class="zj">7+球</dd>
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
<!--center end-->
<!--确认投注 strat-->
<script src="<?php echo ((is_array($_tmp='betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../confirm/betbox.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--确认投注 end-->
<!--Help start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/help.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--Help end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>