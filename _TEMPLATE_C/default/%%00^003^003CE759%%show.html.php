<?php /* Smarty version 2.6.17, created on 2018-03-04 22:55:02
         compiled from show.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'show.html', 3, false),array('modifier', 'getPoolDesc', 'show.html', 60, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='shaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='newshaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
<div id="fade" class="black_overlay"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="tipsters">
  <div class="NewsNav">
    <dl>
      <dt>
        <h1><em>智赢网智赢晒单、跟单中心！停止盲目投注...</em></h1>
        <h2><em>跟随智赢高手<span>，</span>让您的利润蒸蒸日上 ! </em></h2>
      </dt>
      <dd>
        <ol>
          <li><img src="http://www.shunjubao.xyz/www/statics/i/tuijianw.jpg"></li>
          <li>
            <p><strong>智赢团队推荐号</strong></p>
            <p>zhiyingwangtuandui</p>
            <p>第一手资讯及推荐！</p>
          </li>
        </ol>
      </dd>
    </dl>
  </div>
</div>
<div style=" width:1000px; margin:0 auto 15px auto;"><a href="https://mp.weixin.qq.com/s/PzoAsxEnJeGNDy_uZL4j1w" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/18.png" width="1000"></a></div>
<!--center start-->
<div class="shaiTag" style="position:relative;">
  <ul>
    <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.html"   <?php if ($this->_tpl_vars['sport'] == 'fb' || $this->_tpl_vars['sport'] == ''): ?> class='active' <?php endif; ?>>竞彩足球</a></li>
    <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/bkshow.html" <?php if ($this->_tpl_vars['sport'] == 'bk'): ?> class='active'<?php endif; ?> >竞彩篮球</a></li>
    <li style="position:relative;left:-25px;"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/dingzhi.php" style="color:#dc0000;">跟单定制</a></li>
    <li class="gs"><a href="http://www.shunjubao.xyz/help/dingzhi.html">如何定制?</a><a href="http://www.shunjubao.xyz/help/shaidan.html">晒单问题?</a></li>
  </ul>
  <div class="clear"></div>
</div>
<div style="position:relative;">
  <script>
function turnoff(obj){
document.getElementById(obj).style.display="none";
}
</script>
  <div class="gendanCenter">
    <div class="sdList"> <?php $_from = $this->_tpl_vars['show_tickets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
      <div class="sdListC">
        <dl>
          <dt><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html" target="_blank"><img src="<?php if ($this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"></a>
            <p><b><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html" target="_blank"><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</a></b></p>
            <p class="gendan"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html" target="_blank"><?php if ($this->_tpl_vars['item']['is_end']): ?><span>查看</span><?php else: ?>跟单<?php endif; ?> </a></p>
          </dt>
          <dd>
            <p class="show"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow/<?php echo $this->_tpl_vars['item']['id']; ?>
.html" target="_blank"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['item']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['item']['pool'])); ?>
</a><strong><?php if ($this->_tpl_vars['item']['prize_state'] == 1): ?> <a  href="javascript::void(0);"  href="javascript:void();" onClick="show_tips('<?php echo $this->_tpl_vars['item']['id']; ?>
','<?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_id']; ?>
','<?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_nick']; ?>
','<?php echo $this->_tpl_vars['item']['prize']; ?>
')" >打赏</a><?php endif; ?></strong></p>
            <p class="show"><b>晒单时间：</b><u><?php echo $this->_tpl_vars['item']['datetime']; ?>
</u></p>
            <p class="show"><b>结束时间：</b><u><?php echo $this->_tpl_vars['item']['endtime']; ?>
</u></p>
            <p class="show"><b>投注金额：</b><span><i>&yen;<?php echo $this->_tpl_vars['item']['money']; ?>
</i></span></p>
            <p class="show"><b>跟单金额：</b><span><i>&yen;<?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_money']; ?>
</i></span></p>
            <p class="show"><b>跟单人数：</b><u><?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_sum']; ?>
人</u></p>
            <?php if ($this->_tpl_vars['item']['pay_rate'] > 0): ?>
            <p class="show"><b>提成比例：</b><u><?php echo $this->_tpl_vars['item']['pay_rate']; ?>
%</u></p>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['item']['prize_state'] == 1): ?>
            <p><em>赢</em></p>
            <?php endif; ?> </dd>
        </dl>
      </div>
      <?php endforeach; endif; unset($_from); ?>
      <div class="clear"></div>
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
<!--footer start--->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->

<div id="light2" class="white_content" style="top:17%;">
  <div class="MSCenter">
    <h1>打赏<span><a href="javascript:void(0)" onClick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl class="tips">
        <dd>此晒单中了<strong id="prize" style="color:#dc0000;">0</strong>元,我要给<strong id="partent_u_nick" style="color:#dc0000;">0</strong>打赏。</dd>
      </dl>
      <dl>
        <dt>打赏金额</dt>
        <dd style="position:relative;left:-5px;">
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
        <dt>其它金额</dt>
        <dd class="text" style=" position:relative;top:-10px;">
          <input type="text" name="other_tips_money" id="other_tips_money" style="width:230px;border:1px solid #ddd;" value="" onKeyUp="clearNoNum(this)">
          &nbsp;&nbsp;
          元</dd>
        <dd>
      </dl>     
      <dl class="tips" style="padding:0 0 0 30px;">
        <dd><span>*</span>&nbsp;&nbsp;温馨提示：提交后，打赏额度直接从您账户余额扣除。</dd>
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