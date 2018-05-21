<?php /* Smarty version 2.6.20, created on 2018-05-09 16:31:49
         compiled from user_charge_count.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'user_charge_count.html', 80, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
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
  	<td colspan="7">
	

    	<div align="left"><strong><span style="color:#FF0000">充值报表</span></strong>
        <strong>充值时间</strong>:
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
  	<td  bgcolor="#F7F7F7"><div align="center"><strong>类型</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>来源</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>充值成功条数</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>充值失败条数</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>成功率</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>成功金额</strong></div></td>
  	<td bgcolor="#F7F7F7"><div align="center"><strong>失败金额</strong></div></td>
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
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['charge_type']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['charge_source']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['nums']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['nums2']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['rate']; ?>
%</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['totalmoney']; ?>
</div></td>
  	<td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['totalmoney2']; ?>
</div></td>
  	</tr>
      <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#F7F8F8'">
    <td colspan="2"><div align="center"><strong>总数</strong></div>      <div align="center"></div></td>
    <td><div align="center"><strong style="color:red">
      <?php echo $this->_tpl_vars['all']['nums']; ?>

    </strong></div></td>
    <td><div align="center"><strong style="color:red">
      <?php echo $this->_tpl_vars['all']['nums2']; ?>

    </strong></div></td>
    <td><div align="center"><strong style="color:red">
      <?php echo $this->_tpl_vars['all']['rate']; ?>
%
    </strong></div></td>
    <td><div align="center"><strong style="color:red">
      <?php echo $this->_tpl_vars['all']['totalmoney']; ?>

    </strong></div></td>
    <td><div align="center"><strong style="color:red">
      <?php echo $this->_tpl_vars['all']['totalmoney2']; ?>

    </strong></div></td>
  </tr>

  <tr bgcolor="#FFFFFF">
    <td colspan="7"><div align="center"><?php echo $this->_tpl_vars['multi']; ?>

      </div></td>
  </tr>
  <tr bgcolor="#FFFFFF" style="height:30px;">
    <td colspan="7">
    
    <div align="center"> 
  
    天无局支付宝收入：<strong><?php echo $this->_tpl_vars['value01']['nums']; ?>
 </strong>笔,<strong ><?php echo ((is_array($_tmp=$this->_tpl_vars['value01']['totalmoney'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
元</strong><br /> 
    
    智赢支付宝指定帐号：<strong><?php echo $this->_tpl_vars['value02']['nums']; ?>
 </strong>笔,<strong ><?php echo ((is_array($_tmp=$this->_tpl_vars['value02']['totalmoney'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
元</strong><br /> 
    
 	智赢支付宝非指定帐号：<strong  ><?php echo $this->_tpl_vars['value03']['nums']; ?>
 </strong>笔,<strong ><?php echo ((is_array($_tmp=$this->_tpl_vars['value03']['totalmoney'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
元</strong><br /> 
    
    智赢支付宝在线网银：<strong ><?php echo $this->_tpl_vars['value04']['nums']; ?>
 </strong>笔,<strong ><?php echo ((is_array($_tmp=$this->_tpl_vars['value04']['totalmoney'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
元</strong><br /> 
    
    智赢支付宝总入帐：<strong   style="color:red"><?php echo $this->_tpl_vars['value01']['nums']+$this->_tpl_vars['value02']['nums']+$this->_tpl_vars['value03']['nums']+$this->_tpl_vars['value04']['nums']; ?>
 </strong>笔,<strong  style="color:red"><?php echo $this->_tpl_vars['value01']['totalmoney']+$this->_tpl_vars['value02']['totalmoney']+$this->_tpl_vars['value03']['totalmoney']+$this->_tpl_vars['value04']['totalmoney']; ?>
</strong>元<br /> 
    
    人工后台充值：<strong><?php echo $this->_tpl_vars['log_type_nums']; ?>
 </strong>笔,<strong ><?php echo ((is_array($_tmp=$this->_tpl_vars['log_type_totalmoney'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.2f") : smarty_modifier_string_format($_tmp, "%.2f")); ?>
元</strong><br /> 
		</div></td>
  </tr>
</table>

</form>
</body>
</html>