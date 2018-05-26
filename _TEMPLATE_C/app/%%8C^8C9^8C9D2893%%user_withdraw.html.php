<?php /* Smarty version 2.6.17, created on 2017-04-17 06:20:33
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
<div class="" style="text-align:left; background:#FFFFCC; padding:5px 20px; font-size:14px; line-height:24px;">温馨提示：
  <p>1、选择提现到支付宝资金瞬间到账！</p>
  <p>2、如银行卡及支付宝账户信息变动，请联系我们的在线客服或致电010-64344882。</p>
</div>
<p style="text-align:left; line-height:24px; padding:15px 0 0 20px; font-size:14px;"><span style="color:#dc0000;">投注额度达到每次充值额度的50%方可提现。</span></p>
<div class="center">
  <div class="biaodan">
    <form action='' method='post'>
      <?php if ($this->_tpl_vars['msg_error']): ?> <br/>
      <br/>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <br/>
      <br/>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?> <br/>
      <br/>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <br/>
      <br/>
      <?php endif; ?>
      <dl>
        <dt><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
&nbsp;账户余额&nbsp;<?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
</dt>
      </dl>
      <dl>
        <dt><?php echo $this->_tpl_vars['userRealInfo']['bank']; ?>
&nbsp;<?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
&nbsp;<?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>
</dt>
      </dl>
      <dl>
        <dt>银行卡号&nbsp;<?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>
</dt>
      </dl>
      <dl>
        <dt>提现方式&nbsp;&nbsp;&nbsp;&nbsp;<a href='<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php'>未绑定支付宝？</a></dt>
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
        <dt>提现金额</dt>
        <dd>
          <input type="text" name="money" id="withdraw_money"/>
          <input type="hidden" name='u_id' id="u_id" value="<?php echo $this->_tpl_vars['userInfo']['u_id']; ?>
"/>
        </dd>
      </dl>
      <dl>
        <dt>手机号码</dt>
        <dd>
          <input type="text" name="mobile" id="mobile" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
"/>
        </dd>
      </dl>
      <div class="tijiao">
        <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" id="submit"/>
      </div>
    </form>
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>