<?php /* Smarty version 2.6.17, created on 2017-10-15 08:16:28
         compiled from user_bank.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_bank.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
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
</head><body>
<script src="<?php echo ((is_array($_tmp='china_area.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script src="<?php echo ((is_array($_tmp='step.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript">
TMJF(function($) {
});
</script>
<!--用户中心绑定银行卡 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>我的账户-绑定银行卡</h1>
	<div style="padding:50px 0 0 0;">
	<div class="tabuser">
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">实名认证</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php" class="active">绑定银行卡</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">绑定支付宝</a></li>
      </ul>
    </div>
	</div>
    <div class="userbiaodan"> <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
      <form method="post">
        <dl>
          <dt>真实姓名：</dt>
          <dd><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
 </dd>
        </dl>
        <dl>
          <dt>归属地：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['bank_province'] && $this->_tpl_vars['userRealInfo']['bank_city']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['bank_province']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;
            <?php echo $this->_tpl_vars['userRealInfo']['bank_city']; ?>

            <?php else: ?>
            <select name="f[province]" class="select1" id="pselect1">
              <option value="" selected>请选择</option>
            </select>
            <select name="f[city]" class="select2" id="pselect2">
              <option value="" selected>请选择</option>
            </select>
            <?php endif; ?></dd>
        </dl>
        <dl>
          <dt>开户行：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['bank']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['bank']; ?>

            <?php else: ?>
            <input type="text" class="ustext" name="bank" id="bank"/>
            <span class="none">请输入您的开户行名称</span> <?php endif; ?></dd>
        </dl>
        <dl>
          <dt>支行名称：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['bank_branch']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['bank_branch']; ?>

            <?php else: ?>
            <input type="text" class="ustext" name="bank_branch" id="bank_branch"/>
            <span class="none">请输入您的支行名称</span> <?php endif; ?></dd>
        </dl>
        <dl>
          <dt>银行卡号：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['bankcard']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['bankcard']; ?>

            <?php else: ?>
            <input type="text" class="ustext" name="bankcard" id="bankcard"/>
            <span class="none">请输入您的银行卡卡号。</span> <?php endif; ?></dd>
        </dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['bankcard']): ?>
        <dl>
          <dt>再次确认：</dt>
          <dd>
            <input type="text" class="ustext" name="rebankcard" id="rebankcard"/>
            <span class="none">请再一次输入输入您的银行卡卡号。</span></dd>
        </dl>
        <dl>
          <dt></dt>
          <dd>
            <input type="submit" value="提交" class="sub" />
          </dd>
        </dl>
        <?php endif; ?>
        
        
        
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
        <?php endif; ?>
      </form>
      <?php else: ?>
      <div ><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">点击进行实名认证</a> <?php endif; ?> </div>
    </div>
  </div>
</div>
<!--用户中心绑定银行卡 end-->
</body>
</html>