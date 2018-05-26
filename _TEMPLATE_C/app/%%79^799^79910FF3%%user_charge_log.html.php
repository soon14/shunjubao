<?php /* Smarty version 2.6.17, created on 2016-02-19 01:28:53
         compiled from user_charge_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge_log.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
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
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="0" style="width:100%; overflow:hidden;">
      <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php" class="active">充值记录</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></div></td>
    </table>
    <div style="padding:18px 0 0 0;">
      <div class="boldtxt">
        <table width="100%" border="1"  cellpadding="0" cellspacing="0">
          <tr>
            <th>交易类型</th>
            <th>时间</th>
            <th>订单号</th>
            <th>收入</th>
          </tr>
          <?php $this->assign('trade_amount_in', 0); ?>
          <?php $this->assign('trade_money_in', 0); ?>
          <?php $_from = $this->_tpl_vars['userChargeInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userChargeInfo']):
        $this->_foreach['log']['iteration']++;
?>
          <?php $this->assign('trade_amount_in', $this->_tpl_vars['trade_amount_in']+1); ?>
          <?php $this->assign('trade_money_in', $this->_tpl_vars['userChargeInfo']['money']+$this->_tpl_vars['trade_money_in']); ?>
          <tr>
            <td><?php echo $this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userChargeInfo']['log_type']]['desc']; ?>
</td>
            <td><p><?php echo $this->_tpl_vars['userChargeInfo']['create_time']; ?>
</p></td>
            <td><?php echo $this->_tpl_vars['userChargeInfo']['pay_order_id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['userChargeInfo']['money']; ?>
</strong></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
        <?php if (! $this->_tpl_vars['userChargeInfos']): ?>
        <div class="tips">暂时没有您的信息! </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
        <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
        <?php endif; ?>
        <?php endif; ?> </div>
    </div>
  </div>
</div>
<!--用户中心账户明细 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>