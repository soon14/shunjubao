<?php /* Smarty version 2.6.17, created on 2016-02-20 22:46:42
         compiled from reset.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script>
function resetpass(){	
	var u_pwd1 = $("#u_pwd1").val();
	if(u_pwd1 == ''){
		$("#tips").html('请先输入新密码！');
		return false;
	}	
	var u_pwd2 = $("#u_pwd2").val();
	if(u_pwd2 == ''){
		$("#tips").html('请先输入新密码！');
		return false;
	}

	if(u_pwd1 != u_pwd2) {
		$("#tips").html('两次密码不一致！');
		return false;
	}
	$("#f").submit();
}
</script>
</head>
<body>
<div class="top">
  <h3>重置密码-智赢网</h3>
  <div class="logo none">
    <h1 ><a href="/">智赢网</a><em>重置密码</em></h1>
  </div>
</div>
<div class="center">
  <div class="biaodan">
    <form method="post" action=""  name='f' id='f' >
      <input type="hidden" value="<?php echo $this->_tpl_vars['mobile']; ?>
" name="mobile"/>
      <input type="hidden" value="<?php echo $this->_tpl_vars['code']; ?>
" name="code"/>
      <div class="tips" id="tips"><?php if ($this->_tpl_vars['msg']): ?><?php echo $this->_tpl_vars['msg']; ?>
<?php endif; ?></div>
      <dl>
        <dt>输入新密码</dt>
        <dd>
          <input name="u_pwd1" type="password" size="25" id="u_pwd1"/>
        </dd>
      </dl>
      <dl>
        <dt>请再次输入</dt>
        <dd>
          <input name="u_pwd2" type="password" size="25" id="u_pwd2"/>
        </dd>
      </dl>
      <div class="tijiao">
        <input name="button" type="button" value="提&nbsp;&nbsp;&nbsp;&nbsp;交" onClick=" return resetpass()" />
      </div>
    </form>
  </div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>