<?php /* Smarty version 2.6.17, created on 2018-01-07 00:02:56
         compiled from ../admin/system/data_monitor.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<script type="text/javascript">
TMJF(function($) {
	$("#data").submit(function(){
		if (!confirm('检测过程可能较长，确定要开始检测吗？')) {
			return false;
		}
		return true;
	});
});
</script>
<div class="UserRight">
<form method="post" id="data">
<div class="timechaxun" style="height:45px;">
  <ul>
  <li>
  	<input type="hidden" name='action' value='show'>
      <input type="submit" name="" value="检测数据源状态">
    </li>
  </ul>
  <div class="clear"></div>
</div>
</form>
</div>
<div>
  <h2><b>●</b>数据源状态</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>监测项目</td>
          <td>状态</td>
        </tr>
        <?php $_from = $this->_tpl_vars['return']['source']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
        <td class="show"><?php echo $this->_tpl_vars['item']['desc']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    
  </div>
</div>
<div>
  <h2><b>●</b>数据文件状态</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>文件名称</td>
          <td>说明</td>
          <td>状态</td>
          <td>最后更新时间</td>
        </tr>
        <?php $_from = $this->_tpl_vars['return']['files']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
        <td class="show"><?php echo $this->_tpl_vars['key']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['desc']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['updatetime']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>