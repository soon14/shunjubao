<?php /* Smarty version 2.6.17, created on 2017-10-30 18:58:31
         compiled from manul_charge.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'manul_charge.html', 2, false),)), $this); ?>
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
  
  <div class="pay"> 
    <!---->
    手动充值接口（不对外开放）
    <form action='http://www.zhiying365.com/services/mppay_return_man.php' method="post" target="_blank">
      <div class="paycenter">
        订单号:<input type="text" name="out_trade_no" id="out_trade_no" value=""  /> <br> <br>
      金额:<input type="text" name="total_fee" id="total_fee" value="" /> <br> <br>
       密钥:<input type="text" name="sign" id="sign" value=""  />  <br> <br>
        
         <input type="submit" name="button" id="button" value="确认充值"> <br>
      
        
      </div>
    </form>
    <!---->
    
  </div>
</div>
<!--center end--> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 