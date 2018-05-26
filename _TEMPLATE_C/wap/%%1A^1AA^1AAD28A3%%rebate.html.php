<?php /* Smarty version 2.6.17, created on 2017-10-22 21:31:44
         compiled from ../admin/user/rebate.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

TMJF(function ($) {

	$("#sub").click(function () {
		var u_name = $("#u_name").val();
		var rebate = $("#rebate").val();
		if(rebate>=100 || rebate<0) {
			alert('返点比例错误，请输入0-99');
			return false;
		}
		if(confirm("确定为： " + u_name + "修改返点比例 " + rebate +  "% 吗？")) {
			return true;
		}
		return false;
	});

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
    <table width="20%" border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td>用户名：</td><td><input id="u_name" name="u_name" value="" type="text" /></td>
        </tr>
        <tr>
            <td>返点比例：(%)</td><td><input id="rebate" name="rebate" value="" type="text" /></td>
        </tr>
        <tr>
            <td><input id="sub" type="submit" value="提交" name="submit"/></td>
        </tr>
    </table>
    </form>
    </td>
  </tr>
</table>

</body>
</html>