<?php /* Smarty version 2.6.20, created on 2016-03-19 15:41:50
         compiled from quan_member.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>圈子用户</title>
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
  	<td colspan="10">
	
	<div align="left"><strong><span style="color:#FF0000"><span class="STYLE1">圈子用户</span></span></strong> <strong style="color:#FF0000">会员帐号</strong>:
          <input name="keywords" id="keywords" value="<?php echo $this->_tpl_vars['keywords']; ?>
" size="8"/>,<strong  style="color:#FF0000">板块:</strong> 
          <?php echo $this->_tpl_vars['quan']; ?>
 ,<strong>是否管理员：</strong><input name="isman" id="isman" type="checkbox" value="1" <?php if ($this->_tpl_vars['mancheck'] == 1): ?>  checked="checked" <?php endif; ?>/> <input type="submit" name="Submit" value=" 搜 索 " />,<a href="quan_member.php">取消查询条件</a></div>	</td>
  </tr>
 
  <tr bgcolor="#F7F7F7">
  	<td width="83"><div align="center"><STRONG>系统ID</STRONG></div></td>
    <td width="295" bgcolor="#F7F7F7"><div align="center">模块</div></td>
    <td bgcolor="#F7F7F7"><div align="center">u_id</div></td>
    <td bgcolor="#F7F7F7"><div align="center">姓名</div></td>
    <td bgcolor="#F7F7F7"><div align="center">昵称</div></td>
    <td bgcolor="#F7F7F7"><div align="center">登录次数</div></td>
    <td bgcolor="#F7F7F7"><div align="center">进入时间</div></td>
    <td bgcolor="#F7F7F7"><div align="center">最后时间</div></td>
    <td width="172" bgcolor="#F7F7F7"><div align="center">是否管理员</div></td>
    <td width="172" bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div></td>
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
  	<td width="83"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
</div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['qid']; ?>
</div></td>
    <td width="118"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_id']; ?>
</div></td>
    <td width="118"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_name']; ?>
</div></td>
    <td width="118"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['u_nick']; ?>
</div></td>
    <td width="118"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['loginnums']; ?>
</div></td>
    <td width="183"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['firsttime']; ?>
</div></td>
    <td width="139"><div align="center">
      <?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['lasttime']; ?>

    </div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['isman_show']; ?>
</div></td>
    <td><div align="center">
    
        <?php if ($this->_tpl_vars['datalist'][$this->_sections['a']['index']]['isman'] == 1): ?>
        [<a href="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['filename']; ?>
?action=update&id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
&isman=0" > 取消 </a>]</div>
        <?php else: ?>
        [<a href="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['filename']; ?>
?action=update&id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['id']; ?>
&isman=1" > 设为管理员 </a>]</div>
        <?php endif; ?>

    
    </td>
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
    <td colspan="10"><div align="center"></div></td>
  </tr>
</table>

</form>
</body>
</html>