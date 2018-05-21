<?php /* Smarty version 2.6.20, created on 2016-01-04 19:31:46
         compiled from permission_add.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="js/common.css" type="text/css" rel="stylesheet">
<link href="style/css/layout.css" rel="stylesheet" type="text/css">
<script>
function checkad_add(frm){
    if(frm.m_id.value==''){
	  alert('请输入权限ID');
	  frm.m_id.focus();
	  return false;
	}
    if(frm.name.value==''){
	  alert('请输权限名称');
	  frm.name.focus();
	  return false;
	  }
	
}
</script>
</head>
<body style="margin-top:20px;">
<form action="permission.php?action=add_action" method="post" enctype="multipart/form-data" name="frm" id="frm" onSubmit="return checkad_add(this);">
  <table width="99%" border="0" align=center cellpadding="3" cellspacing=1 class="p_table_order">
    <tr bgcolor="#FFFFFF">
      <td><div align="right">权限ID：</div></td>
      <td><input name="m_id" type="text" id="m_id" />
        <font color="#ff6600">*</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><div align="right">权限名称：</div></td>
      <td><input name="name" type="text" id="name" />
        <font color="#ff6600">*</font></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td><div align="right"> 备注：</tiv></td>
      <td><textarea name="desc" rows="4" cols="40"></textarea>
      <font color="#ff6600">*</font></td>
    </tr>
   
   
    <tr bgcolor="#FFFFFF">
      <td height="40" colspan="2"><div align="center">
          <input type=submit name=btnSubmit value=" 提　交 " class="input_submit">
          <input type="hidden" name="id" id="id" value="<%{$hotel[0]}%>" />
　　　
          <input type=reset name=btnReset value=" 重　填 " class="input_submit">
        </div></td>
    </tr>
  </table>
</form>
</body>
</html>