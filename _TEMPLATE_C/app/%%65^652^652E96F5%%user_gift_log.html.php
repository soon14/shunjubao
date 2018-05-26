<?php /* Smarty version 2.6.17, created on 2016-02-25 14:34:25
         compiled from user_gift_log.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
<div class="ustitle">
  <h1><em>个人账户明细<b></b><i></i></em></h1>
</div>
<div class="Paymingxi">
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="0" style="width:100%; overflow:hidden;">
      <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php" class="active">彩金明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></div></td>
    </table>
    <div style="padding:18px 0 0 0;">
      <div class="boldtxt">
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
          <?php $this->assign('gift', 0); ?>
          <?php $_from = $this->_tpl_vars['userGiftLogInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userGiftLogInfo']):
        $this->_foreach['log']['iteration']++;
?>
          <?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userGiftLogInfo']['log_type']]['direction'] == 1): ?>
          <?php $this->assign('gift', $this->_tpl_vars['userGiftLogInfo']['old_gift']+$this->_tpl_vars['userGiftLogInfo']['gift']); ?>
          <?php $this->assign('trade_amount_in', $this->_tpl_vars['trade_amount_in']+1); ?>
          <?php $this->assign('trade_money_in', $this->_tpl_vars['trade_money_in']+$this->_tpl_vars['userGiftLogInfo']['gift']); ?>
          <?php else: ?>
          <?php $this->assign('gift', $this->_tpl_vars['userGiftLogInfo']['old_gift']-$this->_tpl_vars['userGiftLogInfo']['gift']); ?>
          <?php $this->assign('trade_money_out', $this->_tpl_vars['trade_money_out']+$this->_tpl_vars['userGiftLogInfo']['gift']); ?>
          <?php $this->assign('trade_amount_out', $this->_tpl_vars['trade_amount_out']+1); ?>
          <?php endif; ?>
          <tr>
            <td><?php echo $this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userGiftLogInfo']['log_type']]['desc']; ?>
</td>
            <td><p><?php echo $this->_tpl_vars['userGiftLogInfo']['create_time']; ?>
</p></td>
            <td><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userGiftLogInfo']['log_type']]['direction'] == 1): ?><?php echo $this->_tpl_vars['userGiftLogInfo']['gift']; ?>
<?php endif; ?></td>
            <td><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userGiftLogInfo']['log_type']]['direction'] == 2): ?><?php echo $this->_tpl_vars['userGiftLogInfo']['gift']; ?>
<?php endif; ?></td>
            <td><?php echo $this->_tpl_vars['userGiftLogInfo']['old_gift']; ?>
</td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
      <div> <?php if (! $this->_tpl_vars['userGiftLogInfos']): ?>
        <div class="tips" style=" padding:4px 0;background:#FFFFCC;">暂无数据! </div>
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