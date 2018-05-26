<?php /* Smarty version 2.6.17, created on 2017-10-14 18:10:16
         compiled from user_basic.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_basic.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
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
<!--基本资料 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>个人信息-基本信息</h1>
  </div>
  <div style="text-align:left;padding:40px 0 0 0;">
  <div class="tabuser">
    <ul>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php" class="active">基本信息</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php">上传头像</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php">修改密码</a></li>
    </ul>
  </div>
  </div>
  <form action="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php" method="post">
    <div class="userbiaodan" style="text-align:left;">
      <dl>
        <dt>用户名：</dt>
        <dd><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</dd>
      </dl>
      <dl>
        <dt>昵称：</dt>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userInfo']['u_nick']; ?>
" name="u_nick">
        </dd>
      </dl>
      <dl>
        <dt>生日：</dt>
        <dd><?php if ($this->_tpl_vars['birthday_date']): ?><?php echo $this->_tpl_vars['birthday_date']; ?>
<?php else: ?>
          <input id="birth_date" type='text' value="" name="u_birthday">
          <?php endif; ?></dd>
      </dl>
      <dl>
        <dt>手机号：</dt>
        <dd>
          <input type='text'  value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
" name="mobile">
        </dd>
      </dl>
      <dl>
        <dt>居住地：</dt>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userInfo']['u_address']; ?>
" name="u_address">
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <input type="submit" class="sub" value="保存">
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd><?php if ($this->_tpl_vars['msg_error']): ?><font color="red"><?php echo $this->_tpl_vars['msg_error']; ?>
</font><?php endif; ?>
          <?php if ($this->_tpl_vars['msg_success']): ?><font color="green"><?php echo $this->_tpl_vars['msg_success']; ?>
</font><?php endif; ?></dd>
      </dl>
    </div>
  </form>
</div>
<!--基本资料 end-->
</body>
</html>