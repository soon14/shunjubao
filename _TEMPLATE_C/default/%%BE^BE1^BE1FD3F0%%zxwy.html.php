<?php /* Smarty version 2.6.17, created on 2017-10-14 19:58:06
         compiled from zxwy.html */ ?>
<!DOCTYPE html>
<head>
<title>聚宝网充值中心-在线网银支付！</title>
<meta name="keywords" content="聚宝网充值中心-在线网银支付！" />
<meta name="description" content="聚宝网充值中心-在线网银支付！。" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="http://www.zhiying365.com/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link href="http://www.zhiying365.com/www/statics/c/footer.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="http://www.zhiying365.com/www/statics/j/jquery.js"></script>
</head>
<body>
<div class="head">
  <h1><a href="/"></a><u></u></h1>
</div>
<!--center start-->
<style>
body{ background:#f9f9f9;}
.payname{ text-align:left;padding:15px 0 0 0;width:1000px;margin:0 auto;border-bottom:1px solid #ccc;}
.payname ul{ position:relative;}
.payname ul li{line-height:22px;}
.payname ul li b{color:#dc0000;font-size:20px;font-weight:900;}
.payname ul li strong{color:#444;font-size:12px;font-weight:300;}
.payname ul li.cc{ position:absolute;right:0;top:5px;color:#dc0000;font-size:30px;}
.mppay{width:1000px;margin:0 auto 30px auto;text-align:left;border-bottom:1px solid #ccc;min-height:350px;background:#fff url(http://www.zhiying365.com/www/statics/i/saoyisao.jpg) no-repeat 650px 0;}
.mppaycenter{ text-align:center; padding:48px 0 0 0; position:relative;left:-30px;}
.mppaycenter p{ padding:10px 0 0 0;}
.mpbottips{ padding:30px 0;color:#999;text-align:center;}
iframe{background:none; width:1000px; height:800px;border:none;border-bottom:1px solid #ccc; padding:30px 0 0 0; margin:0;}
/*iframe img{ width:250px; height:250px;}*/
</style>
<div class="cnetr">
  <div class="payname">
    <ul>
      <li>充值账户：<b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></li>
      <li>订单号：<?php echo $this->_tpl_vars['out_trade_no']; ?>
</li>
      <li class="cc"><?php echo $this->_tpl_vars['payment']; ?>
<span>元</span></li>
    </ul>
  </div>
  <!---->
  <div class="mppaycenter" style="width:1200px; margin:0 auto; position:relative;left:0;">
    <iframe scrolling="no" style="border:0;padding:0; width:100%; height:1000px; position:relative;top:-40px;margin:0;" scrolling="no" src="<?php echo $this->_tpl_vars['iframe_url']; ?>
"></iframe>
    <div class="mpbottips">如您在充值过程中遇到问题，请联系我们客服热线:QQ:1323698651,或联系我们在线客服&nbsp;<a style="position:relative;top:3px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1323698651&amp;site=qq&amp;menu=yes" target="_blank"><img border="0" title="在线客服" alt="在线客服" src="http://www.zhiying365.com/www/statics/i/ServicesQ.jpg"></a></div>
  </div>
  <!---->
</div>
<script>
$(document).ready(function(){
setInterval(function (){check_issussce();}, 3000);
function check_issussce(){
var orderid = '<?php echo $this->_tpl_vars['out_trade_no']; ?>
';
	if(orderid==''){
		return;
	}
	
	$.ajax({
			type:'POST', //URL方式为POST
			url:'/services/mppay_ajax_check.php', //这里是指向登录验证的頁面
			data:'out_trade_no='+orderid, //把要验证的参数传过去 
			dataType: 'json', //数据类型为JSON格式的验证 
			success: function(data) {
				if (data.status == "2") {
					
					alert('充值完成');
					
					location.href='/account/user_center.php?p=charge_log';
					return;
				}else{
					//alert('未完成');
					return;
				}
			}
		});
		
	}
	
});
</script>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
