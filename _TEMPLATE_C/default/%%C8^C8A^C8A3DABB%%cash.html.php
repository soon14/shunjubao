<?php /* Smarty version 2.6.17, created on 2018-01-03 22:12:43
         compiled from ../admin/user/cash.html */ ?>
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
		if(confirm("确定为： " + u_name + "充值 " + cash + "元" + type + "吗？")) {
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
    <table width="28%" border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td colspan="2">后台<strong>充值</strong>操作</td>
          </tr>
        <tr>
            <td width="45%" height="45"><div align="right">用户名：</div></td><td width="55%"><div align="left">
              <input id="u_name" name="u_name" value="" type="text" />
            </div></td>
        </tr>
        <tr>
            <td><div align="right">金额(元)：</div></td><td><div align="left">
              <input id="cash" name="cash" value="" type="text" />
            </div></td>
        </tr>
        <tr>
        	<td height="34"><div align="right">类型：</div></td>
        	<td>
        	  <div align="left">
        	    <select name="type" id="type">
        	      <option value="cash" selected>余额</option>
        	      <option value="gift">彩金</option>
        	      <option value="score">积分</option>
        	            	      </select>
      	    </div></td>
        </tr>
        <tr>
          <td height="33"><div align="right">到帐方式：</div></td>
          <td><div align="left">
            <select name="manu_income" id="manu_income">
              <option value="" >请选择</option>
                <?php $_from = $this->_tpl_vars['getCHARGEmanuincomeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                 <option <?php if ($this->_tpl_vars['key'] == 1): ?> selected="selected" <?php endif; ?> value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['item']['desc']; ?>
 </option>
           	 <?php endforeach; endif; unset($_from); ?>
            </select>
          </div></td>
        </tr>
        <tr><td height="36"><div align="right">说明:</div></td><td><div align="left">
          <input name="desc" value=""/>
        </div></td></tr>
        <tr>
          <td height="36" colspan="2">  <input id="sub" type="submit" value="提交" name="submit"/></td>
          </tr>
        
    </table>
    </form>
    </td>
  </tr>
</table>

</body>
</html>