<?php /* Smarty version 2.6.17, created on 2016-02-25 17:16:12
         compiled from user_realinfo.html */ ?>
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
<div class="ustitle">
  <h1><em>实名认证<b></b><i></i></em></h1>
</div>
<div class="center">
  <form method="post" id="submit">
    <div class="biaodan"> <br/><br/><br/><?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <?php endif; ?>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
        <dt>真实姓名： <?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
</dt>
        <?php else: ?>
        <dt>真实姓名</dt>
        <dd>
          <input type="text" name="realname" id="realname"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['idcard']): ?>
        <dt> 身份证号：<?php echo $this->_tpl_vars['userRealInfo']['idcard']; ?>
</dt>
        <?php else: ?>
        <dt>身份证号</dt>
        <dd>
          <input type="text" name="idcard"  id="idcard"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['idcard']): ?>
        <dt>再次确认</dt>
        <dd>
          <input type="text" name="reidcard" id="reidcard"/>
        </dd>
      </dl>
      <div class="tijiao">
        <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" />
      </div>
      <?php endif; ?> </div>
  </form>
</div>
<!--实名认证 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>