<?php /* Smarty version 2.6.17, created on 2018-03-04 22:54:46
         compiled from show.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'show.html', 2, false),array('modifier', 'getPoolDesc', 'show.html', 139, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_shaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<style>
.black_overlay{display:none;background-color:#999;width:100%;height:100%;left:0;top:0;/*FF IE7*/
filter:alpha(opacity=80);/*IE*/
opacity:0.8;/*FF*/
z-index:9999999999999999999999;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/

}



.black_overla{display:none;background-color:#999;width:100%;height:100%;left:0;top:0;/*FF IE7*/
filter:alpha(opacity=80);/*IE*/
opacity:0.8;/*FF*/
z-index:9999999999999999999999;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/

}


.white_content{display:none;left:0%;/*FF IE7*/
top:0;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/}


.white_conten{display:none;left:0%;/*FF IE7*/
top:0;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/background:#000;opacity:0.9;filter:alpha(opacity=90);height:100%;}
.white_conten h1{ height:50px;line-height:50px;}
.white_conten h1 a{}
.white_conten h1 a:hover{}
.white_conten dl{display:inline-table;display:inline-block;zoom:1;*display:inline;vertical-align:middle;text-align:center;}
.white_conten dl dt img {}
.white_conten dl dd{color:#fff;margin:0 auto;text-align:left;padding:20px 0 0 0;font-size:14px;}
.white_conten dl dd span{color:#666;font-size:12px;float:right;}
.MSCenter{border:2px solid #888;width:94%;height:100%;margin:0 auto;text-align:left;background:#fff;padding:10px;position:relative;margin:0 auto auto auto; text-align:left;}
.MSCenter h1{font-size:18px;font-weight:900;font-family:'微软雅黑';border-bottom:1px solid #ccc;height:40px;line-height:40px;position:relative; padding:0 0 10px 0; margin:0;}
.MSCenter h1 a{padding:0 0 0 10px;position:absolute;right:10px;top:0;color:#565656;font-size:14px;color:#dc0000;}
.MSCenter h2{font-size:12px;font-weight:300;font-family:'';height:24px;line-height:24px;text-align:center;background:#ccc;position:absolute;left:0;bottom:0;display:block;width:100%;color:#999;}
.sdanopenwindows{}
.sdanopenwindows h4{ height:40px; line-height:40px; font-weight:300; font-size:12px; padding:20px 0 0 28px;}
.sdanopenwindows h4 strong{ font-size:14px; font-weight:900;color:#dc0000;}
.sdanopenwindows ul li.sub{padding:15px 0 0 45px;}
.sdanopenwindows ul li.sub input{border:none;background:#CE050B;color:#fff;width:234px;height:38px;line-height:38px;text-align:center;font-size:16px;font-weight:900;cursor:pointer;font-family:'微软雅黑';display:inline-table;display:inline-block;zoom:1;*display:inline;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.sdanopenwindows dl{ padding:10px 0;}
.sdanopenwindows dl.tips{ padding:5px;color:#777; clear:both; text-align:left;}
.sdanopenwindows dl.tips span{ font-size:14px; font-weight:900;color:red; position:relative;top:3px;left:-3px;}
.sdanopenwindows dl dt{ font-size:14px; height:50px; line-height:50px; font-weight:900;}
.sdanopenwindows dl dd{display:inline-table;display:inline-block;zoom:1;*display:inline; font-size:14px; font-size:12px;}
.sdanopenwindows dl dd.text{ padding:15px 0 5px 0;}
.sdanopenwindows dl dd.text input{ width:150px; height:26px; line-height:26px; text-align:center;}
.sdanopenwindows dl dd input{ position:relative;top:1px;}
.sdanopenwindows dl dd.sub{ margin:55px 0 150px 0;background:#CE050B; width:100%; height:38px; line-height:38px;display:inline-table;display:inline-block;zoom:1;*display:inline;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.sdanopenwindows dl dd.sub input{border:none; background:none;color:#fff;height:36px;line-height:36px;text-align:center;font-weight:900;cursor:pointer;font-family:'微软雅黑';display:inline-table;display:inline-block;zoom:1;*display:inline; width:100%; font-size:18px; letter-spacing:3px;}

.Dinzhism{ width:100%; margin:0 auto; text-align:left; line-height:24px; padding:10px 0; font-size:12px; font-size:14px; background:#f9f9f9;}
.Dinzhism p{ width:98%; margin:0 auto; text-align:left;}
.NavphTab{ position:relative;top:-5px;}
.NavphTab table{}
.NavphTab table tr{}
.NavphTab table tr td{background:#fff;}
.NavphTab table tr td a{color:#000;font-weight:900;font-size:14px;border-bottom:2px solid #ddd;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000;}

</style>
<body>
<div id="fade" class="black_overlay"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--center start-->
<div class="Dinzhism">
  <p>智赢晒单跟单中心！停止盲目投注...</p>
  <p>跟随智赢高手，让您的利润蒸蒸日上 ! </p>
</div>
<div class="gendanCenter">
  <div style=" height:80px;">
    <div style="background:url(http://www.zhiying365365.com/www/statics/i/64.png) no-repeat scroll transparent;background-size:100% 100%;height:100%;"><a href="https://mp.weixin.qq.com/s/PzoAsxEnJeGNDy_uZL4j1w">
      <div style=" display:block; width:100%; height:100%;">&nbsp;</div>
      </a></div>
  </div>
  <div>
    <div class="NavphTab">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/mshow.html" <?php if ($this->_tpl_vars['sport'] == 'fb' || $this->_tpl_vars['sport'] == ''): ?> class='active' <?php endif; ?>>竞彩足球</a></td>
          <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/bkmshow.html" <?php if ($this->_tpl_vars['sport'] == 'bk'): ?> class='active'<?php endif; ?> >竞彩篮球</a></td>
          <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/dingzhi.php">跟单定制</a></td>
        </tr>
      </table>
    </div>
  </div>
  <div class="shaidanlibiao">
    <table width="100%" border="0" cellpadding="10" cellspacing="0">
      <?php $_from = $this->_tpl_vars['show_tickets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
      <tr>
        <td valign="middle"><p><strong><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html"><img src="<?php if ($this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"></a></strong><b><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow.php?userTicketId=<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</a></b><span style="position:relative;top:-12px; padding:0 0 0 10px;"><?php if ($this->_tpl_vars['item']['prize_state'] == 1): ?> <a href="javascript:void(0);" onClick="show_tips('<?php echo $this->_tpl_vars['item']['id']; ?>
','<?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_id']; ?>
','<?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_nick']; ?>
','<?php echo $this->_tpl_vars['item']['prize']; ?>
')" >打赏</a><?php endif; ?></span></p>
          <p>玩法类型：<span><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['item']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['item']['pool'])); ?>
</span></p>
          <p>晒单时间：<span><?php echo $this->_tpl_vars['item']['datetime']; ?>
</span></p>
          <p>结束时间：<span><?php echo $this->_tpl_vars['item']['endtime']; ?>
</span></p>
          <p>投注金额：<span><?php echo $this->_tpl_vars['item']['money']; ?>
元</span></p>
          <p>跟单金额：<span><?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_money']; ?>
元</span></p>
          <p>跟单人数：<span><?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_sum']; ?>
人</span></p>
          <?php if ($this->_tpl_vars['item']['pay_rate'] > 0): ?>
          <p>提成比例：<span><?php echo $this->_tpl_vars['item']['pay_rate']; ?>
%</span></p>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['item']['prize_state'] == 1): ?>
          <p><em>赢</em></p>
          <?php endif; ?>
          <p><u><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html"><?php if ($this->_tpl_vars['item']['is_end']): ?><i>查看详细</i><?php else: ?>我要跟单<?php endif; ?></a></u></p></td>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </table>
  </div>
  <?php if ($this->_tpl_vars['total_page'] > 1): ?>
  <div class="sharepages"> <a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
">首页</a> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
" class="active">上一页</a> <?php endif; ?>
    <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
" class="active">下一页</a> <?php endif; ?> <a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
&page=<?php echo $this->_tpl_vars['total_page']; ?>
">末页</a> </div>
  <?php endif; ?> </div>
</div>
<!--center end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
<div id="light2" class="white_content">
  <div class="MSCenter">
    <h1>打赏<span><a href="javascript:void(0)" onClick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl class="tips" style="padding:20px 0 0 0;">
        <dd>此晒单中了<strong id="prize" style="color:#dc0000;">0</strong>元,我要给<strong id="partent_u_nick" style="color:#dc0000;">0</strong>打赏。</dd>
      </dl>
      <dl>
        <dt>打赏金额</dt>
        <dd>
          <input type="radio" name="tips_money" checked value="1">
          1元</dd>
        <dd>
          <input type="radio" name="tips_money" value="2">
          2元</dd>
        <dd>
          <input type="radio" name="tips_money" value="5">
          5元</dd>
        <dd>
          <input type="radio" name="tips_money" value="10">
          10元</dd>
        <dd>
          <input type="radio" name="tips_money" value="50">
          50元</dd>
        <dd>
          <input type="radio" name="tips_money" value="100">
          100元</dd>
      </dl>
      <dl>
        <dt>其他金额</dt>
        <dd class="text" style="border:1px solid #ccc; width:99%; height:34px; line-height:34px; overflow:hidden; padding:0;">
          <input type="text" name="other_tips_money" id="other_tips_money" style="border:none;  background:#fff; width:99%; height:38px; line-height:38px; position:relative;top:-4px;" value="" onKeyUp="clearNoNum(this)">
        </dd>
        <dd>
      </dl>
      <dl class="tips">
        <dd><span>*</span>温馨提示：提交后，打赏额度直接从您账户余额扣除。</dd>
      </dl>
      <dl>
        <dd class="sub">
          <input id="add_tips_userTicketId" type="hidden" value="">
          <input id="tips_to" type="hidden" value="">
          <input type="button" name="sd" value="提交" id="sd"  onClick="return mytips()">
        </dd>
      </dl>
    </div>
    <h2>红单打赏-感谢晒单人，小小意思下。</h2>
  </div>
</div>
<script>

function show_tips(userTicketId,partent_u_id,partent_u_nick,prize){
	
	$("#other_tips_money").val('');
	$("#add_tips_userTicketId").val(userTicketId);
	$("#tips_to").val(partent_u_id);
	$("#partent_u_nick").html(partent_u_nick);
	$("#prize").html(prize);
	$("#light2").show();
	$("#fade").show();
}


function mytips(){
	var userTicketId = $("#add_tips_userTicketId").val();
	var tips_to = $("#tips_to").val();
	var other_tips_money = $("#other_tips_money").val();
	if(other_tips_money>0){
		var tips_money = other_tips_money;//其它打赏金额
	}else{
		var tips_money = $('input[name="tips_money"]:checked').val();//打赏金额
	}
	

	$.post(Domain + '/operate.php'
                , {id: userTicketId,tips_to:tips_to,tips_money:tips_money,
					operate:'addtips'
                  }
                , function(data) {
                    if (data.ok) {
                    	alert('打赏成功，谢谢你的打赏！');
                    	window.location.reload(true);
                    } else {
						$("#light2").hide();
						$("#fade").hide();
                    	alert(data.msg);
                    }
                }
                , 'json'
            );	
	
}
function clearNoNum(obj){  
  obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符   
  obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的   
  obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");  
  obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数   
  if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额  
   obj.value= parseFloat(obj.value);  
  }  
} 
</script>
</body>
</html>