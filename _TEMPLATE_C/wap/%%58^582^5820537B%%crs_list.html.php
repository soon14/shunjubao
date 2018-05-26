<?php /* Smarty version 2.6.17, created on 2017-10-21 13:10:42
         compiled from confirm/crs_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/crs_list.html', 402, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "crs";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "比分", dataPool: "crs" };

    var matchData = {};

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

                matchData[key] = matchObj.crs;

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
						 
						  "<td>"+
						  
						  "<div class=''>" +
						  
						  "<td style='width:65px;'>"+
						  
						  "<div class='Saishi'>" +
						  
							"<dl>" +
									  
							"<dt><b class='name ssName' style='background:" + matchObj.l_color + "; color:#fff;'>" + matchObj.l_cn + "</b></dt>" +
									  
							"<dd>" +
									  
							"<p><u></u><i></i><strong>"+ matchObj.num + "</strong></p>" +
									  
							"<p><span>"+ matchObj.time+"</span><em>截止</em></p>" +
									  
							"</dd>" +
							
							"<dt class='hidden'><a class='hideMatch' href='javascript:void(0);'>隐藏本场</a></dt>" +
									  
							"<dl>" +
									  
							"</div>" +
						  
						  "</td>"+
						  
						  "<td>"+
						  
						  "<div class='zqbifen'>" +
						  
						  	"<ul>" +
				
							"<li><b><hn>" + matchObj.h_cn + "</hn></b></li>" +
							
							"<li><span>VS</span></li>" +
							
							"<li><strong><gn>" + matchObj.a_cn + "</gn></strong></li>" +
							
							"<li class='dg'>"+ ((matchObj.danguan == 1)? "<span class='danguan'>单</span>":"")+"</li>" +
							
							"</ul>" +
							
							"<ul>" +
							
							"<li>" +
							
							"<p><a class='crsFoldBtn' href='javascript:void(0);'>显示投注区</a></p>"+
							
							"<li>" +
							
							"</ul>" +
				
						  "</div>"+
						  
						  "</td>"+
						  
						  "</div>" +
						  
						  
						  "</td>"+
                "</tr>"+

                "<tr m='" + isFind + "' style='display:none;' a=1>" +

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

        //

        $("#dataList .crsFoldBtn").click(function() {

            if ($(this).text() == "显示投注区") {

                var obj = $(this).closest("tr").next();

                obj.show();

                if (obj.html() == "") {

                    var tmpData = matchData[$(this).closest("tr").attr("id")];

                    if (tmpData == undefined) {

                        obj.html("<td colspan='3'><div class='guoguanbifen OddsTd'>没有数据！</div></td>");

                    } else {
                    	
                    	var can_touzhu = true;//能否投注，比赛开始前8分钟停止投注

                        obj.html("<td colspan=\"0\">" +
						
						   "<div class=''>" +
						  
						   "<td style='width:65px;'>"+
						  
						   "<div class=''>" +
						  
						   "<ul>" +
						   
						   "<li><b>比分</b></li>" +
						   
						   "<li>(90分钟内，两队的比分)</li>" +
						   
						   "</ul>" +
									  
						   "</div>" +
						  
						   "</td>"+
						  
						   "<td>"+	
						  
						   "<div class='fbbifen'>" +
						  
						   "<dl>" +
						  
							"<dt>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>1:0</span><br/><label class='oddsItem'>" + tmpData["0100"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>2:0</span><br/><label class='oddsItem'>" + tmpData["0200"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>2:1</span><br/><label class='oddsItem'>" + tmpData["0201"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>3:0</span><br/><label class='oddsItem'>" + tmpData["0300"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>3:1</span><br/><label class='oddsItem'>" + tmpData["0301"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>3:2</span><br/><label class='oddsItem'>" + tmpData["0302"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>4:0</span><br/><label class='oddsItem'>" + tmpData["0400"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>4:1</span><br/><label class='oddsItem'>" + tmpData["0401"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>4:2</span><br/><label class='oddsItem'>" + tmpData["0402"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>5:0</span><br/><label class='oddsItem'>" + tmpData["0500"] +"</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>5:1</span><br/><label class='oddsItem'>" + tmpData["0501"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>5:2</span><br/><label class='oddsItem'>" + tmpData["0502"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>胜++</span><br/><label class='oddsItem'>" + tmpData["-1-h"] +"</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>0:0</span><br/><label class='oddsItem'>" + tmpData["0000"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>1:1</span><br/><label class='oddsItem'>" + tmpData["0101"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>2:2</span><br/><label class='oddsItem'>" + tmpData["0202"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>3:3</span><br/><label class='oddsItem'>" + tmpData["0303"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>平++</span><br/><label class='oddsItem'>" + tmpData["-1-d"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>0:1</span><br/><label class='oddsItem'>" + tmpData["0001"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>0:2</span><br/><label class='oddsItem'>" + tmpData["0002"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>1:2</span><br/><label class='oddsItem'>" + tmpData["0102"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>0:3</span><br/><label class='oddsItem'>" + tmpData["0003"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>1:3</span><br/><label class='oddsItem'>" + tmpData["0103"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>2:3</span><br/><label class='oddsItem'>" + tmpData["0203"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>0:4</span><br/><label class='oddsItem'>" + tmpData["0004"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>1:4</span><br/><label class='oddsItem'>" + tmpData["0104"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>2:4</span><br/><label class='oddsItem'>" + tmpData["0204"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>0:5</span><br/><label class='oddsItem'>" + tmpData["0005"] + "</label></a></p>" +
									  
							"<p><a class='o' href='javascript:void(0);'><span>1:5</span><br/><label class='oddsItem'>" + tmpData["0105"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>2:5</span><br/><label class='oddsItem'>" + tmpData["0205"] + "</label></a></p>" +
							
							"<p><a class='o' href='javascript:void(0);'><span>负++</span><br/><label class='oddsItem'>" + tmpData["-1-a"] + "</label></a></p>" +
									  
							"</dt>" +
									  
							"</dl>" +
						
						  "</div>"+
						  
						  "</td>"+
						  
						  "</div>" +
	
						"</td>");

                        obj.find(".crsSelAll").click(function() {

                            var oddsObj = $(this).closest("dl").find("dt");

                            var oddsItem = oddsObj.find("a");

                            var index = $(this).closest("tr").find(".crsSelAll").index($(this));

                            var rangeAry = [0, 13, 18];

                            var obj = $(this).closest("tr").prev();

                            var key = obj.attr("id");

                            if (oddsObj.find(".active").length == oddsItem.length) {

                                //全不选

                                oddsItem.removeClass("active");

                                //selAry

                                for (var m = 0; m < oddsItem.length-1; m++) {

                                    selAry[key].odds[m + rangeAry[index] + poolOptionIndex[curPool]] = 1;

                                }

                                if (eval(selAry[key].odds.join("*")) == 1) {

                                    delete (selAry[key]);

                                }

                            } else {

                                //全选

                                oddsItem.addClass("active");

                                //selAry

                                if (selAry[key] == undefined) {

                                    selAry[key] = {};

                                    selAry[key].pool = curPool;

                                    selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

                                    selAry[key].num = obj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + obj.find(".hideMatch").text();

                                    selAry[key].hostTeam = obj.find("hn").text();

                                    selAry[key].guestTeam = obj.find("gn").text();



                                    //判断场数

                                    if (!checkSelCount()) {

                                        $(this).removeClass("active");

                                        return;

                                    }

                                }

                                for (var m = 0; m < oddsItem.length-1; m++) {

                                    selAry[key].odds[m + rangeAry[index] + poolOptionIndex[curPool]] = Number(oddsObj.find("a").eq(m).contents().eq(2).text().replace(/ /g, ""));

                                }

                            }

                            fillSelPan();

                            fillOptionsPan();

                            calculate();

                        });

                    }

                }

                $(this).text("隐藏投注区");

            } else {

                $(this).closest("tr").next().hide();

                $(this).text("显示投注区");

            }

        });

        //默认第一展开

        $("#dataList .crsFoldBtn:eq(0)").click();

	  };    
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
/football/hafu_list.php">半全场</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php" class="active">比分</a></td>
    </tr>
  </table>
</div>
<!--touzhuNav end-->
<!--center start-->
<div class="center">
  <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
  </table>
</div>
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