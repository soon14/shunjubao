<?php /* Smarty version 2.6.20, created on 2016-01-26 10:00:49
         compiled from bascdata_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'show_datalist_type', 'bascdata_list.html', 40, false),array('modifier', 'show_tstatus', 'bascdata_list.html', 43, false),array('modifier', 'showusername', 'bascdata_list.html', 44, false),array('modifier', 'date_format', 'bascdata_list.html', 45, false),)), $this); ?>
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

<table width="99%"  border="0" cellpadding="3" cellspacing="1" class="p_table_order">
<form name="myform"  id="myform" method="Post">
  <tr bgcolor="#F7F7F7">
  	<td colspan="11">
	<div style="float:right; padding-right:10px;"> <a href="bascdata_list.php?action=add"><strong>添加数据</strong></a>  <a href="bascdata_list.php"><strong>查看列表</strong></a></div>
    	<div  style="float:left; padding-left:10px;"><strong>关键字</strong>：
              <input name="keywords" id="keywords" value="<?php echo $this->_tpl_vars['keywords']; ?>
"/>
         		<input type="submit" name="Submit" value="搜索" />
		 		<input name="action" type="hidden" id="action" value="search" />
   	 </div></td>
  </tr>
</form>  
  <form name="myform"  id="myform" method="Post">
  <tr bgcolor="#F7F7F7">
  	<td width="61"><div align="center"><STRONG>选中</STRONG></div></td>
    <td width="205" bgcolor="#F7F7F7"><div align="center">名称</div></td>
    <td width="176" bgcolor="#F7F7F7"><div align="center">类型</div>      </td>
    <td bgcolor="#F7F7F7"><div align="center">中文标记</div></td>
    <td bgcolor="#F7F7F7"><div align="center">状态</div></td>
    <td bgcolor="#F7F7F7"><div align="center">操作人</div></td>
    <td bgcolor="#F7F7F7"><div align="center">操作时间</div></td>
    <td colspan="4" bgcolor="#F7F7F7"><div align="center"><strong>操作</strong></div></td>
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
  	<td width="61"><div align="center"><input name='delid' type='checkbox' onclick="unselectall()" id="delid" value="<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
" /></div></td>
    <td><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['tname']; ?>
</div></td>
    <td><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ttype'])) ? $this->_run_mod_handler('show_datalist_type', true, $_tmp) : show_datalist_type($_tmp)); ?>

      </div></td>
    <td width="165"><div align="center"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['ttag']; ?>
</div></td>
    <td width="165"><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['tstatus'])) ? $this->_run_mod_handler('show_tstatus', true, $_tmp) : show_tstatus($_tmp)); ?>
</div></td>
    <td width="130"><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['addid'])) ? $this->_run_mod_handler('showusername', true, $_tmp) : showusername($_tmp)); ?>
</div></td>
    <td width="142"><div align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['datalist'][$this->_sections['a']['index']]['addtime'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d %H:%M:%S") : smarty_modifier_date_format($_tmp, "%Y-%m-%d %H:%M:%S")); ?>
</div></td>
    <td width="63"><div align="center">[<a href="bascdata_value.php?bd_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
"> 查列表</a>]</div></td>
    <td width="64"><div align="center">[<a href="bascdata_value.php?action=add&bd_id=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
"> 加列表</a>]</div></td>
    <td width="70"><div align="center">[<a href="bascdata_list.php?action=edit&sysid=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
"> 修改 </a>]</div></td>
    <td width="76">[<a href="bascdata_list.php?action=delete&sysid=<?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['sysid']; ?>
" onclick="javascript:return confirm('您确认要删除吗？一旦删除将不可恢复');"> 删除 </a>]</td>
  </tr>
  <?php endfor; endif; ?>
  <tr bgcolor="#FFFFFF">
  <td width="61"><div align="center">
      <input name="chkAll" type="checkbox" id="chkAll" onclick=CheckAll(this.form) value="checkbox">全选
    </div></td>
    <td colspan="10">&nbsp;
      
      <label>
      <input type="button" name="Submit3" onclick="funcDoAllData('删除将无法恢复，确认删除?','bascdata_list.php','1')"  value="删除选中" />
      </label>
    </a></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td colspan="11"><div align="center">每页<font color="#FF0000"> 
      <?php echo $this->_tpl_vars['pageSize']; ?>

      </font>条 共<font color="#FF0000">
        <?php echo $this->_tpl_vars['page']; ?>
 
        </font>页  共<font color="#FF0000">
          <?php echo $this->_tpl_vars['totalRecord']; ?>
 
          </font>条记录
		   <?php echo $this->_tpl_vars['multi']; ?>

    </div>
     </td>
  </tr>
  </form>
  <tr bgcolor="#FFFFFF">
    <td colspan="11">&nbsp;<br /></td>
  </tr>
</table>

</body>
</html>