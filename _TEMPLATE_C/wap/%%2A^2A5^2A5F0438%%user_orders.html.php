<?php /* Smarty version 2.6.17, created on 2017-10-21 05:36:09
         compiled from ../admin/order/user_orders.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getPoolDesc', '../admin/order/user_orders.html', 236, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.gdtype{text-align:left;position:relative;padding:0 0 0 5px;}
.gdtype span{ font-size:12px;color:#dc0000;background:url(<?php echo @STATICS_BASE_URL; ?>
/i/gBj.gif) no-repeat;width:17px;height:19px;line-height:19px;color:#fff;text-align:center;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.gdtype strong{background:url(<?php echo @STATICS_BASE_URL; ?>
/i/shai.gif) no-repeat;position:absolute;right:10px;top:3px;width:17px;height:19px;line-height:19px;text-indent:-5000px;cursor:pointer;}
</style>
<body>
<script type="text/javascript">
TMJF(function($) {
	var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";
	$("#start_date").focus(function(){
		//if (!$("#start_date").val()) {
		showCalendar('start_date', 'y-mm-dd');
		//}
	});
	
	$("#end_date").focus(function(){
	    //if (!$("#end_date").val()) {
	    showCalendar('end_date', 'y-mm-dd');
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
                    		for(var key in option) {
                    			if (key == 'red') {
                    				option_html += '<font color="red">'+option[key] +'</font>';
                    			} else {
                    				option_html += option[key];
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
	});
	var refund_money_ing = false;
	$(".refund_money").click(function(){
		if (!confirm("本单的本金将全部退还到用户的账户，确定为:  "+$(this).attr('u_name')+"   执行"+$(this).text()+"操作吗？")) return false; 
		if (refund_money_ing) return false;
		$.post(root_domain + '/admin/admin_operate.php'
                , {userTicketId: $(this).attr('userTicketId'),
					type:'refund_money'
                  }
                , function(data) {
                	refund_money_ing = true;
                	alert(data.msg);
                	if (data.ok) {
                		window.location.reload(true);
                	}
                }
                , 'json'
            );
		refund_money_ing = false;
	});
	var manu_prize_ing = false;
	$(".manu_prize").click(function(){
		if (!confirm("确定为:  "+$(this).attr('u_name')+"   执行"+$(this).text()+"操作吗？")) return false; 
		if (manu_prize_ing) return false;
		$.post(root_domain + '/admin/admin_operate.php'
                , {userTicketId: $(this).attr('userTicketId'),
					type:'manu_prize'
                  }
                , function(data) {
                	manu_prize_ing = true;
                	alert(data.msg);
                	if (data.ok) {
                		window.location.reload(true);
                	}
                }
                , 'json'
            );
		manu_prize_ing = false;
	});
	var compayn_to_zhiying_img = false;
	$(".company_to_zhiying").click(function(){
		if (!confirm("确定为:  "+$(this).attr('u_name')+"   的订单(ID：" + $(this).attr('userTicketId') + ")执行"+$(this).text()+"操作吗？")) return false; 
		if (compayn_to_zhiying_img) return false;
		$.post(root_domain + '/admin/admin_operate.php'
                , {userTicketId: $(this).attr('userTicketId'),
					type:'company_to_zhiying'
                  }
                , function(data) {
                	compayn_to_zhiying_img = true;
                	alert(data.msg);
                	if (data.ok) {
                		window.location.reload(true);
                	}
                }
                , 'json'
            );
		compayn_to_zhiying_img = false;
	});
});
</script>
<!--投注记录 start-->
<div class="UserRight">
<form method="post">
<div class="timechaxun" style="">
  <ul>
  <li>用户名
      <input type="text" name="user_name" id="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">
    |出票订单号
      <input type="text" name="return_id" id="return_id" value="<?php echo $this->_tpl_vars['return_id']; ?>
">
    |玩法：
      <select name='pool' id='pool' >
       <option value="all" selected>全部玩法</option>
       <option value="all_fb" <?php if ($this->_tpl_vars['pool'] == all_fb): ?> selected <?php endif; ?> >竞彩足球全部玩法</option>
       <option value="all_bk" <?php if ($this->_tpl_vars['pool'] == all_bk): ?> selected <?php endif; ?> >竞彩篮球全部玩法</option>
       <option value="all_bd" <?php if ($this->_tpl_vars['pool'] == all_bd): ?> selected <?php endif; ?> >北京单场全部玩法</option>
      <?php $_from = $this->_tpl_vars['sportAndPoolDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['pool'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      |串关数：
      <select name='select' id='select' >
       <option value="all" selected>全部串关</option>
       <option value="1x1" <?php if ($this->_tpl_vars['select'] == '1x1'): ?> selected <?php endif; ?> >单关</option>
       <option value="2x1" <?php if ($this->_tpl_vars['select'] == '2x1'): ?> selected <?php endif; ?> >两场2x1</option>
       <option value="3x1" <?php if ($this->_tpl_vars['select'] == '3x1'): ?> selected <?php endif; ?> >三场3x1</option> 
       <option value="4x1" <?php if ($this->_tpl_vars['select'] == '4x1'): ?> selected <?php endif; ?> >四场4x1</option> 
      </select>
    出票状态：
       <select name='print_state' id='print_state' >
      <option value="all" selected>全部状态</option>
      <?php $_from = $this->_tpl_vars['userTicketPrintStateDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <?php if ($this->_tpl_vars['key']): ?>
      <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['print_state'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php else: ?>
      <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if (! $this->_tpl_vars['print_state']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      <br/>
   中奖状态：
       <select name='prize_state' id='prize_state' >
      <option value="all" <?php if ($this->_tpl_vars['prize_state'] == 'all'): ?> selected <?php endif; ?> >全部状态</option>
       <?php $_from = $this->_tpl_vars['userTicketPrizeStateDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
       <?php if ($this->_tpl_vars['key']): ?>
       <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['prize_state'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
       <?php else: ?>
       <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if (! $this->_tpl_vars['prize_state']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      出票方：<select name='company_id' id='company_id'>
      <option value="all" <?php if ($this->_tpl_vars['company_id'] == 'all'): ?> selected <?php endif; ?> >全部状态</option>
      <?php $_from = $this->_tpl_vars['getTicketCompany']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['company_id'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      </select>|
      来源：<select name='source' id='source'>
      <option value="all" <?php if ($this->_tpl_vars['source'] == 'all'): ?> selected <?php endif; ?> >全部状态</option>
      <option value='1' <?php if ($this->_tpl_vars['source'] == 1): ?>selected<?php endif; ?>>主站</option>
      <option value='10' <?php if ($this->_tpl_vars['source'] == 10): ?>selected<?php endif; ?>>wap</option>
      <option value='11' <?php if ($this->_tpl_vars['source'] == 11): ?>selected<?php endif; ?>>安卓</option>
      <option value='12' <?php if ($this->_tpl_vars['source'] == 12): ?>selected<?php endif; ?>>ios</option>
      </select>
      ，最小中奖金额 ：
      <input type="text" name="start_money" id="start_money" style="width:60px" value="<?php echo $this->_tpl_vars['start_money']; ?>
">  
      ，最小投注金额 ：
      <input type="text" name="money" id="money" style="width:60px" value="<?php echo $this->_tpl_vars['money']; ?>
">  
      <br/>
    开始日期：
      <input type="text" name="start_date" id="start_date" value="<?php echo $this->_tpl_vars['start_date']; ?>
">
    开始时间：
      <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
    结束日期：
      <input type="text" name="end_date" id="end_date" value="<?php echo $this->_tpl_vars['end_date']; ?>
">
   结束时间：
      <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
      
      <input type="submit" name="" value="查询">
    </li>
  </ul>
  <div class="clear"></div>
</div>
</form>
<br/>
<div>
<table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
	<tr><?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><td><?php echo $this->_tpl_vars['key']; ?>
</td><?php endforeach; endif; unset($_from); ?></tr>
	<tr><?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><td><?php if ($this->_tpl_vars['key'] != '订单数'): ?>&yen;<?php echo $this->_tpl_vars['item']; ?>
元<?php else: ?><?php echo $this->_tpl_vars['item']; ?>
<?php endif; ?></td><?php endforeach; endif; unset($_from); ?></tr>
</table>
  <h2>
  <b>●</b>订单信息</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>序号</td>
          <td>彩种</td>
          <td>用户名</td>
          <td>串关方式</td>
          <td>总金额</td>
          <td>倍数</td>
          <td>出票状态</td>
          <td>中奖信息</td>
          <td>出票方</td>
          <td>认购时间</td>
          <td>操作</td>
                  </tr>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr <?php if ($this->_foreach['ticket']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <td class="show"><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/orders.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" target="_blank" title="查看系统订单"><?php echo $this->_tpl_vars['userTicket']['id']; ?>
</a></td>
          <td class="show"><div class="gdtype">
        <?php if ($this->_tpl_vars['userTicket']['partent_id']): ?><span class="">&nbsp;跟&nbsp;</span><?php endif; ?>
        <?php if ($this->_tpl_vars['userTicket']['source'] == 10): ?><span class="">&nbsp;手机&nbsp;</span><?php endif; ?>
        <?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>

		</div></td>
          <td class="show">
          <?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/user_orders.php?print_state=all&&user_name=<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
" class="show_details"  target="_blank" >投注记录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/reg_log.php?u_name=<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
"  target="_blank" >账户信息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/gift_log.php?log_type=all&u_name=<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
" class="show_details"  target="_blank">彩金信息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/account_log.php?u_name=<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
" class="show_details"  target="_blank">余额信息</a>
          </td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['user_select']; ?>
</td>
          <td class="show">￥<?php echo $this->_tpl_vars['userTicket']['money']; ?>
元</td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</td>
          <td class="show">
          <?php echo $this->_tpl_vars['userTicketPrintStateDesc'][$this->_tpl_vars['userTicket']['print_state']]['desc']; ?>

          |<a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/orders.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" target="_blank">详情</a>
          |<a href="<?php echo @ROOT_DOMAIN; ?>
/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" target="_blank">方案页面</a>
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
          <td class="show"><?php echo $this->_tpl_vars['getTicketCompany'][$this->_tpl_vars['userTicket']['company_id']]['desc']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['userTicket']['datetime']; ?>
</td>
          <td class="show">
                    <?php if ($this->_tpl_vars['userTicket']['print_state'] != 8 && $this->_tpl_vars['userTicket']['print_state'] != 9999): ?>
          <a href="javascript::void(0);" target="_blank" class="refund_money" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" u_name="<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
">退票</a>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['userTicket']['manu_prize'] == 1): ?>&nbsp;&nbsp;|
          <a href="javascript::void(0);" target="_blank" class="manu_prize" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" u_name="<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
">手动算奖</a>
          <?php endif; ?>
          <?php if ($this->_tpl_vars['userTicket']['print_state'] != 1): ?>
          &nbsp;&nbsp;|
          <a href="javascript::void(0);" target="_blank" class="company_to_zhiying" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" u_name="<?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['userTicket']['u_id']]['u_name']; ?>
">智赢出票</a>
          <?php endif; ?>
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
</div>
<!--投注记录 end-->
</body>
</html>