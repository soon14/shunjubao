<?php /* Smarty version 2.6.17, created on 2018-03-04 22:54:25
         compiled from confirm/confirm_result.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/confirm/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.Tipcenter{padding:20px 0 0 0; background:#fff;margin:5px;}
.Tips{text-align:center;border-top:1px dashed #fff;height:24px;line-height:18px;color:#000;font-size:12px; background:url(http://www.zhiying365365.com/www/statics/i/wbg.gif) repeat-x;}
.systemtips{padding:20px 0 0 0;width:280px; margin:0 auto; text-align:cenetr;}
.systemtips p{font-size:12px;font-family:'';line-height:32px;height:32px;}
.systemtips p span{background:url(http://www.zhiying365365.com/www/statics/i/raster.jpg) no-repeat 0 -96px;width:50px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.systemtips p em{background:url(http://www.zhiying365365.com/www/statics/i/raster.jpg) no-repeat 61% 90%;width:50px;display:inline-table;display:inline-block;zoom:1;*display:inline;font-style:normal;}
.ohter{height:100px;}
.ohter p{height:30px;line-height:30px;padding:28px 0 0 10px;}
.ohter p span{background:url(http://www.zhiying365365.com/www/statics/i/showRight.png) no-repeat left bottom;width:16px;height:14px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.ohter p em{ font-style:normal;position:relative;top:-2px; font-size:12px;}
.ohter p a{text-decoration:none;color:#000;font-size:12px;padding:0 10px 0 5px;position:relative;top:-3px;}
.ohter p a:hover{text-decoration:none;color:#dc0000;}
.ohter p a.active{text-decoration:none;color:#dc0000;}
</style>
<body>
<!--页面top start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--页面top end-->
<!--center start-->
<div class="Tipcenter"> <?php if ($this->_tpl_vars['type'] == 'success'): ?>
  <!--投注成功 start-->
  <div class="">
    <div class="systemtips">
      <p><span>&nbsp;</span>恭喜您!投注成功o(∩_∩)o</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/account/user_center.php">用户中心</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
    </div>
  </div>
  <!--投注成功 end-->
  <?php elseif ($this->_tpl_vars['type'] == 'fail'): ?>
  <!--投注失败 start-->
  <div class="">
    <div class="systemtips">
      <p><em>&nbsp;</em>您的投注没有成功。</p>
      <p><em>原因：</em><?php echo $this->_tpl_vars['msg']; ?>
</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['from']; ?>
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
">继续投注</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
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
/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
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
/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
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
">去登录</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
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
/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
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
/football/hafu_list.html">投注竞彩足球</a>| <a href="<?php echo @ROOT_WEBSITE; ?>
/football/hdc_list.html">投注竞彩篮球</a><span></span><a href="http://m.zhiying365365.com/">返回首页</a></p>
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
/account/user_center.php?p=realinfo">去认证</a><em>联系客服</em><a style="position:relative;top:6px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=2733292184&amp;site=qq&amp;menu=yes" target="_blank"><img title="在线客服" alt="在线客服" src="http://www.zhiying365365.com/www/statics/i/ServicesQ.jpg" style=" position:relative;top:-4px;"></a></p>
    </div>
  </div>
  <?php endif; ?>
</div>
<!--center end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>