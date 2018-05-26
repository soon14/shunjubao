<?php /* Smarty version 2.6.17, created on 2017-10-16 21:06:42
         compiled from ../admin/order/tickets.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/order/tickets.html', 2, false),array('modifier', 'getPoolDesc', '../admin/order/tickets.html', 128, false),)), $this); ?>
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
                    		html += '<td>'+ k +'</td>';
                    		html += '<td>'+ ticketInfo[i].num +'</td>';
                    		html += '<td>'+ ticketInfo[i].l_code+'</td>';
                    		html += '<td>'+ ticketInfo[i].date +'&nbsp;&nbsp;'+ ticketInfo[i].time +'</td>';
                    		if (ticketInfo[i].sport == 'bk') {
                    			html += '<td>'+ ticketInfo[i].a_cn +'&nbsp;VS&nbsp;'+ ticketInfo[i].h_cn +'</td>';
                    		} else {
                    			html += '<td>'+ ticketInfo[i].h_cn +'&nbsp;VS&nbsp;'+ ticketInfo[i].a_cn +'</td>';
                    		}
                    		html += '<td>'+ ticketInfo[i].spool +'</td>';
                    		
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
<!--投注记录 start-->
<div class="UserRight">
<form method="post">
  <div class="timechaxun" style="height:45px;">
    <ul>
      <li>用户名
        <input type="text" name="user_name" id="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">
        |
        开始时间：
        <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
        |
        结束时间：
        <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
        <input type="submit" name="" value="查询">
      </li>
    </ul>
    <div class="clear"></div>
  </div>
</form>
<div>
  <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
    <tr>
      <th>总投注额度</th>
      <th>总中奖额度</th>
    </tr>
    <tr>
      <td><?php echo $this->_tpl_vars['totalTicketMoney']; ?>
</td>
      <td><?php echo $this->_tpl_vars['totalPrizeMoney']; ?>
</td>
    </tr>
  </table>
  <h2> <b>●</b>方案信息</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <th>方案类型</th>
          <th>总金额</th>
          <th>倍数</th>
          <th>彩票标识</th>
          <th>方案奖金</th>
          <th>认购时间</th>
          <th>方案详情</th>
        </tr>
      <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
      <tr>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>
</td>
        <td>￥<?php echo $this->_tpl_vars['userTicket']['money']; ?>
元</td>
        <td><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</td>
        <td><?php echo $this->_tpl_vars['userTicketPrintStateDesc'][$this->_tpl_vars['userTicket']['print_state']]['desc']; ?>

           </td>
        <td><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['userTicket']['prize_state'] == 1): ?> <b>中奖</b>&nbsp;￥<?php echo $this->_tpl_vars['userTicket']['prize']; ?>
元&nbsp;
            <?php else: ?> <strong class=""><?php echo $this->_tpl_vars['userTicketPrizeStateDesc'][$this->_tpl_vars['userTicket']['prize_state']]['desc']; ?>
</strong> <?php endif; ?> </div></td>
        <td><?php echo $this->_tpl_vars['userTicket']['datetime']; ?>
</td>
        <td><a href="javascript:void(0);" class="show_details" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">方案详情</a>| <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/orders.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" class="show_details" target="_blank">订单详情</a></td>
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
  <br/>
  <div class="URcenter none" style="border:none;">
    <h2><b>●</b>方案详情</h2>
    <div>
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody id='detail_tr'>
          <tr>
            <th>序号</th>
            <th>场次</th>
            <th>赛事</th>
            <th>截止时间</th>
            <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>
            <th>客队VS主队</th>
            <?php else: ?>
            <th>主队VS客队</th>
            <?php endif; ?>
            <th>玩法</th>
            <th>您的选项</th>
            <th>赛果</th>
          </tr>
                </tbody>
        
      </table>
      <div class="Jilu">过关方式：<em id="user_select"></em></div>
       </div>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>