<?php /* Smarty version 2.6.17, created on 2018-03-04 23:02:17
         compiled from login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'login.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='login.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<style>
.top h3{ font-size:14px;font-family:'Microsoft YaHei';font-weight:300;text-align:center;color:#fff; position:relative;}
.top h3 a{color:#fff; position:absolute;right:10px;}
#tipsCode{ background:#FFFFCC; line-height:22px;}
.Codetips{ width:88%; margin:0 auto; text-align:left; line-height:22px; padding:20px 0 0 0;color:#dc0000; font-size:12px;}
.Codetips p u{ text-decoration:none;}
.newpartner{ text-align:center; width:93%; margin:0 auto; position:relative;top:-20px;}
.newpartner h1{border-bottom:1px solid #ddd; height:40px; line-height:40px; font-size:12px;font-weight:300;}
.newpartner h1 b{font-weight:300; padding:0 30px; height:30px;position:relative;top:20px; text-align:center; background:#fff;display:inline-table;display:inline-block;zoom:1;*display:inline;position:}
.newpartner dl{ text-align:center; padding:30px 0 0 0; width:100%;}
.newpartner dl dt{display:inline-table;display:inline-block;zoom:1;*display:inline; width:32px; height:32px; margin:0 15px;}
.newpartner dl dt a{ width:32px; height:32px; line-height:32px;text-indent:-5000px; display:block;}
.newpartner dl dt.alipay{ width:32px; height:32px; background:url(http://www.shunjubao.xyz/www/statics/i/alipaywapicon.png) no-repeat;}
.newpartner dl dt.qq{width:32px; height:32px; background:url(http://www.shunjubao.xyz/www/statics/i/qqwapicon.png) no-repeat;}
.newpartner dl dt.weibo{width:32px; height:32px; background:url(http://www.shunjubao.xyz/www/statics/i/weibowapicon.png) no-repeat;}
.newpartner dl dt.weixin{width:32px; height:32px; background:url(http://www.shunjubao.xyz/www/statics/i/weixinwapicon.png) no-repeat;}
</style>
</head><body>
<div class="top">
  <h3>登录智赢<a href="/">返回</a></h3>
  <div class="logo none">
    <h1 ><a href="/">智赢网</a><em>登录</em></h1>
  </div>
</div>
<div class="center">
  <div class="biaodan">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/login.php?from=<?php echo $this->_tpl_vars['from']; ?>
" name='frm_login' id='frm_login'>
      <div class="tips"> <?php if ($this->_tpl_vars['msg']['pwd']): ?><span class="none"><?php echo $this->_tpl_vars['msg']['pwd']; ?>
</span><?php else: ?><u class="none">密码正确</u><?php endif; ?>
        <?php if ($this->_tpl_vars['msg']['loginerror']): ?> <span><?php echo $this->_tpl_vars['msg']['loginerror']; ?>
</span> <?php endif; ?> </div>
      <dl>
        <dd>
          <input name="u_name" type="text" size="25" placeholder="您的用户名" id="u_name"/>
        </dd>
      </dl>
      <dl>
        <dd>
          <input name="u_pwd" type="password" size="25" placeholder="请输入密码" id="u_pwd"/>
        </dd>
      </dl>
      <div class="link"><b>&nbsp;</b><a href="<?php echo @ROOT_DOMAIN; ?>
/passport/forgot.php" style="font-size:14px;color:#999;">忘记密码？</a><a href="http://m.shunjubao.xyz/passport/reg.php" style="font-size:14px;color:#999; float:right; position:relative;right:0;">我要注册</a></div>
      <div class="tijiao">
        <input name="submit" type="submit" value="登&nbsp;录" />
      </div>
      <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
    </form>
    <div class="newpartner">
      <h1><b>使用合作网站登录</b></h1>
      <dl>
        <dt class="alipay"><a href="https://mapi.alipay.com/gateway.do?_input_charset=utf-8&partner=2088311949386932&return_url=http://m.shunjubao.xyz/connect/alipay_connect.php&service=alipay.auth.authorize&target_service=user.auth.quick.login&sign=79baf752edb6ac32cc9ebdfa8ba9ea39&sign_type=MD5">支付宝登录</a></dt>
        <dt class="qq"><a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101179991&redirect_uri=http%3A%2F%2Fm.shunjubao.xyz%2Fconnect%2Fqq_connect.php&state=acadb2d2318870b40a1b6e48dcb960cd&scope=get_user_info,add_share,add_weibo">QQ登录</a></dt>
        <dt class="weixin"><a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc1b1ad8efd2af8eb&redirect_uri=http%3A%2F%2Fwww.shunjubao.xyz%2Fconnect%2Fweixin_connect.php&response_type=code&scope=snsapi_login&state=79ec3e6d6a0a3b4168f79dc88ce57525#wechat_redirect">微信登录</a></dt>
        <dt class="weibo"><a href="https://api.weibo.com/oauth2/authorize?client_id=3430318831&redirect_uri=http%3A%2F%2Fm.shunjubao.xyz%2Fconnect%2Fweibo_connect.php&response_type=code&display=default">新浪微博登录</a></dt>
      </dl>
    </div>
  </div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>