<?php /* Smarty version 2.6.17, created on 2016-04-06 15:51:17
         compiled from user_center.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_center.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='app_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
</head><body>
<!--页面头部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "userinfor.html", 'smarty_include_vars' => array()));
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
<div class="center" style="font-size:14px;">
  <!--tips start-->
  <?php if (! $this->_tpl_vars['userRealInfo']['realname']): ?>
  <div class="UserTips" ><b class="">您的账户有风险！</b>您尚未进行实名认证。<a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" target="rightFrame">立即认证</a> </div>
  <?php endif; ?>
  <!--tips end-->
  <div class="TouXiang">
    <dl>
      <dt><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php" target="rightFrame"> <img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /></a></dt>
      <dd><b>积分:</b><em><?php echo $this->_tpl_vars['userAccount']['score']; ?>
</em></dd>
      <dd><b>余额:</b><strong><?php echo $this->_tpl_vars['userAccount']['cash']; ?>
元</strong></dd>
      <!--<dd><b>可提现:</b><em><?php echo $this->_tpl_vars['userAccount']['cash']; ?>
元</em></dd>-->
    </dl>
    <div class="clear"></div>
  </div>
  <style>
.wapuserNav{text-align:center; background:#f1f1f1; padding:5px 0;}
.wapuserNav p{height:30px; line-height:30px; font-size:14px;}
.wapuserNav p span{color:#dc0000; font-size:12px; font-weight:300; padding:0 5px 0 0;}
.wapuserNav p a{color:#555;}
  </style>
  <table class="" width="99.5%" bordercolor="#e2e2e2" border="1" cellspacing="0" cellpadding="0" style="width:99.5%; overflow:hidden;font-size:13px; border-bottom:1px solid #fff; text-align:center;">
    <tr>
      <th><div style="height:34px;line-height:34px;"><strong>个人信息</strong></div></th>
      <th><div style="height:34px;line-height:34px;"><strong>我的账户</strong></div></th>
      <th><div style="height:34px;line-height:34px;"><strong>投注管理</strong></div></th>
      <th><div style="height:34px;line-height:34px;"><strong>其他</strong></div></th>
    </tr>
    <tr>
      <td valign="top" class="wapuserNav"><p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php">基本信息</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php">修改密码</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php" style="color:#dc0000;">快捷提现</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php">站内信</a>&nbsp;&nbsp;&nbsp;</p></td>
      <td valign="top" class="wapuserNav"><p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php">实名认证</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php">绑定银行</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现记录</a></p></td>
      <td valign="top" class="wapuserNav"><p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket.php">投注记录</a></p></td>
      <td valign="top" class="wapuserNav"><p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php">充值</a></p>
        <p><span>●</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_withdraw.php" class="hover">提现</a></p></td>
    </tr>
  </table>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 