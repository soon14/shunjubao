<?php /* Smarty version 2.6.17, created on 2018-03-04 22:54:45
         compiled from ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'ticket.html', 3, false),array('modifier', 'getPoolDesc', 'ticket.html', 118, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='wap_confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript">
	$(document).ready(function(){
		var org_details_html = $("#detail_tr").html();
			var html = '';
		<?php if ($this->_tpl_vars['endtime_forbin'] != 1): ?>
		$.post(Domain + '/getUserTicketInfo.php'
                , {id: <?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>

                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    	//var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
							html += '<td>'+ ticketInfo[i].show_num +'</td>';
                    		if (ticketInfo[i].sport == 'bk') {
							html += '<td><b>'+ticketInfo[i].a_cn+'</b></td>';
							html += '<td><b>'+ticketInfo[i].h_cn+'</b></td>';
							} else {
							html += '<td>'+ticketInfo[i].h_cn+'</td>';
							html += '<td>'+ticketInfo[i].a_cn+'</td>';
							};
                    		var option = ticketInfo[i].option;
                    		var option_html = '';
							var prize_html = '<div class="zhuangTai"><b class="">未开奖</b></div>';
                    		
                    		var isPrize = false;//是否有中奖
                			var isNotPirze = true;//是否全不中
                			
                    		var red = option['red'];//中奖
                    		var black = option['black'];//未中奖
                    		var empty = option['empty'];//无赛果
                    		
                    		if (red) {
                    			isPrize = true;
                    			isNotPirze = false;
                    			for(var key in red) {
                        				option_html += '&nbsp;<font color="#dc0000">'+red[key] +'</font>&nbsp;';
                        		}
                    		}
                    		if (black) {
                    			for(var key in black) {
                        				option_html += '&nbsp;' + black[key] + '&nbsp;';
                        		}
                    		}
                    		if (empty) {
                    			isNotPirze = false;
                    			for(var key in empty) {
                        				option_html += '&nbsp;' + empty[key] + '&nbsp;';
                        		}
                    		}
                    		
                    		if (isPrize) {
                    			prize_html = '<div class="zhuangTai"><strong><span>奖</span></strong></div>';
                    		}
                    		if (isNotPirze) {
                    			prize_html = '<div class="zhuangTai"><b class="">未中奖</b></div>';
                    		}
                    		if (ticketInfo[i].matchstate == 3) {
                    			prize_html = '<div class="zhuangTai"><b class="">取消</b></div>';
                    		}
                    		if (ticketInfo[i].matchstate == 2) {
                    			prize_html = '<div class="zhuangTai"><b class="">推迟</b></div>';
                    		}
                    		
                    		html += '<td valign="middle" class="x5"><div style="margin:0 auto;word-wrap: break-word;word-break: normal;word-break:break-all;">'+ option_html +'</div></td>';
                    		//html += '<td valign="middle" class="x6">'+ ticketInfo[i].results +'</td>';
                    		//html += '<td valign="middle" class="x7">'+ticketInfo[i].score+'</td>';
                    		html += '<td valign="middle" class="x8">'+ prize_html +'</td>';
                    		html += '</tr>'
                        }
                    	$("#detail_tr").html(org_details_html + html);
                    } 
                }
                , 'json'
            );
		<?php else: ?>
		
			html += '<tr>';
			html += '<td  valign="middle"  colspan="7"  >方案在投注截止后可看!</td>';
			html += '</tr>'
			$("#detail_tr").html(org_details_html + html);	
		<?php endif; ?>		
		//理论最高奖金
		var prize_state = '<?php echo $this->_tpl_vars['userTicketInfo']['prize_state']; ?>
';
		if(prize_state==0) {
			$.post(Domain + '/ticket/detail.php'
	                , {userTicketId: <?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
,
	                type:'json'
	                  }
	                , function(data) {
	                	if(data.ok) {
	                		for(var key in data.msg.detail) {
	                			var first_html = '<span>理论奖金：<em>'+data.msg.detail[key].max_money+'</em>元</span>';
		                		$("#ticket_prize").html(first_html);
		                		//break;
	                		}
	                	}
	                }
	                    , 'json'
	        );
		}
	})
</script>
<body>
<!--center start-->
<div class="center">
  <!--确认投注center start-->
  <div>
    <div class="touzhuxinxi">
      <dl>
        <dt><img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /></dt>
        <dd>
          <p><?php echo $this->_tpl_vars['follow_ticket_user']['u_name']; ?>
&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['userTicketInfo']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicketInfo']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicketInfo']['pool'])); ?>
</p>
          <p style="padding:10px 0 0 0;">串关&nbsp;<?php echo $this->_tpl_vars['userTicketInfo']['user_select']; ?>
&nbsp;&nbsp;金额&nbsp;<?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
&nbsp;&nbsp;奖金<span style="color:#dc0000;" id="id="ticket_prize""><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</span>&nbsp;&nbsp;<?php if ($this->_tpl_vars['endtime_forbin'] != 1): ?><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/detail.php?userTicketId=<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
">奖金明细</a><?php endif; ?></p>
        </dd>
      </dl>
    </div>
    <style>
.ustab{ padding:0;}
.ustab table{color:#444;font-size:12px;border-bottom:none;}
.ustab table th {background:url(http://www.zhiying365365.com/www/statics/i/thBj.jpg) repeat-x;height:34px;line-height:34px;font-weight:300;border-right:1px solid #e4e4e4;border-bottom:none;}
.ustab table tr{border-right:1px solid #e4e4e4;}
.ustab table td{padding:0;text-align:center;color:#444;line-height:34px;border:1px solid #e4e4e4;}
.ustab table td b{font-size:12px;font-weight:300;}
.ustab table td strong{font-size:12px;font-weight:300;}
.ustab table tbody{color:#444;font-size:12px;border:none;}
.ustab table th {background:url(http://www.zhiying365365.com/www/statics/i/thBj.jpg) repeat-x;height:34px;line-height:34px;font-weight:300;border-right:1px solid #e4e4e4;border-bottom:none;}
#detail_tr tr{border-right:1px solid #e4e4e4;border-bottom:1px solid #e4e4e4;}
.ustab table td{padding:0;text-align:center;color:#444;line-height:34px;}
.ustab table td b{font-size:12px;font-weight:300;}
.ustab table td strong{font-size:12px;font-weight:300;}
</style>
    <div class="ustab">
      <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody id='detail_tr'>
          <tr>
            <th>场次</th>
            <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>
            <th>客队</th>
            <th>主队</th>
            <?php else: ?>
            <th>主队</th>
            <th>客队</th>
            <?php endif; ?>
            <th>我的选择</th>
            <th>状态</th>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<!--确认投注center end-->
<!--center end-->
<!--footer start-->
<div><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<!--footer end-->
</body>
</html>