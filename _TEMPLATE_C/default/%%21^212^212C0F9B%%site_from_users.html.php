<?php /* Smarty version 2.6.17, created on 2017-10-28 09:48:33
         compiled from ../admin/business/site_from_users.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/business/site_from_users.html', 2, false),)), $this); ?>
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
TMJF(function($) {
	$(".start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
	});
	$(".end_time").focus(function(){
		showCalendar('end_time', 'y-mm-dd');
	});
});
</script>
<div>
  <h2> <b>●</b>网站代理人信息</h2>
  <div class="UserRight">
    <form method="post">
      <div class="timechaxun" style="height:45px;">
        <ul>
          <li> 用户名：
            <input type="text" name="create_uname" id="create_uname" value="<?php echo $this->_tpl_vars['create_uname']; ?>
">
            &nbsp;&nbsp;|&nbsp;&nbsp;
            开始时间：
            <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
            结束时间：
            <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
            &nbsp;&nbsp;|&nbsp;&nbsp;
            <select name='order' id='order'>
              <option value="total_registers desc" <?php if ($this->_tpl_vars['order'] == 'total_registers desc'): ?>selected<?php endif; ?>>注册人数倒序
              </option>
              <option value="total_registers asc" <?php if ($this->_tpl_vars['order'] == 'total_registers asc'): ?>selected<?php endif; ?>>注册人数正序
              </option>
              <option value="total_idcards desc" <?php if ($this->_tpl_vars['order'] == 'total_idcards desc'): ?>selected<?php endif; ?>>认证人数倒序
              </option>
              <option value="total_idcards asc" <?php if ($this->_tpl_vars['order'] == 'total_idcards asc'): ?>selected<?php endif; ?>>认证人数正序
              </option>
              <option value="total_money desc" <?php if ($this->_tpl_vars['order'] == 'total_money desc'): ?>selected<?php endif; ?>>投注总量倒序
              </option>
              <option value="total_money asc" <?php if ($this->_tpl_vars['order'] == 'total_money asc'): ?>selected<?php endif; ?>>投注总量正序
              </option>
            </select>
            <input type="submit" name="" value="查询">
          </li>
        </ul>
        <div class="clear"></div>
      </div>
    </form>
  </div>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <th>序号</th>
          <th>外站链接</th>
          <th>注册人数</th>
          <th>认证人数</th>
          <th>投注总金额</th>
          <th>创建时间</th>
          <th>创建人</th>
          <th>操作</th>
        </tr>
      <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
      <tr 
      <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
      <form method="post" action="">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
">
          <input type='hidden' name='operate' value="modify">
          <?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['link']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['total_registers']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['total_idcards']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['total_money']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_uname']; ?>
</td>
        <td class="show"><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/site_from_detail.php?source_key=<?php echo $this->_tpl_vars['item']['source_key']; ?>
">详情</a></td>
      </form>
      </tr>
      
      <?php endforeach; endif; unset($_from); ?>
      </tbody>
      
    </table>
    <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
    <div class="pageC">
      <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
        <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?> </div>
    </div>
    <?php endif; ?> </div>
</div>
</body>
</html>