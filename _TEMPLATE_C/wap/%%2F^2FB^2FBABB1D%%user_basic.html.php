<?php /* Smarty version 2.6.17, created on 2017-10-18 17:53:32
         compiled from user_basic.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script>
TMJF(function($){
	$("#birth_date").focus(function(){
	    if (!$("#birth_date").val()) {
	    showCalendar('birth_date', 'y-mm-dd');
	    }
	});	
});
</script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--用户中心基本信息-->
<div class="center">
  <form action="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php" method="post">
    <div class="biaodan" style="padding:18px 0 0 0;"> <?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div  class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <?php endif; ?>
      <dl>
        <dt>用户名：<?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</dt>
      </dl>
      <dl>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userInfo']['u_nick']; ?>
" placeholder="昵称" name="u_nick">
        </dd>
      </dl>
      <dl>
        <dd>
          <input type='text'  value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
" placeholder="手机号" name="mobile">
        </dd>
      </dl>
      <dl>
        <dd>
          <input type='text' value="<?php echo $this->_tpl_vars['userInfo']['u_address']; ?>
" placeholder="居住地" name="u_address">
        </dd>
      </dl>
      <div class="tijiao">
        <input type="submit" value="保&nbsp;&nbsp;&nbsp;存"/>
      </div>
    </div>
  </form>
</div>
<!--用户中心基本信息 end-->
<div class="clear"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>