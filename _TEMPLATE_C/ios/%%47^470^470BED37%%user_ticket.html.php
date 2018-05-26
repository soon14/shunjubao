<?php /* Smarty version 2.6.17, created on 2016-04-06 15:51:26
         compiled from user_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_ticket.html', 2, false),array('modifier', 'getPoolDesc', 'user_ticket.html', 115, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head><body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "userinfor.html", 'smarty_include_vars' => array()));
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
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
	});
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
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
	})
});
</script>
<!--投注记录 start-->
<div class="usTips">
  <p><b>总中奖额度：</b><strong><?php if ($this->_tpl_vars['totalPrize']): ?><?php echo $this->_tpl_vars['totalPrize']; ?>
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
      <table width="100%" border="1"  cellpadding="0" cellspacing="0">
        <tr>
          <th>方案类型</th>
          <th>总金额</th>
          <!--<th>倍数</th>-->
          <th>标志</th>
          <th>奖金</th>
          <th  style="padding:0 5px 0 0;">详情</th>
        </tr>
        <?php $this->assign('trade_money_in', 0); ?>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <?php $this->assign('trade_money_in', $this->_tpl_vars['userTicket']['money']+$this->_tpl_vars['trade_money_in']); ?>
        <tr>
          <td><div class="fanantype">
              <ul>
                <?php if ($this->_tpl_vars['userTicket']['partent_id']): ?>
                <li class="show">跟</li>
                <?php endif; ?>
                <li class="stype"><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>
</li>
              </ul>
              <div class="clear"></div>
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
            失败已退款
            <?php else: ?>
            出票中
            <?php endif; ?></td>
          <td><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['userTicket']['prize_state'] == 1): ?> <b style="color:#fff;">奖</b>&nbsp;&yen;<?php echo $this->_tpl_vars['userTicket']['prize']; ?>
元&nbsp;
              <?php else: ?> <strong class=""> <?php if ($this->_tpl_vars['userTicket']['prize_state']): ?>
              <?php echo $this->_tpl_vars['userTicketPrizeStateDesc'][$this->_tpl_vars['userTicket']['prize_state']]['desc']; ?>

              <?php else: ?>
              未开奖
              <?php endif; ?> </strong> <?php endif; ?> </div></td>
          <td  style="padding:0 5px 0 0;"><span class="show_details1"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/ticket.php?userTicketId=<?php echo $this->_tpl_vars['userTicket']['id']; ?>
" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">详情</a></span></td>
        </tr>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>