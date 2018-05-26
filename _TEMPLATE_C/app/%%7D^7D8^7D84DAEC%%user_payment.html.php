<?php /* Smarty version 2.6.17, created on 2016-02-25 23:19:26
         compiled from user_payment.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
<div class="ustitle">
  <h1><em>绑定支付宝帐号<b></b><i></i></em></h1>
</div>
<div class="center">
  <div class="tipss">
    <p><b>温馨提示：</b></p>
    <p>1）绑定支付宝帐号</p>
    <p>2）选择提现到支付宝资金瞬间到账</p>
  </div>
  <form action="" method="post">
    <div class="biaodan"> <?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <br/>
      <br/>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <br/>
      <br/>
      <?php endif; ?>
      <dl>
        <dt>到账类型：</dt>
        <dd>
          <select name="pay_type" style="height:32px; line-height:32px;border:1px solid #ccc; width:100%;border:none; background:none;">
            <option value='' selected>===请选择===</option>
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
        <dt>支付帐号</dt>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userPaymentInfo']['pay_account']; ?>
" name="pay_account"/>
        </dd>
      </dl>
      <div class="tijiao">
        <input type="submit" value="保&nbsp;&nbsp;&nbsp;存"  style="width:230px;"/>
      </div>
    </div>
  </form>
</div>
<!--用户支付宝及财付通信息 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>