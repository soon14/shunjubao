<?php /* Smarty version 2.6.17, created on 2016-04-13 05:15:42
         compiled from beidan/jqs.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'beidan/jqs.html', 159, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "JQS";

    var curPos = { gameCode: "bd", gameType: "北京单场", poolName: "进球数", dataPool: "JQS" };

    function getDataBack(data) {

        if (Number(data.total) == 0) {
            alert("没有数据！");
            return;
        }

        var matchNameAry = [];

        var tmpAry = data.datas;

        var filterHtm = "";

        var htmStr = "<tr>";

        for (var i = 0; i < tmpAry.length; i++) {

            var obj = tmpAry[i];

            htmStr += "<div><tr class='time'><td id='tdwin'><div class='DQtime'><b>" + obj.num + "&nbsp;" + obj.day + "&nbsp;[11:30 -- 次日 11:30]</b><span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>&nbsp;显示已隐藏比赛<b>[<label class='hideNum'>0</label>]</b>场</a></strong></div></td></tr>";

            htmStr += "<tr d='" + i + "'><td><table width='100%' cellpadding='0' cellspacing='0'>";

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

                "<td style='width:65px;'>" +
						 
						  "<div class='bdSaishi'>" +
						  
						  "<dl>" +
						  
						  "<dt><b class='ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.name + "</b></dt>" +
						  
						  "<dd>" +
						  
						  "<p><u></u><i></i><strong>" + matchObj.num + "</strong></p>" +
						  
						  "<p><span>" + matchObj.time + "</span><em>截止</em></p>" +
						  
						  "</dd>" +
						  
						  "<dt class='hidden' ><a class='hideMatch' href='javascript:void(0);'><em>&rsaquo;</em>&nbsp;隐藏本场</a></dt>" +
						  
						  "<dl>" +
						  
						  "</div>" +			 
						  
						  "</td>" +
						  
						  "<td>" +
						 
						  "<div class='beidanjqs'>" +
						  
						  "<ul><li><hn>" + matchObj.h_cn + "</hn></li><li>VS</li><li><gn>" + matchObj.a_cn + "</gn></li></ul>" +
						  
						  "<dl>" +
						  
						  "<dt>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>0球</strong><label class='oddsItem'>" + matchObj.JQS.s0 + "</label></a></p>" +
						   
						  "<p><a class='o' href='javascript:void(0);'><strong>1球</strong><label class='oddsItem'>" + matchObj.JQS.s1 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>2球</strong><label class='oddsItem'>" + matchObj.JQS.s2 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>3球</strong><label class='oddsItem'>" + matchObj.JQS.s3 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>4球</strong><label class='oddsItem'>" + matchObj.JQS.s4 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>5球</strong><label class='oddsItem'>" + matchObj.JQS.s5 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>7球</strong><label class='oddsItem'>" + matchObj.JQS.s6 + "</label></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><strong>7+球</strong><label class='oddsItem'>" + matchObj.JQS.s7 + "</label></a></p>" +
						  
						  "</dt>" +
						  
						  "</dl>" +
						  
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
</head><body>
<!--top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--touzhuNav start-->
<div class="touzhusubNav">
  <h1>北单<em><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/spf.php">胜平负</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/sf.php">胜负<span></span></a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/jqs.php" class="active">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bqc.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/bf.php">比分</a><a href="<?php echo @ROOT_DOMAIN; ?>
/beidan/sxds.php">上下单双</a></em></h1>
</div>
<!--touzhuNav end-->
<!--center start-->
<div class="center">
  <!--投注center start-->
  <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="1">
  </table>
  <!--投注center end-->
</div>
<!--center end-->
<!--确认投注 strat-->
<script src="<?php echo ((is_array($_tmp='app_betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<!--确认投注 end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>