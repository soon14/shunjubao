<?php /* Smarty version 2.6.17, created on 2017-10-27 21:49:54
         compiled from user_charge_myali.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge_myali.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body style=" background:#f9f9f9;">
<script language="javascript" src="<?php echo ((is_array($_tmp='payment.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script> 
<script type="text/javascript" src="http://www.zhiying365.com/www/statics/j/jquery.js"></script> 
<script type="text/javascript">
TMJF(function($) {
});
</script>
<div class="head">
  <h1><a href="/"></a><u></u>
    <ul>
      <li><!--<a href="/">返回首页</a>--><!--<span>|</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php?p=account_log">用户中心</a>--></li>
    </ul>
  </h1>
</div>
<!--center start-->
<div class="cnetr">
  <div class="payname">
    <ul>
      <li>您当前使用的是支付宝支付，实时到账，手续费为0。</li>
      <li>充值账户：<b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></li>
      <li>账户余额：<strong>&yen;<?php echo $this->_tpl_vars['userAccount']['cash']; ?>
元</strong></li>
    </ul>
  </div>
  <div class="pay"> 
    <!---->
    <form action='' method="post" id="gotocash">
      <div class="paycenter">
        <dl>
          <dt>充值金额：</dt>
          <dd>
            <ul>
              <li><a href="" class="charge_cash" payment="50">50元</a></li>
              <li><a href="" class="charge_cash" payment="100">100元</a></li>
              <li><a href="" class="charge_cash" payment="500">500元</a></li>
              <li>
                <div>
                  <input type="text" name="" value="其他金额" style="width:90px;height:32px;line-height:32px;border-radius:2px;border:1px solid #ccc;text-align:center;" id="inputc1"/>
                </div>
              </li>
            </ul>
          </dd>
        </dl>
        <div class="clear"></div>
        <dl class="show">
          <dt>在线支付：</dt>
          <dd>
            <ol>
            		<li class="paypal"><a href="" class="pay_bank" pay_bank="ALIPAY">支付宝</a></li>	
            		<!-- <li class="weixin"><a href="" class="pay_bank" pay_bank="wx" >微信充值</a></li>-->
            	<!--  <li class="jingdong" ><a href="" class="pay_bank" pay_bank="jdPayDebitCredit" >银行快捷</a></li>-->
                  <!-- <li class="paypal"><a href="" class="pay_bank" pay_bank="ALIPAY2">支付宝</a></li>-->
            <!--      <li class="zhaoshang"><a href="" class="pay_bank" pay_bank="CMB1">招商银行</a></li>
                   <li class="gongshang"><a href="" class="pay_bank" pay_bank="ICBC1">工商银行</a></li>
                   <li class="jianshe"><a href="" class="pay_bank" pay_bank="CCB1">建设银行</a></li>
                   <li class="zhongguo"><a href="" class="pay_bank" pay_bank="BOC1">中国银行</a></li>
                   <li class="nongye"><a href="" class="pay_bank" pay_bank="ABC1">农业银行</a></li>
                    <li class="jiaotong"><a href="" class="pay_bank" pay_bank="BOCM1">交通银行</a></li>
                  <li class="pufa"><a href="" class="pay_bank" pay_bank="SPDB1">浦发银行</a></li> 
                  <li class="guangfa"><a href="" class="pay_bank" pay_bank="CGB1">广发银行</a></li>
                   <li class="zhongxin"><a href="" class="pay_bank" pay_bank="CITIC1">中信银行</a></li>
                   
                   <li class="xingye"><a href="" class="pay_bank" pay_bank="CIB1">兴业银行</a></li>
                  <li class="pingan"><a href="" class="pay_bank" pay_bank="PAYH1">平安银行</a></li>
                  <li class="minsheng"><a href="" class="pay_bank" pay_bank="CMBC1">民生银行</a></li>
                  <li class="beijing"><a href="" class="pay_bank" pay_bank="BCCB1">北京银行</a></li> 
                  <li class="jingdong"><a href="" class="pay_bank" pay_bank="jdPay" style=" font-size:24px">jd支付</a></li> 
                  <li class="guangda"><a href="" class="pay_bank" pay_bank="CEB1">光大银行</a></li>-->
          <!--       <li class="onlinepayment"><a href="" class="pay_bank" pay_bank="zxwy2" style=" font-size:24px">网银支付</a></li> -->
                  
                  
            </ol>
          </dd>
        </dl>
        <div class="clear"></div>
        <div class="payNext">
          <p><a href="" id="payment" target="_blank">下一步
            <input id="u_id" type="hidden" value="<?php echo $this->_tpl_vars['userAccount']['u_id']; ?>
"/>
            </a></p>
        </div>
      </div>
    </form>
    <!---->
    <div class="bottips">如您在充值过程中遇到问题，请联系我们客服热线:010-64344882,或联系我们在线客服&nbsp;<a style="position:relative;top:3px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img border="0" title="在线客服" alt="在线客服" src="<?php echo @ROOT_DOMAIN; ?>
/www/statics/i/ServicesQ.jpg"></a><br/><br/><br/><br/></div>
  </div>
</div>
<!--center end--> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 