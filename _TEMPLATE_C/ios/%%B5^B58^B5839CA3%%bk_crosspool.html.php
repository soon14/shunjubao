<?php /* Smarty version 2.6.17, created on 2016-03-12 10:41:16
         compiled from confirm/bk_crosspool.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/bk_crosspool.html', 452, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

var curPool = "crosspool";

var curPos = { gameCode: "bk", gameType: "竞彩篮球", poolName: "混合过关", dataPool: "mnl,hdc,wnm,hilo" };

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

		            htmStr += "<div><tr><td><div class='DQtime'>" + obj.day + "<em>[11:30-次日11:30]</em><span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>显示隐藏[<label class='hideNum'>0</label>]场</a></strong></div></td></tr>";

		            htmStr += "<tr d='" + i + "'><td><table cellpadding='0' cellspacing='0'>";

		            var listObj = obj.matchs[0];

		            var count = 0;

		            for (var key in listObj) {

		                count++;

		                var matchObj = listObj[key];

		                matchData[key] = matchObj.wnm;

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
						
						"<dt class='zk'><a class='openOtherPool' href='javascript:void(0);'><em>&rsaquo;</em>&nbsp;展开玩法</a></dt>" +
								  
						"</dd>" +
								  
						"<dl>" +
						
						"</div>" +
						
						"</td>" +
						
						"<td>" +
						
						"<div class='hhglanc'>" +
						
						"<ul>" +
				
						"<li><b><hn>" +matchObj.a_cn+ "</hn></b></li>" +
						
						"<li><span>VS</span></li>" +
						
						"<li><strong><gn>" + matchObj.h_cn+ "</gn></strong></li>" +
						
						"</ul>" +
						
						"<dl>" +
				
						"<dt>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>客胜</b><label class='oddsItem'>" + ((matchObj.mnl == undefined) ? "" : matchObj.mnl.a) + "</label></a></p>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>主胜</b><label class='oddsItem'>" + ((matchObj.mnl == undefined) ? "" : matchObj.mnl.h) + "</label></a></p>" +
						
						"<p class='rQ'><b>胜负</b></p>" +
						
						"</dt>" +
						
						"</dl>" +
						
						"<dl>" +
				
						"<dt>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>客胜</b><label class='oddsItem'>" + ((matchObj.hdc == undefined) ? "" : matchObj.hdc.a) + "</label></a></p>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>主胜</b><label class='oddsItem'>" + ((matchObj.hdc == undefined) ? "" : matchObj.hdc.h) + "</label></a></p>" +
						
						"<p class='rQ'><b>让分</b><span class='line' pool='hdc'><label class='oddsItem'>" + matchObj.hdc.goalline + "</span></p>" +
						
						"</dt>" +
						
						"</dl>" +
						
						"<dl>" +
				
						"<dt>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>大分</b><label class='oddsItem'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.h) + "</label></a></p>" +
						
						"<p><a class='o' href='javascript:void(0);'><b>小分</b><label class='oddsItem'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.l) + "</label></a></p>" +
						
						"<p class='rQ'><b>大小</b><span class='AsK line' pool='hilo'>" + ((matchObj.hilo == undefined) ? "" : matchObj.hilo.goalline) + "</span></p>" +
						
						"</dt>" +
						
						"</dl>" +
						
						"</div>" +
						
						"</td>" +
						
						"</div>" +

		                "</td>" +

		                "</tr>" +

		              "<tr a=1>"

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

		        filterHtm = "";

		        for (var i = 0; i < matchNameAry.length; i++) {

		            filterHtm += "<em><input type='checkbox' checked />" + matchNameAry[i].name + "[" + matchNameAry[i].len + "]</em>";

		        }

		        $("#fMatches").html(filterHtm);



		        //展开按钮

		        $("#dataList .openOtherPool").click(function() {

		            var obj = $(this).closest("tr").next();

		            if (obj.html() == "") {

		                var tmpData = matchData[$(this).closest("tr").attr("id")];

		                if (tmpData == undefined) {

		                    obj.html("<td colspan='3'><div class='OddsTd noneDade'>没有数据！</div></td>");

		                } else {

		                    obj.html(" <div>" +
							
							"<td width='65'>"+
							
							"<div class='Saishi'><h1>胜分差</h1></div>"+
							
							"</td>"+
							
							"<td>"+
							
							"<div class='hhglanc'>"+
							
							"<dl>" +
					
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>1-5</b></strong><label class='oddsItem'>" + tmpData.l1 + "</label></a></p>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>6-10</b></strong><label class='oddsItem'>" + tmpData.l2 + "</label></a></p>" +
							
							"<p class='fc'><span>客胜</span></p>" +
							
							"</dt>" +
							
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>11-15</b></strong><label class='oddsItem'>" + tmpData.l3 + "</label></a></p>" +
											
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>16-20</b></strong><label class='oddsItem'>" + tmpData.l4 + "</label></a></p>" +
							
							"<p class='fc'><span>客胜</span></p>" +
							
							"</dt>" +
							
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>21-25</b></strong><label class='oddsItem'>" + tmpData.l5 + "</label></a></p>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>26+</b></strong><label class='oddsItem'>" + tmpData.l6 + "</label></a></p>" +
							
							"<p class='fc'><span>客胜</span></p>" +
							
							"</dt>" +
							
							
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>1-5</b></strong><label class='oddsItem'>" + tmpData.w1 + "</label></a></p>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>6-10</b></strong><label class='oddsItem'>" + tmpData.w2 + "</label></a></p>" +
							
							"<p class='fc'><span>主胜</span></p>" +
							
							"</dt>" +
							
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>11-15</b></strong><label class='oddsItem'>" + tmpData.w3 + "</label></a></p>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>16-20</b></strong><label class='oddsItem'>" + tmpData.w4 + "</label></a></p>" +
							
							"<p class='fc'><span>主胜</span></p>" +
							
							"</dt>" +
							
							"<dt>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>21-25</b></strong><label class='oddsItem'>" + tmpData.w5 + "</label></a></p>" +
							
							"<p class='fc'><a class='o' href='javascript:void(0);'><strong><b>26+</b></strong><label class='oddsItem'>" + tmpData.w6 + "</label></a></p>" +
							
							"<p class='fc'><span>主胜</span></p>" +
							
							"</dt>" +
							
							"</dl>" +
							
							"</div>"+
							
							"</td>"+
							
							"</div>"+
							
		              		"</div></td>");

		                }



		                //全选按钮

		                obj.find(".selAllOdds").click(function() {

		                    var obj = $(this).closest("tr").prev();

		                    var oObj = $(this).closest(".LcOtherC").find(".o");



		                    //selAry

		                    var key = $(this).closest("tr").prev().attr("id");

		                    if (selAry[key] == undefined) {

		                        selAry[key] = {};

		                        if (curPos.gameCode == "fb") {

		                            selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

		                        } else {

		                            selAry[key].odds = [1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1];

		                        }



		                        selAry[key].num = obj.closest("table").closest("tr").prev().find(".DQtime").find("b").text().substr(0, 2) + obj.find(".hideMatch").text();

		                        selAry[key].hostTeam = obj.find("hn").text();

		                        selAry[key].guestTeam = obj.find("gn").text();

		                        //if (curPool == "had") selAry[key].goalLine = obj.attr("l");

		                        //判断场数

		                        if (!checkSelCount()) {

		                            //$(this).removeClass("active");

		                            return;

		                        }

		                    }




		                    oObj.addClass("active");

		                    oObj.each(function() {

		                        var index = oObj.index($(this));

		                        selAry[key].odds[index + 6] = $(this).text();

		                    });

		                    //

		                    fillSelPan();

		                    fillOptionsPan();

		                    calculate();

		                });

		                //全清按钮

		                obj.find(".clearAllOdds").click(function() {

		                    $(this).closest(".LcOtherC").find(".o").removeClass("active");

		                    //selAry

		                    var oObj = $(this).closest(".LcOtherC").find(".o");

		                    var key = $(this).closest("tr").prev().attr("id");

		                    if (selAry[key] != undefined) {

		                        oObj.each(function() {

		                            var index = oObj.index($(this));

		                            selAry[key].odds[index + 6] = 1;

		                        });



		                        if (eval(selAry[key].odds.join("*")) == 1) {

		                            delete (selAry[key]);

		                        }



		                        fillSelPan();

		                        fillOptionsPan();

		                        calculate();

		                    }

		                });

		                //关闭按钮

		                obj.find(".closeOtherPool").click(function() {

		                    $(this).closest("tr").hide();

		                });



		            } else {

		                obj.show();

		            }



		        });

		        //默认第一展开

		        $("#dataList .openOtherPool:eq(0)").click();

		    }
	
</script>
<script src="<?php echo ((is_array($_tmp='publicFunc.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/javascript"></script>
<body>
<!--top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--touzhuNav start-->
<div class="touzhusubNav">
  <h1 class="hdc">竞彩篮球<em><a href="<?php echo @ROOT_DOMAIN; ?>
/basketball/hdc_list.php">让分胜负</a><a href="<?php echo @ROOT_DOMAIN; ?>
/basketball/bk_crosspool.php" class="active">混合过关</a> <a href="<?php echo @ROOT_DOMAIN; ?>
/basketball/wnm_list.php">胜分差</a><a href="<?php echo @ROOT_DOMAIN; ?>
/basketball/hilo_list.php">大小分</a></em></h1>
</div>
<!--touzhuNav end-->
<!--center start-->
<div class="center">
  <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
  </table>
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