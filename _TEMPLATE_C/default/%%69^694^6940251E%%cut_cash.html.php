<?php /* Smarty version 2.6.17, created on 2017-10-14 21:06:10
         compiled from ../admin/user/cut_cash.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

TMJF(function ($) {

	$("#sub").click(function () {
		var u_name = $("#u_name").val();
		var cash = $("#cash").val();
		var type = '余额';
		if ($("#type").val() == 'gift') type = '彩金';
		if ($("#type").val() == 'rebate') type = '返点';
		if ($("#type").val() == 'score') type = '积分';
		if(confirm("确定为： " + u_name + "扣款 " + cash + "元" + type + "吗？")) {
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
          <td colspan="2">用户<strong>扣款</strong>操作</td>
          </tr>
        <tr>
            <td>用户名：</td><td><input id="u_name" name="u_name" value="" type="text" /></td>
        </tr>
        <tr>
            <td>金额(元)：</td><td><input id="cash" name="cash" value="" type="text" /></td>
        </tr>
        <tr>
        	<td>类型：</td>
        	<td>
        	<select name="type" id="type">
        	<option value="cash" selected>余额</option>
        	<option value="gift">彩金</option>
        	<option value="score">积分</option>
        	        	</select>
        	</td>
        </tr>
        <tr><td>说明:</td><td><input name="desc" value=""/></td></tr>
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