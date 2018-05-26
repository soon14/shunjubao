<?php /* Smarty version 2.6.17, created on 2017-10-14 18:11:09
         compiled from ../admin/order/user_ticket_operate.html */ ?>
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
    $("#export").click(function(){
        document.form1.action = root_domain + '/admin/order/user_ticket_operate_export.php';
        document.form1.submit();
    });
    $("#search").click(function(){
          document.form1.action = root_domain + '/admin/order/user_ticket_operate.php';
          document.form1.submit();
      });
});
</script>
<!--投注记录 start-->
<div class="UserRight">
<form method="post" name='form1'>
<div class="timechaxun" style="">
  <ul>
  <li>排序：
      <select name='field' id='field' >
       <option value="datetime" <?php if ($this->_tpl_vars['field'] == 'datetime'): ?> selected <?php endif; ?> >出票时间</option>
       <option value="create_time" <?php if ($this->_tpl_vars['field'] == 'create_time'): ?> selected <?php endif; ?> >操作时间</option>
      </select>
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
     <br/> 操作人：
      <select name='operate_uname' id='operate_uname'>
      <option value='all' selected>===全部===</option>
      <?php $_from = $this->_tpl_vars['operateUnames']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value='<?php echo $this->_tpl_vars['item']; ?>
' <?php if ($this->_tpl_vars['operate_uname'] == $this->_tpl_vars['item']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['item']; ?>
</option> 
      <?php endforeach; endif; unset($_from); ?>
      </select>
      操作类型：
      <select name='type' id='type'>
      <option value='all' selected>===全部===</option>
      <?php $_from = $this->_tpl_vars['operateTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['type']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>
</option> 
      <?php endforeach; endif; unset($_from); ?>
      </select>
      <input id='search' type="submit" name="" value="查询"><input id='export' type="submit" name="" value="导出">
    </li>
  </ul>
  <div class="clear"></div>
</div>
</form>
<br/>
<div>
<table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
	<tr><td>总投注金额</td><td>总中奖金额</td></tr>
	<tr><td>&yen;<?php echo $this->_tpl_vars['total']['total_money']; ?>
元</td><td>&yen;<?php echo $this->_tpl_vars['total']['total_prize']; ?>
元</td></tr>
    
</table>
  <h2>
  <b>●</b>订单信息(选择出票人和类型，会显示总金额和总奖金)</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>序号</td>
          <td>订单ID</td>
          <td>订单金额</td>
          <td>中奖信息</td>
          <td>出票时间</td>
          <td>操作人</td>
          <td>操作类型</td>
          <td>操作时间</td>
        </tr>
        <?php $_from = $this->_tpl_vars['userTicketOperateInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['ticket']['iteration']++;
?>
        <?php $this->assign('keyorder', $this->_tpl_vars['key']+1); ?>
        <tr <?php if ($this->_foreach['ticket']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>> 
        	<td class="show"><?php echo $this->_tpl_vars['keyorder']; ?>
</td>     
          	<td class="show"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['item']['user_ticket_id']; ?>
" target="_blank"><?php echo $this->_tpl_vars['item']['user_ticket_id']; ?>
</a></td>
          	<td class="show"><?php echo $this->_tpl_vars['item']['money']; ?>
</td>
          	<td class="show"><?php if ($this->_tpl_vars['item']['prize'] == -1): ?>未开奖<?php elseif ($this->_tpl_vars['item']['prize'] == '0.00'): ?>未中奖<?php else: ?><?php echo $this->_tpl_vars['item']['prize']; ?>
<?php endif; ?></td>
          	<td class="show"><?php echo $this->_tpl_vars['item']['datetime']; ?>
</td>
          	<td class="show"><?php echo $this->_tpl_vars['item']['operate_uname']; ?>
</td>
          	<td class="show"><?php echo $this->_tpl_vars['operateTypeDesc'][$this->_tpl_vars['item']['type']]['desc']; ?>
</td>
          	<td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
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