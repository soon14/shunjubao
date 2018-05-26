<?php /* Smarty version 2.6.17, created on 2017-10-14 18:09:08
         compiled from ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'ticket.html', 8, false),array('modifier', 'getPoolDesc', 'ticket.html', 222, false),)), $this); ?>
<!DOCTYPE html>
<html xmlns:wb=“http://open.weibo.com/wb”>
<head>
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
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3430318831" type="text/javascript" charset="utf-8"></script>
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
for (var i=0;i<=li.length;i++){
if (i%2==0){
li[i].style.backgroundColor="#f1f1f1";
}else li[i].style.backgroundColor="#fff";
}
}
</script>
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
                        				option_html += '&nbsp;<em style="font-style:normal;color:#dc0000;">'+red[key] +'</em>&nbsp;';
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
                    		html += '<td valign="middle" class="x5"><div>'+ option_html +'</div></td>';
                    		
                    		if (ticketInfo[i].matchstate == 3 || ticketInfo[i].matchstate == 2) {
                    			html += '<td valign="middle" class="x6"><div class="wAnfa"><b><span></span>'+ ticketInfo[i].results +'</b></div></td>';
                    		} else {
                    			html += '<td valign="middle" class="x6"><div class="wAnfa"><b><u><span></span>'+ ticketInfo[i].results +'</u></b></div></td>';
                    		}
                    		
                    		if (ticketInfo[i].pool != 'SF') {
                    			//胜负玩法不显示比分
                    			html += '<td valign="middle" class="x7">'+ticketInfo[i].score+'</td>';
                    		}
                    		
                    		html += '<td valign="middle" class="x8" style="border-right:none;">'+ prize_html +'</td>';
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
	                			var first_html = '<span>理论奖金：</span><strong>&yen;'+data.msg.detail[key].max_money+'</strong>';
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
	$("#submit").click(function(){
		calMoney();
		if ($("#multiple").val() == '') {
			alert('请输入倍数');
			return false;
		}
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
/i/touxiang.jpg<?php endif; ?>" /><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
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
            <p><?php if ($this->_tpl_vars['endtime_forbin'] != 1): ?><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/detail.php?userTicketId=<?php echo $this->_tpl_vars['userTicketInfo']['id']; ?>
" target="_blank">奖金明细</a><?php endif; ?></p>
          </dd>
        </dl>
        <div class="clear"></div>
      </div>
      <!--方案内容 start-->
      <table class="hacker" border="0" cellpadding="0" cellspacing="0" id="hacker">
        <tbody id="detail_tr">
          <tr>
            <th>序号</th>
            <th>场次</th>
            <th>赛事</th>
            <th><?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>客队VS主队<?php else: ?>主队VS客队<?php endif; ?></th>
            <th>我的选择</th>
            <th>彩果</th>
            <?php if ($this->_tpl_vars['userTicketInfo']['pool'] != 'sf'): ?>
            <th>比分</th>
            <?php endif; ?>
            <th style="border-right:1px solid #6f6f6f;">状态</th>
          </tr>
        </tbody>
      </table>
      <!--方案内容 end-->
      <?php if ($this->_tpl_vars['follow_infos']): ?>
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
</em><strong>金额：<?php echo $this->_tpl_vars['item']['money']; ?>
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
</body>
</html>