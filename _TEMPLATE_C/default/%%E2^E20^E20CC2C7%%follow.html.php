<?php /* Smarty version 2.6.17, created on 2017-10-14 18:05:36
         compiled from follow.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'follow.html', 6, false),array('modifier', 'getPoolDesc', 'follow.html', 214, false),)), $this); ?>
<!DOCTYPE html><head>
<title><?php echo $this->_tpl_vars['TEMPLATE']['title']; ?>
</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['TEMPLATE']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['TEMPLATE']['description']; ?>
" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='newshaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='float.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
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
<script language="javascript" src="<?php echo ((is_array($_tmp='common.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='pms.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<link rel="shortcut icon" href="<?php echo @STATICS_BASE_URL; ?>
/i/zy.icon" type="image/x-icon" />
</head>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<link href="<?php echo ((is_array($_tmp='confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script language="javascript">
window.onload=function showtable(){
	var tablename=document.getElementById("hacker");
	var li=tablename.getElementsByTagName("tr");
	for (var i=0;i<li.length;i++){
		if (i%2==0){
			li[i].style.backgroundColor="#f1f1f1";
		} else {
			li[i].style.backgroundColor="#fff";
		}
	}
}
</script>
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
                    	
                    	for(var i = 0; i<ticketInfo.length;i++) {
                    		var k= i+1;
                    		html += '<tr>';
                    		html += '<td valign="middle" class="x1">'+ k +'</td>';
                    		html += '<td valign="middle" class="x2">'+ ticketInfo[i].show_num +'</td>';
                    		html += '<td valign="middle" class="x3">'+ ticketInfo[i].l_code+'</td>';
                    		html += '<td valign="middle" class="x4"><div class="XinagQingL"><b>';
                    		if (ticketInfo[i].sport == 'bk') {
                    			html += ticketInfo[i].a_cn +'</b><span>VS</span><b>'+ ticketInfo[i].h_cn;
                    		} else {
                    			html += ticketInfo[i].h_cn +'</b><span>VS</span><b>'+ ticketInfo[i].a_cn;
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
                    		
                    		html += '<td valign="middle" class="x5"><div class="Anfax"><b><span>&nbsp;&nbsp;'+ option_html +'&nbsp;&nbsp;</span></b></div></td>';
                    		html += '<td valign="middle" class="x6"><div class="wAnfa"><b><u><span></span>'+ ticketInfo[i].results +'</u></b></div></td>';
                    		html += '<td valign="middle" class="x7">'+ticketInfo[i].score+'</td>';
                    		html += '<td valign="middle" class="x8" style="border-right:none;">'+ prize_html +'</td>';
                    		html += '</tr>'
                        }
                    	$("#detail_tr").html(org_details_html + html);
                    } 
                }

                , 'json'
            );
		<?php elseif ($this->_tpl_vars['follow_show'] == 2): ?>	
			html += '<tr>';
			html += '<td  valign="middle"  colspan="7" >方案截止后可见！</td>';
			html += '</tr>'
			$("#detail_tr").html(org_details_html + html);	
		<?php elseif ($this->_tpl_vars['follow_show'] == 1): ?>	
			html += '<tr>';
			html += '<td  valign="middle"  colspan="7" >跟单人可见！</td>';
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
	                			var first_html = '<span>理论奖金：</span><strong>'+data.msg.detail[key].max_money+'</strong>';
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="center">
  <!--确认投注center start-->
  <div class="ConfirmationTz">
    <!--投注确认过关方式 start-->
    <div>
      <div class="TouXiang">
        <dl>
          <dt><img src="<?php if ($this->_tpl_vars['follow_ticket_user']['u_img']): ?><?php echo $this->_tpl_vars['follow_ticket_user']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /><?php echo $this->_tpl_vars['follow_ticket_user']['u_name']; ?>
</dt>
          <dd class="first">
            <p>累计中奖：<strong class="f300"><?php echo $this->_tpl_vars['totalPrize']; ?>
</strong></p>
            <p id="ticket_prize"><span>方案奖金：</span><strong><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</strong></p>
          </dd>
          <dd>
            <p>方案类型：<i><?php echo ((is_array($_tmp=$this->_tpl_vars['userTicketInfo']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['userTicketInfo']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['userTicketInfo']['pool'])); ?>
</i></p>
            <p>认购时间：<i><?php echo $this->_tpl_vars['userTicketInfo']['datetime']; ?>
</i></p>
          </dd>
          <dd>
            <p>方案金额：<strong class="f300"><?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
</strong></p>
            <p>方案倍数：<i><?php echo $this->_tpl_vars['userTicketInfo']['multiple']; ?>
</i>&nbsp;倍</p>
          </dd>
          <dd>
            <p>过关方式：<em><?php echo $this->_tpl_vars['userTicketInfo']['user_select']; ?>
</em></p>
            <p><?php if ($this->_tpl_vars['follow_show'] == 0): ?><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/detail.php?userTicketId=<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
" target="_blank">奖金明细</a><?php endif; ?></p>
          </dd>
        </dl>
        <div class="clear"></div>
      </div>
      <!--方案 start-->
      <table class="hacker" border="0" cellpadding="0" cellspacing="0" id="hacker">
        <tbody id="detail_tr">
          <tr>
            <th>序号</th>
            <th>场次</th>
            <th>赛事</th>
            <th><?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>客队VS主队<?php else: ?>主队VS客队<?php endif; ?></th>
            <th>我的选择</th>
            <th>彩果</th>
            <th>比分</th>
            <th style="border-right:1px solid #6f6f6f;">状态</th>
          </tr>
        </tbody>
      </table>
      <!--方案内容 end-->
      <!-- 跟单start-->
      <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == bd): ?>
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
            <dt class="cc">跟单金额：<span><?php echo $this->_tpl_vars['userTicketInfo']['moneyMin']; ?>
元</span>
              <input id="money" type="hidden" name="money" value="<?php echo $this->_tpl_vars['userTicketInfo']['moneyMin']; ?>
">
            </dt>
            <dt>跟单倍数：</dt>
            <dt>
              <ul>
                <li class="show"><a href="javascript:void(0);" id="subBtn">-</a></li>
                <li>
                  <input type="text" value="1"  id="multiple" name="multiple">
                </li>
                <li><a href="javascript:void(0);" id="addBtn">+</a></li>
              </ul>
            </dt>
            <dt class="first">最高100000倍</dt>
            <dd> <?php if ($this->_tpl_vars['is_end']): ?>
             
            
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
              <input type="submit" value="跟单" class="gdsub" id="submit" style="cursor:pointer;">
              <?php endif; ?> 
            
              </dd>
          </dl>
          <div class="clear"></div>
        </div>
      </form>
      <!-- 跟单end-->
      <?php if ($this->_tpl_vars['follow_infos']): ?>
      <!--跟单用户 start-->
      <div class="gName">
        <h2><b></b>已经有<span><?php echo $this->_tpl_vars['follow_info']['total_sum']; ?>
人</span>跟单</h2>
        <?php $_from = $this->_tpl_vars['follow_infos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <dl>
          <dt><img src="<?php if ($this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"></dt>
          <dd><em><?php echo $this->_tpl_vars['all_users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</em><strong><?php echo $this->_tpl_vars['item']['money']; ?>
元</strong></dd>
        </dl>
        <?php endforeach; endif; unset($_from); ?>
        <div class="clear"></div>
      </div>
      <?php endif; ?>
      <!--跟单用户 end-->
    </div>
  </div>
  <!--投注确认过关方式 end-->
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div id="light2" class="white_content" style="top:17%;">
  <div class="MSCenter">
    <h1>我要打赏<span><a href="javascript:void(0)" onClick="document.getElementById('light2').style.display='none';document.getElementById('fade').style.display='none'">关闭</a></span></h1>
    <div class="sdanopenwindows">
      <dl class="tips">
        <dd>此晒单中了<strong id="prize" style="color:#dc0000;">0</strong>元,我要给<strong id="partent_u_nick" style="color:#dc0000;">0</strong>打赏。</dd>
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