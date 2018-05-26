<?php /* Smarty version 2.6.17, created on 2017-11-06 08:11:34
         compiled from user_bank.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_bank.html', 14, false),)), $this); ?>
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
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
var TMJF = jQuery.noConflict(true);
TMJF.conf = {
    	cdn_i: "<?php echo @STATICS_BASE_URL; ?>
/i"
    	, domain: "<?php echo @ROOT_DOMAIN; ?>
"
};
</script>
<script src="<?php echo ((is_array($_tmp='china_area.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script src="<?php echo ((is_array($_tmp='step.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<!--用户中心绑定银行卡 start-->
<div class="center">
  <div class="NavphTab">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">实名认证</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php" class="active">绑定银行卡</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">绑定支付宝</a></td>
      </tr>
    </table>
  </div>
  <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
  <div class="tipss">
    <p><b>温馨提示：</b></p>
    <p>如信息变更，请致电010-64344882或联系我们的在线客服。</p>
  </div>
  <div class="biaodan">
    <form method="post">
      <?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <?php endif; ?>
      <dl>
        <dt>真实姓名<span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
</span>
      </dl>
      </dl>
      <dl>
        <dt><span style="float:left;">卡行属地&nbsp;</span> <?php if ($this->_tpl_vars['userRealInfo']['bank_province'] && $this->_tpl_vars['userRealInfo']['bank_city']): ?> <span style="float:right; position:relative;right:0;"> <?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
&nbsp;
          <?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>
</span> <?php else: ?> <em style="clear:both;">
          <select name="f[province]" id="pselect1" style="position:relative;top:2px;line-height:32px;border:none; font-size:14px;background:none; float:left;border-radius:2px;color:#999;">
            <option value="" selected>请选择</option>
          </select>
          <select name="f[city]" id="pselect2" style="left:-10px;position:relative;top:2px;line-height:32px;border:none;background:none;font-size:14px;float:left;border-radius:2px;color:#999;">
            <option value="" selected>请选择</option>
          </select>
          </em> <?php endif; ?> </dt>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bank']): ?>
        <dt>卡行所属<span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['bank']; ?>
</span></dt>
        <?php else: ?>
        <dd>
          <input type="text" name="bank" placeholder="所属卡行" id="bank"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bank_branch']): ?>
        <dt>支行名称<span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['bank_branch']; ?>
</span></dt>
        <?php else: ?>
        <dd>
          <input type="text" name="bank_branch" placeholder="支行名称" id="bank_branch"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bankcard']): ?>
        <dt>银行卡号<span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>
</span></dt>
        <?php else: ?>
        <dd>
          <input type="text" name="bankcard" placeholder="银行卡号" id="bankcard"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['bankcard']): ?>
        <dd>
          <input type="text"name="rebankcard" placeholder="再次确认" id="rebankcard"/>
        </dd>
      </dl>
      <div class="sub">
        <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" />
      </div>
      <?php endif; ?>
    </form>
  </div>
  <?php else: ?>
  <div class="tipss">
    <p><b>温馨提示：</b></p>
    <p>1)&nbsp;在实名认证之前请您核实您填写的身份信息是否正确，如果不正确将会导致您认证不通过；</p>
    <p>2)&nbsp;智赢网暂时只支持身份证的实名认证，不支持其它证件的认证；</p>
    <p>3)&nbsp;真实姓名是您提款时的重要依据，填写后不可更改。</p>
  </div>
  <div class="smlink"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">进行实名认证</a> <?php endif; ?> </div>
</div>
<!--用户中心绑定银行卡 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>