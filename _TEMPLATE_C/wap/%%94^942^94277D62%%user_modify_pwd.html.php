<?php /* Smarty version 2.6.17, created on 2017-10-21 12:55:03
         compiled from user_modify_pwd.html */ ?>
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
<!--center start-->
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
<div class="center"><br/>
  <form method="post" action="" id="pwd">
    <div class="biaodan">
      <div style="padding:10px 0;"><?php if ($this->_tpl_vars['msg_error']): ?>
        <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['msg_success']): ?>
        <div  class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
        <?php endif; ?> </div>
      <dl>
        <dd>
          <input type="password" name="old_pwd" placeholder="初始密码" id="old_pwd"/>
        </dd>
      </dl>
      <dl>
        <dd>
          <input type="password" name="new_pwd" placeholder="新的密码" id="new_pwd"/>
        </dd>
      </dl>
      <dl>
        <dd>
          <input type="password" name="re_pwd" placeholder="重新输入" id="re_pwd"/>
        </dd>
      </dl>
      <div class="tijiao">
        <input type="submit" value=" 确认修改"  />
        <span class="none">
        <input type="reset" value="重&nbsp;&nbsp;&nbsp;置" style="background:#cfcfcf;" />
        </span> </div>
    </div>
  </form>
</div>
<!--用户中心修改密码 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>