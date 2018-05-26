<?php /* Smarty version 2.6.17, created on 2017-10-18 12:37:24
         compiled from zxwy.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zxwy.html', 2, false),)), $this); ?>
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
.center{margin:0 auto; text-align:left; background:#fff; padding:0  5px 60px 5px; overflow:hidden;}
.payname{ padding:0 0 10px 0;}
.payname h1{ text-align:left; height:30px; line-height:30px;border-bottom:1px solid #ccc;margin:0 auto; font-size:16px; font-weight:300;font-family:'微软雅黑'; width:100%;color:#000;}
.payname h1 span{ float:right; font-size:12px; font-weight:300;}
.payname h1 span b{font-size:12px; font-weight:300;}
.payname ul{ width:300px; margin:0 auto; text-align:left; position:relative;}
.payname ul img{ position:absolute;top:-20px;right:-50px;}
.payname ul li{ line-height:24px;}
.payname ul li b{ font-size:12px; font-weight:300;color:#dc0000;}
.payname ul li strong{ font-size:12px; font-weight:300;color:#777;}
.mppaycenter{ padding:0; text-align:center;}
.mppaycenter dl{}
.mppaycenter dl dt{}
.mppaycenter dl dt p{ width:145px; text-align:center; margin:0 auto;color:#dc0000; font-size:16px; font-weight:300; padding:10px 0 10px 0;}
.mppaycenter dl dd{width:145px; text-align:center; margin:0 auto; padding:10px 0 0 0;}
</style>
<div>
  <div class="center">
    <div class="payname">
      <h1>银行卡快捷支付<span>充值账户：<b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b>&nbsp;&nbsp;</span></h1>
    </div>
    <div class="mppaycenter">
      <dl>
        <dd style=" position:relative; width:100%;height:570px;">
          <iframe  style="border:0;padding:0; width:100%; height:100%; margin:0;" scrolling="no" src="<?php echo $this->_tpl_vars['iframe_url']; ?>
"></iframe>
        </dd>
        <dt>
         
        </dt>
      </dl>
    </div>
	
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