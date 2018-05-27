<?php /* Smarty version 2.6.17, created on 2018-02-22 01:18:30
         compiled from user_withdraw.html */ ?>
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
<div class="" style="text-align:left; background:#FFFFCC;width:100%;font-size:14px; line-height:24px;">
  <div class="tipss" style="padding:10px 0;">
    <p><b>温馨提示：</b></p>
    <p>1）选择提现到支付宝资金瞬间到账！</p>
    <p>2）如银行卡及支付宝账户信息变动，请联系我们的在线客服或致电QQ:1323698651。</p>
    <p>3）<span style="color:#dc0000;">投注额度达到每次充值额度的50%方可提现。</span></p>
  </div>
</div>
<div class="center">
  <div class="biaodan">
    <form action='' method='post'>
      <?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <?php endif; ?>
      <dl>
        <dt>账户余额&nbsp;<span style="color:#dc0000;"><?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
</span></dt>
      </dl>
      <dl>
        <dt style="position:relative;">提现方式<span style="float:right; position:absolute:right:0;"><a href='<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php' style="color:#666;">未绑定支付宝？</a></span></dt>
        <dd>
          <select name='payment' style="height:32px; line-height:32px;border:1px solid #ccc; width:100%;border:none; background:none;">
            <?php $_from = $this->_tpl_vars['EncashPaymentDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['userPaymentInfo']['pay_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
          <?php if (! $this->_tpl_vars['userPaymentInfo']): ?><?php endif; ?></dd>
      </dl>
      <dl>
        <dd>
          <input type="text" name="money" placeholder="提现金额"  id="withdraw_money"/>
          <input type="hidden" name='u_id' id="u_id" value="<?php echo $this->_tpl_vars['userInfo']['u_id']; ?>
"/>
        </dd>
      </dl>
      <dl>
        <dd>
          <input type="text" name="mobile" id="mobile" placeholder="手机号码" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
"/>
        </dd>
      </dl>
       
      <div class="tijiao">
        <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" id="submit" />
      </div>
    </form>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>