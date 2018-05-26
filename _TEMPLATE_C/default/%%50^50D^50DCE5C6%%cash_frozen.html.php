<?php /* Smarty version 2.6.17, created on 2017-10-14 18:42:04
         compiled from ../admin/user/cash_frozen.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

TMJF(function ($) {
	$("#sub").click(function () {
		var u_name = $("#u_name").text();
		var cash = $("#frozen_cash").val();
		if(confirm("确定为： " + u_name + "将冻结资金： " + cash + "元转为余额吗？")) {
			return true;
		}
		return false;
	});
});
</script>
<?php if (! $this->_tpl_vars['userAccountInfo']): ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <form method="post" action="">
    <table width="20%" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td>用户名：</td><td><input id="u_name" name="u_name" value="" type="text" /></td>
        </tr>
        <tr>
            <td><input id="sub_search" type="submit" value="提交" name="submit"/></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
</table>
<?php else: ?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <form method="post" action="">
    <table width="20%" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td>用户名：</td><td><span id="u_name"><?php echo $this->_tpl_vars['user']['u_name']; ?>
</span></td>
        </tr>
        <tr>
            <td>账户余额：<?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
</td><td>冻结资金：<?php echo $this->_tpl_vars['userAccountInfo']['frozen_cash']; ?>
</td>
        </tr>
        <tr>
            <td>转移(元)：</td><td><input id="frozen_cash" name="frozen_cash" value="<?php echo $this->_tpl_vars['userAccountInfo']['frozen_cash']; ?>
" type="text" /></td>
        </tr>
                <tr>
            <td><input id="sub" type="submit" value="提交" name="submit"/><input type="hidden" value="<?php echo $this->_tpl_vars['user']['u_name']; ?>
" name="u_name"/></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
</table>
<?php endif; ?>

</body>
</html>