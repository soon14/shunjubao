<?php /* Smarty version 2.6.17, created on 2018-03-04 22:56:57
         compiled from confirm/confirm_result.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/confirm_result.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<body>
<!--页面top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--页面top end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--center start-->
<div class="Tipcenter"> 
  <?php if ($this->_tpl_vars['type'] == 'success'): ?>
  <!--投注成功 start-->
  <div class="">
    <div class="systemtips">
      <p><span>&nbsp;</span>恭喜您!投注成功o(∩_∩)o</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/account/user_center.php">用户中心</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--投注成功 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'fail'): ?>
  <!--投注失败 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的投注没有成功o_O???</p>
      <p><em>原因：</em><?php echo $this->_tpl_vars['msg']; ?>
</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--投注失败 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'sport'): ?>
  <!--体育类型错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的投注彩种错误&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--体育类型错误 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'multiple'): ?>
  <!--体育类型错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--体育类型错误 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'money'): ?>
  <!--投注金额错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的投注金额错误&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--投注金额错误 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'pool'): ?>
  <!--投注玩法错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的投注玩法错误&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--投注玩法错误 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'other'): ?>
  <!--投注其他错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <!--投注其他错误 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'cash'): ?>
  <!--余额不足 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的账户余额不足&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php" class="active">立即充值</a><span></span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php">进入用户中心</a></p>
    </div>
  </div>
  <!--余额不足 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'start'): ?>
  <!--比赛已开赛 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span> <a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--比赛已开赛 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'end'): ?>
  <!--比赛已截止 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--比赛已截止 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'login'): ?>
  <!--比赛已截止 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您还没有登录&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span> <a href="<?php echo @ROOT_DOMAIN; ?>
/passport/login.php?from=<?php echo $this->_tpl_vars['from']; ?>
">去登录</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--比赛已截止 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'start_time'): ?>
  <!--比赛已截止 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--比赛已截止 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'end_time'): ?>
  <!--比赛已截止 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/www/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
">返回首页</a></p>
    </div>
  </div>
  <!--比赛已截止 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'idcard'): ?>
  <!--投注其他错误 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em><?php echo $this->_tpl_vars['msg']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/account/user_center.php?p=realinfo">去认证</a><em>联系客服？</em><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.shunjubao.xyz/www/statics/i/ServicesQ.jpg"></a></p>
    </div>
  </div>
  <?php endif; ?>
  <div class="Tips">智赢网是彩票赢家的聚集地，口碑最好的彩票做单网站</div>
</div>
<!--center end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>