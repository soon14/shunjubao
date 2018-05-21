<?php /* Smarty version 2.6.20, created on 2018-05-03 20:18:15
         compiled from dp_member.html */ ?>
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

<body style="margin:20px 0px 0px 8px;">
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#f7f7f7">
    <td colspan="10"><div align="center">
      <form id="form1" name="form1" method="post" action="" style="margin:0px;">
        部门：
        <label>
        <select name="dept_id_s" id="dept_id_s">
		  <option value="">请选择部门</option>
		<?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['dp_list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
          <option value="<?php echo $this->_tpl_vars['dp_list'][$this->_sections['a']['index']]['d_id']; ?>
" <?php if ($this->_tpl_vars['dp_list'][$this->_sections['a']['index']]['d_id'] == $this->_tpl_vars['dm_id_s']): ?>selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['dp_list'][$this->_sections['a']['index']]['d_name']; ?>
</option>
		<?php endfor; endif; ?> 
        </select>
        </label>
         ,姓名:<input name="uname" type="text" style="height:13px;" id="uname" size="15" value="<?php echo $this->_tpl_vars['uname']; ?>
" />
		  <label>
		  <input type="submit" name="Submit" value="查询" />
		  <input name="action" type="hidden" id="action" value="search">
		  </label>
      </form>
      </div></td>
  </tr>
  <tr bgcolor="#F7F7F7">
    <td width="84" bgcolor="#F7F7F7"><div align="center"><STRONG>部门名称</STRONG></div></td>
    <td width="110"><div align="center"><strong>成员登录名称</strong></div></td>
    <td width="110"><div align="center"><strong>是否锁定</strong></div></td>
    <td width="110"><div align="center"><strong>姓名</strong></div></td>
    <td width="91"><div align="center"><strong>修改人</strong></div></td>
    <td width="114"><div align="center"><strong>修改时间</strong></div></td>
    <td width="120"><div align="center"><strong>最后登录时间</strong></div></td>
 	<td width="120"><div align="center"><strong>最后登录ip</strong></div></td>
    <td colspan="2" bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div>      </td>
  </tr>
  <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['dept_member']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['dm_d_id']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['a_name']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['iflock']; ?>
</div></td>
   <td>
    <div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['real_name']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['dm_edit_id']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['dm_edit_time']; ?>
</div></td>
   
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['admin_logintme']; ?>
</div></td>
   <td><div align="center"><?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['a_login_ip']; ?>
</div></td>


    <td width="75"><div align="center">[<a href="dp_member.php?action=edit&id=<?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['dm_al_id']; ?>
">修改</a>]</div></td>
    <td width="75"><div align="center">[<a href="#" onclick="ConfirmDel('dp_member.php?action=delete&id=<?php echo $this->_tpl_vars['dept_member'][$this->_sections['a']['index']]['dm_al_id']; ?>
');">删除</a>]</div></td>
  </tr>
  <?php endfor; endif; ?>
</table>
<table width="99%" border="0" cellpadding="3" cellspacing="1" class="p_table_order" style="margin-top:5px;">
  <tr>
    <td bgcolor="#FFFFFF"><div align="center">每页 <font color="#FF0000">
      <?php echo $this->_tpl_vars['pageSize']; ?>

      </font> 条 共 <font color="#FF0000">
        <?php echo $this->_tpl_vars['page']; ?>

        </font> 页 共 <font color="#FF0000">
        <?php echo $this->_tpl_vars['totalRecord']; ?>

          </font> 条记录&nbsp;
      <?php echo $this->_tpl_vars['multi']; ?>

    </div></td>
  </tr>

  <tr>
    <td bgcolor="#FFFFFF"><div align="center"><a href="dp_member.php?action=add"><strong>添加新的部门成员</strong></a></div></td>
  </tr>
  <tr style="height:30px;"><td bgcolor="#FFFFFF"></td></tr>
</table>

</body>
</html>