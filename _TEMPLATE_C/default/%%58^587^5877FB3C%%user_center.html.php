<?php /* Smarty version 2.6.17, created on 2018-03-04 22:59:34
         compiled from user_center.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_center.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
<!--页面头部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	function getQueryString(name) {
	    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
	    var r = window.location.search.substr(1).match(reg);
	    if (r != null)  {
	    	return unescape(r[2]).replace(/<\/?[^>]*>/g,'');
	    }
	    return null;
	}
	//条转到相应的用户管理页面
	var p_name = 'ticket';
	if (getQueryString('p')) {
		p_name = getQueryString('p');
	}
	var iframe_src = '<?php echo @ROOT_DOMAIN; ?>
/account/user_' + p_name + '.php';
	if(p_name=='ticket') iframe_src += '?is_prize=1';
	$("#right_iframe").attr('src', iframe_src);
});
</script>
<!--页面头部 end-->
<!--center start-->
<div class="center">
  <!--tips start-->
  <?php if (! $this->_tpl_vars['userRealInfo']['realname']): ?>
  <div class="renzhengtips" >您的账户有风险！您尚未进行实名认证，实名认证信息是您账户提取资金重要核对依据，认证后可有效防止资金被盗。<a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" target="rightFrame">立即认证</a> </div>
  <?php endif; ?>
  <!--tips end-->
  <div class="pagebody">
    <div class="userleft">
      <h1>用户中心</h1>
      <dl>
        <dt><b>充值&nbsp;|&nbsp;提现</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php" target="_blank">充值</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_withdraw.php" target="rightFrame">提现</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php" target="rightFrame" >充值记录</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php" target="rightFrame" >提现记录</a></p>
        </dd>
      </dl>
      <dl>
        <dt><b>投注管理</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket.php?is_prize=1" target="rightFrame" >投注记录</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_virtual_ticket.php" target="rightFrame" >积分投注</a></p>
          <p style="display:none;"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_daletou.php" target="rightFrame" >大乐透投注记录</a></p>
        </dd>
      </dl>
      <dl>
        <dt><b>定制管理</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_dingzhi.php" target="rightFrame" >我的定制</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_dingzhied.php" target="rightFrame" >定制我的</a></p>
        </dd>
      </dl>
      <dl>
        <dt><b>我的账户</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php" target="rightFrame">我的消息</a><span>(<i><?php echo $this->_tpl_vars['unRecieviSum']; ?>
</i>)</span></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php" target="rightFrame" >账户明细</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" target="rightFrame" >实名认证</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php" target="rightFrame" >银行卡绑定</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php" target="rightFrame" >绑定支付宝</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php" target="rightFrame" >我要推广</a><img src="http://www.shunjubao.xyz/www/statics/i/new.gif"></p>
        </dd>
      </dl>
      <dl>
        <dt><b>个人信息</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_basic.php" target="rightFrame">基本信息</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php"  target="rightFrame">上传头像</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_modify_pwd.php"  target="rightFrame">修改密码</a></p>
        </dd>
      </dl>
      <dl>
        <dt><b>彩金&nbsp;|&nbsp;积分</b></dt>
        <dd>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_tran.php" target="rightFrame" class=''>彩金换积分</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_score_tran.php" target="rightFrame" class='' >积分换彩金</a></p>
          <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_money_tran.php" target="rightFrame" class='' >余额换积分</a></p>
        </dd>
      </dl>
    </div>
    <div class="userright">
      <div class="userinfor">
        <dl style="position:relative;">
          <dt><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php" target="rightFrame"> <img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /> </a></dt>
          <dd><b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b>
            <p  style="display:none;">总中奖额度：<?php if ($this->_tpl_vars['totalPrize']): ?><?php echo $this->_tpl_vars['totalPrize']; ?>
<?php else: ?>0.00<?php endif; ?>元</p>
            <p>积分：<?php echo $this->_tpl_vars['userAccount']['score']; ?>
</p>
            <p>彩金：<?php echo $this->_tpl_vars['userAccount']['gift']; ?>
</p>
            <p>余额：<?php echo $this->_tpl_vars['userAccount']['cash']; ?>
</p>
            
            <p style="display:none;">可提额度：<?php echo $this->_tpl_vars['userAccount']['cash']; ?>
</p>
            <span style="position:absolute;right:-10px;top:0;">
            <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php" target="_blank">充值</a></p>
            <p><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_withdraw.php" target="rightFrame">提现</a></p>
            </span> </dd>
        </dl>
      </div>
      <div class="rightcenetr">
        <iframe  id="right_iframe" width="100%" height="900" frameborder="0" scrolling="no" src="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket.php" name="rightFrame" id="rightFrame" title="rightFrame">
        </iframe>
      </div>
    </div>
  </div>
</div>
<!--center end-->
<div class="footer" style="background:#f9f9f9;">
  <div class="footdaodu" style="border:none;">
    <p><a href="/passport/reg.php" target="_blank">用户注册</a><span>|</span></p>
    <p><a href="/about/index.html" target="_blank">关于我们</a><span>|</span></p>
    <p><a href="/about/baozhang.html" target="_blank">安全保障</a><span>|</span></p>
    <p><a href="/about/contactus.html" target="_blank">联系方式</a><span>|</span></p>
    <p><a href="/about/job.html" target="_blank">人才招聘</a><span>|</span></p>
    <p><a href="/about/bd.html" target="_blank">商务合作</a><span>|</span></p>
    <p><a href="/about/lawfirm.html" target="_blank">法律声明</a><span>|</span></p>
    <p><a href="/about/xieyi.html" target="_blank">网站协议</a></p>
  </div>
  <div class="FooterOhter">
    <p>彩票有风险，投注需谨慎，不向未满18周岁的青少年出售彩票&nbsp;&nbsp;客服热线：010-64344882&nbsp;&nbsp;&nbsp;<a href="http://www.shunjubao.xyz/message/show.php" target="_blank">您的建议对我们很重要!</a></p>
  </div>
  <div class="FootPic">
    <ul>
      <li><a href="http://www.pinpaibao.com.cn/intro/index/" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic2.jpg"/></a></li>
      <li><a href="http://www.miitbeian.gov.cn/state/outPortal/loginPortal.action" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic1.jpg"/></a></li>
      <li><a href="http://www.315online.com.cn/" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic3.jpg"/></a></li>
      <li><a href="http://www.mps.gov.cn/n16/index.html?_v=1438535553945" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic4.jpg"/></a></li>
      <li><a href="http://www.itrust.org.cn/" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic5.jpg"/></a></li>
      <li><a href="http://www.bj.cyberpolice.cn/index.jsp" target="_blank"><img src="http://www.shunjubao.xyz/www/statics/i/FootPic6.jpg"/></a></li>
    </ul>
  </div>
  <div class="FooterOhter">
    <p>2014-2016&nbsp;智赢网&nbsp;&copy;&nbsp;版权所有&nbsp;All rights reserved</p>
    <p>京ICP备14016851-1号</p>
    <p>京ICP证150586号</p>
    <p>京公安网备11011402000202</p>
  </div>
</div>
<div class="none">
  <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https:\/\/" : " http:\/\/");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000441119'%3E%3C\/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com\/z_stat.php%3Fid%3D1000441119%26show%3Dpic' type='text\/javascript'%3E%3C\/script%3E"));</script>
</div>
<div class="none">
  <script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?b5c0fa192dddf3552c42bd96791a0a00";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</div>
