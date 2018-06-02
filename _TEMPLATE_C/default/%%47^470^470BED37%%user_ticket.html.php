<?php /* Smarty version 2.6.17, created on 2017-10-14 18:06:21
         compiled from user_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_ticket.html', 2, false),array('modifier', 'getPoolDesc', 'user_ticket.html', 247, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='newshaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='winmac.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
var TMJF = jQuery.noConflict(true);
TMJF.conf = {
    	cdn_i: "<?php echo @STATICS_BASE_URL; ?>
/i"
    	, domain: "<?php echo @ROOT_DOMAIN; ?>
"
};
</script>
</head><body>
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
	
	$(".add_show_ticket2").click(function(){
		$("#add_show_ticket2").val($(this).attr('userTicketId'));
		if($(this).attr('money')<64){
			alert('新晒单规则，您当前方案额度低于64元，不可晒单，请重新选择晒单方案！');
			return ;
		}
		
		$("#money").val($(this).attr('money'));
		$("#light1").show();
		$("#fade").show();
		return ;
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


function mysd(){
	var userTicketId = $("#add_show_ticket2").val();

	var show_range = $('input[name="show_range"]:checked').val();//显示人群
	var pay_rate = $('input[name="pay_rate"]:checked').val();//分成比例
	
	
		$.post(Domain + '/operate.php'
                , {id: userTicketId,show_range: show_range,pay_rate: pay_rate,
					operate:'show_ticket'
                  }
                , function(data) {
                    if (data.ok) {
                    	alert('操作成功');
                    	window.location.reload(true);
                    } else {
						$("#light1").hide();
						$("#fade").hide();
                    	alert(data.msg);
                    }
                }
                , 'json'
            );	
	
}


function show_tips(userTicketId,partent_u_id,partent_u_nick,prize){
	$("#other_tips_money").val('');
	$("#add_tips_userTicketId").val(userTicketId);
	$("#tips_to").val(partent_u_id);
	
	$("#partent_u_nick").html(partent_u_nick);
	$("#prize").html(prize);
	
	$("#light2").show();
	$("#fade").show();
}


function mytips(){
	var userTicketId = $("#add_tips_userTicketId").val();
	var tips_to = $("#tips_to").val();
	var other_tips_money = $("#other_tips_money").val();
	if(other_tips_money>0){
		var tips_money = other_tips_money;//其它打赏金额
	}else{
		var tips_money = $('input[name="tips_money"]:checked').val();//打赏金额
	}
	

	$.post(Domain + '/operate.php'
                , {id: userTicketId,tips_to:tips_to,tips_money:tips_money,
					operate:'addtips'
                  }
                , function(data) {
                    if (data.ok) {
                    	alert('打赏成功，谢谢你的打赏！');
                    	window.location.reload(true);
                    } else {
						$("#light2").hide();
						$("#fade").hide();
                    	alert(data.msg);
                    }
                }
                , 'json'
            );	
	
}
function clearNoNum(obj){  
  obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符   
  obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的   
  obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");  
  obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数   
  if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额  
   obj.value= parseFloat(obj.value);  
  }  
} 

</script>
<!--投注记录 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>投注管理-投注记录</h1>
    <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <form method="get">
          <tr>
            <td colspan="8" class="show" style="padding: 30px 0 10px 0;border-bottom:none;">投注总额：<span style="color:#dc0000;"><?php if ($this->_tpl_vars['totalTicketMoney']): ?><?php echo $this->_tpl_vars['totalTicketMoney']; ?>
<?php else: ?>0.00<?php endif; ?>元</span>&nbsp;&nbsp;&nbsp;中奖总额：<span style="color:#dc0000;"><?php if ($this->_tpl_vars['totalPrizeMoney']): ?><?php echo $this->_tpl_vars['totalPrizeMoney']; ?>
<?php else: ?>0.00<?php endif; ?></span></td>
          </tr>
          <tr>
            <td colspan="8" class="show" style="padding: 0 0 20px 0;border-bottom:none;">开始时间：
              <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
              &nbsp;结束时间：
              <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
              &nbsp;<input  type="checkbox" name="is_prize" id="is_prize" <?php if ($this->_tpl_vars['is_prize']): ?>checked<?php endif; ?> value="1" style="width:15px; height:15px; position:relative;top:4px;">只看红单
              &nbsp;
              <input class="sub"  style="width:183px;" name="" type="submit" value="查询"></td>
        </form>
        </tr>
        
        <tr>
          <th>方案类型</th>
          <th align="center">总金额</th>
          <th align="center">倍数</th>
          <th align="center">彩票标识</th>
          <th align="center">状态</th>
          <th align="center">认购时间</th>
          <th align="center">方案详情</th>
          <?php if ($this->_tpl_vars['can_show_ticket']): ?>
          <th align="right"><span style="padding:0 10px 0 0;">操作</span></th>
          <?php endif; ?> </tr>
        <?php $this->assign('trade_money_in', 0); ?>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userTicket']):
        $this->_foreach['ticket']['iteration']++;
?>
        <?php $this->assign('trade_money_in', $this->_tpl_vars['userTicket']['money']+$this->_tpl_vars['trade_money_in']); ?>
        <tr>
          <td><div class="gdtype"> <?php if ($this->_tpl_vars['userTicket']['partent_id']): ?><span class="">&nbsp;跟&nbsp;</span><?php endif; ?>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['userTicket']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicket']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicket']['pool'])); ?>

               </div></td>
          <td align="center"><?php echo $this->_tpl_vars['userTicket']['money']; ?>
元</td>
          <td align="center"><?php echo $this->_tpl_vars['userTicket']['multiple']; ?>
</td>
          <td align="center"><?php if ($this->_tpl_vars['userTicket']['print_state'] == 1): ?>
            已出票
             
            <?php elseif ($this->_tpl_vars['userTicket']['print_state'] == 3): ?>
            未出票
            <?php elseif ($this->_tpl_vars['userTicket']['print_state'] == 8): ?>
            出票失败已退款
            <?php else: ?>
            出票中
            <?php endif; ?> </td>
          <td align="center"><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['userTicket']['prize_state'] == 1): ?> <b>奖</b><?php echo $this->_tpl_vars['userTicket']['prize']; ?>
元&nbsp;
              <?php else: ?> <strong class=""> <?php if ($this->_tpl_vars['userTicket']['prize_state']): ?>
              <?php echo $this->_tpl_vars['userTicketPrizeStateDesc'][$this->_tpl_vars['userTicket']['prize_state']]['desc']; ?>

              <?php else: ?>
              未开奖
              <?php endif; ?> </strong> <?php endif; ?> </div></td>
          <td align="center"><?php echo $this->_tpl_vars['userTicket']['datetime']; ?>
</td>
          <td align="center"><div class="caozuo"><a target="_blank" href="<?php echo @ROOT_DOMAIN; ?>
/account/ticket/<?php echo $this->_tpl_vars['userTicket']['id']; ?>
.html" class="show_details1" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">方案详情</a></div></td>
          <?php if ($this->_tpl_vars['can_show_ticket']): ?>
          <?php if ($this->_tpl_vars['userTicket']['combination_type'] == 1): ?>
          <td align="right"><div class="yishai"><a href="javascript:void(0);" class="show_ticket_cancel1" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">已晒单</a></div></td>
          <?php else: ?>
          <td align="right"><div class="caozuo"> <?php if ($this->_tpl_vars['userTicket']['partent_id'] == 0): ?> <a href="javascript:void(0);" class="add_show_ticket2" money="<?php echo $this->_tpl_vars['userTicket']['money']; ?>
" userTicketId="<?php echo $this->_tpl_vars['userTicket']['id']; ?>
">晒单</a> <?php endif; ?>
             
              <?php if ($this->_tpl_vars['userTicket']['partent_id'] > 0 && $this->_tpl_vars['userTicket']['prize_state'] == 1): ?>
              <!--中奖的跟单可以打赏-->
              <a href="javascript:void(0);"  href="javascript:void();" onClick="show_tips('<?php echo $this->_tpl_vars['userTicket']['id']; ?>
','<?php echo $this->_tpl_vars['userTicket']['partent_u_id']; ?>
','<?php echo $this->_tpl_vars['userTicket']['partent_u_nick']; ?>
','<?php echo $this->_tpl_vars['userTicket']['prize']; ?>
')">打赏</a> <?php endif; ?>
              <?php endif; ?> </div></td>
          
          
          <?php endif; ?> </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pageC">
        <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?> </div>
      </div>
      <?php endif; ?> </div>
  </div>
</div>
<!--投注记录 end-->
<div id="light1" class="white_content">
  <div class="MSCenter">
    <h1>晒单设置<span><a href="javascript:void(0)" onClick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl>
        <dt>权限设置：</dt>
        <dd>
          <input type="radio" name="show_range" value="1" checked>
          所有人可见</dd>
        <dd>
          <input type="radio" name="show_range" value="2">
          跟单人可见</dd>
        <dd>
          <input type="radio" name="show_range" value="3">
          方案截止后可见 </dd>
      </dl>
      <dl>
        <dt>跟单提成比例：</dt>
        <dd>
          <input type="radio" name="pay_rate" value="0" checked>
          无</dd>
        <dd>
          <input type="radio" name="pay_rate" value="1">
          1%</dd>
        <dd>
          <input type="radio" name="pay_rate" value="2">
          2%</dd>
        <dd>
          <input type="radio" name="pay_rate" value="3">
          3%</dd>
        <dd>
          <input type="radio" name="pay_rate" value="4">
          4%</dd>
        <dd>
          <input type="radio" name="pay_rate" value="5">
          5%</dd>
      </dl>
      <dl class="tips">
        <dd><span>*</span><strong>温馨提示：</strong>提成比例指用户进行跟单后，方案中奖，需要扣除对应的比例给到晒单人。中奖奖金（指的是中奖额度-投注本金）！</dd>
      </dl>
      <dl>
        <dd class="sub">
          <input id="add_show_ticket2" type="hidden" value="">
           <input id="money" type="hidden" value="">
          <input type="button" name="sd" value="提交" id="sd"  onClick="return mysd()">
        </dd>
      </dl>
    </div>
    <h2>聚宝晒单中心-专家和明星会员推荐,打造竞彩中奖的福地！</h2>
  </div>
</div>
<div id="light2" class="white_content">
  <div class="MSCenter">
    <h1>我要打赏<span><a href="javascript:void(0)" onClick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl class="tips">
        <dd>跟单中了<strong id="prize" style="color:#dc0000;">0</strong>元,我要给<strong id="partent_u_nick" style="color:#dc0000;">0</strong>打赏。</dd>
      </dl>
      <dl>
        <dt>打赏金额</dt>
        <dd style="position:relative;left:-5px;">
          <input type="radio" name="tips_money" checked value="1">
          1元</dd>
        <dd>
          <input type="radio" name="tips_money" value="2">
          2元</dd>
        <dd>
          <input type="radio" name="tips_money" value="5">
          5元</dd>
        <dd>
          <input type="radio" name="tips_money" value="10">
          10元</dd>
        <dd>
          <input type="radio" name="tips_money" value="50">
          50元</dd>
        <dd>
          <input type="radio" name="tips_money" value="100">
          100元</dd>
      </dl>
      <dl>
        <dt>其它金额</dt>
        <dd class="text" style=" position:relative;top:-10px;">
          <input type="text" name="other_tips_money" id="other_tips_money" style="width:230px;border:1px solid #ddd;" value="" onKeyUp="clearNoNum(this)">
          &nbsp;&nbsp;
          元</dd>
        <dd>
      </dl>     
      <dl class="tips" style="padding:0 0 0 30px;">
        <dd><span>*</span>&nbsp;&nbsp;温馨提示：提交后，打赏额度直接从您账户余额扣除。</dd>
      </dl>
	  <dl>
        <dd class="sub">
          <input id="add_tips_userTicketId" type="hidden" value="">
          <input id="tips_to" type="hidden" value="">
          <input type="button" name="sd" value="提交" id="sd"  onClick="return mytips()">
        </dd>
      </dl>
    </div>
    <h2>红单打赏-感谢晒单人，小小意思下。</h2>
  </div>
</div>
</body>
</html>