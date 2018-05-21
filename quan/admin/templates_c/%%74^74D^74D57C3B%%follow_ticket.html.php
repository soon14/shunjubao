<?php /* Smarty version 2.6.20, created on 2018-04-12 15:31:19
         compiled from follow_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'show_post_member', 'follow_ticket.html', 60, false),)), $this); ?>
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
  	<td colspan="16">
<div align="left">
       <strong><span style="color:#FF0000"><span class="STYLE1">已定制用户列表</span></span>,<span style="color:red">被</span>定制用户帐号</strong>:
         <input name="follow_name" id="follow_name" value="<?php echo $this->_tpl_vars['follow_name']; ?>
" size="8"/>,
    <strong>定制用户帐号</strong>:
         <input name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
" size="8"/>
          ，定制日期 <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="var e_date=$dp.$('e_date');WdatePicker({onpicked:function(){e_date.focus();},maxDate:'#F{$dp.$D(\'e_date\')}'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="10"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'s_date\')}'})" size="10"/>
         ，状态
          <select name="status" id="status">
			<option value="0">请选择</option>
         	 <option value="1" <?php if ($this->_tpl_vars['status'] == 1): ?>  selected="selected" <?php endif; ?>>成功</option>
              <option value="2" <?php if ($this->_tpl_vars['status'] == 2): ?>  selected="selected" <?php endif; ?>>失败</option>
          </select>
          <input name="spage" type="hidden" id="spage" value="1" />
      <input type="submit" name="Submit" value=" 搜 索 " /></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td width="72"><div align="center"><STRONG>系统ID</STRONG></div></td>
    <td bgcolor="#F7F7F7"><div align="center">被定制用户</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制用户</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制周期</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制倍数</div></td>
    <td bgcolor="#F7F7F7"><div align="center">返点数</div></td>
    <td bgcolor="#F7F7F7"><div align="center">开始时间</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">截止时间</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">添加时间</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">当前状态</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">成功跟注</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">跟注金额</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">中奖金额</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">跟注失败</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">错失金额</div></td>
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
  	<td width="72"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
</div></td>
    <td><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['follow_id'])) ? $this->_run_mod_handler('show_post_member', true, $_tmp) : show_post_member($_tmp)); ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['cycle_show']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['multiple']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['rebate']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['start_time']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['end_time']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['create_time']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['status_show']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['suc_nums']; ?>
</div></td>
    <td><div align="center"></div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ticket_prize']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['miss_nums']; ?>
</div></td>
    <td><div align="center"></div></td>
    <td><div align="center"> 
    <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['enable'] == 1): ?>
    
    <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['status'] == 1): ?>
      [<a href="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['filename']; ?>
?action=update&id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
&status=2}-->" >点击退订</a>]
      <?php else: ?>
      [<a href="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['filename']; ?>
?action=update&id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
&status=1}-->" >点击续订</a>]
      <?php endif; ?>
      <?php endif; ?> 
     </div>
    </td>
    </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="16"><div align="center">每页<font color="#FF0000"> 
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
    <td colspan="16"><div align="center"></div></td>
  </tr>
</table>

</form>
</body>
</html>