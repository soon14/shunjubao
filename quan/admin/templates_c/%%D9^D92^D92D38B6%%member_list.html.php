<?php /* Smarty version 2.6.20, created on 2018-05-10 20:33:25
         compiled from member_list.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>会员列表 </title>
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
  	<td colspan="11">
	
	<div align="left"><strong><span style="color:#FF0000"><span class="STYLE1">会员列表</span></span></strong><strong >u_id</strong>:
          <input name="u_id" id="u_id" value="<?php echo $this->_tpl_vars['u_id']; ?>
" size="8"/>  , <strong >手机号</strong>:
          <input name="keywords" id="keywords" value="<?php echo $this->_tpl_vars['keywords']; ?>
" size="8"/>  ,<strong >帐号</strong>:
          <input name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
" size="8"/>  
          ,<strong>注册时间</strong>:
          <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="var e_date=$dp.$('e_date');WdatePicker({onpicked:function(){e_date.focus();},maxDate:'#F{$dp.$D(\'e_date\')}'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="10"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'s_date\')}'})" size="10"/>
          ,是否认证<input name="rz" type="checkbox" value="1" <?php if ($this->_tpl_vars['rz'] == 1): ?> checked="checked"<?php endif; ?> />
           <input name="spage" type="hidden" id="spage" value="1" />
          <input type="submit" name="Submit" value=" 搜 索 " /></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td bgcolor="#F7F7F7"><div align="center">u_id</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">帐号</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">余额</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">冻结金额</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">积分</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">彩金</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">姓名</div></td>
    <td bgcolor="#F7F7F7"><div align="center">身份证</div></td>
    <td bgcolor="#F7F7F7"><div align="center">手机号</div></td>
    <td bgcolor="#F7F7F7"><div align="center">注册时间</div></td>
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
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['cash']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['frozen_cash']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['score']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['gift']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['realname']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['idcard']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['mobile']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_jointime']; ?>
</div></td>
    <td><div align="center">[<a href="member_list.php?action=delete&u_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
" onclick="javascript:return confirm('确认删除单个帐号？一旦删除将不可恢复');"> 删除单个 </a>][<a href="member_list.php?action=delete2&mobile=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['mobile']; ?>
" onclick="javascript:return confirm('确认删除此手机所有帐号？一旦删除将不可恢复');"> 删除此手机帐号 </a>] [<a style="color:#F00" href="member_list.php?action=set_area&u_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
"> 设置出票地区 </a>]</div>
      
      
    </td>
    </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="11"><div align="center">每页<font color="#FF0000"> 
      <?php echo $this->_tpl_vars['pageSize']; ?>

      </font>条 共<font color="#FF0000">
        <?php echo $this->_tpl_vars['page']; ?>
 
        </font>页  共<font color="#FF0000">
          <?php echo $this->_tpl_vars['totalRecord']; ?>
 
          </font>条记录
      <?php echo $this->_tpl_vars['multi']; ?>

      </div></td>
  </tr>
  <tr bgcolor="#FFFFFF" style="height:30px;">
    <td colspan="11"><div align="center">设置出票必须要有管理员权限才生效</div></td>
  </tr>
</table>

</form>
</body>
</html>