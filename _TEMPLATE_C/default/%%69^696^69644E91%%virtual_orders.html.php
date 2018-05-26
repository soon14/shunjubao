<?php /* Smarty version 2.6.17, created on 2017-10-14 18:34:54
         compiled from ../admin/order/virtual_orders.html */ ?>
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
});
</script>
<!--投注记录 start-->
<div class="UserRight">
<form method="post">
<div class="timechaxun" style="height:45px;">
  <ul>
  <li>系统ID
      <input type="text" name="id" id="id"  style="width:65px;" value="<?php echo $this->_tpl_vars['id']; ?>
">|
  用户名
      <input type="text" name="user_name" id="user_name" value="<?php echo $this->_tpl_vars['user_name']; ?>
">|
    状态：
       <select name='status' id='status' >
      <option value="all" selected>全部状态</option>
      <?php $_from = $this->_tpl_vars['statusDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['status'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      来源：<select name='source' id='source'>
      <option value="all" selected>全部来源</option>
      <?php $_from = $this->_tpl_vars['sourceDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['source'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      </select>|
    开始时间：
      <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
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
<div>
   <h2>
  <b>●</b>订单信息</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <td>序号</td>
          <td>用户名</td>
          <td>总积分</td>
          <td>倍数</td>
          <td>出票状态</td>
          <td>中奖信息</td>
          <td>认购时间</td>
                    <td>方案详情</td>
          <td>来源</td>
        </tr>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr <?php if ($this->_foreach['ticket']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <td class="show"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td class="show">
          <?php echo $this->_tpl_vars['item']['u_name']; ?>
&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/user_orders.php?print_state=all&&user_name=<?php echo $this->_tpl_vars['item']['u_name']; ?>
" class="show_details"  target="_blank" >投注记录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/reg_log.php?u_name=<?php echo $this->_tpl_vars['item']['u_name']; ?>
"  target="_blank" >账户信息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/gift_log.php?log_type=all&u_name=<?php echo $this->_tpl_vars['item']['u_name']; ?>
" class="show_details"  target="_blank">彩金信息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/account_log.php?u_name=<?php echo $this->_tpl_vars['item']['u_name']; ?>
" class="show_details"  target="_blank">余额信息</a>&nbsp;&nbsp;|&nbsp;&nbsp;
          <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/score_log.php?u_name=<?php echo $this->_tpl_vars['item']['u_name']; ?>
&log_type=all" class="show_details"  target="_blank">积分信息</a>
          </td>
          <td class="show"><?php echo $this->_tpl_vars['item']['money']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['multiple']; ?>
</td>
          <td class="show">
          <?php echo $this->_tpl_vars['statusDesc'][$this->_tpl_vars['item']['status']]['desc']; ?>

          </td>
          <td class="show">
	          <div class="jiesuancaozuo">
		          <?php if ($this->_tpl_vars['item']['prize'] > 0): ?>
		          	<b>中奖</b>&nbsp;<?php echo $this->_tpl_vars['item']['prize']; ?>
积分&nbsp;
		          <?php endif; ?>
		          <?php if ($this->_tpl_vars['item']['status'] == 2): ?>
		          未中奖
		          <?php endif; ?>
	          </div>
          </td>
          <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td class="show"><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/virtual_orders_detail.php?ticket_id=<?php echo $this->_tpl_vars['item']['id']; ?>
" >查看</a></td>
          <td class="show"><?php echo $this->_tpl_vars['sourceDesc'][$this->_tpl_vars['item']['source']]['desc']; ?>
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