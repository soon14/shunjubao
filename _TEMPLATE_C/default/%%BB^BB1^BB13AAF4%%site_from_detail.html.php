<?php /* Smarty version 2.6.17, created on 2018-03-06 10:14:20
         compiled from ../admin/business/site_from_detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '../admin/business/site_from_detail.html', 84, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<script type="text/javascript">
TMJF(function($) {
	var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
	});
	
	$("#end_time").focus(function(){
	    //if (!$("#end_time").val()) {
	    showCalendar('end_time', 'y-mm-dd');
	    //}
	});
		
});
</script>
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 外站链接：
          <input type="text" name="source_key" id="source_key" value="<?php echo $this->_tpl_vars['source_key']; ?>
">
          |
          开始时间：
          <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
          结束时间：
          <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
          <input type="submit" name="" value="查询">
        </li>
        <li style="padding:20px 0;">外站链接格式：1、全部链接=>http://www.zhiying365365.com/sites?ZYsiteFrom=xxx; 2、外站参数=>xxx</li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
</div>
<div>
  <h2><b>●</b>网站代理人信息</h2>
  <div class="tabpading">
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <th>序号
            </td>
          <th>外站描述</th>
          <th>外站管理组</th>
          <th>外站链接</th>
          <th>外站参数</th>
          <th>创建时间</th>
          <th>创建人</th>
        </tr>
        <tr>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['id']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['describe']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['admin_group']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['link']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['source_key']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['create_time']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['siteFromInfo']['create_uname']; ?>
</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<div>
  <h2><b>●</b>网站代理人统计详情（已排除管理组用户）</h2>
  <div class="tabpading">
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tr>
          <th>注册日期</th>
          <th align="center">用户名</th>
          <th align="center">认证用户</th>
          <th align="center">充值金额</th>
          <th align="center">投注金额</th>
          <th align="center">返点</th>
        </tr>
        <?php $_from = $this->_tpl_vars['site_from_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['a'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['a']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['site_from_list']):
        $this->_foreach['a']['iteration']++;
?>
        <tr>
          <td align="left" style="color:#777;"><?php echo $this->_tpl_vars['site_from_list']['u_jointime']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['site_from_list']['u_name']; ?>
</td>
          <td align="center"><?php if ($this->_tpl_vars['site_from_list']['idcard'] > 0): ?> 是 <?php else: ?>  <?php endif; ?></td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['charge_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['total_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
          <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['refund_total_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
		<div style="display:none;">

		</div>
    </table>
	<?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
        <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
      <?php endif; ?>
      <?php endif; ?>
  </div>
</div>
</body>
</html>