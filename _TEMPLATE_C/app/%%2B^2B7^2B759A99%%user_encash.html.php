<?php /* Smarty version 2.6.17, created on 2016-02-19 09:01:46
         compiled from user_encash.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
    });
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
	$("#end_time").focus(function(){
        //if (!$("#end_time").val()) {
        showCalendar('end_time', 'y-mm-dd');
        //}
    });	
});
</script>
<!--提现记录 start-->
<div class="ustitle">
  <h1><em>提现记录<b></b><i></i></em></h1>
</div>
<div class="usTips">
  <p><strong>冻结资金<?php echo $this->_tpl_vars['userAccountInfo']['frozen_cash']; ?>
</strong></p>
</div>
<div>
  <div class="boldtxt">
    <table width="100%" border="1"  cellpadding="0" cellspacing="0">
      <tr>
        <th>提现时间</th>
        <th>提现额度</th>
        <th>状态</th>
      </tr>
      <?php $_from = $this->_tpl_vars['userEncashInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userEncashInfo']):
        $this->_foreach['log']['iteration']++;
?>
      <tr>
        <td height="30"><?php echo $this->_tpl_vars['userEncashInfo']['create_time']; ?>
</td>
        <td><?php echo $this->_tpl_vars['userEncashInfo']['money']; ?>
元</td>
        <td><?php echo $this->_tpl_vars['EncashStatusDesc'][$this->_tpl_vars['userEncashInfo']['encash_status']]['desc']; ?>
</td>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </table>
  </div>
  <br/>
  <br/>
  <div class="clear"></div>
  <div> <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
    <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
    <?php endif; ?>
    <?php endif; ?> </div>
</div>
<!--提现记录 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>