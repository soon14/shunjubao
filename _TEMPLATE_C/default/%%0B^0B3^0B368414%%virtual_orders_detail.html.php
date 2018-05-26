<?php /* Smarty version 2.6.17, created on 2017-10-14 18:34:57
         compiled from ../admin/order/virtual_orders_detail.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<script type="text/javascript">
TMJF(function($) {
	
});
</script>
<!--投注记录 start-->
<div>
  <h2>
  <b>●</b>积分订单信息-用户：<?php echo $this->_tpl_vars['userTicketInfo']['u_name']; ?>
</h2>
  <table class="" width="20%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5" style="overflow:hidden;">
      <tbody>
        <tr>
        <td>总金额</td>
          <td>倍数</td>
          <td>出票状态</td>
          <td>中奖信息</td>
          <td>认购时间</td>
        </tr>
        <tr>
        	<td><?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
</td>
        	<td><?php echo $this->_tpl_vars['userTicketInfo']['multiple']; ?>
</td>
        	<td><?php echo $this->_tpl_vars['statusDesc'][$this->_tpl_vars['userTicketInfo']['status']]['desc']; ?>
</td>
        	<td><?php if ($this->_tpl_vars['userTicketInfo']['prize'] > 0): ?><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
<?php endif; ?></td>
        	<td><?php echo $this->_tpl_vars['userTicketInfo']['create_time']; ?>
</td>
        </tr>
        </tbody>
  </table>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
                <th>序号</th>
                <th>场次</th>
                <th>主队</th>
                <th>VS</th>
                <th>客队</th>
                <th>选项</th>
                <th>彩果</th>
              </tr>
              <?php $_from = $this->_tpl_vars['return']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['matchInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['matchInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['matchInfo']['iteration']++;
?>
              <tr>
              <?php if ($this->_tpl_vars['item']['matchInfo']): ?>
                <td><?php echo $this->_foreach['matchInfo']['iteration']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['matchInfo']['num']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['matchInfo']['host_team']; ?>
</td>
                <td>VS</td>
                <td><?php echo $this->_tpl_vars['item']['matchInfo']['guest_team']; ?>
</td>
                <td><?php echo $this->_tpl_vars['item']['key_str']; ?>
</td>
                <td><?php echo $this->_tpl_vars['resultDesc'][$this->_tpl_vars['item']['matchInfo']['lottery_result']]['desc']; ?>
</td>
              <?php else: ?>
              <td>赛事被删除，无法获取（id:<?php echo $this->_tpl_vars['key']; ?>
;combination:<?php echo $this->_tpl_vars['item']; ?>
）</td>
              <?php endif; ?>
              </tr>
              <?php endforeach; endif; unset($_from); ?> 
      </tbody>
    </table>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>