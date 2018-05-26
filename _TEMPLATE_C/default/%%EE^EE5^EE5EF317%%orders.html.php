<?php /* Smarty version 2.6.17, created on 2017-10-16 21:10:48
         compiled from ../admin/order/orders.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/order/orders.html', 2, false),array('modifier', 'getPoolDesc', '../admin/order/orders.html', 164, false),)), $this); ?>
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
	var org_details_html = $("#detail_tr").html();
	$(".show_details").click(function(){
		$(".URcenter").show();
		
		$.post(root_domain + '/getUserTicketInfo.php'
                , {id: $(this).attr('userTicketId')
                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    	var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
                    		html += '<td class="show">'+ k +'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].num +'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].l_code+'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].date +'&nbsp;&nbsp;'+ ticketInfo[i].time +'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].h_cn +'&nbsp;VS&nbsp;'+ ticketInfo[i].a_cn +'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].spool +'</td>';
                    		
                    		var option = ticketInfo[i].option;
                    		var option_html = '';
                    		
                    		var red = option['red'];//中奖
                    		var black = option['black'];//未中奖
                    		var empty = option['empty'];//无赛果
                    		
                    		if (red) {
                    			for(var key in red) {
                        				option_html += '&nbsp;<font color="red">'+red[key] +'</font>&nbsp;';
                        		}
                    		}
                    		if (black) {
                    			for(var key in black) {
                        				option_html += '&nbsp;' + black[key] + '&nbsp;';
                        		}
                    		}
                    		if (empty) {
                    			for(var key in empty) {
                        				option_html += '&nbsp;' + empty[key] + '&nbsp;';
                        		}
                    		}
                    		
                    		html += '<td class="show">'+ option_html +'</td>';
                    		html += '<td class="show">'+ ticketInfo[i].results +'</td>';
                    		html += '</tr>'
                    		$("#user_select").html(ticketInfo[i].user_select);
                        }
                    	$("#detail_tr").html(org_details_html + html);
                    	//$("#detail_tr").append(html);
                    } 
                }
                , 'json'
            );
	})
});
</script>
<!--投注记录 start-->
<div class="UserRight">
<div>
  <h2>
  <b>●</b>订单信息-用户：<?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
(uid:<?php echo $this->_tpl_vars['userInfo']['u_id']; ?>
)</h2>
  <table class="" width="20%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5" style="overflow:hidden;">
      <tbody>
        <tr>
        	<?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><td><?php echo $this->_tpl_vars['key']; ?>
</td><?php endforeach; endif; unset($_from); ?>
        </tr>
        <tr>
        	<?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><td><?php echo $this->_tpl_vars['item']; ?>
</td><?php endforeach; endif; unset($_from); ?>
        </tr>
        </tbody>
  </table>
        
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>序号</td>
          <td>订单号</td>
          <td>彩种</td>
          <td>串关方式</td>
          <td>总金额</td>
          <td>倍数</td>
          <td>出票状态</td>
          <td>出票方</td>
          <td>中奖信息</td>
          <td>认购时间</td>
          <td>备注(票号或出错信息)</td>
                  </tr>
        <?php $_from = $this->_tpl_vars['orderTickets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr <?php if ($this->_foreach['ticket']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <td class="show"><?php echo $this->_foreach['ticket']['iteration']; ?>
</td>
        <td class="show"><?php if ($this->_tpl_vars['userTicket']['return_id']): ?><?php echo $this->_tpl_vars['userTicket']['return_id']; ?>
<?php else: ?><?php echo $this->_tpl_vars['userTicket']['ticket_id']; ?>
(<?php echo $this->_tpl_vars['userTicket']['id']; ?>
)<?php endif; ?></td>
          <td class="show"><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['select']; ?>
</td>
          <td class="show">￥<?php echo $this->_tpl_vars['userTicket']['money']; ?>
元</td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</td>
          <td class="show">
          <?php echo $this->_tpl_vars['userTicketPrintStateDesc'][$this->_tpl_vars['userTicket']['print_state']]['desc']; ?>

          </td>
          <td class="show">
          <?php echo $this->_tpl_vars['ticketCompanyDesc'][$this->_tpl_vars['userTicket']['company_id']]['desc']; ?>

          </td>
          <td class="show">
	          <div class="jiesuancaozuo">
		          <?php if ($this->_tpl_vars['userTicket']['prize_state'] == 1): ?>
		          	<b>中奖</b>&nbsp;￥<?php echo $this->_tpl_vars['userTicket']['prize']; ?>
元&nbsp;
		          <?php else: ?>
		          		<strong class=""><?php echo $this->_tpl_vars['userTicketPrizeStateDesc'][$this->_tpl_vars['userTicket']['prize_state']]['desc']; ?>
</strong>
		          <?php endif; ?>
	          </div>
          </td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['datetime']; ?>
</td>
          <td><?php echo $this->_tpl_vars['userTicket']['return_str']; ?>
</td>
                  </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
    <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
		<div class="pageC">
		<div class="pages">
		<?php if ($this->_tpl_vars['previousUrl']): ?>
		<a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['nextUrl']): ?>
		<a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a>
		<?php endif; ?>
		</div>
		</div>
	<?php endif; ?>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>