<?php /* Smarty version 2.6.17, created on 2018-03-04 23:17:37
         compiled from user_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getPoolDesc', 'user_ticket.html', 143, false),)), $this); ?>
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
<div class="ustitle">
  <h1><em>投注记录<b></b><i></i></em></h1>
</div>
<script type="text/javascript">
TMJF(function($) {
	//(window.parent.document).find("#main").load(function(){
		//var main = $(window.parent.document).find("#main");
		//var thisheight = $(document).height()+30;
		//main.height(thisheight);
	//});
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
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
	});
	$(".add_show_ticket").click(function(){
		$.post(Domain + '/operate.php'
                , {id: $(this).attr('userTicketId'),
					operate:'show_ticket'
                  }
                , function(data) {
                    if (data.ok) {
                    	alert('操作成功');
                    	window.location.reload(true);
                    } else {
                    	alert(data.msg);
                    }
                }
                , 'json'
            );
	});
	$(".show_ticket_cancel").click(function(){
		$.post(Domain + '/operate.php'
                , {id: $(this).attr('userTicketId'),
					operate:'show_ticket_cancel'
                  }
                , function(data) {
                    if (data.ok) {
                    	alert('操作成功');
                    	window.location.reload(true);
                    } else {
                    	alert(data.msg);
                    }
                }
                , 'json'
            );
	});
});
</script>
<!--投注记录 start-->
<div class="usTips">
  <p><strong>总中奖额度<?php if ($this->_tpl_vars['totalPrize']): ?><?php echo $this->_tpl_vars['totalPrize']; ?>
<?php else: ?>0.00<?php endif; ?>元</strong></p>
</div>
<div>
  <form method="post">
    <div class="timechaxun">
      <ul>
        <li>
          <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
          &nbsp;- </li>
        <li>
          <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
        </li>
        <li>
          <input type="submit" name="" class="TMchaxun" value="查询">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
  <div>
    <div class="boldtxt">
      <table width="99%" border="0"  cellpadding="0" cellspacing="0">
        <tr>
          <th>方案类型</th>
          <th>总金额</th>
          <!--<th>倍数</th>-->
          <th>状态</th>
          <th>奖金</th>
          <th>&nbsp;详情&nbsp;</th>
          <?php if ($this->_tpl_vars['can_show_ticket']): ?>
          <th align="center" >&nbsp;操作&nbsp;</th>
          <?php endif; ?> </tr>
        <?php $this->assign('trade_money_in', 0); ?>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <?php $this->assign('trade_money_in', $this->_tpl_vars['userTicket']['money']+$this->_tpl_vars['trade_money_in']); ?>
        <tr>
          <td style="position:relative;"><?php if ($this->_tpl_vars['userTicket']['partent_id']): ?>
            <div class="gendan">跟</div>
            <?php endif; ?>
            <div class="stype"><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>
</div></td>
          <td><?php echo $this->_tpl_vars['userTicket']['money']; ?>
</td>
          <!--<td><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</td>-->
          <td><?php if ($this->_tpl_vars['userTicket']['print_state'] == 1): ?>
            已出票
             
            <?php elseif ($this->_tpl_vars['userTicket']['print_state'] == 3): ?>
            未出票
            <?php elseif ($this->_tpl_vars['userTicket']['print_state'] == 8): ?>
            失败退款
            <?php else: ?>
            出票中
            <?php endif; ?></td>
          <td><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['userTicket']['prize_state'] == 1): ?> <b style="color:#fff;">奖</b><?php echo $this->_tpl_vars['userTicket']['prize']; ?>

              <?php else: ?> <strong class=""> <?php if ($this->_tpl_vars['userTicket']['prize_state']): ?>
              <?php echo $this->_tpl_vars['userTicketPrizeStateDesc'][$this->_tpl_vars['userTicket']['prize_state']]['desc']; ?>

              <?php else: ?>
              未开奖
              <?php endif; ?> </strong> <?php endif; ?> </div></td>
          <td class="show_details1"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">详情</a></td>
          <?php if ($this->_tpl_vars['can_show_ticket']): ?>
          <?php if ($this->_tpl_vars['userTicket']['combination_type'] == 1): ?>
          <td align="center"><div class="yishai"><a href="javascript::void(0);" style="color:#666"  class="show_ticket_cancel1" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">已晒</a></div></td>
          <?php else: ?>
          <td align="center"><div class="caozuo" style=" padding:9px 0 0 0;"><a href="javascript::void(0);" class="add_show_ticket" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
"><img src="http://www.shunjubao.xyz/www/statics/i/shai.gif"></a></div></td>
          <?php endif; ?>
          
          <?php endif; ?> </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
    </div>
    <div> <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pages" style="border-bottom:none;"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
        <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> <?php endif; ?> </div>
      <?php endif; ?> </div>
    <div class="yiwen"><span style="color:red;padding:0 5px 0 0; position:relative;top:3px;">*</span>中奖详情请登录智赢网站进行查询！</div>
  </div>
</div>
<!--投注记录 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>