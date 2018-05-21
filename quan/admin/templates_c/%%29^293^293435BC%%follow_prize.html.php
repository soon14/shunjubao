<?php /* Smarty version 2.6.20, created on 2018-04-12 15:32:43
         compiled from follow_prize.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'show_post_member', 'follow_prize.html', 61, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跟单分成列表</title>
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
  	<td colspan="15">
	
	<div align="left">
       <strong><span><span >跟单分成列表</span></span>,订单ID： <input name="sid" id="sid" value="<?php echo $this->_tpl_vars['sid']; ?>
" size="8"/>,<span style="color:red">被</span>定制用户帐号</strong>:
         <input name="follow_name" id="follow_name" value="<?php echo $this->_tpl_vars['follow_name']; ?>
" size="8"/>,
    <strong>定制用户帐号</strong>:
         <input name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
" size="8"/>
         	 ，分成时间 <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="var e_date=$dp.$('e_date');WdatePicker({onpicked:function(){e_date.focus();},maxDate:'#F{$dp.$D(\'e_date\')}'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="10"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'s_date\')}'})" size="10"/>
          ,分成状态：
          <label for="select"></label>
          <select name="f_status" id="f_status">
			<option value="0">请选择</option>
         	 <option value="1" <?php if ($this->_tpl_vars['f_status'] == 1): ?>  selected="selected" <?php endif; ?>>成功</option>
              <option value="2" <?php if ($this->_tpl_vars['f_status'] == 2): ?>  selected="selected" <?php endif; ?>>失败</option>
          </select>
          <input name="spage" type="hidden" id="spage" value="1" />
      <input type="submit" name="Submit" value=" 搜 索 " /></div></td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td width="72"><div align="center"><STRONG>系统ID</STRONG></div></td>
  	<td bgcolor="#F7F7F7"><div align="center">被定制用户</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制用户</div></td>
    <td bgcolor="#F7F7F7"><div align="center">被跟订单</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制订单</div></td>
    <td><div align="center">出票状态</div></td>
    <td><div align="center">投注金额</div></td>
    <td><div align="center">跟单中奖金额</div></td>
    <td><div align="center">中奖时间</div></td>
    <td><div align="center">分成比例</div></td>
    <td><div align="center">分成金额</div></td>
    <td bgcolor="#F7F7F7"><div align="center">是否已分成</div></td>
    <td bgcolor="#F7F7F7"><div align="center">分成时间</div></td>
    <td bgcolor="#F7F7F7"><div align="center">定制详情</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">操作</div></td>
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
    <td ><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id'])) ? $this->_run_mod_handler('show_post_member', true, $_tmp) : show_post_member($_tmp)); ?>
</div></td>
    <td ><div align="center"><a target="_blank" href="http://www.zhiying365.com/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['partent_id']; ?>
"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['partent_id']; ?>
</a></div></td>
    <td ><div align="center"><a target="_blank" href="http://www.zhiying365.com/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ticket_id']; ?>
"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ticket_id']; ?>
</a></div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['print_state']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['money']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['prize']; ?>
</div></td>
    <td><div align="center">
      <div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['prize_time']; ?>
</div></td>
    <td><div align="center">
      <?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['pay_rate']; ?>

    </div></td>
    <td><div align="center">
      <?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['f_prize']; ?>

    </div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['f_status_show']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['f_time']; ?>
</div></td>
    <td ><div align="center"><a target="_blank" href="http://www.zhiying365.com/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ticket_id']; ?>
"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ticket_show']; ?>
</a></div></td>
    <td><div align="center"></div></td>
    </tr>
 
  <?php endfor; endif; ?>
  
   <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#F7F8F8'">
    <td><strong>小计：</strong></td>
    <td>&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td><div align="center"></div></td>
    <td><div align="center"><strong style="color:#F00"><?php echo $this->_tpl_vars['total_money']; ?>
</strong></div></td>
    <td>
      <div align="center"><strong style="color:#F00"><?php echo $this->_tpl_vars['total_prize']; ?>
</strong></div></td>
    <td><div align="center"></div></td>
    <td>&nbsp;</td>
    <td>  <div align="center"><strong style="color:#F00"><?php echo $this->_tpl_vars['total_f_prize']; ?>
</strong></div></td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td >&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="15"><div align="center">每页<font color="#FF0000"> 
      <?php echo $this->_tpl_vars['pageSize']; ?>

      </font>条 共<font color="#FF0000">
        <?php echo $this->_tpl_vars['page']; ?>
 
        </font>页  共<font color="#FF0000">
          <?php echo $this->_tpl_vars['totalRecord']; ?>
 
          </font>条记录
      <?php echo $this->_tpl_vars['multi']; ?>
，本次查询总分成金额:<strong style="color:red"><?php echo $this->_tpl_vars['dingzhi_total_f_prize']; ?>
</strong>
      </div></td>
  </tr>
  <tr bgcolor="#FFFFFF" style="height:30px;">
    <td colspan="15"><div align="center">说明:提成比例为1%-5%（提成=跟单中奖总额-跟单本金总额，中奖奖金若为正数，提成将从跟单中奖用户中按比例扣除）</div></td>
  </tr>
</table>

</form>
</body>
</html>