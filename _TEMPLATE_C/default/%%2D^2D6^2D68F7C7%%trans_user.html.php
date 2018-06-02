<?php /* Smarty version 2.6.17, created on 2018-03-11 16:05:42
         compiled from trans_user.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'trans_user.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script>
TMJF(function($) {
	var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";var connect_id = "<?php echo $this->_tpl_vars['connect_info']['id']; ?>
";$("#verify_pwd").click(function(){
		$.post(root_domain + '/connect/ajax_connect.php'
	            , {	connect_id:connect_id,
					u_name: $("#u_name").val(),
					u_pwd:$("#u_pwd").val(),
					type:'verify_pwd'
	              }
	            , function(data) {
	            	alert(data.msg);if (data.ok) {
// 	            		window.location.reload(true);} else {
	            		
	            	}
	            }
	            , 'json'
	        );});$("#verify_uname").click(function(){
		$.post(root_domain + '/connect/ajax_connect.php'
	            , {	connect_id:connect_id,
					u_name: $("#u_name1").val(),
					type:'verify_uname'
	              }
	            , function(data) {
	            	alert(data.msg);if (data.ok) {
// 	            		window.location.reload(true);} else {
	            		
	            	}
	            }
	            , 'json'
	        );});$("#bind_user").click(function(){
		$.post(root_domain + '/connect/ajax_connect.php'
	            , {	connect_id:connect_id,
					u_name: $("#u_name").val(),
					u_pwd:$("#u_pwd").val(),
					type:'bind_user'
	              }
	            , function(data) {
	            	alert(data.msg);if (data.ok) {
// 	            		window.location.reload(true);} else {
	            		
	            	}
	            }
	            , 'json'
	        );});$("#create_new").click(function(){
		$.post(root_domain + '/connect/ajax_connect.php'
	            , {	connect_id:connect_id,
					u_name: $("#u_name1").val(),
					type:'create_new'
	              }
	            , function(data) {
	            	alert(data.msg);if (data.ok) {
// 	            		window.location.reload(true);} else {
	            		
	            	}
	            }
	            , 'json'
	        );});});</script>
</head><body>
<div class="head">
  <h1><a href="/"><i>第三方联合登录</i></a></h1>
</div>
<div class="loginC">
  <div class="loginCleft">
    <h1 style="font-size:20px; font-family:'微软雅黑';font-weight:300;height:70px;line-height:20px;padding:0 0 0 20px;"><img src="http://www.shunjubao.xyz/www/statics/i/scrollTip.gif" style=" position:relative;top:4px;">&nbsp;&nbsp;您正在使用<b style="color:#dc0000;font-size:20px;">“<?php echo $this->_tpl_vars['typeDesc'][$this->_tpl_vars['connect_info']['type']]['desc']; ?>
帐号”</b>登录聚宝网！</h1>
    <?php if ($this->_tpl_vars['same_user']): ?>
    <div class="error"> 您的用户名在聚宝网已经被注册过！</div>
    <?php endif; ?>
    <dl>
      <dt>用户名</dt>
      <dd>
        <input type='text'  style="width:135px;" id='u_name1' value="<?php echo $this->_tpl_vars['connect_info']['c_name']; ?>
"/>
        <input type='button' style="width:115px;height:34px;line-height:30px;top:1px;" class="code" value='验证用户名' id="verify_uname"/>
      </dd>
    </dl>
    <dl>
      <dt></dt>
      <dd class="tijiao">
        <input type='submit' value='创建新帐号' id="create_new"/>
      </dd>
    </dl>
    <dl>
      <dt>已有帐号</dt>
      <dd>
        <input type='text' class="inputc1" id='u_name' value=""/>
      </dd>
    </dl>
    <dl>
      <dt>登录密码</dt>
      <dd>
        <input type='password' style="width:135px;" id='u_pwd' value=""/>
        <input type='button' style="width:115px;height:34px;line-height:30px;top:1px;" class="code" value='验证密码' id="verify_pwd"/>
      </dd>
    </dl>
    <dl>
      <dt></dt>
      <dd class="tijiao">
        <input type='submit' value='关联此帐号' id="bind_user"/>
      </dd>
    </dl>
  </div>
  <div class="loginRight">
    <h1>合作网站登录</h1>
    <p>用合作站账号直接登录，方便又快捷。 </p>
    <p>用户购彩信息，保证您的隐私和安全。</p>
    <p>合作站账户操作便捷，购彩、充值提款畅通无阻。</p>
  </div>
  <div class="clear"></div>
</div>
<!--页面底部-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--页面底部-->
