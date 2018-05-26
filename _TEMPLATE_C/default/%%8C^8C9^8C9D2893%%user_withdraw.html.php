<?php /* Smarty version 2.6.17, created on 2018-02-21 21:50:12
         compiled from user_withdraw.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_withdraw.html', 2, false),)), $this); ?>
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
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>我的账户-提现<span style="font-size:12px; font-weight:300; padding:0 0 0 14px; font-family:'宋体'; position:relative;top:-1px;">您当前账户余额：<u style="color:#dc0000; text-decoration:none;"><?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
元</u></span></h1>
    <h2 style="padding:10px; margin:25px auto auto auto;border:1px solid #e9e9e9; background:#f9f9f9;"><b style="font-weight:900; display:none;">温馨提示：</b>
      <p>1、选择提现到支付宝资金瞬间到账！</p>
      <p>2、如银行卡及支付宝账户信息变动，请联系我们的在线客服或致电010-64344882。</p>
      <p>3、<span style="color:#dc0000;">投注额度达到每次充值额度的50%方可提现</span>(举例说明：充值100，投注50后中奖100，可提中奖奖金部分及充值余额的50%即100+50=150元)!!!</p>
    </h2>
  </div>
  <form action='' method='post'>
    <div class="userbiaodan">
      <dl>
        <dt>提款人：</dt>
        <dd><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>
</dd>
      </dl>
      <dl>
        <dt>开户行：</dt>
        <dd><?php echo $this->_tpl_vars['userRealInfo']['bank_branch']; ?>
</dd>
      </dl>
      <dl>
        <dt>银行卡号：</dt>
        <dd> <?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>
 </dd>
      </dl>
      <dl>
        <dt>提现方式：</dt>
        <dd>
          <select name='payment' style='height:28px;line-height:28px;'>
            <?php $_from = $this->_tpl_vars['EncashPaymentDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['userPaymentInfo']['pay_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
          <?php if (! $this->_tpl_vars['userPaymentInfo']): ?><a href='<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php'>去完善其他提现方式</a><?php endif; ?> </dd>
      </dl>
      <dl>
        <dt>提现金额：</dt>
        <dd>
          <input type="text" name="money" id="withdraw_money"/>
          <input type="hidden" name='u_id' id="u_id" value="<?php echo $this->_tpl_vars['userInfo']['u_id']; ?>
"/>
        </dd>
      </dl>
      <dl>
        <dt>手机号：</dt>
        <dd>
          <input type="text" name="mobile" id="mobile" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
"/>
        </dd>
      </dl>
       
        
      <dl>
        <dt></dt>
        <dd>
          <input type="submit" class="sub" value="提交" id="submit" />
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
<!--用户提现 end-->
</body>
</html>