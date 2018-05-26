<?php /* Smarty version 2.6.17, created on 2016-04-08 23:38:11
         compiled from trans_user.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
</head>
<body>
<div class="top">
  <h3>您正在使用<b>“<?php echo $this->_tpl_vars['typeDesc'][$this->_tpl_vars['connect_info']['type']]['desc']; ?>
帐号”</b>登录智赢网</h3>
  <div class="logo none">
    <h1 ><a href="/">智赢网</a><em>注册</em></h1>
  </div>
</div>
<div class="tips"><?php if ($this->_tpl_vars['same_user']): ?><em>!</em>&nbsp;您的用户名在智赢网已经被注册过
  <?php endif; ?></div>
<div class="biaodan">
  <dl>
    <dt>用户姓名</dt>
    <dd>
      <input type='text' id='u_name1' value="<?php echo $this->_tpl_vars['connect_info']['c_name']; ?>
"/>
    </dd>
  </dl>
  <p>
    <input type='button' value='验证用户名' style="border:1px solid #999;" id="verify_uname" />
  </p>
  <dl>
    <dt>已有帐号</dt>
    <dd>
      <input type='text' id='u_name' value=""/>
    </dd>
  </dl>
  <div class="tijiao">
    <input type='submit' style=" background:#fff;color:#000;" value='创建新帐号' id="create_new"/>
  </div>
  <dl>
    <dt>帐号密码</dt>
    <dd>
      <input type='password' id='u_pwd' value=""/>
    </dd>
  </dl>
  <p>
    <input type='button' style="border:1px solid #999;" value='验证密码' id="verify_pwd"/>
  </p>
  <div class="tijiao">
    <input type='submit' value='关联帐号' id="bind_user"/>
  </div>
</div>
<!--页面底部-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--页面底部-->