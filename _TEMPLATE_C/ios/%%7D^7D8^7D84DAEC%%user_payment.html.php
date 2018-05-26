<?php /* Smarty version 2.6.17, created on 2016-06-14 14:14:12
         compiled from user_payment.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_payment.html', 4, false),)), $this); ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "userinfor.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='app_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<body>
<script type="text/javascript">
TMJF(function($) {
	$("#submit").submit(function(){
		if ($("#pay_type").val() == '') {
			alert('支付类型不能为空');
			return false;
		}
		if ($("#pay_account").val() == '') {
			alert('帐号信息不能为空');
			return false;
		}
		return true;
	});
});
</script>
<!--用户支付宝及财付通信息 start-->
<div class="center">
  <div class="ustitle">
    <h1><em>快捷提款账号<b></b><i></i></em></h1>
    <div class="wap_loginC">
      <form action="" method="post">
        <div class="kuaiti">
          <p>支付类型</p>
          <p>
            <select name="pay_type" style="height:28px; line-height:28px;">
              <option value='' selected>===请选择===</option>
              <?php $_from = $this->_tpl_vars['payTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['userPaymentInfo']['pay_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

              </option>
              <?php endforeach; endif; unset($_from); ?>
            </select>
            <b style="font-size:12px; padding:0 0 0 5px;color:#dc0000;">选择提现支付类型</b> </p>
          <p>支付帐号</p>
          <p>
            <input type='text' class="ustext" value="<?php echo $this->_tpl_vars['userPaymentInfo']['pay_account']; ?>
" style="width:230px;" name="pay_account"/>
          </p>
          <p class="sub">
            <input type="submit" class="loginsub" value="保&nbsp;&nbsp;&nbsp;存" />
          </p>
          <?php if ($this->_tpl_vars['msg_error']): ?>
          <p class="error"><?php echo $this->_tpl_vars['msg_error']; ?>
</p>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['msg_success']): ?>
          <p class="right"><?php echo $this->_tpl_vars['msg_success']; ?>
</p>
          <?php endif; ?> </div>
      </form>
      <div class="clear"></div>
    </div>
  </div>
</div>
<!--用户支付宝及财付通信息 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>