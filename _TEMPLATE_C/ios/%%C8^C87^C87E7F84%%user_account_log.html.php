<?php /* Smarty version 2.6.17, created on 2016-09-20 05:09:40
         compiled from user_account_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_account_log.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head><body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "userinfor.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
    });
	
	$("#end_time").focus(function(){
        showCalendar('end_time', 'y-mm-dd');
    });	
	$("table tr:nth-child(odd)").css("background-color","#f1f1f1");
});
</script>
<!--用户中心账户明细 start-->
<div class="ustitle">
  <h1><em>个人账户明细<b></b><i></i></em></h1>
</div>
<div class="Paymingxi">
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="0" style="width:100%;overflow:hidden;">
      <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php" class="active">账户明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></div></td>
    </table>
    <div class="boldtxt" style="padding:18px 0 0 0;">
      <table width="100%" border="1"  cellpadding="0" cellspacing="0">
        <tr>
          <th>类型</th>
          <th>时间</th>
          <th>收入</th>
          <th>支出</th>
          <th>余额</th>
        </tr>
        <?php $this->assign('trade_amount_out', 0); ?>
        <?php $this->assign('trade_amount_in', 0); ?>
        <?php $this->assign('trade_money_out', 0); ?>
        <?php $this->assign('trade_money_in', 0); ?>
        <?php $_from = $this->_tpl_vars['userAccountLogInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userAccountLogInfo']):
        $this->_foreach['log']['iteration']++;
?>
        <?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 1): ?>
        <?php $this->assign('trade_amount_in', $this->_tpl_vars['trade_amount_in']+1); ?>
        <?php $this->assign('trade_money_in', $this->_tpl_vars['trade_money_in']+$this->_tpl_vars['userAccountLogInfo']['money']); ?>
        <?php else: ?>
        <?php $this->assign('trade_money_out', $this->_tpl_vars['trade_money_out']+$this->_tpl_vars['userAccountLogInfo']['money']); ?>
        <?php $this->assign('trade_amount_out', $this->_tpl_vars['trade_amount_out']+1); ?>
        <?php endif; ?>
        <tr>
          <td><div style="width:30px; height:22px; line-height:22px; overflow:hidden;"><?php echo $this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['desc']; ?>
</div></td>
          <td><p><?php echo $this->_tpl_vars['userAccountLogInfo']['create_time']; ?>
</p></td>
          <td><b><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 1): ?><?php echo $this->_tpl_vars['userAccountLogInfo']['money']; ?>
元<?php endif; ?></b></td>
          <td><strong><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 2): ?><?php echo $this->_tpl_vars['userAccountLogInfo']['money']; ?>
元<?php endif; ?></strong></td>
          <td><b><?php echo $this->_tpl_vars['userAccountLogInfo']['account_money']; ?>
元</b></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
    </div>
    <?php if (! $this->_tpl_vars['userAccountLogInfos']): ?>
    <div class="tips">暂时没有您的信息! </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
    <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
</div>
<!--用户中心账户明细 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>