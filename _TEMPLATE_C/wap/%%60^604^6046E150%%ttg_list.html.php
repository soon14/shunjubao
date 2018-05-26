<?php /* Smarty version 2.6.17, created on 2017-10-21 12:54:55
         compiled from confirm/ttg_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/ttg_list.html', 177, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/confirm/header.html", 'smarty_include_vars' => array()));
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

        var htmStr = "<tr><td>";

        for (var i = 0; i < tmpAry.length; i++) {

            var obj = tmpAry[i];

            htmStr += "<div><tr><td><div class='DQtime'>" + obj.day + "<span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>显示隐藏[<label class='hideNum'>0</label>]场</a></strong></div></td></tr>";

            htmStr += "<tr d='" + i + "'><td><table cellpadding='0' cellspacing='0'>";

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

                " <td>"+
				
				"<div>" +
				
				"<td>" +
				
				"<td style='width:65px;'>" +
						  
				"<div class='Saishi'>" +
						  
				"<dl>" +
						  
				"<dt><b class='name ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</b></dt>" +
						  
			    "<dd>" +
						  
				"<p><u></u><i></i><strong>"+ matchObj.num + "</strong></p>" +
						  
				"<p><span>"+ matchObj.time+"</span><em>截止</em></p>" +
						  
				"</dd>" +
						  
				"<dt class='hidden'><a class='hideMatch' href='javascript:void(0);'>隐藏本场</a></dt>" +
						  
				"</dd>" +
						  
				"<dl>" +
						  
				"</div>" +
						  
				"</td>" +
				
				"<td style='padding:0 0 0 5px;'>" +
				
				"<div class='zjqdui'>" +
				
				"<ul>" +
				
				"<li><b><hn>" + matchObj.h_cn + "</hn></b></li>" +
				
				"<li><span>VS</span></li>" +
				
				"<li><strong><gn>" + matchObj.a_cn + "</gn></strong></li>" +
				
				"<li class='dg'>"+ ((matchObj.danguan == 1)? "<span class='danguan'>单</span>":"")+"</li>" +
				
				"</ul>" +
				
				"<dl>" +
				
				"<dt>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>0球</span><b><label class='oddsItem'>" + matchObj.ttg.s0 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>1球</span><b><label class='oddsItem'>" + matchObj.ttg.s1 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>2球</span><b><label class='oddsItem'>" + matchObj.ttg.s2 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>3球</span><b><label class='oddsItem'>" + matchObj.ttg.s3 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>4球</span><b><label class='oddsItem'>" + matchObj.ttg.s4 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>5球</span><b><label class='oddsItem'>" + matchObj.ttg.s5 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>6球</span><b><label class='oddsItem'>" + matchObj.ttg.s6 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>7+球</span><b><label class='oddsItem'>"+ matchObj.ttg.s7 + "</label></b></a></p>" +
				
				"</dt>" +
				
				"</dl>" +
				
				"</div>" +

                " </td>"+

                "</tr>";

            }

            htmStr += "</table></td></tr>";

            htmStr += "</div>";

            filterHtm += "<em><input type='checkbox' checked />" + obj.num + "[" + count + "]</em>";

        }

        htmStr += "</td></tr>";

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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--touzhuNav start-->
<div class="NavphTab">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php">胜平负</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php">混合过关</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php" class="active">总进球</a></td>
	  <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php">半全场</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php">比分</a></td>
    </tr>
  </table>
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
<script src="<?php echo ((is_array($_tmp='wap_betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<!--确认投注end-->
<!--bottom tips start-->
<div class="bottomTips">
  <h2>竞彩结果指90分钟（含伤停补时）的结果，不含加时赛！</h2>
</div>
<!--bottom tips end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>