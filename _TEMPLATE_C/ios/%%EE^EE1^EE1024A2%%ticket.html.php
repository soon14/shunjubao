<?php /* Smarty version 2.6.17, created on 2016-04-06 15:51:32
         compiled from ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'ticket.html', 3, false),)), $this); ?>
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
		$.post(Domain + '/getUserTicketInfo.php'
                , {id: <?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>

                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    	var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
                    		html += '<td valign="middle" class="x4"><div class="DhiddEn"><b style="text-align:right;">';
                    		if (ticketInfo[i].sport == 'bk') {
                    			html += ticketInfo[i].a_cn +'</b><span>vs</span><b style="left:65px;text-align:left;">'+ ticketInfo[i].h_cn;
                    		} else {
                    			html += ticketInfo[i].h_cn +'</b><span>vs</span><b style="left:65px;text-align:left;">'+ ticketInfo[i].a_cn;
                    		}
                    		
                    		html += '</b></div></td>';
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
                    		
                    		html += '<td valign="middle" class="x5"><div style="width:155px;line-height:20px;margin:0 auto;word-wrap: break-word;word-break: normal;word-break:break-all;">'+ option_html +'</div></td>';
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
// 		                		break;
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
<div class="touzhutips">串关&nbsp;<span><?php echo $this->_tpl_vars['userTicketInfo']['user_select']; ?>
</span>&nbsp;金额&nbsp;<strong><?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
</strong>&nbsp;奖金&nbsp;<strong><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</strong> </div>
    <table class="hacker" border="1" cellpadding="0" cellspacing="0" width="100%"style="text-align:center;">
      <tbody id='detail_tr'>
        <tr> <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>
          <th>客队VS主队</th>
          <?php else: ?>
          <th>主队VS客队</th>
          <?php endif; ?>
          <th>我的选择</th>
          <!--<th>彩果</th>-->
          <!--<th>比分</th>-->
          <th style="border-right:1px solid #ccc;">状态</th>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!--确认投注center end-->
<!--center end-->
<!--footer start-->
<div style="position:relative;top:-1px;"> <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?></div>
<!--footer end-->
</body>
</html>