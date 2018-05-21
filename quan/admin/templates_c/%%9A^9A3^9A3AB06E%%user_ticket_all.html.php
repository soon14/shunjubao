<?php /* Smarty version 2.6.20, created on 2018-05-10 23:20:34
         compiled from user_ticket_all.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>投注列表 </title>
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
	
	<div align="left"><strong><span style="color:#FF0000"><span class="STYLE1">投注列表</span></span></strong>  <strong >ID</strong>:
          <input name="id" id="id" value="<?php echo $this->_tpl_vars['id']; ?>
" size="8"/> ，<strong >帐号</strong>:
          <input name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
" size="8"/>  
          ,<strong>下单时间</strong>:
          <input name="s_date" type="text" class="Wdate" id="s_date"  onFocus="var e_date=$dp.$('e_date');WdatePicker({onpicked:function(){e_date.focus();},maxDate:'#F{$dp.$D(\'e_date\')}'})" value="<?php echo $this->_tpl_vars['s_date']; ?>
" size="10"/>
          至
          <input name="e_date" type="text" value="<?php echo $this->_tpl_vars['e_date']; ?>
" class="Wdate" id="e_date" onFocus="WdatePicker({minDate:'#F{$dp.$D(\'s_date\')}'})" size="10"/>
          ,
          <strong >投注倍数>=</strong><input name="multiple" id="multiple" value="<?php echo $this->_tpl_vars['multiple']; ?>
" size="8"/>  
          ,
           <strong >投注金额</strong><input name="money" id="money" value="<?php echo $this->_tpl_vars['money']; ?>
" size="8"/>至<input name="money2" id="money2" value="<?php echo $this->_tpl_vars['money2']; ?>
" size="8"/>    
          ,
          <strong >中奖金额>=</strong><input name="prize_money" id="prize_money" value="<?php echo $this->_tpl_vars['prize_money']; ?>
" size="8"/>  
          <br />

          <input type="checkbox" name="combination_type" id="combination_type" value="1" <?php if ($this->_tpl_vars['combination_type'] == 1): ?> checked="checked" <?php endif; ?> /><strong>晒单</strong>,  
          <input type="checkbox" name="prize" id="prize" value="1" <?php if ($this->_tpl_vars['prize'] == 1): ?> checked="checked" <?php endif; ?> /><strong>中奖</strong>,
          <input type="checkbox" name="pay_rate" id="pay_rate" value="1" <?php if ($this->_tpl_vars['pay_rate'] == 1): ?> checked="checked" <?php endif; ?> /> <strong>已设置分成</strong>，
           <input type="checkbox" name="print_state" id="print_state" value="1" <?php if ($this->_tpl_vars['print_state'] == 1): ?> checked="checked" <?php endif; ?> /><strong>已出票</strong>
      	，<strong >赛事系统ID</strong>:
          <input name="combination" id="combination" value="<?php echo $this->_tpl_vars['combination']; ?>
" size="15"/>  
          ,	
          <input name="spage" type="hidden" id="spage" value="1" />
          <input type="submit" name="Submit" value=" 搜 索 " /></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td bgcolor="#F7F7F7"><div align="center">id</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">帐号</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">串关</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">下单时间</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">倍数</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">投注金额</div></td>
  	<td bgcolor="#F7F7F7"><div align="center">是否中奖</div></td>
    <td bgcolor="#F7F7F7"><div align="center">中奖金额</div></td>
    <td bgcolor="#F7F7F7"><div align="center">跟注截止时间</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">是否跟单</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">是否设置擂台</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">出票</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">是否晒单</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">显示范围</div></td>
    <td  bgcolor="#F7F7F7"><div align="center">提成比例</div></td>
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
  	<td ><div align="center"><a target="_blank" href="http://news.shunjubao.com/account/tlcket.php?userTicketId=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
</a></div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['user_select']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['datetime']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['multiple']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['money']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['prize_state_show']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['prize']; ?>
</div></td>
    <td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['endtime']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['partent_id']; ?>
</div></td>
    <td><div  style="color:#F00" id="leitai_tips<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
">
      <div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['leitai_show']; ?>

      </div>
    </div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['print_state']; ?>
</div></td>
    <td><div align="center"><div  style="color:#F00" id="combination_type_tips<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['combination_type_show']; ?>
</div></div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_range2']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['pay_rate2']; ?>
</div></td>
    <td><div align="center">
   <span style=" <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['leitai'] == 0): ?>display:<?php else: ?>display:none<?php endif; ?>" id="a1_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" >[<a  href="javascript:void(0);" onclick="update_leitai('<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
','1');" > 设为擂台 </a>]</span>
   <span id="a0_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" style=" <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['leitai'] == 1): ?>display:<?php else: ?>display:none<?php endif; ?>" > [<a  id="a0_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" href="javascript:void(0);" onclick="update_leitai('<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
','0');" > 取消擂台 </a>]</span>
      </div>
      
    </td>
    </tr>
  <?php endfor; endif; ?>    
  <tr bgcolor="#FFFFFF" onmouseout="this.style.backgroundColor=''" onmouseover="this.style.backgroundColor='#F7F8F8'">
    <td ><div align="center"></div></td>
    <td ><div align="center"></div></td>
    <td ><div align="center"></div></td>
    <td ><div align="center"></div></td>
    <td ><div align="center"></div></td>
    <td ><div align="center" style="color:#F00"><?php echo $this->_tpl_vars['all']['money']; ?>
</div></td>
    <td ><div align="center"></div></td>
    <td ><div align="center"  style="color:#F00"><?php echo $this->_tpl_vars['all']['prize']; ?>
(<?php echo $this->_tpl_vars['all']['prize']-$this->_tpl_vars['all']['money']; ?>
)</div></td>
    <td ><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
    <td><div align="center"></div></td>
  </tr>

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

<script>

	function update_leitai(id,type){
	
	if(id==''){
		return;
	}
	
	$.ajax({
			type:'POST', //URL方式为POST
			url:'ajax_update_leitai.php', //这里是指向登录验证的頁面
			data:'tid='+id+'&action=leitai&type='+type, //把要验证的参数传过去 
			dataType: 'json', //数据类型为JSON格式的验证 
			success: function(data) {
				
				if (data.status == "success") {
					
					if(type==1){
						$("#a1_"+id).hide();
						$("#a0_"+id).show();
						$("#leitai_tips"+id).html('成功设置擂台');
						$("#combination_type_tips"+id).html('同时设置为晒单');
						
						
					}else{
						$("#leitai_tips"+id).html('成功取消擂台');
						$("#combination_type_tips"+id).html('同时取消晒单');
						$("#a1_"+id).show();
						$("#a0_"+id).hide();
						
						
					}
					
				
					
					return true;
					//alert('修改成功');
				}else{
					
					$("#leitai_tips"+id).html('设置出错');
					$("#combination_type_tips"+id).html('设置出错');
					return true;
					//$("#orderbytip"+id).html('出错');
					
					//$("#phone").focus();
					return true;
				}
			}
		});
		
	}
</script>



</body>
</html>
