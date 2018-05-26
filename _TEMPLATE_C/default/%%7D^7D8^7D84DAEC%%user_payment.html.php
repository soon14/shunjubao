<?php /* Smarty version 2.6.17, created on 2017-10-15 18:07:24
         compiled from user_payment.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_payment.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
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
<!--用户支付宝信息 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>我的账户-快捷提款账户</h1>
    <div style="padding:50px 0 0 0; text-align:left;">
      <div class="tabuser">
        <ul>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">实名认证</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php">绑定银行卡</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php" class="active">绑定支付宝</a></li>
        </ul>
      </div>
    </div>
    <div class="clear"></div>
    <h2><em>!</em>填写保存您的支付宝帐号，提现申请时选择提现到支付宝，资金瞬间到账!</h2>
  </div>
  <form action="" method="post">
    <div class="userbiaodan">
      <dl>
        <dt>支付类型：</dt>
        <dd>
          <select name="pay_type" style="height:36px;line-height:36px;border:1px solid #ccc; width:290px;text-align:center;">
            <option value='' selected>==请选择==</option>
            <?php $_from = $this->_tpl_vars['payTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['userPaymentInfo']['pay_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
        </dd>
      </dl>
      <dl>
        <dt>支付帐号：</dt>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userPaymentInfo']['pay_account']; ?>
" name="pay_account">
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <input type="submit" class="sub" value="保&nbsp;&nbsp;&nbsp;存" />
        </dd>
      </dl>
      <?php if ($this->_tpl_vars['msg_error']): ?>
      <dl>
        <dt></dt>
        <dd> <?php echo $this->_tpl_vars['msg_error']; ?>
 </dd>
      </dl>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <dl>
        <dt></dt>
        <dd> <?php echo $this->_tpl_vars['msg_success']; ?>
 </dd>
      </dl>
      <?php endif; ?> </div>
  </form>
</div>
<!-- end-->
</body>
</html>