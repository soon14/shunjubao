<?php /* Smarty version 2.6.20, created on 2018-05-09 17:08:48
         compiled from member_show_area_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出票对应地区列表 </title>
<link href="./js/common.css" type="text/css" rel="stylesheet">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript src="js/jquery.js"></SCRIPT>
<SCRIPT language=javascript src="js/common.js" ></SCRIPT>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style></head>
<body style="margin:30px 0px 0px 8px;">
<form name="myform"  id="myform" method="Post">
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#F7F7F7">
  	<td colspan="9">
	
	<div align="left"><strong><span style="color:#FF0000"><span class="STYLE1">出票对应地区设置</span></span></strong>
        （设置出票必须要有管理员权限才生效）</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td bgcolor="#F7F7F7"><div align="center"><strong>u_id</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>帐号</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>姓名</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>手机号</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>出票对应地区</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>备注</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>操作时间</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>操作ip</strong></div></td>
    <td  bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div></td>
  </tr>
  <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['datalist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#F7F8F8'">
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['realname']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['mobile']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['area_info']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['description']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['addtime']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['addip']; ?>
</div></td>
    <td><div align="center">[<a href="member_list.php?action=delete_area&u_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
" onclick="javascript:return confirm('确认删除单个帐号？一旦删除将不可恢复');"> 删除出票权限 </a>] [<a style="color:#F00" href="member_list.php?action=set_area&u_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
"> 修改出票地区 </a>]</div>
      
      
    </td>
    </tr>
  <?php endfor; endif; ?>


</table>

</form>
</body>
</html>