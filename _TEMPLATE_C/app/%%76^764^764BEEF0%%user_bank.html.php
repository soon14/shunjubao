<?php /* Smarty version 2.6.17, created on 2016-02-26 11:30:16
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
<div class="ustitle">
  <h1><em>绑定银行卡<b></b><i></i></em></h1>
</div>
<!--用户中心绑定银行卡 start-->
<div class="center"> <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
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
        <dt>真实姓名：<?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>

      </dl>
      </dl>
      <dl>
        <dt>&nbsp;&nbsp;&nbsp;&nbsp;归属地：
          <?php if ($this->_tpl_vars['userRealInfo']['bank_province'] && $this->_tpl_vars['userRealInfo']['bank_city']): ?>
          <?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;
          <?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>

          <?php else: ?>
          <select name="f[province]" id="pselect1">
            <option value="" selected>请选择</option>
          </select>
          <select name="f[city]" id="pselect2">
            <option value="" selected>请选择</option>
          </select>
          <?php endif; ?> </dt>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bank']): ?>
        <dt>&nbsp;&nbsp;&nbsp;&nbsp;开户行：<?php echo $this->_tpl_vars['userRealInfo']['bank']; ?>
</dt>
        <?php else: ?>
        <dt>开户行</dt>
        <dd>
          <input type="text" name="bank" id="bank"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bank_branch']): ?>
        <dt>支行名称：<?php echo $this->_tpl_vars['userRealInfo']['bank_branch']; ?>
</dt>
        <?php else: ?>
        <dt>支行名称</dt>
        <dd>
          <input type="text" name="bank_branch" id="bank_branch"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['bankcard']): ?>
        <dt>银行卡号：<?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>
</dt>
        <?php else: ?>
        <dt>银行卡号</dt>
        <dd>
          <input type="text" name="bankcard" id="bankcard"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['bankcard']): ?>
        <dt>再次确认</dt>
        <dd>
          <input type="text"name="rebankcard" id="rebankcard"/>
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
    <p>2)&nbsp;聚宝网暂时只支持身份证的实名认证，不支持其它证件的认证；</p>
    <p>3)&nbsp;真实姓名是您提款时的重要依据，填写后不可更改。</p>
  </div>
  <div class="smlink"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">进行实名认证</a> <?php endif; ?> </div>
</div>
<!--用户中心绑定银行卡 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>