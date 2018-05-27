<?php /* Smarty version 2.6.17, created on 2018-03-04 23:14:11
         compiled from beidan/sf.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'beidan/sf.html', 164, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "SF";

    var curPos = { gameCode: "bd", gameType: "北京单场", poolName: "胜负过关", dataPool: "SF" };

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

            htmStr += "<div><tr class='time'>";
            htmStr += "<td id='tdwin' colspan='7' style='border:none;'>";
            htmStr += "<div class='DQtime'><b>" + obj.w + "&nbsp;" + obj.day + "&nbsp;[10:00 -- 次日 10:00]</b>";
            htmStr += "<span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span>";
//             htmStr += "<strong><input type='checkbox' name=''>";
            htmStr += "<strong>";
            htmStr += "<a href='javascript:void(0);' class='showHide'>&nbsp;显示已隐藏比赛<b>[<label class='hideNum'>0</label>]</b>场</a>";
            htmStr += "</strong></div></td></tr>";
            
            htmStr += "<tr d='"+i+"'><td><div>";
            
            var listObj = obj.matchs[0];

            var count = 0;

            for (var key in listObj) {

                count++;

                var matchObj = listObj[key];

                var goalLine = Number((matchObj.SF == undefined) ? "0" : matchObj.SF.goalline);

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
                //让球数颜色
				var goalline_color = 'red';//默认让球
                if (matchObj.goalline > 0) {
                	goalline_color = 'green';//受让
                }
                if (matchObj.goalline == 0) {
                	goalline_color = 'black';
                }
                htmStr += "<tr l='" + goalLine + "' m='" + matchObj.num + "' id='" + key + "'" + ((count % 2 == 0) ? " class='alt'" : "") + ">" +

                          "<td class='dc1' style='width:42px;'><a class='hideMatch' href='javascript:void(0);'>" + matchObj.num + "</a></td>" +
						  
						  "<td class='dc3'>" + matchObj.l_cn + "</td>" +
						  
						  "<td class='dc2'><div class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.name + "</div></td>" +
						  
						  "<td class='dc4'>" + matchObj.date + "&nbsp;&nbsp;" + matchObj.time + "</td>" +
						  
						  "<td class='dc5'><div class='duiName'><b><hn>" + matchObj.h_cn + "</hn></b><u>" + "VS </u><strong><gn>" + matchObj.a_cn + "</gn></strong></div></td>" +
						  
						  "<td class='dc6'>" +
						  
						  "<div class='beidanspftouzhu'>" +
						  
						  "<ul>" +
						  
						  "<li><a class='o' href='javascript:void(0);'>" +  matchObj.SF.h + "</a></li>" +
						  
						  "<li><span style='color:"+goalline_color+";'>" +  matchObj.goalline + "</span></li>" +
						  
						  "<li><a class='o' href='javascript:void(0);'>" +  matchObj.SF.a + "</a></li>" +
						  
						  "</ul>" +
						  
						  "</div>" +
						  
						  "</td>" +

                          "</tr>";

            }

            htmStr += "</div></td></tr>";

            
            filterHtm += "<em><input type='checkbox' checked />" + obj.num + "[" + count + "]</em>";

        }

        htmStr += "</td></tr>";

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
/beidan/sf.php" class="active">胜负过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/jqs.php">进球数</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bqc.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bf.php">比分</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/sxds.php">上下单双</a></h1>
  </div>
</div>
<!--caipiao location end-->
<!--center start-->
<div class="center">
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
        <div class="bjdc_Nav">
          <dl class="one">
            <dt>序号</dt>
          </dl>
          <dl class="two">
            <dt>赛事类型</dt>
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
            <dt>投注区</dt>
            <dd class="show">主胜</dd>
			<dd class="rq">让球</dd>
			<dd class="zhufu">客胜&nbsp;</dd>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
      <div>
        <!--读取数据结果-->
        <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="1">
        </table>
        <!--读取数据结果 end-->
      </div>
    </div>
  </div>
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
<!--确认投注end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>