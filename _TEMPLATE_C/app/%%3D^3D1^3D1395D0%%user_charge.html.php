<?php /* Smarty version 2.6.17, created on 2018-01-03 21:44:08
         compiled from user_charge.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge.html', 2, false),)), $this); ?>
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
<div class="paytop none">
  <h1>智赢用户充值中心</h1>
</div>
<div class="center">
  <div class="pay">
    <div class="paytips"><b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b>&nbsp;当前账户余额:<b><?php echo $this->_tpl_vars['userAccount']['cash']; ?>
元</b></div>
    <!---->
    <form action='' method="post" id="gotocash">
	<div class="paycenter">
	<dl>
      <dt><b>充值金额：</b></dt>
      <dd>
        <ul>
          <li class="paypal"><a href="" class="charge_cash" payment="50">50元</a></li>
          <li class="paypal"><a href="" class="charge_cash" payment="100">100元</a></li>
          <li class="paypal"><a href="" class="charge_cash" payment="500">500元</a></li>
          <li class="mpay">
            <input type="text" name="" value="其他金额" id="inputc1" />
          </li>
        </ul>
      </dd>
    </dl>
	<dl>
    <dt style="width:100%;"><b>支付方式：</b><span>（网上充值0手续费，资金即刻到账。）</span></dt>
    <dd>
     <ol>
              <li class="paypal"><a href="" class="pay_bank" pay_bank="alipay">支付宝</a></li>
              <!--<li class="tenpay"><a href="" class="pay_bank" pay_bank="">财付通</a></li>-->
            <!--  <li class="jianshe"><a href="" class="pay_bank" pay_bank="CCB">建设银行</a></li>
              <li class="zhaoshang"><a href="" class="pay_bank" pay_bank="CMB">招商银行</a></li>
              <li class="gongshang"><a href="" class="pay_bank" pay_bank="ICBCB2C">工商银行</a></li>
              <li class="nongye"><a href="" class="pay_bank" pay_bank="ABC">农业银行</a></li>
              <li class="zhongguo"><a href="" class="pay_bank" pay_bank="BOCB2C">中国银行</a></li>
              <li class="jiaotong"><a href="" class="pay_bank" pay_bank="COMM">交通银行</a></li>
              <li class="zhongxin"><a href="" class="pay_bank" pay_bank="CITIC">中信银行</a></li>
              <li class="youzheng"><a href="" class="pay_bank" pay_bank="PSBC-DEBIT">邮政</a></li>
              <li class="guangfa"><a href="" class="pay_bank" pay_bank="GDB">广发银行</a></li>
              <li class="guangda"><a href="" class="pay_bank" pay_bank="CEBBANK">光大银行</a></li>
              <li class="pingan"><a href="" class="pay_bank" pay_bank="SPABANK">平安银行</a></li>
              <li class="xingye"><a href="" class="pay_bank" pay_bank="CIB">兴业银行</a></li>
              <li class="minsheng"><a href="" class="pay_bank" pay_bank="CMBC">民生银行</a></li>
              <li class="pufa"><a href="" class="pay_bank" pay_bank="SPDB">浦发银行</a></li>
                                                        <li class="beijing"><a href="" class="pay_bank" pay_bank="BJBANK">北京银行</a></li>
                                                        <li class="nanjing"><a href="" class="pay_bank" pay_bank="NJBANK">南京银行</a></li>
              <li class="ningbo"><a href="" class="pay_bank" pay_bank="NBBANK">宁波银行</a></li>        
              <li class="weixin"><a href="" class="pay_bank" pay_bank="wx" style="color:#fff; display:none;">微信充值</a></li>
			  <li class="yeepay"><a href="" class="pay_bank" pay_bank="yeepay" style="color:#fff; display:none;">易宝支付</a></li>-->
            </ol>
          </dd>
        </dl>
	</div>
	<div class="clear"></div>
	<div class="payNext">
        <p><a href="" id="payment" target="_blank">下一步
          <input id="u_id" type="hidden" value="<?php echo $this->_tpl_vars['userAccount']['u_id']; ?>
"/>
          </a></p>
      </div>
    </form>
    <!---->
  </div>
</div>
<div class="yiwen">如您有问题，请联系智赢网客服。</div>
<!--center end-->

<style>
.tips{margin:0 auto;width:350px;text-align:center;font-size:26px;font-family:'Microsoft YaHei';font-weight:900;padding:12px 0 0 0;}
.aaaaa{font-size:14px;text-align:center;width:320px;margin:0 auto;text-align:left;font-size:18px;font-family:'Microsoft YaHei';font-weight:300;line-height:30px;text-indent:38px;line-height:40px;padding:20px 0 0 0;}
.aaaaa p{font-size:14px;line-height:32px;font-size:16px;font-family:'Microsoft YaHei';font-weight:300;}
.aaaaa p span{ font-family:'宋体'}
.openwindowscenter{width:350px;height:500px;margin:0 auto;text-align:left;background:#fff;padding:10px 20px;position:relative;margin:0 auto;border-radius:7px;}
.openwindowscenter h1 a{padding:15px 15px 0 10px;position:absolute;right:10px;top:0;color:#565656;font-size:14px;color:#ed2424;font-family:'宋体';font-size:14px;font-weight:300;}
.openwindowspage{}
.openwindowspage h2{font-size:12px;color:#666;font-weight:300;margin:30px 0;height:36px;line-height:36px;background:#FFF5ED;padding:0 15px;}
.openwindowspage h5{font-size:12px;color:#666;font-weight:300;margin:0 0 10px 0;height:36px;line-height:26px;padding:0 15px;}
.openwindowspage h5 em{font-style:normal;color:#ed2424;padding:0 5px 0 0;}
.openwindowspage h6{font-size:12px;color:#666;font-weight:300;margin:0 0 10px 0;line-height:26px;border:1px solid #ed2424;background:#FFF5ED;padding:10px 20px;}
.openwindowspage h6 a{color:#ed2424;}
.openwindowspage h6 a:hover{text-decoration:underline;}
.openwindowspage h7{padding:0 0 0 100px;height:40px;line-height:40px;color:#ed2424;}
.black_overlay{display:none;background-color:#444;width:100%;height:100%;left:0;top:0;/*FF IE7*/
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
top:15%;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;vertical-align:middle;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/}
</style>
<div id="fade" class="black_overlay"></div>
<!--弹出层start-->
<div style="display:;">
  <div id="light1" class="white_content">
    <div class="openwindowscenter" style="height:200px;width:320px;">
      <div>
        <h1 style="border:none;"><span><a href="javascript:void(0)" onClick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none';window.location.reload();" style="text-decoration:none;">关闭</a></span></h1>
        <div class="openwindowspage">
          <div class="tips">温馨提示</div>
          <div class="aaaaa">
            <p><span></span>需充值的会员请联系客服进行手工充值（客服微信：a37573231    QQ:1323698651）为避免充不上，请于赛前20分钟完成充值<span></span></p>
            <p>
            <p style="text-align:right;font-size:14px;">智赢网官方</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--弹出层end--> 


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
