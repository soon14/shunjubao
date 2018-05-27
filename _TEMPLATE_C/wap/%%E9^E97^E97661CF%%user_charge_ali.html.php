<?php /* Smarty version 2.6.17, created on 2017-12-30 21:26:44
         compiled from user_charge_ali.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge_ali.html', 2, false),)), $this); ?>
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
          <dt>支付宝支付：</dt>
          <dd>
            <ol>
                 <li class="paypal"><a href="" class="pay_bank" pay_bank="ALIPAY" style=" font-size:24px">支付宝支付</a></li>
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
    <div class="bottips">如您在充值过程中遇到问题，请联系我们客服热线:QQ:1323698651,或联系我们在线客服&nbsp;<a style="position:relative;top:3px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1323698651&amp;site=qq&amp;menu=yes" target="_blank"><img border="0" title="在线客服" alt="在线客服" src="<?php echo @ROOT_DOMAIN; ?>
/www/statics/i/ServicesQ.jpg"></a><br/><br/><br/><br/></div>
  </div>
</div>
<!--center end--> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 