<?php /* Smarty version 2.6.17, created on 2018-05-23 23:16:12
         compiled from reg.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reg.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='reg.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<body>
<!--页面头部 start-->
<div class="head">
  <h1><a href="/"><i>用户注册</i></a></h1>
</div>
<!--页面头部 end--
<!--center start-->
<div class="loginC">
  <div class="loginCleft">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/reg.php?refer=<?php echo $this->_tpl_vars['refer']; ?>
" name='frm_reg' id='frm_reg'>
      <dl>
        <dt>用户名</dt>
        <dd>
          <input name="u_name" type="text" size="25"  id='u_name'/>
          <font class="<?php if ($this->_tpl_vars['msg']['u_name']): ?><?php else: ?>none<?php endif; ?>" id='tips1'> <?php if ($this->_tpl_vars['msg']['u_name']): ?><span class="" id='u_name_err'><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><u class="none" id='tips1'></u><?php endif; ?> </font> </dd>
      </dl>
      <dl>
        <dt>登录密码</dt>
        <dd>
          <input name="u_pwd" type="password" size="25"  id="u_pwd"/>
          <font class="<?php if ($this->_tpl_vars['msg']['newpas']): ?><?php else: ?>none<?php endif; ?>" id='tips2'> <?php if ($this->_tpl_vars['msg']['newpas']): ?><span class=""><?php echo $this->_tpl_vars['msg']['newpas']; ?>
</span><?php else: ?><u class="">请输入密码</u><?php endif; ?> </font> </dd>
      </dl>
      <dl>
        <dt>确认密码</dt>
        <dd>
          <input name="repas" type="password" size="25"  id="repas"/>
          <font class="<?php if ($this->_tpl_vars['msg']['repas']): ?><?php else: ?>none<?php endif; ?>" id='tips3'> <?php if ($this->_tpl_vars['msg']['repas']): ?><span class=""><?php echo $this->_tpl_vars['msg']['repas']; ?>
</span><?php else: ?><u class="none">&nbsp;&nbsp;</u><?php endif; ?> </font> </dd>
      </dl>
      <dl>
        <dt>手机号</dt>
        <dd>
          <input name="mobile" type="text" size="25"  id="mobile" onBlur="hidetipsCode()"  />
          <font class="<?php if ($this->_tpl_vars['msg']['mobile']): ?><?php else: ?>none<?php endif; ?>" id='tips4'> <?php if ($this->_tpl_vars['msg']['mobile']): ?><span class=""><?php echo $this->_tpl_vars['msg']['mobile']; ?>
</span><?php else: ?><u class="none">&nbsp;&nbsp;</u><?php endif; ?> </font> </dd>
      </dl>
       <dl>
       <dt>验证码</dt>
       <dd> <input id="Validate_Code" name="Validate_Code" maxlength="4" size="15" type="text" class="form-control" style=" width:130px;" placeholder="验证码" onBlur="hidetipsCode()" onFocus="hidetips5()">
       
       <font class="<?php if ($this->_tpl_vars['msg']['Validate_Code']): ?><?php else: ?>none<?php endif; ?>" id='tips5'><?php if ($this->_tpl_vars['msg']['Validate_Code']): ?><span class="" id='Validate_Code_err'><?php echo $this->_tpl_vars['msg']['Validate_Code']; ?>
</span><?php else: ?><u class="none" id='tips5'></u><?php endif; ?> </font> 
        <a href="javascript:void(0);" onClick="reflash_image_reg()"><img src="/include/Imagecode/Imagecode.php" id="imgCaptcha" height="40" width="100" style="position:relative;left:4px;"></a>
        <a class="refresh" href="javascript:void(0);" onClick="reflash_image_reg()">&nbsp;&nbsp;换一张</a>
         <font id="tipsCode" style="color:#F00;" class="none"></font>
        </dd>
      </dl>
      
      <!--<dl>
        <dt>短信验证码</dt>
        <dd>
          <input type="text" value="" style="width:135px;" id="code" name="code" onBlur="getcode()">
          <input type="text" value="发送短信验证码" style="width:110px;" onClick="sendcode()" id="settimecode" class="code">
          <font id="tips100" >
			<u class=""></u>
		  </font>
        </dd>
      </dl>-->
      <dl>
        <dt></dt>
        <dd class="tijiao">
          <input name="submit" type="submit" value="注&nbsp;册" class="loginsub" />
        </dd>
      </dl>
    </form>
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
	<p>已有帐号？<a href="http://www.shunjubao.xyz/passport/login.php" style="font-size:14px;color:#dc0000;">登录</a></p>
  </div>
  <div class="clear"></div>
</div>
<script>
	var i = 300;
	var intervalid;
	function fun() {
		if (i == 0) {
			clearInterval(intervalid);
			$("#settimecode").val("重新发送");
		}
		$("#settimecode").val(i+"s");
		i--;
	}
	
	
	function hidetipsCode(){
		$("#tipsCode").addClass("none");

	}
	function hidetips5(){
		$("#tips5").addClass("none");
	}
	
	function sendcode(){
		
		var mobile=$("#mobile").val();
		var Validate_Code = $("#Validate_Code").val();
		if(Validate_Code==''){
			$("#tipsCode").removeClass("none");
			$("#tipsCode").html("请先输入验证码");
			return false;
		}
		if(mobile==''){
			$("#tipsCode").removeClass("none");
			$("#tipsCode").html("请先输入手机号码");
			return false;
		}
	
		var url="/passport/sendcode.php";
		$.ajax({
			type:'post',
			url:url,
			data:{mobile:mobile,type:'sendcode',Validate_Code:Validate_Code},
			dataType:'html',
			success:function(data){
				if(data==1){
					$("#settimecode").val("发送成功");
					$("#settimecode").attr("disabled",true);
					intervalid = setInterval("fun()", 1000);
				}else if(data==5){
					$("#tipsCode").removeClass("none");
					$("#tipsCode").html("请输入正确的验证码！");
				}else{
					$("#settimecode").val("发送失败，重新发送");
				}
			}
		});
	}

	function getcode(){
		var code=$("#code").val();
		var url="/passport/sendcode.php";
		$.ajax({
			type:'post',
			url:url,
			data:{code:code,type:'checkcode'},
			dataType:'html',
			success:function(data){	
				$("#tips100").removeClass("none");
				if(data==1){
					$("#tips100").html('<u>验证码正确</u>');
				}else{
					$("#tips100").html('<span>验证码错误</span>');
				}
			}
		});
	}
	
	function reflash_image_reg(){
		var el = document.getElementById("imgCaptcha");
		 var now = new Date();
		el.src="/include/Imagecode/Imagecode.php?x=" + now.toUTCString();
	}	
	
</script>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>