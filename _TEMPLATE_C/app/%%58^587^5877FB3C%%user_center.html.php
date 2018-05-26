<?php /* Smarty version 2.6.17, created on 2017-02-03 00:50:37
         compiled from user_center.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
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
  <div class="uTips"><img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" />&nbsp;&nbsp;积分：<?php echo $this->_tpl_vars['userAccount']['score']; ?>
&nbsp;&nbsp;彩金：<span><?php echo $this->_tpl_vars['userAccount']['gift']; ?>
</span>&nbsp;&nbsp;余额：<span><?php echo $this->_tpl_vars['userAccount']['cash']; ?>
</span></div>
  <div class="userpage">
    <table  border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td class="active"><b>个人信息</b></td>
        <td class="active"><b>我的账户</b></td>
        <td class="active"><b>投注管理</b></td>
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
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户<br/>
          明细</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_score_tran.php">积分<br/>
          兑换</a></td>
        <!--<td></td>-->
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">快捷<br/>
          提现</a></td>
      </tr>
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值<br/>
          记录</a>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现<br/>
          记录</a></td>
        </td>
        <td><a href=""></a></td>
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
  <?php endif; ?>
  <!--tips end-->
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 