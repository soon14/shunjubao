<?php /* Smarty version 2.6.20, created on 2018-05-03 20:18:44
         compiled from betting_log.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>定制用户</title>
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
  	<td colspan="5">
<div align="left">
       <strong><span style="color:#FF0000"><span class="STYLE1">赛事修改日志</span></span>,赛事系统ID</strong>:
         <input name="m_id" id="m_id" value="<?php echo $this->_tpl_vars['m_id']; ?>
" size="8"/>,
    <strong>修改人帐号</strong>:
         <input name="operate_uname" id="operate_uname" value="<?php echo $this->_tpl_vars['operate_uname']; ?>
" size="8"/>
          ，修改日期 <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="var e_date=$dp.$('e_date');WdatePicker({onpicked:function(){e_date.focus();},maxDate:'#F{$dp.$D(\'e_date\')}'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="10"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'s_date\')}'})" size="10"/>
         ，状态
          
          <input name="spage" type="hidden" id="spage" value="1" />
      <input type="submit" name="Submit" value=" 搜 索 " /></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td width="72"><div align="center"><STRONG>日志ID</STRONG></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>赛事ID</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>修改人</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>操作时间</strong></div></td>
    <td bgcolor="#F7F7F7"><div align="center"><strong>修改内容说明</strong></div>      <div align="center"></div></td>
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
  	<td width="72"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['m_id']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['operate_uname']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['create_time']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['mod_log']; ?>
</div></td>
    </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="5"><div align="center">每页<font color="#FF0000"> 
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
    <td colspan="5"><div align="center"></div></td>
  </tr>
</table>

</form>
</body>
</html>