<?php /* Smarty version 2.6.17, created on 2016-02-21 12:48:34
         compiled from user_virtual_ticket.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
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
	$("#end_time").focus(function(){
	   // if (!$("#end_time").val()) {
	    showCalendar('end_time', 'y-mm-dd');
	   // }
	});
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
});
</script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="ustitle">
  <h1><em>积分投注记录<b></b><i></i></em></h1>
</div>
<!--投注记录 start-->
<div class="boldtxt" style="margin:10px 0 0 0;">
  <table class="hacker" border="1" cellpadding="0" cellspacing="0" width="100%"style="text-align:center;">
    <tbody>
      <tr>
        <!--<th>认购时间</th>-->
        <th>投注积分</th>
        <th>积分详情</th>
        <th>方案详情</th>
      </tr>
    <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['ticket']['iteration']++;
?>
    <tr>
      <!--<td ><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>-->
      <td style="padding:2px 0;"><?php echo $this->_tpl_vars['item']['money']; ?>
</td>
      <td><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['item']['prize'] > 0): ?>
          中奖<?php echo $this->_tpl_vars['item']['prize']; ?>
积分
          <?php endif; ?>
          <?php if ($this->_tpl_vars['item']['status'] == 2): ?> <span style="color:#000;">未中奖</span> <?php endif; ?> </div></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/virtual_ticket.php?userTicketId=<?php echo $this->_tpl_vars['item']['id']; ?>
" style='color:#444;'>查看详情</a></td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    </tbody>
    
  </table>
  <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
  <div class="pages" style="border-bottom:none;"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
    <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> <?php endif; ?> </div>
  <?php endif; ?></div>
<!--投注记录 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>