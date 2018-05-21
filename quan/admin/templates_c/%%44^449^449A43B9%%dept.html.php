<?php /* Smarty version 2.6.20, created on 2016-01-04 19:34:23
         compiled from dept.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link href="./js/common.css" type="text/css" rel="stylesheet">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript>
function unselectall()
{
    if(document.myform.chkAll.checked){
	document.myform.chkAll.checked = document.myform.chkAll.checked&0;
    } 	
}

function CheckAll(form)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.Name != "chkAll"&&e.disabled==false)
       e.checked = form.chkAll.checked;
    }
}
function ConfirmDel(url){
	if(confirm("此操作不可恢复,真的要删除吗?")){   
		location.href=url;
		return true;
	}else{
		return false;
	}
}
</SCRIPT>
</head>

<body style="margin:20px 0px 30px 8px;">
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#F7F7F7">
    <td width="305" bgcolor="#F7F7F7"><div align="center"><STRONG>部门ID</STRONG></div></td>
    <td width="216"><div align="center"><strong>部门名称</strong></div></td>
    <td width="165"><div align="center"><strong>添加人</strong></div></td>
    <td width="180"><div align="center"><strong>添加时间</strong></div></td>
    <td width="240"><div align="center"><strong>备注</strong></div></td>
    <td colspan="2" bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div>      </td>
  </tr>
  <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['dept']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <tr bgcolor="#FFFFFF"  onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#fff06d'">
   <td><div align="center"><?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['d_id']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['d_name']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['d_addid']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['d_addtime']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['d_desc']; ?>
</div></td>
    <td width="118"><div align="center">[<a href="dept.php?action=edit&id=<?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['sysid']; ?>
">修改</a>]</div></td>
    <td width="117"><div align="center">[<a href="#" onclick="ConfirmDel('dept.php?action=delete&id=<?php echo $this->_tpl_vars['dept'][$this->_sections['a']['index']]['sysid']; ?>
');">删除</a>]</div></td>
  </tr>
  <?php endfor; endif; ?>
</table>
<table width="99%" border="0" cellpadding="3" cellspacing="1" class="p_table_order" style="margin-top:5px;">
  <tr>
    <td bgcolor="#FFFFFF"><div align="right">每页 <font color="#FF0000"><?php echo $this->_tpl_vars['pageSize']; ?>
</font> 条 共 <font color="#FF0000"><?php echo $this->_tpl_vars['page']; ?>
</font> 页 共 <font color="#FF0000"><?php echo $this->_tpl_vars['totalRecord']; ?>
</font> 条记录&nbsp;<?php echo $this->_tpl_vars['multi']; ?>
</div></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><div align="center"><a href="dept.php?action=add">添加新的部门</a></div></td>
  </tr>
</table>

</body>
</html>