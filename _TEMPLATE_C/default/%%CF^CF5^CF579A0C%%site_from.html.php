<?php /* Smarty version 2.6.17, created on 2017-10-15 10:12:13
         compiled from site_from.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'site_from.html', 2, false),array('modifier', 'number_format', 'site_from.html', 109, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
</script>
<script type="text/javascript">
$(function() {
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
    });
	
	$("#end_time").focus(function(){
        showCalendar('end_time', 'y-mm-dd');
    });	
});
</script>
<style>
.page{padding:25px 0 ;text-align:center;font-size:14px;clear:both;margin: 0 auto;text-align:center;}
.page li{display:inline-table;display:inline-block;zoom:1;*display:inline; margin:0 0 10px 0;}
.page a{border:1px solid #ccc;padding:5px 10px;color:#000;font-size:14px;margin:0 1px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.page a:hover{border:1px solid #dc0000;background:#fff;}
.page .thisclass{border:1px solid #dc0000;background:#dc0000;margin:0 1px;color:#fff;padding:4px 9px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.page li span{display:none;}
.page li select{display:none;}
</style>
<body>
<div><?php if (! $this->_tpl_vars['action']): ?>
  <?php if ($this->_tpl_vars['siteFromInfo']): ?>
  <div class="rightcenetr" style="text-align:left;">
    <h1><span>▌</span>账户明细-推广</h1>
    <div style="padding:50px 0 0 0;">
      <div class="tabuser">
        <ul>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现记录</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_follow_prize.php">提成明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php">我的打赏</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php">打赏我的</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php" class="active">我的推广</a></li>
        </ul>
      </div>
    </div>
    <h2 style="font-size:14px; line-height:24px;">简单的说就是智赢用户生成一个推广链接地址，之后拿生成出来的链接去推广（QQ群、微信、图片、文字等等资源），通过此链接进来注册的用户，并产生投注行为，就可以拿到1%的返点啦~~~返点于每星期一早上9：00发放至账户余额里边，返点可以用于投注或直接申请提现。</h2>
    <br/>
    <br/>
    <br/>
    <p>还在等什么？让您的账号更具价值-智赢推广中心期待您的加入!</p>
    <br/>
    <br/>
  </div>
  <div class="tuiguang">我的推广链接地址是：<?php echo $this->_tpl_vars['siteFromInfo']['link']; ?>
<a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php?action=show">查看详细数据</a></div>
  <?php else: ?>
  <div class="tuiguang"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php?action=create">创建我的推广链接</a></div>
  <?php endif; ?><?php endif; ?>
  <?php if ($this->_tpl_vars['action'] == 'show'): ?>
  <div style="text-align:left;"class="rightcenetr" >
    <h1 style="padding:0 0 50px 0;"><span>▌</span>账户明细-推广</h1>
    <div style="padding:0 0 20px 0;">
      <div class="tabuser">
        <ul>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现记录</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_follow_prize.php">提成明细</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php">我的打赏</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php">打赏我的</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php" class="active">我的推广</a></li>
        </ul>
      </div>
    </div>
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese" style="display:;">
      <tr>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">
          <td colspan="3" class="show" style="padding: 0 0 20px 0;">开始时间：
            <input type="text" value="<?php echo $this->_tpl_vars['start_time']; ?>
" id="start_time" name="start_time">
            &nbsp;结束时间：
            <input type="text" value="<?php echo $this->_tpl_vars['end_time']; ?>
" id="end_time" name="end_time">
            &nbsp;
            <input type="submit" class="sub" value="查询" name="">
            <input type="hidden" value="show" name="action"></td>
        </form>
      </tr>
    </table>
    <!--增加功能-->
    <div >
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <th>注册日期</th>
          <th align="center">用户名</th>
          <th align="center">认证用户</th>
          <th align="center">充值金额</th>
          <th align="center">投注金额</th>
          <th align="center">返点</th>
        </tr>
        <?php $_from = $this->_tpl_vars['site_from_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['a'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['a']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['site_from_list']):
        $this->_foreach['a']['iteration']++;
?>
        <tr>
          <td align="left" style="color:#777;"><?php echo $this->_tpl_vars['site_from_list']['u_jointime']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['site_from_list']['u_name']; ?>
</td>
          <td align="center"><?php if ($this->_tpl_vars['site_from_list']['idcard'] > 0): ?> 是 <?php else: ?>  <?php endif; ?></td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['charge_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['total_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['refund_total_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php if (! $this->_tpl_vars['site_from_list']): ?>
        <tr>
          <td colspan="6" class="show" style="border-bottom:none; background:#FFFFCC;">暂时没有您的信息!</td>
        </tr>
        <?php endif; ?>
      </table>
      <div style="padding:15px 0 0 0;">注册用户总数：<?php echo $this->_tpl_vars['return']['total_registers']; ?>
人&nbsp;&nbsp;认证用户总数：<?php echo $this->_tpl_vars['return']['total_idcards']; ?>
人&nbsp;&nbsp;有效投注量：<?php echo $this->_tpl_vars['return']['total_money']; ?>
元&nbsp;&nbsp;总返点：<?php echo $this->_tpl_vars['return']['total_money_refund']; ?>
元&nbsp;&nbsp;</div>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
        <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
      <?php endif; ?>
      <?php endif; ?> </div>
    <!--增加功能 end-->
  </div>
  <div class="imgtips"  style="text-align:left;">
    <p>特别说明：推广所获得返点于每星期一早上9：00发放至账户余额里边，返点可以直接申请提现。</p>
  </div>
  <?php endif; ?> </div>
</body>
</html>