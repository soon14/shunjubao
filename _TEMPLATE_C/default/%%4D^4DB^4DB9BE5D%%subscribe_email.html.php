<?php /* Smarty version 2.6.17, created on 2018-03-06 10:50:37
         compiled from ../admin/cms/subscribe_email.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style type='text/css'>
body {
    margin-left: 3px;
    margin-top: 0px;
    margin-right: 3px;
    margin-bottom: 0px;
	 font-size:12px;
	 font-weight:300;
}
.import {
    margin-top:100px;
    margin-left:150px;
    width:auto;
	border:0 0 0 0;
}
.import td{
	width: 100px;
}
</style>
<script type="text/javascript">
TMJF(function($){	
	$("#sub").click(function(){
		passChecked = true;	
		var emails = $("#emails").val();
        if (emails == '') {
        	alert('邮箱不能为空');
            return false;
        }
	});
});
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<h1>批量导入订阅邮箱</h1>
<br/>
<form action="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/subscribe_email.php" method="post" enctype="multipart/form-data">
  <table width="100%" border="0" cellpadding="0" cellspacing="6" class=''>
    <tr>
      <td width="100">输入邮箱
        <input type="hidden" name="code" value="<?php echo $this->_tpl_vars['code']; ?>
" /></td>
      <td align="left"><textarea name="emails"  cols="100" rows="20" id="emails"></textarea></td>
    </tr>
    <tr>
      <td  width="100">订阅类型</td>
      <td align="left"><select name="type">
          <?php $_from = $this->_tpl_vars['cmsTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['cmsTypeDesc']):
?>
          <option  value="<?php echo $this->_tpl_vars['cmsTypeDesc']['type']; ?>
" />
          <?php echo $this->_tpl_vars['cmsTypeDesc']['desc']; ?>
 <?php endforeach; endif; unset($_from); ?>
        </select>
      </td>
    </tr>
    <tr>
      <td  width="100">推荐期数(新)：</td>
      <td align="left"><input type="radio" name="batch" id="newbatch" value="<?php echo $this->_tpl_vars['newbatch']; ?>
" checked>
        <font><?php echo $this->_tpl_vars['newbatch']; ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->_tpl_vars['new_sunday']; ?>
~<?php echo $this->_tpl_vars['new_saturday']; ?>
</font></td>
    </tr>
    <tr>
      <td  width="100">往期(旧):</td>
      <td align="left"><input type="radio" name="batch" id="oldbatch" value="<?php echo $this->_tpl_vars['oldbatch']; ?>
" >
        <font><?php echo $this->_tpl_vars['oldbatch']; ?>
&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $this->_tpl_vars['old_sunday']; ?>
~<?php echo $this->_tpl_vars['old_saturday']; ?>
</font></td>
    </tr>
    <tr>
	  <td  width="100"></td>
      <td align="left"><input id="sub" type="submit" name="submit" class="upbtn" value="上传" /></td>
    </tr>
  </table>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/bottom.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>