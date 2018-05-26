<?php /* Smarty version 2.6.17, created on 2016-04-23 18:01:55
         compiled from user_withdraw.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_withdraw.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='app_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
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
	$("#submit").click(function(){
		var money = $("#withdraw_money").val()
		if (!$.common.Verify.isMoney(money)) {
			alert('金额不正确');
			return false;
		}
		return true;
	});
});
</script>
<!--用户提现 start-->
<div class="center">
  <div class="ustitle">
    <h1 style="font-size:12px;font-weight:300;color:#dc0000;"><em>当前账户额度：<span><u style="text-decoration:none;font-weight:900;"><?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
元</u></span><b></b><i></i></em></h1>
    <div class="wap_loginC" style="width:250px;position:relative;left:10px;">
      <div class="kuaiti">
        <form action='' method='post'>
          <p class="pad">提款姓名：<strong><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
</strong><span>您的姓名</span>&nbsp;归属地：<?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
<?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>
</p>
          <p class="pad"><?php echo $this->_tpl_vars['userRealInfo']['bank']; ?>
：<?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>
&nbsp;(银行卡号)</p>
          <p class="other">提现方式：
            <select name='payment' style='height:30px;line-height:30px;width:70px;'>
              <?php $_from = $this->_tpl_vars['EncashPaymentDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['userPaymentInfo']['pay_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>

              </option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
            <?php if (! $this->_tpl_vars['userPaymentInfo']): ?><?php endif; ?><a href='<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php'>完善其他提现方式</a></p>
          <p class="other" style="padding:10px 0;">提现金额：
            <input type="text" class="ustext" name="money" id="withdraw_money" style="width:150px; height:22px; line-height:22px; "/>
            <input type="hidden" name='u_id' id="u_id" value="<?php echo $this->_tpl_vars['userInfo']['u_id']; ?>
"/>
          </p>
          <p class="other" style="padding:5px 0;">手机号码：
              <input type="text" class="ustext" name="mobile" id="mobile" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
" style="width:150px; height:22px; line-height:22px; "/></p>
          <p class="sub">
            <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" class="loginsub" id="submit"/>
          </p>
          <?php if ($this->_tpl_vars['msg_error']): ?>
          <p class="error"><?php echo $this->_tpl_vars['msg_error']; ?>
</p>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['msg_success']): ?>
          <p class="error"><?php echo $this->_tpl_vars['msg_success']; ?>
</p>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>