<?php /* Smarty version 2.6.17, created on 2016-02-18 18:11:18
         compiled from confirm/hhad_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/hhad_list.html', 209, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/confirm/header.html", 'smarty_include_vars' => array()));
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
			
			htmStr += "<div><tr><td><div class='DQtime'>" + obj.day + "<span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>显示隐藏[<label class='hideNum'>0</label>]场</a></strong></div></td></tr>";

            htmStr += "<tr d='"+i+"'><td><table width='100%' cellpadding='0' cellspacing='0'>";

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
						  
						  "<td>" +
						 
						  "<div>" +
						  
						  "<td style='width:65px;'>" +
						  
						  "<div class='Saishi'>" +
						  
						  "<dl>" +
						  
						  "<dt><b class='name ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</b></dt>" +
						  
						  "<dd>" +
						  
						  "<p><u></u><i></i><strong>"+ matchObj.num + "</strong></p>" +
						  
						  "<p><span>"+ matchObj.time+"</span><em>截止</em></p>" +
						  
						  "</dd>" +
						  
						  "<dt class='hidden' ><a class='hideMatch' href='javascript:void(0);'>隐藏本场</a></dt>" +
						  
						  "<dl>" +
						  
						  "</div>" +
						  
						  "</td>" +
						  
						  "<td>" +
						  
						  "<div class='bisaidui'>" +
						  
						  "<ul>" +
				
						  "<li><b><hn>" + matchObj.h_cn + "</hn></b></li>" +
						
						  "<li><span>VS</span></li>" +
						
						  "<li><strong><gn>" + matchObj.a_cn + "</gn></strong></li>" +
						  
						  "<li class='dg'>"+ ((matchObj.danguan == 1)? "<span class='danguan'>单关</span>":"")+"</li>" +
						  
						  "<li class='wf' style='display:none;'>胜平负玩法</li>" +
						
						  "</ul>" +
						  
						  "<dl>" +
						  
						  "<dt class='"+ ((matchObj.danguan_had == 1)? "dgsaishi":"")+"'>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><span>主胜</span><strong><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.h) + "</label></strong></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><span>平局</span><strong><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.d) + "</label></strong></a></p>" +
						  
						   "<p><a class='o' href='javascript:void(0);'><span>客胜</span><strong><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.a) + "</label></strong></a></p>" +

						   "<p class='cc'><i>0</i></p>"+
						  
						  "</dt>" +
						  
						  "</dl>" +
						  
						  "<dl>" +
						  
						  "<dt class='"+ ((matchObj.danguan_hhad == 1)? "dgsaishi":"")+"'>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><span>主胜</span><strong><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.h) + "</label></strong></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><span>平局</span><strong><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.d) + "</label></strong></a></p>" +
						  
						  "<p><a class='o' href='javascript:void(0);'><span>客胜</span><strong><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.a) + "</label></strong></a></p>" +

						  "<p class='cc'><b>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.goalline) + "</b></p>"+
						  
						  "</dt>" +
						  
						  "</dl>" +
						  				  
						  "</div>" +
						  
						  "</td>" +

						  "<div>" +

						  "</td>" +
						  
                        "</tr>";

            }

            htmStr += "</table></td></tr>";


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
<script src="<?php echo ((is_array($_tmp='publicFunc.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
</head>
<body>
<!--top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--touzhuNav start-->
<div class="touzhusubNav">
  <h1><em><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php" class="active">胜平负<span></span></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php">比分</a></em></h1>
</div>
<!--touzhuNav end-->
<!--center start-->
<div class="center">
  <!---->
  <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
  </table>
  <!---->
</div>
<!--center end-->
<!--确认投注 strat-->
<script src="<?php echo ((is_array($_tmp='app_betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<!--确认投注end-->
<!--bottom tips start-->
<div class="bottomTips">
  <h2>竞彩结果指90分钟（含伤停补时）的结果，不含加时赛！</h2>
</div>
<!--bottom tips end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>