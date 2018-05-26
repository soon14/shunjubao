<?php /* Smarty version 2.6.17, created on 2018-03-04 22:59:35
         compiled from user_center.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_center.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
</head><body>
<!--页面头部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	function getQueryString(name) {
	    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null) return unescape(r[2]); return null;
	}
	//条转到相应的用户管理页面
	var p_name = 'ticket';
	if (getQueryString('p')) {
		p_name = getQueryString('p');
	}
	var iframe_src = '<?php echo @ROOT_DOMAIN; ?>
/account/user_' + p_name + '.php';
	$("#right_iframe").attr('src', iframe_src);
});
</script>
<!--页面头部 end-->
<!--center start-->
<div class="center">
  <table width="100%" border="0" style="height:40px; line-height:40px; font-size:12px;">
    <tr>
      <td>积分<?php echo $this->_tpl_vars['userAccount']['score']; ?>
</td>
      <td>彩金<?php echo $this->_tpl_vars['userAccount']['gift']; ?>
</td>
      <td>余额<?php echo $this->_tpl_vars['userAccount']['cash']; ?>
</td>
    </tr>
  </table>
  <!--tips end-->
  <div class="userpage">
    <table  border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td class="active"><b>个人信息</b></td>
        <td class="active"><b>我的账户</b></td>
        <td class="active"><b>相关管理</b></td>
        <td class="active"><b>其他</b></td>
      </tr>
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php">基本<br/>
          信息</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">实名<br/>
          认证</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket.php">投注<br/>
          记录</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php">充值<br/>
          中心</a></td>
      </tr>
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php">修改<br/>
          密码</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php">绑定<br/>
          银行</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_virtual_ticket.php">积分<br/>
          记录</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php" class="active">我要<br/>
          推广</a></td>
      </tr>
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php">站内<br/>
          消息</a></td>
        <td><a href="http://zhiying365365.com/account.html">账户<br/>
          明细</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_score_tran.php">积分<br/>
          兑换</a></td>
        <!--<td></td>-->
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">绑支<br/>
          付宝</a></td>
      </tr>
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现<br/>
          记录</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php">打赏<br/>
          信息</a></td>
        </td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_dingzhi.php">定制<br/>
          管理</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_withdraw.php">我要<br/>
          提现</a></td>
      </tr>
    </table>
  </div>
  <!--tips start-->
  <?php if (! $this->_tpl_vars['userRealInfo']['realname']): ?>
  <div class="UserTips" ><b class="none">您的账户有风险！</b>您尚未进行实名认证。<a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" target="rightFrame">立即认证</a> </div>
  <?php endif; ?> </div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 