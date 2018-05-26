<?php /* Smarty version 2.6.17, created on 2017-10-14 18:08:55
         compiled from user_charge_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge_log.html', 2, false),)), $this); ?>
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
<body>
<!--用户中心账户明细 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>账户明细-充值记录</h1>
  </div>
  <div class="msg">
    <div class="tabuser">
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php" class="active">充值记录</a></li>
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
/account/user_site_from.php">我的推广</a></li>
      </ul>
    </div>
    <div class="" style="padding:20px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <td colspan="5" class="show" style="padding: 0 0 10px 0;border-bottom:none;">收入交易笔数：<?php echo $this->_tpl_vars['trade_amount_in']; ?>
&nbsp;&nbsp;&nbsp;收入金额合计：<span style="color:#dc0000;"><?php echo $this->_tpl_vars['trade_money_in']; ?>
元</span></td>
        </tr>
        <tr>
          <form method="post">
            <td colspan="5" class="show" style="padding: 0 0 20px 0;">开始时间：
              <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
              &nbsp;结束时间：
              <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
              &nbsp;
              &nbsp;
              <input class="sub" name="" type="submit" value="查询"></td>
          </form>
        </tr>
        <tr>
          <th>交易类型</th>
          <th align="center">交易时间</th>
          <th align="center">订单号</th>
          <th align="right">收入</th>
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
          <td align="center"  style="color:#999;"><?php echo $this->_tpl_vars['userChargeInfo']['create_time']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['userChargeInfo']['pay_order_id']; ?>
</td>
          <td align="right"><?php echo $this->_tpl_vars['userChargeInfo']['money']; ?>
元</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php if (! $this->_tpl_vars['userChargeInfos']): ?>
        <tr>
          <td colspan="5" class="show" style="border-bottom:none; background:#FFFFCC;">暂时没有您的信息!</td>
        </tr>
        <?php endif; ?>
      </table>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
        <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
      <?php endif; ?>
      <?php endif; ?> </div>
  </div>
</div>
<!--用户中心账户明细 end-->
</body>
</html>