<?php /* Smarty version 2.6.20, created on 2018-04-14 09:49:02
         compiled from admin_log.html */ ?>
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
<form name="myform"  id="myform" method="Post">
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#F7F7F7">
  	<td colspan="16"><div  style="float:left; padding-left:10px;"><strong style="color:#FF0000">系统日志</strong> <strong>关键字</strong>：
              <input name="keywords" id="keywords" value="<?php echo $this->_tpl_vars['keywords']; ?>
"/>
         		<input type="submit" name="Submit" value="搜索" />
		 		<input name="action" type="hidden" id="action" value="search" />
   	 </div></td>
  </tr>
  <tr bgcolor="#F7F7F7">
  	<td width="10%"><div align="center">日志ID</div></td>
  	<td  width="9%" bgcolor="#F7F7F7"><div align="center">会员名称</div></td>
    <td width="41%" bgcolor="#F7F7F7"><div align="center">操作内容</div></td>
    <td width="16%" bgcolor="#F7F7F7"><div align="center">操作时间</div></td>
    <td width="24%" bgcolor="#F7F7F7"><div align="center">操作IP</div></td>
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
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#fff06d'">
  	<td width="10%">
  	  <div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['al_user']; ?>
</div></td>
    <td><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['al_action']; ?>
</td>
    <td>
      <div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['al_create_time']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['al_ip']; ?>
</div></td>
  </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td width="10%">&nbsp;</td>
    <td colspan="4">&nbsp;</td>
  </tr>
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
  <tr bgcolor="#FFFFFF">
    <td colspan="5"><div align="center"></div></td>
  </tr>
</table>
</form>
</body>
</html>