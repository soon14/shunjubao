<?php /* Smarty version 2.6.17, created on 2018-03-04 23:58:57
         compiled from reset.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reset.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script>
function resetpass(){	
	var u_pwd1 = $("#u_pwd1").val();
	if(u_pwd1 == ''){
		$("#showtips").html('请先输入新密码！');
		return false;
	}	
	var u_pwd2 = $("#u_pwd2").val();
	if(u_pwd2 == ''){
		$("#showtips").html('请先输入新密码！');
		return false;
	}

	if(u_pwd1 != u_pwd2) {
		$("#showtips").html('两次密码不一致！');
		return false;
	}
	$("#f").submit();
}

</script>
<!--页面头部 start-->
<div class="head">
  <h1><a href="/"><i>重置密码</i></a></h1>
</div>
<!--页面头部 end-->
<!--center start-->
<div class="loginC">
  <div class="loginCleft">
    <form method="post" action=""  name='f' id='f' >
      <input type="hidden" value="<?php echo $this->_tpl_vars['mobile']; ?>
" name="mobile"/>
      <input type="hidden" value="<?php echo $this->_tpl_vars['code']; ?>
" name="code"/>
      <dl>
        <dt>新的密码</dt>
        <dd>
          <input name="u_pwd1" type="password" size="25"  id="u_pwd1"/>
      </dl>
      <dl>
        <dt>再次输入</dt>
        <dd>
          <input name="u_pwd2" type="password" size="25"  id="u_pwd2"/>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd> <span id="showtips"><?php if ($this->_tpl_vars['msg']): ?><?php echo $this->_tpl_vars['msg']; ?>
<?php endif; ?></span> </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd class="tijiao">
          <input name="button" type="button" value="提&nbsp;&nbsp;&nbsp;&nbsp;交"  onClick=" return resetpass()" />
        </dd>
      </dl>
    </form>
    <div class="lianhelogin">
      <h2>使用合作网站登录</h2>
      <ul>
        <li><a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101179991&redirect_uri=http%3A%2F%2Fwww.shunjubao.xyz%2Fconnect%2Fqq_connect.php&state=519325605e4f681a2c0589ca19d741ed&scope=get_user_info,add_share,add_weibo"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/QQlogin.gif">QQ登录</a></li>
        <li><a href="https://mapi.alipay.com/gateway.do?_input_charset=utf-8&partner=2088311949386932&return_url=http://www.shunjubao.xyz/connect/alipay_connect.php&service=alipay.auth.authorize&target_service=user.auth.quick.login&sign=eec67941b9a9e81899e345ed53b2873b&sign_type=MD5"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/alipaylogin.gif">支付宝登录</a></li>
        <li><a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc1b1ad8efd2af8eb&redirect_uri=http%3A%2F%2Fwww.shunjubao.xyz%2Fconnect%2Fweixin_connect.php&response_type=code&scope=snsapi_login&state=782141d36830c698e07e22dfd9bfa129#wechat_redirect"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/weixin2.gif">微信登录</a></li>
        <li><a href="https://api.weibo.com/oauth2/authorize?client_id=3430318831&redirect_uri=http%3A%2F%2Fwww.shunjubao.xyz%2Fconnect%2Fweibo_connect.php&response_type=code&display=default"><img src="<?php echo @STATICS_BASE_URL; ?>
/i/weibologin.gif">微博登录</a></li>
      </ul>
    </div>
  </div>
  <div class="loginRight">
    <h1>我们的优势</h1>
    <p>业界中奖率最高的网站</p>
    <p>数千万彩民的信赖</p>
    <p>每日赛事精选推荐</p>
    <p>晒单中心红的不要不要</p>
    <p>最及时、最全面、最专业的彩票新闻</p>
    <p>提款瞬间秒到</p>
  </div>
  <div class="clear"></div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 