<?php /* Smarty version 2.6.17, created on 2017-10-21 13:08:25
         compiled from confirm/hafu_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/hafu_list.html', 293, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "hafu";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "半全场", dataPool: "hafu" };

    var hafuAry = ["33", "31", "30", "13", "11", "10", "03", "01", "00"];


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

                if (matchObj.hafu !== undefined) {
                	
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
				
				"<td>" +
				
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
				
				"<p><a class='o' href='javascript:void(0);'><span>主-主</span><b><label class='oddsItem'>" + matchObj.hafu.hh + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>主-平</span><b><label class='oddsItem'>" + matchObj.hafu.hd + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>主-客</span><b><label class='oddsItem'>" + matchObj.hafu.ha + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-主</span><b><label class='oddsItem'>" + matchObj.hafu.dh + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-平</span><b><label class='oddsItem'>" + matchObj.hafu.dd + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-客</span><b><label class='oddsItem'>" + matchObj.hafu.da + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-主</span><b><label class='oddsItem'>" + matchObj.hafu.ah + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-平</span><b><label class='oddsItem'>" + matchObj.hafu.ad + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-客</span><b><label class='oddsItem'>" + matchObj.hafu.aa + "</label></b></a></p>" +
				
				"</dt>" +
				
				"</dl>" +
				
				"</div>" +

                " </td>"+
				
				"</td>" +
						
				"</div>" +

                " </td>"+

                "</tr>";
                }
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



        //

        $("#dataList .Kuaitou select").change(function() {

            var tmpAry = [];

            var isNull = false;

            $(this).closest(".Kuaitou").find("select").each(function() {

                if ($(this).val() == "" || $(this).val() == "半场" || $(this).val() == "全场") {

                    isNull = true;

                } else {

                    tmpAry.push($(this).val());

                }

            });

            var trObj = $(this).closest("tr");

            var tmpKey = trObj.attr("id");

            trObj.find(".active").removeClass("active");

            if (isNull) {

                $(this).closest("tr").find(".active").removeClass("active");

                if (selAry[tmpKey] != undefined) {

                    delete (selAry[tmpKey]);

                }

            } else {

                if (selAry[tmpKey] == undefined) {

                    selAry[tmpKey] = {};

                    selAry[tmpKey].pool = curPool;

                    selAry[tmpKey].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

                    selAry[tmpKey].num = trObj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + trObj.find(".hideMatch").text();

                    selAry[tmpKey].hostTeam = trObj.find("hn").text();

                    selAry[tmpKey].guestTeam = trObj.find("gn").text();



                    //判断场数

                    if (!checkSelCount()) {

                        $(this).removeClass("active");

                        return;

                    }

                    

                } else {

                    selAry[tmpKey].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

                }

                for (var m = 0; m < 9; m++) {

                    if (tmpAry[0].indexOf(hafuAry[m].charAt(0)) != -1 && tmpAry[1].indexOf(hafuAry[m].charAt(1)) != -1) {

                        var oddsItem = trObj.find(".OddsTd a").eq(m);

                        oddsItem.addClass("active");

                        selAry[tmpKey].odds[m + poolOptionIndex[curPool]] = Number(oddsItem.text());

                    }

                }

            }

            fillSelPan();

            fillOptionsPan();

            calculate();

        });

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
/football/ttg_list.php">总进球</a></td>
	  <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php" class="active">半全场</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php">比分</a></td>
    </tr>
  </table>
</div>
<!--touzhuNav end-->
<!---->
<table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
</table>
<!--投注center end-->
<!--center end-->
<!--确认投注 strat-->
<script src="<?php echo ((is_array($_tmp='wap_betbox.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<!--确认投注 end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>