<?php /* Smarty version 2.6.17, created on 2017-10-18 13:07:15
         compiled from per_alipay.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'per_alipay.html', 2, false),)), $this); ?>
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
});</script>
<!--center start-->
<style>
body{font-size:12px;font-family:'宋体';}
.center{margin:0 auto;text-align:left;background:#fff;padding:30px 10px;overflow:hidden;}
.toptitle{ height:42px;line-height:42px;width:98%;margin:0 auto;border-bottom:1px solid #ddd;}
.toptitle h2{ font-size:14px;}
.center table{}
.center table tr{}
.center table tr td{ height:40px;line-height:40px; font-size:14px;}
.tijiao{height:40px;line-height:40px;margin:30px auto auto auto;background:#dc0000;color:#fff;text-align:center;border-radius:5px;}
.tijiao a{ display:block;text-align:center;color:#fff;font-size:14px;font-weight:900;}
</style>
<div class="toptitle">
  <h2>聚宝<?php echo $this->_tpl_vars['pname']; ?>
充值</h2>
</div>
<div>
<div class="center">
  <table width="100%" border="0">
    <tr>
      <td align="left">充值账户</td>
      <td align="right"><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</td>
    </tr>
    <tr>
      <td align="left">交易金额</td>
      <td align="right"><span style="position:relative;top:4px; font-size:24px;color:#dc0000;"><?php echo $this->_tpl_vars['payment']; ?>
元</span></td>
    </tr>
    <tr>
      <td align="left">收款方</td>
      <td align="right">聚宝网</td>
    </tr>
    <tr>
      <td align="left">订单号</td>
      <td align="right"><?php echo $this->_tpl_vars['out_trade_no']; ?>
</td>
    </tr>
  </table>
  <div class="tijiao"> <a href="<?php echo $this->_tpl_vars['to_ali_url']; ?>
"  target="_blank">确认支付</a> </div>
</div>
<script>
$(document).ready(function(){
setInterval(function (){check_issussce();}, 1000);function check_issussce(){
var orderid = '<?php echo $this->_tpl_vars['out_trade_no']; ?>
';if(orderid==''){
		return;}
	
	$.ajax({
			type:'POST', //URL方式为POST
			url:'/services/mppay_ajax_check.php', //这里是指向登录验证的頁面
			data:'out_trade_no='+orderid, //把要验证的参数传过去 
			dataType: 'json', //数据类型为JSON格式的验证 
			success: function(data) {
			if(data.status == "2") {
					alert('充值完成');location.href='/account/user_center.php?p=ticket';return;
				}else{
					//alert('未完成');return;
				}
			}
		});}
	
});</script>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
