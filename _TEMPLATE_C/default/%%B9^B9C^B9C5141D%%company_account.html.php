<?php /* Smarty version 2.6.17, created on 2017-10-22 16:20:47
         compiled from ../admin/business/company_account.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/business/company_account.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<body>
<script type="text/javascript">
root_domain = '<?php echo @ROOT_DOMAIN; ?>
';
TMJF(function ($) {
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
	});
	$("#end_time").focus(function(){
		showCalendar('end_time', 'y-mm-dd');
	});
	$("#sub_export").click(function(){
		this.form.action = root_domain + '/admin/business/company_account_export.php';
	});
	$("#sub").click(function(){
		this.form.action = root_domain + '/admin/business/company_account.php';
	});
});
</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div>
  <h2> <b>●</b>查询出票公司对帐信息</h2>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><form method="post">
          <table width="35%" border="0" cellpadding="0" cellspacing="1">
            <tr>
              <td>开始时间</td>
              <td><input id="start_time" name="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
"/></td>
            </tr>
            <tr>
              <td>结束时间</td>
              <td><input id="end_time" name="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
"/></td>
            </tr>
            <tr>
              <td>是否排除运营投注</td>
              <td>是
                <input name="exclude_virtual" value="1" type="radio" checked>
                否
                <input name="exclude_virtual" value="0" type="radio"></td>
            </tr>
            <tr>
              <td>出票公司</td>
              <td><select id='company_id' name="company_id">
                  <?php $_from = $this->_tpl_vars['companys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['company_id'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>

                  </option>
                  <?php endforeach; endif; unset($_from); ?>
                </select>
              </td>
            </tr>
            <tr>
              <td><input id="sub" type="submit" value="提交" name="submit"/></td>
              <td><input id="sub_export" type="submit" value="导出" name="submit"/></td>
            </tr>
          </table>
        </form></td>
    </tr>
  </table>
  <?php if ($this->_tpl_vars['print_array']): ?>
  <h3><?php echo $this->_tpl_vars['companys']['company_id']['desc']; ?>
</h3>
  <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
    <tr>
      <td>\</td>
      <?php $_from = $this->_tpl_vars['print_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <td><?php echo $this->_tpl_vars['key']; ?>
</td>
      <?php endforeach; endif; unset($_from); ?></tr>
    <tr>
      <td>金额</td>
      <?php $_from = $this->_tpl_vars['print_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <td><?php echo $this->_tpl_vars['item']['money']; ?>
</td>
      <?php endforeach; endif; unset($_from); ?></tr>
    <tr>
      <td>数量</td>
      <?php $_from = $this->_tpl_vars['print_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <td><?php echo $this->_tpl_vars['item']['amount']; ?>
</td>
      <?php endforeach; endif; unset($_from); ?></tr>
  </table>
  <?php endif; ?> </div>
</body>
</html>