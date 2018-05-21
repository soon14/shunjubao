<?php /* Smarty version 2.6.20, created on 2018-04-12 15:31:08
         compiled from user_dingzhi.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>可定制用户列表 </title>
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
	
	<div align="left"><strong><span style="color:#FF0000"><span class="STYLE1">可定制用户列表</span></span>,搜索帐号</strong>:
          <input name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
" size="8"/>  
           <input name="spage" type="hidden" id="spage" value="1" />
          <input type="submit" name="Submit" value=" 搜 索 " /></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td width="4%" bgcolor="#F7F7F7"><div align="center">id</div></td>
  	<td width="7%" bgcolor="#F7F7F7"><div align="center">UID</div></td>
  	<td width="8%" bgcolor="#F7F7F7"><div align="center">帐号</div></td>
  	<td width="15%" bgcolor="#F7F7F7"><div align="center">加入时间</div></td>
  	<td width="15%" bgcolor="#F7F7F7"><div align="center">成功定制人数</div></td>
  	<td width="15%" bgcolor="#F7F7F7"><div align="center">红单数</div></td>
    <td width="13%" bgcolor="#F7F7F7"><div align="center">七天胜率</div></td>
    <td width="14%"  bgcolor="#F7F7F7"><div align="center">是否推荐</div></td>
    <td width="24%"  bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div></td>
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
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['s_u_id']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['s_u_name']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['create_time']; ?>
</div></td>
  	<td ><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_follow_ticket_nums']; ?>
</div></td>
  	<td ><div align="center"><input id="s_hondanshu_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" type="text"  style="width:60px" value="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['s_hondanshu']; ?>
" /></div></td>
    <td ><div align="center" title="七天内红单<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state1']; ?>
/(七天内红单<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state1']; ?>
+七天内黑单<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state2']; ?>
)"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state1']; ?>
/<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state1']+$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['show_prize_state2']; ?>
<input id="s_shenglv_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" type="text" style="width:60px" value="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['s_shenglv']; ?>
" /></div></td>
    <td><div align="center"><input id="s_recomond_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
" type="text" style="width:60px" value="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['s_recomond']; ?>
" /></div></td>
    <td><div align="center"><input name="" type="button"    value="确认修改" onclick="update_dingzhi('<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
')"/><span id="s_tips_<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
"></span></div> </td>
    </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
    <td colspan="9"><div align="center">每页<font color="#FF0000"> 
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
    <td colspan="9"><div align="center" style="color:#F00">修改说明：红单数85，胜率：78.65，
      <div> 推荐的状只填数字，默认为0前台不显示，1为显示，2为推荐<br />排序先后为推荐，胜率，红单数
      </div>
      
    </div></td>
  </tr>
</table>

</form>


<script>
	function update_dingzhi(id){
				var s_hondanshu = $("#s_hondanshu_"+id).val();
				var s_heidanshu = $("#s_heidanshu_"+id).val();
				var s_shenglv = $("#s_shenglv_"+id).val();
				var s_recomond = $("#s_recomond_"+id).val();
		
				$.ajax({
					type:'POST', //URL方式为POST
					url:'user_dingzhi.php', //这里是指向登录验证的頁面
					data:'action=update&s_hondanshu='+s_hondanshu+'&s_heidanshu='+s_heidanshu+'&s_shenglv='+s_shenglv+'&s_recomond='+s_recomond+'&id='+id, //把要验证的参数传过去 
					dataType: 'json', //数据类型为JSON格式的验证 
					success: function(data) {
						if(data.status == "success"){
							$("#s_tips_"+id).text(data.mess);
							return false;		
						}else{
							$("#s_tips_"+id).text(data.mess);
							return false;	
						}
				}
			});	
	
}
	
		

</script>
</body>
</html>