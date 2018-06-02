<?php /* Smarty version 2.6.17, created on 2017-10-18 18:21:53
         compiled from user_charge_myali.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge_myali.html', 2, false),)), $this); ?>
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
<div class="paytop">
  <h1>聚宝用户充值中心</h1>
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
          <dt>充值金额：</dt>
          <dd>
            <ul>
              <li class="paypal"><a href="" class="charge_cash" payment="50">50元</a></li>
              <li class="paypal"><a href="" class="charge_cash" payment="100">100元</a></li>
              <li class="paypal"><a href="" class="charge_cash" payment="500">500元</a></li>
              <li class="mpay">
                <input type="text" name="" value="其他金额" id="inputc1"/>
              </li>
            </ul>
          </dd>
        </dl>
        <div class="clear"></div>
        <dl class="show">
		 <dt style="width:100%;"><b>选择银行：</b><span>（网上充值0手续费，资金即刻到账。）</span></dt>
          <dd>
            <ol>
            	<li class="paypal"><a href="" class="pay_bank" pay_bank="ALIPAY">支付宝</a></li>
              <!--  <li class="weixin"><a href="" class="pay_bank" pay_bank="rhwx" >微信充值</a></li>-->
                
    
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
  </div>
</div>
<div class="yiwen">如您有问题，请联系聚宝网客服。</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
