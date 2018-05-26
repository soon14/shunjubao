<?php /* Smarty version 2.6.17, created on 2016-02-18 21:19:14
         compiled from confirm/fb_crosspool.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/fb_crosspool.html', 427, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

    var curPool = "crosspool";

    var curPos = { gameCode: "fb", gameType: "竞彩足球", poolName: "混合过关",dataPool:"had,hhad,crs,ttg,hafu" };

    var matchData = {};



    function getDataBack(data) {
    					
    				if (Number(data.total) == 0) {
    		            alert("暂无开售赛事！");
    		            return;
    		        }

        var matchNameAry = [];

        var tmpAry = data.datas;

        var filterHtm = "";

        var htmStr = "<tr><td colspan='8' style='padding:0; margin:0;'>";

        for (var i = 0; i < tmpAry.length; i++) {

            var obj = tmpAry[i];

           htmStr += "<div><tr><td><div class='DQtime'>" + obj.day + "<span><a href='javascript:void(0)' class='foldBtn'>隐藏</a></span><strong><a href='javascript:void(0);' class='showHide'>显示隐藏[<label class='hideNum'>0</label>]场</a></strong></div></td></tr>";

            htmStr += "<tr d='" + i + "'><td><table cellpadding='0' cellspacing='0'>";

            var listObj = obj.matchs[0];

            var count = 0;

            for (var key in listObj) {

                count++;

                var matchObj = listObj[key];

                matchData[key] = { crs: matchObj.crs, ttg: matchObj.ttg, hafu: matchObj.hafu };

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
								"<td style='width:65px;'>" +
								
									"<div class='hbifen' style='height:140px;'>"+
									
										"<dl>" +
										
										 "<dd>" +
										  
										  "<p><b style='background:" + matchObj.l_color + "; color:#fff;font-size:12px;height:24px;line-height:24px;'>" + matchObj.l_cn + "</b></p>" +
										  
										  "<p><strong><u></u><i></i>"+ matchObj.num + "<span>"+ matchObj.time+"</span><em>截止</em></strong></p>" +
										  
										  "<p><a class='openOtherPool' href='javascript:void(0);'>展开玩法</a></p>" +
								  
										  "</dd>" +
										  
										"</dl>" +
										
									 "</div>" +
									 
								"</td>" +	
														
								"<td style='width:100%;'>" +
								
								"<div class='hbifen' style='height:140px;'>"+
								
								"<dl>" +
									
									"<dt>" +
						  
									  "<h1><b><hn>" + matchObj.h_cn + "</hn></b><span>VS</span><strong><gn>" + matchObj.a_cn + "</gn></strong><a class='hideMatch' href='javascript:void(0);'>隐藏本场</a></h1>" +
									  
									  "<p><a class='o" + ((matchObj.had_key == "" && matchObj.score=="") ? "" : " noBorder") + ((matchObj.had_key == "H") ? " oDis" : "") + "' href='javascript:void(0);'><i>0</i><span>主</span><b><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.h) + "</label></b></a></p>" +
									  
									  "<p><a class='o" + ((matchObj.had_key == "" && matchObj.score == "") ? "" : " noBorder") + ((matchObj.had_key == "D") ? " oDis" : "") + "' href='javascript:void(0);'><i>0</i><span>平</span><b><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.d) + "</label></b></a></p>" +
									  
									   "<p><a class='o" + ((matchObj.had_key == "" && matchObj.score == "") ? "" : " noBorder") + ((matchObj.had_key == "A") ? " oDis" : "") + "' href='javascript:void(0);'><i>0</i><span>客</span><b><label class='oddsItem'>" + ((matchObj.had == undefined) ? "" : matchObj.had.a) + "</label></b></p>" +
									   
									   "<p><a class='o" + ((matchObj.hhad_key == "" && matchObj.score == "") ? "" : " noBorder") + ((matchObj.hhad_key == "H") ? " oDis" : "") + "' href='javascript:void(0);'><u>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.goalline) + "</u><span>主</span><b><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.h) + "</label></b></a></p>" +
									  
									  "<p><a class='o" + ((matchObj.hhad_key == "" && matchObj.score == "") ? "" : " noBorder") + ((matchObj.hhad_key == "D") ? " oDis" : "") + "' href='javascript:void(0);'><u>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.goalline) + "</u><span>平</span><b><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.d) + "</label></b></a></p>" +
									  
									  "<p><a class='o" + ((matchObj.hhad_key == "" && matchObj.score == "") ? "" : " noBorder") + ((matchObj.hhad_key == "A") ? " oDis" : "") + "' href='javascript:void(0);'><u>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.goalline) + "</u><span>客</span><b><label class='oddsItem'>" + ((matchObj.hhad == undefined) ? "" : matchObj.hhad.a) + "</label></b></a></p>" +
						  
						  			"</dt>" +
						  
								"</dl>" +
								
								"</div>" +
								
								"</td>" +
								
						  "</td>" +
				
				"</tr>" +
				
                "<tr a=1>" +

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

                    obj.html("<td><div class='guoguanbifen OddsTd'>没有数据！</div></td>");

                } else {

                    obj.html("<td>" +
					
				"<td style='width:65px;' valign='top'>"+
				
				"<div class='wanfaType'>"+
				
				"<p class='cloes'><a class='closeOtherPool' href='javascript:void(0);'>关闭区域</a></p>"+
				
				"<ul>"+				
				
				"<li class='bifen'><b>比分</b></li>"+
				
				"<li class='bqc'><b>半全场</b></li>"+
				
				"<li class='zjq'><b>总进球</b></li>"+
				
				"</ul>"+
				
				"</div>"+
				
				"</td>"+

				"<td style='width:100%;'>"+
				
				" <div class='fbhhCenter'>"+
				
				" <div class='hbifen'>"+
				
				"<div>"+
				
				"<dl>" +
						  
				"<dt>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>1:0</span><b><label class='oddsItem'>" + tmpData.crs["0100"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>2:0</span><b><label class='oddsItem'>" + tmpData.crs["0200"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>2:1</span><b><label class='oddsItem'>" + tmpData.crs["0201"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>3:0</span><b><label class='oddsItem'>" + tmpData.crs["0300"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>3:1</span><b><label class='oddsItem'>" + tmpData.crs["0301"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>3:2</span><b><label class='oddsItem'>" + tmpData.crs["0302"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>4:0</span><b><label class='oddsItem'>" + tmpData.crs["0400"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>4:1</span><b><label class='oddsItem'>" + tmpData.crs["0401"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>4:2</span><b><label class='oddsItem'>" + tmpData.crs["0402"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>5:0</span><b><label class='oddsItem'>" + tmpData.crs["0500"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>5:1</span><b><label class='oddsItem'>" + tmpData.crs["0501"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>5:2</span><b><label class='oddsItem'>" + tmpData.crs["0502"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>胜+</span><b><label class='oddsItem'>" + tmpData.crs["-1-h"] + "</label></b></a></p>" +

				"<p><a class='o' href='javascript:void(0);'><span>0:0</span><b><label class='oddsItem'>" + tmpData.crs["0000"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>1:1</span><b><label class='oddsItem'>" + tmpData.crs["0101"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>2:2</span><b><label class='oddsItem'>" + tmpData.crs["0202"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>3:3</span><b><label class='oddsItem'>" + tmpData.crs["0303"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>平+</span><b><label class='oddsItem'>" + tmpData.crs["-1-d"] + "</label></b></a></p>" +

				"<p><a class='o' href='javascript:void(0);'><span>0:1</span><b><label class='oddsItem'>" + tmpData.crs["0001"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>0:2</span><b><label class='oddsItem'>" + tmpData.crs["0002"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>1:2</span><b><label class='oddsItem'>" + tmpData.crs["0102"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>0:3</span><b><label class='oddsItem'>" + tmpData.crs["0003"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>1:3</span><b><label class='oddsItem'>" + tmpData.crs["0103"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>2:3</span><b><label class='oddsItem'>" + tmpData.crs["0203"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>0:4</span><b><label class='oddsItem'>" + tmpData.crs["0004"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>1:4</span><b><label class='oddsItem'>" + tmpData.crs["0104"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>2:4</span><b><label class='oddsItem'>" + tmpData.crs["0204"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>0:5</span><b><label class='oddsItem'>" + tmpData.crs["0005"] + "</label></b></a></p>" +
								  
				"<p><a class='o' href='javascript:void(0);'><span>1:5</span><b><label class='oddsItem'>" + tmpData.crs["0105"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>2:5</span><b><label class='oddsItem'>" + tmpData.crs["0205"] + "</label></b></a></p>" +
						
				"<p><a class='o' href='javascript:void(0);'><span>负+</span><b><label class='oddsItem'>" + tmpData.crs["-1-a"] + "</label></b></a></p>" +
								  
				"</dt>" +
								  
				"</dl>" +
			
				"</div>" +
				
				"<div style='height:130px;;clear:both;'>"+
				
				"<dl>" +
				
				"<dt>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>主-主</span><b><label class='oddsItem'>" + tmpData.hafu.hh + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>主-平</span><b><label class='oddsItem'>" + tmpData.hafu.hd + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>主-客</span><b><label class='oddsItem'>" + tmpData.hafu.ha + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-主</span><b><label class='oddsItem'>" + tmpData.hafu.dh + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-平</span><b><label class='oddsItem'>" + tmpData.hafu.dd + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>平-客</span><b><label class='oddsItem'>" + tmpData.hafu.da + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-主</span><b><label class='oddsItem'>" + tmpData.hafu.ah + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-平</span><b><label class='oddsItem'>" + tmpData.hafu.ad + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>客-客</span><b><label class='oddsItem'>" + tmpData.hafu.aa + "</label></b></a></p>" +
				
				"</dt>" +
				
				"</dl>" +
				
				"</div>"+
				
				"<div style='height:130px;'>"+
				
				"<dl>" +
				
				"<dt>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>0球</span><b><label class='oddsItem'>" + tmpData.ttg.s0 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>1球</span><b><label class='oddsItem'>" + tmpData.ttg.s1 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>2球</span><b><label class='oddsItem'>" + tmpData.ttg.s2 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>3球</span><b><label class='oddsItem'>" + tmpData.ttg.s3 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>4球</span><b><label class='oddsItem'>" + tmpData.ttg.s4 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>5球</span><b><label class='oddsItem'>" + tmpData.ttg.s5 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>6球</span><b><label class='oddsItem'>" + tmpData.ttg.s6 + "</label></b></a></p>" +
				
				"<p><a class='o' href='javascript:void(0);'><span>7+球</span><b><label class='oddsItem'>"+ tmpData.ttg.s7 + "</label></b></a></p>" +
				
				"</dt>" +
				
				"</dl>" +
				
				" </div>" +
				
				" </div>" +
				
				
				"</td>"+
					
                "    </td>");

                }



                //全清按钮

                obj.find(".clearAllOdds").click(function() {

                $(this).closest(".OtherWanfa").find(".o").removeClass("active");

                    //selAry

                var oObj = $(this).closest(".OtherWanfa").find(".o");

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
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--top end-->
<!--touzhuNav start-->
<div class="touzhusubNav">
  <h1><em><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hhad_list.php">胜平负<span></span></a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/fb_crosspool.php" class="active">混合过关</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/ttg_list.php">总进球</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/hafu_list.php">半全场</a><a href="<?php echo @ROOT_DOMAIN; ?>
/football/crs_list.php">比分</a></em></h1>
</div>
<!--touzhuNav end-->
<!--center start-->
<div class="center">
  <!--投注center start-->
  <table id="dataList" width="100%" border="0" class="stripe" cellpadding="0" cellspacing="0">
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>