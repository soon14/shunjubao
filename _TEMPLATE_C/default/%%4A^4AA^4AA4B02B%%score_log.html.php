<?php /* Smarty version 2.6.17, created on 2017-10-15 13:05:01
         compiled from ../admin/user/score_log.html */ ?>
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
<!--投注记录 start-->
<div class="UserRight">
<form method="post">
<div class="timechaxun" style="height:45px;">
  <ul>
  <li>
      用户名：
      <input type="text" name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
">|
    开始时间：
      <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
    结束时间：
      <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
      积分类型
      <select id="log_type" name="log_type">
      <option value="all" selected> 全部类型</option>
      <?php $_from = $this->_tpl_vars['bankrollChangeType']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <?php if ($this->_tpl_vars['key'] == 27 || $this->_tpl_vars['key'] == 28 || $this->_tpl_vars['key'] == 26 || $this->_tpl_vars['key'] == 29 || $this->_tpl_vars['key'] == 44): ?>
      <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['log_type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?> > <?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      <input type="submit" name="" value="查询">
    </li>
  </ul>
  <div class="clear"></div>
</div>
</form>
<div>
  <h2>
  <b>●</b>用户积分记录</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
          <tbody>
            <tr>
                <th>序号</th>
                <th>用户ID</th>
                <th>收入</th>
                <th>支出</th>
                <th>余额</th>
                <th>交易类型</th>
                <th>交易时间</th>
            </tr>
              <?php $_from = $this->_tpl_vars['userScoreLogInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
              <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
              	<tr>
              	  <td class="show"><?php echo $this->_tpl_vars['item']['log_id']; ?>
</td>
              	  <td class="show"><?php echo $this->_tpl_vars['item']['u_id']; ?>
</td>
                <td class="show"><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['item']['log_type']]['direction'] == 1): ?><?php echo $this->_tpl_vars['item']['score']; ?>
元<?php endif; ?></td>
                <td class="show"><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['item']['log_type']]['direction'] == 2): ?><?php echo $this->_tpl_vars['item']['score']; ?>
元<?php endif; ?></td>
                <td class="show"><?php echo $this->_tpl_vars['item']['old_score']; ?>
</td>
                <td class="show"><?php echo $this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['item']['log_type']]['desc']; ?>
</td>
                <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>
              </tbody>
              
            </table>
  </div>
          <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
          <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
            <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
          <?php endif; ?>
          <?php endif; ?>
</div>
<!--投注记录 end-->
</body>
</html>