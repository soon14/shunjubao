<?php /* Smarty version 2.6.17, created on 2017-10-25 21:50:16
         compiled from ../admin/user/reset_pwd.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

TMJF(function ($) {



});
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
        <form method="post" action="">
    <table width="25%" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td width="100" align="right">用户名：</td><td><input id="u_name" name="u_name" value="" type="text" /></td>
        </tr>
        <tr>
            <td width="100" align="right">新密码：</td><td><input id="pwd" name="pwd" value="" type="password" /></td>
        </tr>
        <tr>
            <td width="100" align="right">重复新密码：</td><td><input id="re_pwd" name="re_pwd" value="" type="password" /></td>
        </tr>
        <tr>
			<td width="100" align="right">
            <td><input id="sub" type="submit" value="提交" name="submit"/></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
</table>

</body>
</html>