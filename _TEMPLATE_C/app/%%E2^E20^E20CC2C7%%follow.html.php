<?php /* Smarty version 2.6.17, created on 2017-03-08 11:52:58
         compiled from follow.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'follow.html', 3, false),array('modifier', 'getPoolDesc', 'follow.html', 168, false),)), $this); ?>
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
		<?php if ($this->_tpl_vars['follow_show'] == 0): ?>
		$.post(Domain + '/getUserTicketInfo.php'
                , {id: <?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>

                  }
                , function(data) {
                    if (data.ok) {
                    	var ticketInfo = data.msg;
                    //	var html = '';
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
							html += '<td>'+ ticketInfo[i].show_num +'</td>';
                    		if (ticketInfo[i].sport == 'bk') {
							html += '<td>'+ticketInfo[i].a_cn+'</td>';
							html += '<td>'+ticketInfo[i].h_cn+'</td>';
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
                    		
                    		html += '<td valign="middle">'+ option_html +'</td>';
                    		html += '<td valign="middle" style="border-right:none;">'+ prize_html +'</td>';
                    		html += '</tr>'
                        }
                    	$("#detail_tr").html(org_details_html + html);
                    } 
                }

                , 'json'
            );
			
			<?php elseif ($this->_tpl_vars['follow_show'] == 2): ?>	
			html += '<tr>';
			html += '<td  valign="middle"  colspan="5" >方案截止后可见！</td>';
			html += '</tr>'
			$("#detail_tr").html(org_details_html + html);	
		<?php elseif ($this->_tpl_vars['follow_show'] == 1): ?>	
			html += '<tr>';
			html += '<td  valign="middle"  colspan="5" >跟单人可见！</td>';
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
	                			var first_html = '理论奖金<strong>'+data.msg.detail[key].max_money+'</strong>';
		                		$("#ticket_prize").html(first_html);
		                		//break;
	                		}
	                	}
	                }
	                    , 'json'
	        );
		}
	});	
TMJF(function($){
	$("#addBtn").click(function(){
		var multiple = Number($("#multiple").val());
		multiple += 1;
		$("#multiple").val(multiple);
		calMoney();
	});
	$("#subBtn").click(function(){
		var multiple = Number($("#multiple").val());
		multiple -= 1;
		$("#multiple").val(multiple);
		calMoney();
	});
	$("#multiple").keyup(function(){
		calMoney();
	});
	var is_confirm = false;
	$("#submit").click(function(){
		//防止重复提交
		if (is_confirm) {
			return false;
		}
		calMoney();
		if ($("#multiple").val() == '') {
			alert('请输入倍数');
			return false;
		}
		is_confirm = true;
		return true;
	});
	$("#submit2").click(function(){
		alert('方案已截止');
		return false;
	});
});
var moneyMin = Number(<?php echo $this->_tpl_vars['userTicketInfo']['moneyMin']; ?>
);
function calMoney(){
	var span_obj = $(".gandanCenter").find('span').eq(0);
	var multiple = $("#multiple").val();
	if (multiple > 100000) multiple = 100000;
	//if (multiple <= 0) multiple = 1;
	$("#multiple").val(multiple);
	
	var money = moneyMin * Number(multiple);
	span_obj.html('&yen;'+money+'元');
	$("#money").val(money);
}
</script>
<body>
<div class="center">
  <div>
    <div class="touzhuxinxi">
      <dl>
        <dt><img src="<?php if ($this->_tpl_vars['follow_ticket_user']['u_img']): ?><?php echo $this->_tpl_vars['follow_ticket_user']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /></dt>
        <dd>
          <p><b><?php echo $this->_tpl_vars['follow_ticket_user']['u_name']; ?>
</b>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['userTicketInfo']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicketInfo']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicketInfo']['pool'])); ?>
</p>
          <p style="padding:10px 0 0 0;">串关<?php echo $this->_tpl_vars['userTicketInfo']['user_select']; ?>
&nbsp;金额<?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
&nbsp;&nbsp;<span id="ticket_prize">方案奖金：<b><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</b></span></p>
        </dd>
      </dl>
      <div class="clear"></div>
    </div>
	<style>
	#detail_tr th{font-size:12px;}
	#detail_tr td{border:1px solid #e4e4e4;line-height:34px;}
</style>
    <!--方案 start-->
    <table border="1" width="100%" cellspacing="0" cellpadding="0" id="hacker">
      <tbody id="detail_tr">
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
    <!--方案内容 end-->
    <!-- 跟单start-->
    <div> <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == bd): ?>
      <form action="<?php echo @ROOT_DOMAIN; ?>
/confirm/combination_submit_bd.php">
      <?php else: ?>
      <form action="<?php echo @ROOT_DOMAIN; ?>
/confirm/combination_submit.php">
        <?php endif; ?>
        <input type="hidden" name="sport" value="<?php echo $this->_tpl_vars['userTicketInfo']['sport']; ?>
">
        <input type="hidden" name="select" value="<?php echo $this->_tpl_vars['userTicketInfo']['select']; ?>
">
        <input type="hidden" name="user_select" value="<?php echo $this->_tpl_vars['userTicketInfo']['user_select']; ?>
">
        <input type="hidden" name="combination" value="<?php echo $this->_tpl_vars['userTicketInfo']['combination']; ?>
">
        <input type="hidden" name="pool" value="<?php echo $this->_tpl_vars['userTicketInfo']['pool']; ?>
">
        <input type="hidden" name="partent_id" value="<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
">
        <input type="hidden" name="from" value="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow.php?userTicketId=<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
">
        <div class="gandanCenter">
          <dl>
            <dd>
              <ul>
                <li><span><?php echo $this->_tpl_vars['userTicketInfo']['moneyMin']; ?>
元</span>
                  <input id="money" type="hidden" name="money" value="<?php echo $this->_tpl_vars['userTicketInfo']['moneyMin']; ?>
">
                </li>
                <li><a href="javascript:void(0);" id="subBtn">-</a></li>
                <li class="cc">
                  <input type="text" value="1"  id="multiple" name="multiple" >
                </li>
                <li><a href="javascript:void(0);" id="addBtn">+</a></b></li>
                <li><?php if ($this->_tpl_vars['is_end']): ?>
                  <input type="button" value="已截止" class="gdsub" id="submit2" style="background:#545454; font-weight:300;" disabled="disabled">
                  <?php else: ?>
                  <input type="submit" value="跟单" class="gdsub" id="submit">
                  <?php endif; ?></li>
              </ul>
              <div class="clear"></div>
            </dd>
          </dl>
          <div class="clear"></div>
        </div>
      </form>
    </div>
    <!-- 跟单end-->
    <!--跟单用户 start-->
    <div> <?php if ($this->_tpl_vars['follow_infos']): ?>
      <div class="gName" style="position:relative;">
        <h2><b></b>已有<span>(<?php echo $this->_tpl_vars['follow_info']['total_sum']; ?>
)</span>人跟单</h2>
      </div>
      <div class="gendanyonghu">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <?php $_from = $this->_tpl_vars['follow_infos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
          <tr>
            <td><div class="yhpic">
                <ul>
                  <li><img src="<?php if ($this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"></li>
                  <li><span><?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</span></li>
                </ul>
              </div></td>
            <td><div class="gendanerdu"><strong><?php echo $this->_tpl_vars['item']['money']; ?>
元</strong></div></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
      <?php endif; ?> </div>
    <!--跟单用户 end-->
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>