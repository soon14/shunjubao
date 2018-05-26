<?php /* Smarty version 2.6.17, created on 2016-06-14 14:15:56
         compiled from user_realinfo.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_realinfo.html', 2, false),)), $this); ?>
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
	$("#submit").submit(function(){
		if ($("#realname").val() == '') {
			alert('真实姓名不能为空');
			return false;
		}
		if ($("#idcard").val() == '') {
			alert('身份证号不能为空');
			return false;
		}
		if ($("#reidcard").val() != $("#idcard").val()) {
			alert('两次身份证号不一致');
			return false;
		}
		return true;
	});
});
</script>
<!--实名认证 start-->
<div class="center">
  <div class="ustitle">
    <h1><em>实名认证<b></b><i></i></em></h1>
    <div class="usTips">
      <p><b>温馨提示：</b>您的个人信息将被严格保密。</p>
    </div>
    <div class="wap_loginC">
      <form method="post" id="submit">
        <div class=""> <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
          <p class="other">真实姓名： <strong><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
</strong></p>
          <?php else: ?>
          <p>真实姓名</p>
          <p>
            <input type="text" class="inputc1" name="realname" id="realname"/>
          </p>
          <?php endif; ?>    
          <?php if ($this->_tpl_vars['userRealInfo']['idcard']): ?>
          <p style="padding:18px 0;" class="other"> 身份证号：<b><?php echo $this->_tpl_vars['userRealInfo']['idcard']; ?>
</b> <?php else: ?>
          <p>身份证号</p>
          <p>
            <input type="text" class="inputc1" name="idcard"  id="idcard"/>
          </p>
          </p>
          <?php endif; ?> 
          <?php if (! $this->_tpl_vars['userRealInfo']['idcard']): ?>
          <p>再次确认</p>
          <p>
            <input type="text" class="inputc1" name="reidcard" id="reidcard"/>
            <span>请再输入一次您的身份证号码。</span></p>
          <p class="sub">
            <input type="submit" class="loginsub" value="提&nbsp;&nbsp;&nbsp;交" />
          </p>
          <?php endif; ?>
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
<!--实名认证 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>