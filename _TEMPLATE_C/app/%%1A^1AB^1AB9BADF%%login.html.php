<?php /* Smarty version 2.6.17, created on 2018-03-05 00:15:14
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
</head>
<body>
<div class="top">
  <h3>登录聚宝网</h3>
  <div class="logo none">
    <h1 ><a href="/">聚宝网</a><em>登录</em></h1>
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
        <dt>您的用户名</dt>
        <dd>
          <input name="u_name" type="text" size="25" id="u_name"/>
        </dd>
      </dl>
      <dl>
        <dt>请输入密码</dt>
        <dd>
          <input name="u_pwd" type="password" size="25" id="u_pwd"/>
        </dd>
      </dl>
      <div class="link"><b>&nbsp;</b><a href="<?php echo @ROOT_DOMAIN; ?>
/passport/forgot.php" style="font-size:14px;color:#999;">忘记密码？</a></div>
      <div class="tijiao">
        <input name="submit" type="submit" value="登&nbsp;录" />
      </div>
      <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
    </form>
    <div class="partner">
      <h2>使用合作网站登录</h2>
      <ul>
        <li class="alipay"><a href="<?php echo $this->_tpl_vars['connect_urls'][1]; ?>
">支付宝登录</a></li>
        <li class="qq"><a href="<?php echo $this->_tpl_vars['connect_urls'][2]; ?>
">QQ登录</a></li>
        <li class="weixin"><a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc1b1ad8efd2af8eb&redirect_uri=http%3A%2F%2Fwww.shunjubao.xyz%2Fconnect%2Fweixin_connect.php&response_type=code&scope=snsapi_login&state=79ec3e6d6a0a3b4168f79dc88ce57525#wechat_redirect">微信登录</a></li>
        <li class="weibo"><a href="<?php echo $this->_tpl_vars['connect_urls'][4]; ?>
">新浪微博登录</a></li>
      </ul>
    </div>
  </div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>