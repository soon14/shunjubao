<?php /* Smarty version 2.6.20, created on 2018-05-07 17:01:51
         compiled from user_ticket_report.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'user_ticket_report.html', 55, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投注报表</title>
<link href="./js/common.css" type="text/css" rel="stylesheet">
<link href="./css/layout.css" rel="stylesheet" type="text/css">
<SCRIPT language=javascript src="js/jquery.js"></SCRIPT>
<SCRIPT language=javascript src="js/common.js" ></SCRIPT>
<script language="javascript" type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
</head>
<body style="margin:30px 0px 0px 8px;">
<form name="myform"  id="myform" method="Post">
<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
  <tr bgcolor="#F7F7F7">
  	<td colspan="10">
	

    	<div align="left"><strong><span style="color:#FF0000">中奖报表</span></strong>
        <strong><strong >用户ID</strong>:
          <input name="u_id" id="u_id" value="<?php echo $this->_tpl_vars['u_id']; ?>
" size="8"/> ，投注时间</strong>:
          <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="18"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})" size="18"/>
    	  <input name="action" type="hidden" id="action" value="default" />
           <input type="submit" name="Submit" value=" 搜 索 " />
        </div>

	
	</td>
  </tr>

  <tr bgcolor="#F7F7F7">
    <td bgcolor="#F7F7F7"><div align="center"><strong><strong >用户ID</strong></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>用户名</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 't_nums'): ?>style="color:#F00"<?php endif; ?>  href="user_ticket_report.php?orderby=t_nums&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">投注数<?php if ($this->_tpl_vars['orderby'] == 't_nums'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'nums'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=nums&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">中奖数<?php if ($this->_tpl_vars['orderby'] == 'nums'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 't_money'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=t_money&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">投注金额<?php if ($this->_tpl_vars['orderby'] == 't_money'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'prize'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=prize&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">中奖金额<?php if ($this->_tpl_vars['orderby'] == 'prize'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'p_nums'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=p_nums&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">跟单数<?php if ($this->_tpl_vars['orderby'] == 'p_nums'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'p_money'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=p_money&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">跟单金额<?php if ($this->_tpl_vars['orderby'] == 'p_money'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'profit'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=profit&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">盈亏<?php if ($this->_tpl_vars['orderby'] == 'profit'): ?>↓<?php endif; ?></a></strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong ><a <?php if ($this->_tpl_vars['orderby'] == 'rate'): ?>style="color:#F00"<?php endif; ?> href="user_ticket_report.php?orderby=rate&s_date=<?php echo $this->_tpl_vars['s_date']; ?>
&e_date=<?php echo $this->_tpl_vars['e_date']; ?>
">中奖率<?php if ($this->_tpl_vars['orderby'] == 'rate'): ?>↓<?php endif; ?></a></strong></div></td>
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
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['t_nums']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['nums']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['t_money']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['prize']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['p_nums']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['p_money']; ?>
</div></td>
  	<td><div align="center" <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['profit'] > 0): ?> style="color:red"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['profit'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['rate']; ?>
%</div></td>
  	</tr>
      <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="10"><div align="center">每页<font color="#FF0000"> 
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
    <td colspan="10">
    
    <div align="center"><br /> 
		</div></td>
  </tr>
</table>

</form>
</body>
</html>