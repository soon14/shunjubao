<?php /* Smarty version 2.6.20, created on 2018-04-12 15:34:03
         compiled from dp_member_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_checkboxes', 'dp_member_edit.html', 87, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="./js/common.css" type="text/css" rel="stylesheet">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<script>
function checkad_add(frm){
    if(frm.dept.value==''){
	  alert('请选择部门');
	  frm.dept.focus();
	  return false;
	}
    if(frm.logname.value==''){
	  alert('请输入登录名称');
	  frm.logname.focus();
	  return false;
	}
}

function select_permission(dp_id,mid){
	location.href='dp_member.php?action=edit&dp_id='+dp_id+'&id='+mid;
}

</script>
<link href="js/common.css" type="text/css" rel="stylesheet">
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</head>
<body style="margin:20px 12px 20px 8px;">
   <form action="dp_member.php?action=edit_action" method="post" enctype="multipart/form-data" name="frm" id="frm" onSubmit="return checkad_add(this);">
	<table width="99%" border="0" align=center cellpadding="3" cellspacing=1 class="p_table_order">
	
	<tr bgcolor="#FFFFFF">
      <td><div align="right">部门：</div></td>
	  <td width="942"><label>
	    <select name="dept" id="dept" onChange="select_permission(this.form.dept.value,<?php echo $this->_tpl_vars['sid']; ?>
);">
	      <option>请选择部门</option>
		  <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['dept_list_1']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
		  <option value="<?php echo $this->_tpl_vars['dept_list_1'][$this->_sections['a']['index']]['d_id']; ?>
" <?php if ($this->_tpl_vars['dm_id'] == $this->_tpl_vars['dept_list_1'][$this->_sections['a']['index']]['d_id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['dept_list_1'][$this->_sections['a']['index']]['d_name']; ?>
</option>
		  <?php endfor; endif; ?>
        </select>
	  </label></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td width="133"><div align="right">成员登录名称：</div></td>
		<td><input name="logname" type="text" class="input_text" id="logname" value="<?php echo $this->_tpl_vars['dm_logname']; ?>
" size="32"></td>
	</tr>
	<tr bgcolor="#FFFFFF">
	  <td><div align="right">会员姓名：</div></td>
	  <td><label>
	    <input name="real_name" type="text" value="<?php echo $this->_tpl_vars['real_name']; ?>
" id="real_name" size="32" />
	  </label></td>
	  </tr>
	<tr bgcolor="#FFFFFF">
	  <td><div align="right">登录密码：</div></td>
	  <td><label>
	    <input name="password" type="text" id="password" size="20">
	  <span style="color:#FF0000;">( * 为空则保留原密码 )</span></label></td>
	  </tr>

	<tr bgcolor="#FFFFFF">
	  <td><div align="right">是否被锁定：</div></td>
	  <td><div align="right">
	    <label>
	    <div align="left">
	      <input type="checkbox" name="iflock" id="iflock" value="2"  <?php if ($this->_tpl_vars['iflock'] == 2): ?> checked="checked"<?php endif; ?>  />
	      </div>
	    </label>
	  </div></td>
	  </tr>
	<tr bgcolor="#FFFFFF">
	  <td><div align="right"> e-mail：</div></td>
	  <td><label>
	    <input name="mail" type="text" id="mail" value="<?php echo $this->_tpl_vars['dm_mail']; ?>
" size="20">
	  </label></td>
	  </tr>
	 
	<tr bgcolor="#FFFFFF">
	  <td><div align="right">权限：</div></td>
	  <td>
	  <table><tr><td>
	  <?php echo smarty_function_html_checkboxes(array('name' => 'perid','options' => $this->_tpl_vars['cust_checkboxes'],'checked' => $this->_tpl_vars['customer_id'],'separator' => "&nbsp;"), $this);?>

	 </td></tr></table>	  </td>
	  </tr>

	<tr bgcolor="#FFFFFF">
	  <td height="40" colspan="2"><div align="center">
          <input type=submit name=btnSubmit value=" 提　交 " class="input_submit"><input type="hidden" name="id" id="id" value="<?php echo $this->_tpl_vars['sid']; ?>
"/>
          　　　　　
          <input type=reset name=btnReset value=" 重　填 " class="input_submit">
      </div></td>
	  </tr>
	</table>
   </form>
</body>
</html>