<?php /* Smarty version 2.6.17, created on 2018-03-04 23:17:58
         compiled from virtual_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'virtual_list.html', 8, false),)), $this); ?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $this->_tpl_vars['TEMPLATE']['title']; ?>
-为家乡的球队加油，CBA\中超-积分投注，竞猜CBA\中超来智赢!!</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['TEMPLATE']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['TEMPLATE']['description']; ?>
" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='touzhu.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='float.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
</script>
</head>
<script type="text/javascript">
	$(document).ready(function(){
		$.post(Domain + '/prize/getPrize.php', {
			type : 1,
			limit : 40,
		}, function(data) {
			var jishi_html = '';
			if(data.ok) {
				var data_msg = data.msg;
				jishi_html += "<ul>";
				for(var key in data_msg) {
					jishi_html += "<li>"+data_msg[key].u_name+"<span>"+data_msg[key].prize+"元</span></li>";
				}
				jishi_html += "</ul>"
			}
			$("#scrollDiv_keleyi_com").html(jishi_html);
		}, 'json'
		);
		
	$("#subBtn").click(function(){
		var Multiple = Number($("#Multiple").val());
		Multiple = Multiple - 1;
		$("#Multiple").val(Multiple);
		cal();
	});
	$("#addBtn").click(function(){
		var Multiple = Number($("#Multiple").val());
		Multiple = Multiple + 1;
		$("#Multiple").val(Multiple);
		cal();
	});
	
	$("#Multiple").change(function(){
		cal();
	});
	$("#Multiple").keyup(function(){
		cal();
	});
	$(".o").click(function() {
		var active = $(this).hasClass("active");
		if(active) {
			$(this).removeClass("active");
		} else {
			$(this).addClass("active");
		}
		cal();
	});
	 
	$(".hideMatch").click(function(){
		var tr = $(this).closest('tr');
		tr.addClass('none');
	});
	
	$("#submit1").click(function(){
		
		var Multiple = $("#Multiple").val();
		var money = $("#money").val();
		var combination = $("#combination").val();
		if(money==''||money==0) return false;
		if(Multiple==''||Multiple==0) return false;
		if(combination=='') return false;
		
		return true;
	});
});
//投注1|h#1&a#1,2|a#2
function getCombination() {
	var combination = '';
	$(".match").each(function(){
		if(!$(this).hasClass('none')) {
			var a = $(this).find('.o');
			var odds = '';
			var matchId = $(this).attr('matchId');
			a.each(function(){
				if($(this).hasClass('active')) {
					var odd = $(this).attr('odd');
					if($(this).hasClass('oddh')) {
						odd = 'h#' + odd;
					}
					if($(this).hasClass('odda')) {
						odd = 'a#' + odd;
					}
					odds += odd + '&';
				}
			});
			if(odds !=''){
				odds = odds.substr(0, odds.length - 1);
				combination += matchId + '|' + odds + ',';
			}
		}
	});
	if(combination !='') combination = combination.substr(0, combination.length - 1);
	return combination;
}
//计算投注积分
function cal() {
	var Multiple = Number($("#Multiple").val());
	
	if(isNaN(Multiple)) {
		Multiple = 1;
	}
	
	if(Multiple>=100001) {
		alert('最大允许投注100000倍');
		Multiple=100000;
	}
	
	if(Multiple==0) Multiple=1;
	
	$("#Multiple").val(Multiple);
	
	var select = 0;
	$(".o").each(function(){
		if($(this).hasClass("active")) select++;
	});
	
	var money = select*Multiple*2;
	$("#betMoney").text(money);
	$("#money").val(money);
	$("#combination").val(getCombination());
}
</script>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="2015top" style="height:60px; background:#BC1E1F;">
  <div style="width:1000px; margin:0 auto; position:relative; height:120px; text-align:left;">
    <div><a href="http://www.zhiying365365.com/"><img src="http://www.zhiying365365.com/www/statics/i/logo.jpg"></a></div>
    <div class="daiyu">
      <h1>积分投注，专为中国CBA、中超球迷提供！</h1>
    </div>
  </div>
</div>
<div class="tipsters">
  <div class="NewsNav">
    <h1><em> <span>支持中国人自己的联赛！<br/>
      积分竞猜CBA/中超赢取彩金...</span></em> </h1>
  </div>
</div>
<!--智赢页面头部 end-->
<!--当前位置 start-->
<div class="jflocation">
  <div class="jflc_center">
    <ul>
      <li><a href="http://www.zhiying365365.com/ticket/virtual_list.php" class="active">积分投注</a></li>
      <li><a href="http://zhiying365365.com/Activities/zhongchao/tzgz.html">投注规则</a></li>
      <li><a href="http://zhiying365365.com/Activities/zhongchao/jfgz.html">积分规则</a></li>
    </ul>
    <div class="zhongjiang"><b>最新中奖用户：</b>
      <div id="scrollDiv_keleyi_com" class="scrollDiv"> </div>
      <script type="text/javascript">
		function AutoScroll(obj){
		$(obj).find("ul:first").animate({
		marginTop:"-25px"
		},500,function(){
		$(this).css({marginTop:"0px"}).find("li:first").appendTo(this);
		});
		}
		$(document).ready(function(){
		setInterval('AutoScroll("#scrollDiv_keleyi_com")',3000);
		});
		</script>
    </div>
  </div>
</div>
<!--当前位置 end-->
<!--center start-->
<div class="center">
  <div class="BitCenter">
    <div>
      <div class="Kjnav3">
        <div class="jf_Nav">
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
            <dt><b>对阵</b></dt>
          </dl>
          <dl class="six">
            <dt>主队</dt>
          </dl>
          <dl class="seven">
            <dt>盘口</dt>
          </dl>
          <dl class="eight">
            <dt>客队</dt>
          </dl>
          <div class="clear"></div>
        </div>
      </div>
      <div>
        <table width="100%" border="0" cellpadding="0" cellspacing="1" class="stripe" id='datalist'>
          <?php $_from = $this->_tpl_vars['vb_lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <tr class="match" matchId="<?php echo $this->_tpl_vars['item']['id']; ?>
">
            <td class="dc1"><a href="javascript:void(0);" class="hideMatch"><?php echo $this->_tpl_vars['item']['num']; ?>
</a></td>
            <td class="dc3" style="background:#<?php if ($this->_tpl_vars['item']['sport'] == 'fb'): ?>4D94FC<?php else: ?>FF6600<?php endif; ?>; color:#fff;"><?php echo $this->_tpl_vars['sportDesc'][$this->_tpl_vars['item']['sport']]['desc']; ?>
</td>
            <td class="dc4"><?php echo $this->_tpl_vars['item']['start_time']; ?>
</td>
            <td class="dc5" style="width:220px;"><div class="duiNamE"><b><?php echo $this->_tpl_vars['item']['host_team']; ?>
</b><u>VS</u><em><?php echo $this->_tpl_vars['item']['guest_team']; ?>
</em></div></td>
            <td class="dc6"><div class="jftouzhu"><b><a class="o oddh" href="javascript:void(0);" odd="<?php echo $this->_tpl_vars['item']['h']; ?>
"><?php echo $this->_tpl_vars['item']['h']; ?>
</a></b></div></td>
            <td class="dc7"><div class="zcsfqb"><?php echo $this->_tpl_vars['item']['remark']; ?>
</div></td>
            <td class="dc6"><div class="jftouzhu"><b><a class="o odda" href="javascript:void(0);" odd="<?php echo $this->_tpl_vars['item']['a']; ?>
"><?php echo $this->_tpl_vars['item']['a']; ?>
</a></b></div></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
    </div>
  </div>
</div>
<form action="<?php echo @ROOT_DOMAIN; ?>
/confirm/confirm_vb.php" method="post" id="form1">
  <div class="betbox">
    <div>
      <table>
        <tbody>
          <tr>
            <td><div class="Tbeishu">
                <ul>
                  <li class="show">投注倍数：</li>
                  <li><a class="" href="javascript:void(0);" id="subBtn">-</a></li>
                  <li class="text">
                    <input type="text" value="1" maxlength="7" autocomplete="off" id="Multiple" name="multiple">
                  </li>
                  <li><a class="" href="javascript:void(0);" id="addBtn">+</a></li>
                  <li class="jf">投注<b id="betMoney">0</b>积分</li>
                </ul>
              </div>
              <div class="jftouzhutips"><span>*</span>所有赛事只能投注单场，不能串关，足球篮球更不能混合投注</div></td>
            <td><div class="BetCheckT">
                <div class="touzhuSub">
                  <input type="hidden" name="money" id="money" value="0"/>
                  <input type="hidden" name="combination" id="combination" value=""/>
                  <input type="submit" id="submit1" value="立即投注">
                </div>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</form>
<!--center end-->
<div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
</body>
</html>