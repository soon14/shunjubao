<?php /* Smarty version 2.6.17, created on 2018-03-05 02:37:26
         compiled from user_follow_prize.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_follow_prize.html', 2, false),)), $this); ?>
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

<div>
  <div class="rightcenetr">
    <h1><span>▌</span>账户明细-提成明细</h1>
  </div>
  <div class="msg" style="text-align:left;">
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
/account/user_follow_prize.php" class="active">提成明细</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php">我的打赏</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php">打赏我的</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">我的推广</a></li>
      </ul>
    </div>
    <div style="padding:15px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
      
      	 <tr>
          <td colspan="8" class="show" style="padding: 0 0 10px 0;border-bottom:none;">提成总金额：<span style="color:#dc0000;"><?php echo $this->_tpl_vars['dingzhi_total_f_prize']; ?>
元</span></td>
        </tr>
        <tr>
          <form method="post">
            <td colspan="8" class="show" style="padding: 0 0 20px 0;">开始时间：
              <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
              &nbsp;结束时间：
              <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
              &nbsp;
              <input class="sub" name="" type="submit" value="查询"></td>
          </form>
        </tr>
      
        <tr>
          <th>定制用户</th>
          <th align="center">被跟订单</th>
          <th align="center">定制订单</th>
          <th align="center">中奖金额</th>
          <th align="center">分成比例</th>
          <th align="center">分成金额</th>
          <th align="center">分成状态</th>
          <th align="center">分成时间</th>
        </tr>
        <?php $_from = $this->_tpl_vars['dingzhi_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item']['iteration']++;
?>
        <tr>
          <td><?php echo $this->_tpl_vars['item']['u_name']; ?>
</td>
          <td align="center" style="color:#999;"><a target="_blank" href="http://www.zhiying365365.com/account/ticket/<?php echo $this->_tpl_vars['item']['partent_id']; ?>
.html"><?php echo $this->_tpl_vars['item']['partent_id']; ?>
</a></td>
          <td align="center" style="color:#999;"><?php echo $this->_tpl_vars['item']['ticket_id']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['prize']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['pay_rate']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['f_prize']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['f_status_show']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['f_time']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        
        <?php if (! $this->_tpl_vars['dingzhi_array']): ?>
        <tr>
          <td colspan="9" class="show" style="border-bottom:none; background:#FFFFCC;">暂时没有分成的信息!</td>
        </tr>
        <?php endif; ?>
        <tr>
          <td colspan="9" class="show" style="border-bottom:none; background:#FFFFCC;">小计：<?php echo $this->_tpl_vars['total_f_prize']; ?>
</td>
        </tr>
      </table>
    </div>
  </div>
  <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
  <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
    <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
  <?php endif; ?>
  <?php endif; ?> </div>
<!--用户中心我的定制 end-->
</body></html>