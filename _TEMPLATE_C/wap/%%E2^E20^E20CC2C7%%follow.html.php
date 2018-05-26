<?php /* Smarty version 2.6.17, created on 2018-03-04 22:54:23
         compiled from follow.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'follow.html', 105, false),array('modifier', 'getPoolDesc', 'follow.html', 270, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.black_overlay{display:none;background-color:#999;width:100%;height:100%;left:0;top:0;/*FF IE7*/
filter:alpha(opacity=80);/*IE*/
opacity:0.8;/*FF*/
z-index:9999999999999999999999;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/

}



.black_overla{display:none;background-color:#999;width:100%;height:100%;left:0;top:0;/*FF IE7*/
filter:alpha(opacity=80);/*IE*/
opacity:0.8;/*FF*/
z-index:9999999999999999999999;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/

}


.white_content{display:none;left:0%;/*FF IE7*/
top:0;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/}


.white_conten{display:none;left:0%;/*FF IE7*/
top:0;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/background:#000;opacity:0.9;filter:alpha(opacity=90);height:100%;}
.white_conten h1{ height:50px;line-height:50px;}
.white_conten h1 a{}
.white_conten h1 a:hover{}
.white_conten dl{display:inline-table;display:inline-block;zoom:1;*display:inline;vertical-align:middle;text-align:center;}
.white_conten dl dt img {}
.white_conten dl dd{color:#fff;margin:0 auto;text-align:left;padding:20px 0 0 0;font-size:14px;}
.white_conten dl dd span{color:#666;font-size:12px;float:right;}
.MSCenter{border:2px solid #888;width:94%;height:100%;margin:0 auto;text-align:left;background:#fff;padding:10px;position:relative;margin:0 auto auto auto; text-align:left;}
.MSCenter h1{font-size:18px;font-weight:900;font-family:'微软雅黑';border-bottom:1px solid #ccc;height:40px;line-height:40px;position:relative; padding:0 0 10px 0; margin:0;}
.MSCenter h1 a{padding:0 0 0 10px;position:absolute;right:10px;top:0;color:#565656;font-size:14px;color:#dc0000;}
.MSCenter h2{font-size:12px;font-weight:300;font-family:'';height:24px;line-height:24px;text-align:center;background:#ccc;position:absolute;left:0;bottom:0;display:block;width:100%;color:#999;}
.sdanopenwindows{}
.sdanopenwindows h4{ height:40px; line-height:40px; font-weight:300; font-size:12px; padding:20px 0 0 28px;}
.sdanopenwindows h4 strong{ font-size:14px; font-weight:900;color:#dc0000;}
.sdanopenwindows ul li.sub{padding:15px 0 0 45px;}
.sdanopenwindows ul li.sub input{border:none;background:#CE050B;color:#fff;width:234px;height:38px;line-height:38px;text-align:center;font-size:16px;font-weight:900;cursor:pointer;font-family:'微软雅黑';display:inline-table;display:inline-block;zoom:1;*display:inline;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.sdanopenwindows dl{ padding:10px 0;}
.sdanopenwindows dl.tips{ padding:5px;color:#777; clear:both; text-align:left;}
.sdanopenwindows dl.tips span{ font-size:14px; font-weight:900;color:red; position:relative;top:3px;left:-3px;}
.sdanopenwindows dl dt{ font-size:14px; height:50px; line-height:50px; font-weight:900;}
.sdanopenwindows dl dd{display:inline-table;display:inline-block;zoom:1;*display:inline; font-size:14px; font-size:12px;}
.sdanopenwindows dl dd.text{ padding:15px 0 5px 0;}
.sdanopenwindows dl dd.text input{ width:150px; height:26px; line-height:26px; text-align:center;}
.sdanopenwindows dl dd input{ position:relative;top:1px;}
.sdanopenwindows dl dd.sub{ margin:55px 0 150px 0;background:#CE050B; width:100%; height:38px; line-height:38px;display:inline-table;display:inline-block;zoom:1;*display:inline;-moz-border-radius:3px;-webkit-border-radius:3px;border-radius:3px;}
.sdanopenwindows dl dd.sub input{border:none; background:none;color:#fff;height:36px;line-height:36px;text-align:center;font-weight:900;cursor:pointer;font-family:'微软雅黑';display:inline-table;display:inline-block;zoom:1;*display:inline; width:100%; font-size:18px; letter-spacing:3px;}
.detail{ padding:0;border-bottom:1px solid #e4e4e4;}
.detail table{color:#444;font-size:12px;border-bottom:none;}
.detail table th {background:url(http://www.zhiying365365.com/www/statics/i/thBj.jpg) repeat-x;height:34px;line-height:34px;font-weight:300;border-right:1px solid #e4e4e4;border-bottom:none;}
.detail table tr{border-right:1px solid #e4e4e4;}
.detail table td{padding:0;text-align:center;color:#444;line-height:34px;border:1px solid #e4e4e4;}
.detail table td b{font-size:12px;font-weight:300;}
.detail table td strong{font-size:12px;font-weight:300;}
</style>
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
                    		html += '<tr style="border-bottom:none;">';
							html += '<td style="border-bottom:none;">'+ ticketInfo[i].show_num +'</td>';
                    		if (ticketInfo[i].sport == 'bk') {
							html += '<td style="border-bottom:none;">'+ticketInfo[i].a_cn+'</td>';
							html += '<td style="border-bottom:none;">'+ticketInfo[i].h_cn+'</td>';
							} else {
							html += '<td style="border-bottom:none;">'+ticketInfo[i].h_cn+'</td>';
							html += '<td style="border-bottom:none;">'+ticketInfo[i].a_cn+'</td>';
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
                    		
                    		html += '<td style="border-bottom:none;" valign="middle">'+ option_html +'</td>';
                    		html += '<td style="border-bottom:none;" valign="middle" style="border-right:none;">'+ prize_html +'</td>';
                    		html += '</tr>'
                        }
                    	$("#detail_tr").html(org_details_html + html);
                    } 
                }

                , 'json'
            );
			
			<?php elseif ($this->_tpl_vars['follow_show'] == 2): ?>	
			html += '<tr>';
			html += '<td  valign="middle" style="border-bottom:none;"  colspan="5" >方案截止后可见！</td>';
			html += '</tr>'
			$("#detail_tr").html(org_details_html + html);	
		<?php elseif ($this->_tpl_vars['follow_show'] == 1): ?>	
			html += '<tr>';
			html += '<td  valign="middle" style="border-bottom:none;" colspan="5" >跟单人可见！</td>';
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
</b></span>&nbsp;&nbsp;<?php if ($this->_tpl_vars['follow_show'] == 0): ?><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/detail.php?userTicketId=<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
">奖金明细</a><?php endif; ?></p>
        </dd>
      </dl>
      <div class="clear"></div>
    </div>
    <!--方案 start-->
	<div class="detail">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
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
	</div>
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
                
               <?php if ($this->_tpl_vars['userTicketInfo']['prize_state'] == 1): ?> 
                <input type="button" value="打赏" class="gdsub"  onClick="show_tips('<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
','<?php echo $this->_tpl_vars['partent_info']['u_id']; ?>
','<?php echo $this->_tpl_vars['partent_info']['u_nick']; ?>
','<?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
')" style="cursor:pointer;">
               <?php else: ?>
                 <input type="button" value="已截止" class="gdsub" id="submit2" style="background:#545454; font-weight:300;" disabled="disabled">
               <?php endif; ?>
               
               
               
                  <?php else: ?>
                  <input type="submit" value="跟单" class="gdsub" id="submit">
                  <?php endif; ?>

                  </li>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="light2" class="white_content">
  <div class="MSCenter">
    <h1>我要打赏<span><a href="javascript:void(0)" onClick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl class="tips" style="padding:20px 0 0 0;">
        <dd>跟单中了<strong id="prize" style="color:#dc0000;">0</strong>元,我要给<strong id="partent_u_nick" style="color:#dc0000;">0</strong>打赏。</dd>
      </dl>
      <dl>
        <dt>打赏金额</dt>
        <dd>
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
        <dt>其他金额</dt>
        <dd class="text" style="border:1px solid #ccc; width:99%; height:34px; line-height:34px; overflow:hidden; padding:0;">
          <input type="text" name="other_tips_money" id="other_tips_money" style="border:none;  background:#fff; width:99%; height:38px; line-height:38px; position:relative;top:-4px;" value="" onKeyUp="clearNoNum(this)">
          </dd>
        <dd>
      </dl>
      <dl class="tips">
        <dd><span>*</span>温馨提示：提交后，打赏额度直接从您账户余额扣除。</dd>
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
<script>

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
</body>
</html>