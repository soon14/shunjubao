<?php /* Smarty version 2.6.17, created on 2017-10-20 13:06:20
         compiled from ../admin/user/send_pms.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";

TMJF(function ($) {
	 $("#form1").submit(function(){
		 if (!confirm('确定发送站内信？')) {
			 return false;
		 }
		 if ($("#user_names").val() == '') {
			 alert('用户名不能为空');
			 return false;
		 }
		 if ($("#subject").val() == '') {
			 alert('主题不能为空');
			 return false;
		 }
		 if ($("#body").val() == '') {
			 alert('内容不能为空');
			 return false;
		 }
			return true;
	 });
});
</script>
<div>
  <form method='post' action='' id='form1'>
    <table width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td width="200">发送人:按用户名
          <input type='radio' name='type' value='user_name' checked/>
          |
          按用户id
          <input type='radio' name='type' value='u_id'/></td>
        <td align="left"><textarea name='user_names' id='user_names' style="width:300px;"></textarea>
        </td>
      </tr>
      <tr>
        <td width="200">主题</td>
        <td align="left"><input type='text' name='subject'  style="width:300px;" id='subject'/></td>
      </tr>
      <tr>
        <td width="200">内容</td>
        <td align="left"><textarea name='body'  style="width:300px;" id='body'></textarea></td>
      </tr>
    </table>
	<div style="padding:50px 0 0 0;"><input type='submit' value='提交'/></div>
  </form>
</div>
</body></html>