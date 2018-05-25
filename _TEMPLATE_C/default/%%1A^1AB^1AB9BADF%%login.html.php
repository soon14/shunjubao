<?php /* Smarty version 2.6.17, created on 2018-05-23 20:43:01
         compiled from login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'login.html', 7, false),)), $this); ?>
<!DOCTYPE html>
<head>
<title>用户登录-聚宝网聚宝彩票，中奖率最高的网站。</title>
<meta name="keywords" content="用户登录,聚宝网,聚宝彩票" />
<meta name="description" content="用户登录-聚宝网聚宝彩票，中奖率最高的网站。" />
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='login.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head>
<body>
<!--页面头部 start-->
<div class="head">
  <h1><a href="/"><i>用户登录</i></a></h1>
</div>
<!--页面头部 end-->
<!--center start-->
<div class="loginC">
  <div class="loginCleft">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/login.php?from=<?php echo $this->_tpl_vars['from']; ?>
" name='frm_login' id='frm_login'>
      <div class="error"> <?php if ($this->_tpl_vars['msg']['pwd']): ?><span class="none"><?php echo $this->_tpl_vars['msg']['pwd']; ?>
</span><?php else: ?><u class="none">密码正确</u><?php endif; ?>
        <?php if ($this->_tpl_vars['msg']['loginerror']): ?> <span><?php echo $this->_tpl_vars['msg']['loginerror']; ?>
</span> <?php endif; ?> </div>
      <dl>
        <dt>用户名</dt>
        <dd>
          <input name="u_name" type="text" size="25" id="u_name"/>
          <?php if ($this->_tpl_vars['msg']['u_name']): ?><span><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><em style="display:none">用户名可用</em><?php endif; ?> </dd>
      </dl>
      <dl>
        <dt>登录密码</dt>
        <dd>
          <input name="u_pwd" type="password" size="25" id="u_pwd"/>
        </dd>
      </dl>
      <dl>
        <dt></dt>
        <dd class="tijiao">
          <input name="submit" type="submit" value="登&nbsp;录" />
        </dd>
      </dl>
      <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
    </form>
    <dl>
      <dt></dt>
      <dd><a href="<?php echo @ROOT_DOMAIN; ?>
/passport/forgot.php">忘记密码？</a></dd>
    </dl>
    <div class="lianhelogin">
      <h2>使用合作网站登录</h2>
      <ul>
        <li><img src="http://www.shunjubao.xyz/www/statics/i/QQlogin.gif"><a href="<?php echo $this->_tpl_vars['connect_urls'][2]; ?>
">QQ登录</a></li>
        <li><img src="http://www.shunjubao.xyz/www/statics/i/alipaylogin.gif"><a href="<?php echo $this->_tpl_vars['connect_urls'][1]; ?>
">支付宝登录</a></li>
        <li><img src="http://www.shunjubao.xyz/www/statics/i/weixin2.gif"><a href="<?php echo $this->_tpl_vars['connect_urls'][3]; ?>
">微信登录</a></li>
        <li><img src="http://www.shunjubao.xyz/www/statics/i/weibologin.gif"><a href="<?php echo $this->_tpl_vars['connect_urls'][4]; ?>
">微博登录</a></li>
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
    <p></p>
    <p><a href="http://www.shunjubao.xyz/passport/reg.php" style="font-size:14px;color:#dc0000;">我要注册</a></p>
  </div>
  <div class="clear"></div>
</div>
<!--center end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</div>
