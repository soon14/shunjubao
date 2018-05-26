<?php /* Smarty version 2.6.17, created on 2017-12-25 23:14:35
         compiled from cib_alipay.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'cib_alipay.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript" src="<?php echo ((is_array($_tmp='payment.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head>
<body>
<script type="text/javascript">
TMJF(function($) {
});
</script>
<!--center start-->
<style>
body{background:#f1f1f1; font-size:12px; font-family:'宋体';}
.center{margin:0 auto; text-align:left; background:#fff; padding:0  20px 60px 20px; overflow:hidden;}
.payname{ padding:10px 0;}
.payname h1{ text-align:center; height:40px; line-height:40px;border-bottom:1px solid #ccc;margin:0 0 20px 0; font-size:20px; font-weight:900;}
.payname ul{ width:300px; margin:0 auto; text-align:left; position:relative;rught:-50px;}
.payname ul img{ position:absolute;top:-20px;right:-90px;}
.payname ul li{ line-height:24px;}
.payname ul li b{ font-size:12px; font-weight:300;color:#dc0000;}
.payname ul li strong{ font-size:12px; font-weight:300;color:#777;}
.mppaycenter{ padding:0; text-align:center;}
.mppaycenter dl{}
.mppaycenter dl dt{}
.mppaycenter dl dt p{ width:145px; text-align:center; margin:0 auto;color:#dc0000; font-size:16px; font-weight:300; padding:10px 0 10px 0;}
.mppaycenter dl dd{width:145px; text-align:center; margin:0 auto; position:relative;top:-20px;}
</style>
<div>
  <div class="center">
    <div class="payname">
      <h1>支付宝扫码充值</h1>
      <ul>
        <img src="http://www.zhiying365.com/www/statics/i/saoyisao.jpg">
        <li>充值账户：<b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></li>
        <li>交易金额：<span><?php echo $this->_tpl_vars['payment']; ?>
元</span></li>
        <li>收款方：智赢网</li>
        <li>订单号：<?php echo $this->_tpl_vars['out_trade_no']; ?>
</li>
      </ul>
    </div>
    <div class="mppaycenter">
      <dl>
        <dt>
          <p><?php echo $this->_tpl_vars['payment']; ?>
元</p>
        </dt>
        <dd style=" position:relative;left:-90px;">
          <iframe  style="border:0;padding:0; height:300px; margin:0;" scrolling="no" src="<?php echo @ROOT_DOMAIN; ?>
/other_payapi/cib/request.php?method=submitOrderInfo&body=<?php echo $this->_tpl_vars['body']; ?>
&attach=<?php echo $this->_tpl_vars['attach']; ?>
&total_fee=<?php echo $this->_tpl_vars['total_fee']; ?>
&mch_create_ip=<?php echo $this->_tpl_vars['mch_create_ip']; ?>
&out_trade_no=<?php echo $this->_tpl_vars['out_trade_no']; ?>
"></iframe>
        </dd>
        <dt>
          <p style="color:#999; font-size:12px; padding:10px 0 0 0; display:none;">手机扫一扫，轻松支付！</p>
        </dt>
      </dl>
    </div>
    <div style="width:300px; margin:0 auto; text-align:left; line-height:24px;color:#888;">如不能自动识别二维码，请存储支付二维码图像或截图保存，在打开支付宝-付款-相册选取截图-扫码-确认支付即可。</div>
  </div>
</div>
<script>
$(document).ready(function(){
setInterval(function (){check_issussce();}, 1000);
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
					location.href='/account/user_center.php?p=ticket';
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 