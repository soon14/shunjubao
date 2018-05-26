<?php /* Smarty version 2.6.17, created on 2016-06-15 13:36:12
         compiled from user_basic.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_basic.html', 4, false),)), $this); ?>
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
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head><body>
<!--center start-->
<script>
TMJF(function($){
	$("#birth_date").focus(function(){
	    if (!$("#birth_date").val()) {
	    showCalendar('birth_date', 'y-mm-dd');
	    }
	});	
});
</script>
<!--用户中心基本信息 start-->
<div class="center">
  <div class="ustitle">
    <h1><em>基本资料<b></b><i></i></em></h1>
    <div class="usTips">
      <p><b>温馨提示：</b>您的个人信息将被严格保密。</p>
    </div>
    <form action="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php" method="post">
      <div class="wap_loginC">
        <!--<p class="name"><b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></p>-->
        <p>昵称</p>
        <p>
          <input type='text' class="inputc1" value="<?php echo $this->_tpl_vars['userInfo']['u_nick']; ?>
" name="u_nick">
        </p>
        <p>手机号</p>
        <p>
          <input type='text' class="inputc1"  value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
" name="mobile">
        </p>
        <p>居住地</p>
        <p>
          <input type='text' class="inputc1" value="<?php echo $this->_tpl_vars['userInfo']['u_address']; ?>
" name="u_address">
        </p>
        <p class="tijiao">
          <input type="submit" class="loginsub" value="保&nbsp;&nbsp;&nbsp;存"/>
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
  </div>
</div>
<!--用户中心基本信息 end-->
<div class="clear"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>