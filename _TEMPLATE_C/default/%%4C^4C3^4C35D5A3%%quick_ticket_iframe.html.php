<?php /* Smarty version 2.6.17, created on 2018-03-04 23:42:04
         compiled from quick_ticket_iframe.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'quick_ticket_iframe.html', 5, false),)), $this); ?>
<!DOCTYPE html>
<head>
<title>单关投注</title>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
var TMJF = jQuery.noConflict(true);
TMJF.conf = {
    	cdn_i: "<?php echo @STATICS_BASE_URL; ?>
/i"
    	, domain: "<?php echo @ROOT_DOMAIN; ?>
"
};
</script>
<script language="javascript" src="<?php echo ((is_array($_tmp='common.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<style>
</style>
</head>
<body>
<script type="text/javascript">
$(document).ready(function() {
	var host = '<?php echo @ROOT_DOMAIN; ?>
';
	var sport = '<?php echo $this->_tpl_vars['return']['sport']; ?>
';
    var matchStatus = '<?php echo $this->_tpl_vars['return']['status']; ?>
';
    
	$("#add").click(function(){
		var multiple = getMultiple();
		$("#multiple").val(multiple + 1);
		cal();
	});
	$("#dec").click(function(){
		var multiple = getMultiple();
		if(multiple == 1) {
			$("#multiple").val(1);
		} else {
			$("#multiple").val(multiple - 1);
		}
		cal();
	});
	$("#multiple").keyup(function(){
		cal();
	})
	$("#multiple").change(function(){
		cal();
	});
	$(".team").click(function(){
		$(".team").removeClass("active");
		$(this).addClass("active");
		cal();
		return false;
	});
	$("#form1").submit(function(){
		if($("#money").val()==0) return false; 
		if($("#prize").val()==0) return false;
		//是否可以投注
		if(isMatchEnd(sport, matchStatus)) return false;
		
        $("#multiple").val(getMultiple());
        $("#combination").val(getCombination());
        var action = host+"/confirm/confirm.php"
        if (sport == 'bd') {
        	action = host+"/confirm/confirm_bd.php";
        } 
        $("#form1").attr('action', action);
        return true;
	});
	isMatchEnd(sport, matchStatus);
});

	function cal() {
		var sport = '<?php echo $this->_tpl_vars['return']['sport']; ?>
';
		var spInfo = getSpInfo();
		var multiple = getMultiple();
		var money = multiple * 2;
		$("#show_money").html("<span>"+money+"元</span>");
		$("#money").val(money);
		var prize = Number(spInfo * money);
		if(sport == 'bd') prize *= 0.65;
		prize = Math.round(prize* 100)/100;
		$("#show_prize").html("奖金：<span>"+prize+"元</span>");
	}
	function getSpInfo() {
		return Number($(".active").attr('sp'));
	}
	function getMultiple() {
		return Number($("#multiple").val());
	}
	//crs|55692|0201#7
	function getCombination() {
		var pool = '<?php echo $this->_tpl_vars['return']['pool']; ?>
';
		var matchid = '<?php echo $this->_tpl_vars['return']['matchid']; ?>
';
		var code = $(".active").attr('code');
		var spInfo = getSpInfo();
		return pool+'|'+matchid+'|'+code+'#'+spInfo;
	}
	function isMatchEnd(sport, matchStatus) {
		if(sport == 'bd' && matchStatus != 0) {
			$("#submit").val('已截止');
			return true;
		}
		
		if(sport == 'fb' && matchStatus != 'Selling') {
			$("#submit").val('已截止');
			return true;
		}
		
		return false;
	}
</script>
<script>
    function scroll_news(){
    $(function(){
    $('#jishi li').eq(0).fadeOut('slow',function(){
    $(this).clone().appendTo($(this).parent()).fadeIn('slow');
    $(this).remove();
    });
    });
    }
    setInterval('scroll_news()',2000);
    </script>
<!--center start-->
<!--单关投注 start-->
<style>
#submit{ background:#6f6f6f;}
.xuanxiang{ display:block; margin:0 5px; height:48px; text-align:center;}
.xuanxiang strong{ display:block; text-align:center;color:#666; font-size:12px; font-weight:300; font-family:'宋体';color:#555;}
.xuanxiang a{ display:block;border:1px solid #ccc;-moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px; font-weight:900; font-size:18px; font-family:'微软雅黑'; line-height:24px;color:#000;}
.xuanxiang a.active{background: url(http://www.zhiying365365.com/www/statics/i/T1_pgo.gif) no-repeat right bottom;border:1px solid #E53C3F;}
.touzhudanguan{ font-size:12px;margin:0 auto;display:inline-table;display:inline-block;zoom:1;*display:inline; text-align:left;}
.touzhudanguan ul{display:inline-table;display:inline-block;zoom:1;*display:inline; position:relative;left:-30px; width:100%;}
.touzhudanguan ul li{display:inline-table;display:inline-block;zoom:1;*display:inline; vertical-align:text-top; position:relative;}
.touzhudanguan ul li.show{width:65px; height:30px; line-height:20px;border:1px solid #ccc;text-align:center;}
.touzhudanguan ul li a{ width:30px; height:30px; line-height:30px; text-align:center;display:block;border:1px solid #ccc; font-size:14px; font-weight:900;color:#000;}
.touzhudanguan ul li a:hover{}
.touzhudanguan ul li input{ width:62px; height:26px; line-height:26px;border:none; text-align:center;}
.touzhudanguan ul li span{color:#dc0000; font-size:14px;}
.touzhudanguan ul li#show_money{ line-height:30px; }
.touzhudanguan ul li#show_prize{line-height:30px;}
.touzhudanguan ul li.tijiao{ position:absolute;left:368px;}
.touzhudanguan ul li.tijiao input{ -moz-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;font-size:16px; font-family:'微软雅黑'; font-weight:300; background:#BC1E1F; width:130px; height:36px; line-height:36px; text-align:center;color:#fff; cursor:pointer;}
a{ text-decoration:none;}
</style>
<div>
  <form id='form1' target="_blank" method="post">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><div class="xuanxiang"><a href="javascript:void(0);" class="team active" code="h" sp="<?php echo $this->_tpl_vars['return']['spInfo']['h']; ?>
"><?php echo $this->_tpl_vars['return']['matchInfo']['h_cn']; ?>
<strong>主胜<?php echo $this->_tpl_vars['return']['spInfo']['h']; ?>
</strong></a></div></td>
        <td><div class="xuanxiang"><a href="javascript:void(0);" class="team" code="d" sp="<?php echo $this->_tpl_vars['return']['spInfo']['d']; ?>
">平局<strong><?php echo $this->_tpl_vars['return']['spInfo']['d']; ?>
</strong></a></div></td>
        <td><div class="xuanxiang"><a href="javascript:void(0);" class="team" code="a" sp="<?php echo $this->_tpl_vars['return']['spInfo']['a']; ?>
"><?php echo $this->_tpl_vars['return']['matchInfo']['a_cn']; ?>
<strong>客胜<?php echo $this->_tpl_vars['return']['spInfo']['a']; ?>
</strong></a></div></td>
      </tr>
      <tr>
        <td height="20" colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" colspan="3"><div class="touzhudanguan">
            <ul>
              <li><a href="javascript:void(0);" id="dec">-</a></li>
              <li class="show">
                <input type="text" value="1" id="multiple" name="multiple" onKeyUp="this.value=this.value.replace(/\D/g,'')">
              </li>
              <li><a href="javascript:void(0);" id="add">+</a></li>
              <li id="show_money"><span>2元</span></li>
              <li id="show_prize">奖金：<span><?php echo $this->_tpl_vars['return']['prize']; ?>
元</span></li>
			  <li class="tijiao"><input type="submit" value="立即购买" id="submit"/>
            <input type="hidden" value="2" id="money" name="money"/>
            <input type="hidden" value="<?php echo $this->_tpl_vars['return']['matchid']; ?>
" id="matchid"/>
            <input type="hidden" value="<?php echo $this->_tpl_vars['return']['sport']; ?>
" id="sport" name="sport"/>
            <input type="hidden" value="1x1" id="select" name="select"/>
            <input type="hidden" value="单关" id="user_select" name="user_select"/>
            <input type="hidden" value="" id="combination" name="combination"/>
            <input type="hidden" value="<?php echo $this->_tpl_vars['return']['pool']; ?>
" id="pool" name="pool"/>
			<li>
            </ul>
            
          </div></td>
      </tr>
    </table>
  </form>
</div>
<!--单关投注 edn-->
</body>
</html>