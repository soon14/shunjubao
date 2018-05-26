<?php /* Smarty version 2.6.17, created on 2017-10-15 15:11:12
         compiled from user_modify_pwd.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_modify_pwd.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
<script>
TMJF(function($){
	$("#pwd").submit(function(){
		var old_pwd = $("#old_pwd").val();
		var new_pwd = $("#new_pwd").val();
		var re_pwd = $("#re_pwd").val();
		
		if (new_pwd != re_pwd) {
			$("#re_error").show();
			return false;
		}
		return true;
	});
});
</script>
<!--用户中心修改密码 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>个人信息-修改密码</h1>
  </div>
  <div style="text-align:left;padding:40px 0 0 0;">
  <div class="tabuser">
    <ul>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php">基本信息</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php">上传头像</a></li>
      <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php" class="active">修改密码</a></li>
    </ul>
  </div>
  </div>
  <form method="post" action="" id="pwd">
    <div class="userbiaodan">
      <dl>
        <dt>初始密码：</dt>
        <dd>
          <input type="password" class="ustext" name="old_pwd" id="old_pwd"/>
        </dd>
      </dl>
      <dl>
        <dt>新的密码：</dt>
        <dd>
          <input type="password" class="ustext" name="new_pwd" id="new_pwd"/>
        </dd>
      </dl>
      <dl>
        <dt>重新输入：</dt>
        <dd>
          <input type="password" class="ustext" name="re_pwd" id="re_pwd"/>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd> <strong class="none" id="re_error">55~您输入的有误，跟第一次不一样。</strong> </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd>
          <input type="submit" class="sub" value=" 确认修改" />
        </dd>
      </dl>
      <?php if ($this->_tpl_vars['msg_error']): ?>
      <dl>
        <dt></dt>
        <dd> <font color="red"><?php echo $this->_tpl_vars['msg_error']; ?>
</font> </dd>
      </dl>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <dl>
        <dt></dt>
        <dd> <font color="green"><?php echo $this->_tpl_vars['msg_success']; ?>
</font> </dd>
      </dl>
      <?php endif; ?> </div>
  </form>
</div>
<!--用户中心修改密码 end-->
</body>
</html>