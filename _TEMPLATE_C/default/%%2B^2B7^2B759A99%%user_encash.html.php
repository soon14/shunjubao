<?php /* Smarty version 2.6.17, created on 2017-10-15 08:15:43
         compiled from user_encash.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_encash.html', 2, false),)), $this); ?>
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
<!--提现记录 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>账户明细-提现记录</h1>
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
/account/user_encash.php" class="active">提现记录</a></li>
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
	</div>
    <div style="padding:20px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <form method="post">
          <tr>
            <td colspan="3" class="show" style="padding:30px 0 20px 0;border-bottom:none;">开始时间：
              <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
              &nbsp;结束时间：
              <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
              &nbsp;
              <input type="submit" class="sub" value="查询" name="submit">
        </form>
        <tr>
          <td>时间</td>
          <td>提现额度</td>
          <td align="right">状态</td>
        </tr>
        <?php $_from = $this->_tpl_vars['userEncashInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userEncashInfo']):
        $this->_foreach['log']['iteration']++;
?>
        <tr>
          <td  style="color:#999;"><?php echo $this->_tpl_vars['userEncashInfo']['create_time']; ?>
</td>
          <td><?php echo $this->_tpl_vars['userEncashInfo']['money']; ?>
元</td>
          <td align="right"><?php echo $this->_tpl_vars['EncashStatusDesc'][$this->_tpl_vars['userEncashInfo']['encash_status']]['desc']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
      <div class="clear"></div>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pageC">
        <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?> </div>
      </div>
      <?php endif; ?> </div>
  </div>
</div>
<!--提现记录 end-->
</body>
</html>