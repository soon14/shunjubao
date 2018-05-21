<?php /* Smarty version 2.6.20, created on 2016-01-26 10:01:21
         compiled from bascdata_value_edit.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'show_datalist_type_name', 'bascdata_value_edit.html', 16, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="./js/common.css" type="text/css" rel="stylesheet">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript src="js/jquery.js"></SCRIPT>
<SCRIPT language=javascript src="js/common.js" ></SCRIPT>
</head>
<body style="margin:30px 0px 0px 8px;">
<form name="myform" method="Post" >
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#F7F7F7">
  	<td colspan="13">
    	<div align="left"><strong >添加值</strong>＝》添加<strong style="color:#FF0000"><?php echo ((is_array($_tmp=$this->_tpl_vars['sysid'])) ? $this->_run_mod_handler('show_datalist_type_name', true, $_tmp) : show_datalist_type_name($_tmp)); ?>
</strong>列表值</div></td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td><div align="right">显示名称：</div></td>
    <td><input name="tname" type="text" id="tname" size="30" value="<?php echo $this->_tpl_vars['tname']; ?>
"/></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><div align="right">值： </div>      
    <strong><label>
      </label>
      </strong></td>
    <td><label>
      <input name="tvalue" type="text" id="tvalue"  value="<?php echo $this->_tpl_vars['tvalue']; ?>
" size="30"/>
    </label>     </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td><div align="right">排序：
    </div>      
      <label>      </label></td>
    <td><?php echo $this->_tpl_vars['key']; ?>

      <label>
      <input name="orderby" type="text" id="orderby"  value="<?php echo $this->_tpl_vars['orderby']; ?>
"  size="30"/>
      (值为数字，如：1，值越大排得越前)</label></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td><div align="right">启用： </div>
        <strong>
        <label> </label>
      </strong></td>
    <td><label>
      <input name="tstatus" type="checkbox" id="tstatus" value="1" <?php echo $this->_tpl_vars['tstatus']; ?>
 />
      </label>
      （选中为启用） </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td><div align="right">值： </div>
        <strong>
        <label> </label>
      </strong></td>
    <td><label>
      <input name="tvalue2" type="text" id="tvalue2"  value="<?php echo $this->_tpl_vars['tvalue2']; ?>
" size="30"/>
      </label>
    </td>
    </tr>
  <tr bgcolor="#FFFFFF">
    <td><div align="right">备注说明： </div>
        <strong>
        <label> </label>
      </strong></td>
    <td><label>
      <textarea name="tdesc" cols="25" rows="3" id="tdesc"><?php echo $this->_tpl_vars['tdesc']; ?>
</textarea>
      </label>    </td>
    </tr>    

  <tr bgcolor="#FFFFFF">
    <td width="14%"></td>
    <td width="86%"><label>
    <input type="submit" name="Submit" value="提交" />
    <input type="button" name="Submit2" onclick="history.go(-1);" value="返回" />
    <input name="action" type="hidden" id="action" value="update" />	
    <input name="bd_id" type="hidden" id="bd_id" value="<?php echo $this->_tpl_vars['bd_id']; ?>
" />
	<input name="sysid" type="hidden" id="sysid" value="<?php echo $this->_tpl_vars['sysid']; ?>
" />
    </label></td>
  </tr>
</table>
</form>
</body>
</html>