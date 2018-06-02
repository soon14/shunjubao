<?php /* Smarty version 2.6.17, created on 2016-03-04 23:20:20
         compiled from reg.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reg.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='reg.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<body>
<!--页面头部 start-->
<div class="top">
  <h3>注册聚宝网</h3>
  <div class="logo none">
    <h1 ><a href="/">聚宝网</a><em>注册</em></h1>
  </div>
</div>
<!--页面头部 end--
<!--center start-->
<div class="center">
  <div class="biaodan">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/reg.php?refer=<?php echo $this->_tpl_vars['refer']; ?>
" name='frm_reg' id='frm_reg'>
      <dl>
        <dt>用户名</dt>
        <dd>
          <input name="u_name" type="text" size="25"  id='u_name'/>
        </dd>
      </dl>
      <dl>
        <dt>登录密码</dt>
        <dd>
          <input name="u_pwd" type="password" size="25"  id="u_pwd"/>
      </dl>
      <dl>
        <dt>确认密码</dt>
        <dd>
          <input name="repas" type="password" size="25"  id="repas"/>
        </dd>
      </dl>
      <dl>
        <dt>手机号：</dt>
        <dd>
          <input name="mobile" type="text" size="25"  id="mobile"/>
        </dd>
      </dl>
      <dl class="none">
        <dt>验证码</dt>
        <dd>
          <input type="text" value="" style="width:135px;">
          <input type="text" value="发送验证码" style="width:110px;" class="code">
        </dd>
      </dl>
      <div class="tips" style="height:auto;"> <font class="<?php if ($this->_tpl_vars['msg']['u_name']): ?><?php else: ?>none<?php endif; ?>" id='tips1'> <?php if ($this->_tpl_vars['msg']['u_name']): ?><span id='u_name_err'><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><u class="none" id='tips1'></u><?php endif; ?> </font><br/>
        <font class="<?php if ($this->_tpl_vars['msg']['newpas']): ?><?php else: ?>none<?php endif; ?>" id='tips2'> <?php if ($this->_tpl_vars['msg']['newpas']): ?><span><?php echo $this->_tpl_vars['msg']['newpas']; ?>
</span><?php else: ?><u class="">请输入密码</u><?php endif; ?> </font><br/>
        <font class="<?php if ($this->_tpl_vars['msg']['repas']): ?><?php else: ?>none<?php endif; ?>" id='tips3'> <?php if ($this->_tpl_vars['msg']['repas']): ?><span><?php echo $this->_tpl_vars['msg']['repas']; ?>
</span><?php else: ?><?php endif; ?> </font><br/>
        <font class="<?php if ($this->_tpl_vars['msg']['mobile']): ?><?php else: ?>none<?php endif; ?>" id='tips4'> <?php if ($this->_tpl_vars['msg']['mobile']): ?><span><?php echo $this->_tpl_vars['msg']['mobile']; ?>
</span><?php else: ?><?php endif; ?> </font> </div>
      <div class="tijiao">
        <input name="submit" type="submit" value="注&nbsp;册"  />
      </div>
    </form>
    <div class="partner">
      <h2>使用合作网站登录</h2>
      <ul>
        <li class="alipay"><a href="https://mapi.alipay.com/gateway.do?_input_charset=utf-8&partner=2088311949386932&return_url=http://www.zhiying365.com/connect/alipay_connect.php&service=alipay.auth.authorize&target_service=user.auth.quick.login&sign=eec67941b9a9e81899e345ed53b2873b&sign_type=MD5">支付宝登录</a></li>
        <li class="qq"><a href="https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=101179991&redirect_uri=http%3A%2F%2Fwww.zhiying365.com%2Fconnect%2Fqq_connect.php&state=519325605e4f681a2c0589ca19d741ed&scope=get_user_info,add_share,add_weibo">QQ登录</a></li>
        <li class="weixin"><a href="https://open.weixin.qq.com/connect/qrconnect?appid=wxc1b1ad8efd2af8eb&redirect_uri=http%3A%2F%2Fwww.zhiying365.com%2Fconnect%2Fweixin_connect.php&response_type=code&scope=snsapi_login&state=79ec3e6d6a0a3b4168f79dc88ce57525#wechat_redirect">微信登录</a></li>
        <li class="weibo"><a href="https://api.weibo.com/oauth2/authorize?client_id=3430318831&redirect_uri=http%3A%2F%2Fwww.zhiying365.com%2Fconnect%2Fweibo_connect.php&response_type=code&display=default">新浪微博登录</a></li>
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