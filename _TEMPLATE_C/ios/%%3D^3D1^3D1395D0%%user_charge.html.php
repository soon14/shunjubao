<?php /* Smarty version 2.6.17, created on 2016-06-14 14:14:36
         compiled from user_charge.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='app_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script language="javascript" src="<?php echo ((is_array($_tmp='payment.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head><body>
<script type="text/javascript">
TMJF(function($) {
});
</script>
<div class="paytop none">
<h1>智赢用户充值中心</h1>
</div>
<!--center start-->
<div class="center">
  <div class="pay">
    <div class="paytips">您要充值的账户是：<b style="color:#dc0000;"><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></div>
    <!---->
    <form action='' method="post" id="gotocash">
      <div class="paycenter">
        <dl>
          <dt><b>充值金额：</b></dt>
          <dd>
            <ul>
              <li><a href="" class="charge_cash" payment="50">50元</a></li>
              <li><a href="" class="charge_cash" payment="100">100元</a></li>
              <li><a href="" class="charge_cash" payment="500">500元</a></li>
              <li class="mpay">
                <input type="text" name="" value="其他金额" id="inputc1" />
              </li>
            </ul>
          </dd>
        </dl>
        <div class="clear"></div>
        <dl class="show">
          <dt style="width:100%;"><b>支付方式：</b><span>（网上充值0手续费，资金即刻到账。）</span></dt>
          <dd>
            <ol>
              <li class="paypal"><a href="" class="pay_bank" pay_bank="ALIPAY">支付宝</a></li>
                            <li class="jianshe"><a href="" class="pay_bank" pay_bank="CCB">建设银行</a></li>
              <li class="zhaoshang"><a href="" class="pay_bank" pay_bank="CMB">招商银行</a></li>
              <li class="gongshang"><a href="" class="pay_bank" pay_bank="ICBCB2C">工商银行</a></li>
              <li class="nongye"><a href="" class="pay_bank" pay_bank="ABC">农业银行</a></li>
              <li class="zhongguo"><a href="" class="pay_bank" pay_bank="BOCB2C">中国银行</a></li>
              <li class="jiaotong"><a href="" class="pay_bank" pay_bank="COMM">交通银行</a></li>
              <li class="zhongxin"><a href="" class="pay_bank" pay_bank="CITIC">中信银行</a></li>
                            <li class="guangfa"><a href="" class="pay_bank" pay_bank="GDB">广发银行</a></li>
              <li class="guangda"><a href="" class="pay_bank" pay_bank="CEBBANK">光大银行</a></li>
              <li class="pingan"><a href="" class="pay_bank" pay_bank="SPABANK">平安银行</a></li>
              <li class="xingye"><a href="" class="pay_bank" pay_bank="CIB">兴业银行</a></li>
              <li class="minsheng"><a href="" class="pay_bank" pay_bank="CMBC">民生银行</a></li>
              <li class="pufa"><a href="" class="pay_bank" pay_bank="SPDB">浦发银行</a></li>
                                                        <li class="beijing"><a href="" class="pay_bank" pay_bank="BJBANK">北京银行</a></li>
                                                        <li class="nanjing"><a href="" class="pay_bank" pay_bank="NJBANK">南京银行</a></li>
              <li class="ningbo"><a href="" class="pay_bank" pay_bank="NBBANK">宁波银行</a></li>
            </ol>
          </dd>
        </dl>
        <div class="clear"></div>
      </div>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 