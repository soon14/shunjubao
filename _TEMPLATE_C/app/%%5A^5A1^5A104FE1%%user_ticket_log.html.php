<?php /* Smarty version 2.6.17, created on 2016-02-25 14:34:29
         compiled from user_ticket_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_ticket_log.html', 5, false),array('modifier', 'getPoolDesc', 'user_ticket_log.html', 83, false),)), $this); ?>
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
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<script type="text/javascript">
TMJF(function($) {
	
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
    });
	$("table tr:nth-child(odd)").css("background-color","#f1f1f1");
	$("#end_time").focus(function(){
        showCalendar('end_time', 'y-mm-dd');
    });	
	var org_details_html = $("#detail_tr").html();
	$(".show_details").click(function(){
		$(".URcenter").show();
		$.post(Domain + '/getUserTicketInfo.php'
                , {id: $(this).attr('userTicketId')
                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    	var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
                    		html += '<td>'+ k +'</td>';
                    		html += '<td>'+ ticketInfo[i].num +'</td>';
                    		html += '<td>'+ ticketInfo[i].l_code+'</td>';
                    		html += '<td>'+ ticketInfo[i].date +'&nbsp;&nbsp;'+ ticketInfo[i].time +'</td>';
                    		html += '<td>'+ ticketInfo[i].h_cn +'&nbsp;VS&nbsp;'+ ticketInfo[i].a_cn +'</td>';
                    		html += '<td>'+ ticketInfo[i].spool +'</td>';
                    		var option = ticketInfo[i].option;
                    		var option_html = '';
                    		for(var key in option) {
                    			if (key == 'red') {
                    				option_html += '<font color="red">'+option[key] +'</font>';
                    			} else {
                    				option_html += option[key];
                    			}
                    		}
                    		html += '<td>'+ option_html +'</td>';
                    		html += '<td>'+ ticketInfo[i].results +'</td>';
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
<div class="ustitle">
  <h1><em>个人账户明细<b></b><i></i></em></h1>
</div>
<div class="Paymingxi">
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="0" style="width:100%; overflow:hidden;">
      <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></div></td>
        <td><div class="selectTag"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php" class="active">奖金派送</a></div></td>
    </table>
    <div style="padding:18px 0 0 0;">
      <div class="boldtxt">
        <table width="100%" border="1"  cellpadding="0" cellspacing="0">
          <tr>
            <th>玩法</th>
            <th>交易时间</th>
            <th>收入</th>
          </tr>
          <?php $this->assign('trade_amount_in', 0); ?>
          <?php $this->assign('trade_money_in', 0); ?>
          <?php $_from = $this->_tpl_vars['userTicketInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicketInfo']):
        $this->_foreach['log']['iteration']++;
?>
          <?php $this->assign('trade_amount_in', $this->_tpl_vars['trade_amount_in']+1); ?>
          <?php $this->assign('trade_money_in', $this->_tpl_vars['userTicketInfo']['prize']+$this->_tpl_vars['trade_money_in']); ?>
          <tr>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicketInfo']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicketInfo']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicketInfo']['pool'])); ?>
</td>
            <td><p><?php echo $this->_tpl_vars['userTicketInfo']['datetime']; ?>
</p></td>
            <td><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
元</td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
        <?php if (! $this->_tpl_vars['userTicketInfos']): ?>
        <div class="tips">暂时没有您的信息! </div>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
        <div class="pages"><?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
        <?php endif; ?>
        <?php endif; ?> </div>
    </div>
  </div>
</div>
<!--用户中心账户明细 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>