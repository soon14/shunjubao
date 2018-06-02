<?php /* Smarty version 2.6.17, created on 2018-03-05 03:22:30
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
<body>
<!--页面头部 start-->
<div class="top">
  <h3>注册聚宝<a href="/">返回</a></h3>
  <div class="logo none">
    <h1 ><a href="/">聚宝网</a><em>注册</em></h1>
  </div>
</div>
<!--页面头部 end--
<!--center start-->
<div class="center">
  <div class="Codetips">
    <p class="<?php if ($this->_tpl_vars['msg']['u_name']): ?><?php else: ?>none<?php endif; ?>" id='tips1'> <?php if ($this->_tpl_vars['msg']['u_name']): ?><span id='u_name_err'><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><span class="none" id='tips1'></span><?php endif; ?> </p>
    <p class="<?php if ($this->_tpl_vars['msg']['newpas']): ?><?php else: ?>none<?php endif; ?>" id='tips2'> <?php if ($this->_tpl_vars['msg']['newpas']): ?><span><?php echo $this->_tpl_vars['msg']['newpas']; ?>
</span><?php else: ?>请输入密码<?php endif; ?> </font></p>
    <p class="<?php if ($this->_tpl_vars['msg']['repas']): ?><?php else: ?>none<?php endif; ?>" id='tips3'> <?php if ($this->_tpl_vars['msg']['repas']): ?><span><?php echo $this->_tpl_vars['msg']['repas']; ?>
</span><?php else: ?><span class="none"></span><?php endif; ?></p>
    <p class="<?php if ($this->_tpl_vars['msg']['mobile']): ?><?php else: ?>none<?php endif; ?>" id='tips4'> <?php if ($this->_tpl_vars['msg']['mobile']): ?><span><?php echo $this->_tpl_vars['msg']['mobile']; ?>
</span><?php else: ?><span class="none"></span><?php endif; ?></p>
    <p class="<?php if ($this->_tpl_vars['msg']['Validate_Code']): ?><?php else: ?>none<?php endif; ?>" id='tips5'><?php if ($this->_tpl_vars['msg']['Validate_Code']): ?><span id='Validate_Code_err'><?php echo $this->_tpl_vars['msg']['Validate_Code']; ?>
</span><?php else: ?><span class="none" id='tips5'></span><?php endif; ?></p>
  </div>
  <div class="biaodan">
    <div>
      <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/reg.php?refer=<?php echo $this->_tpl_vars['refer']; ?>
" name='frm_reg' id='frm_reg'>
        <dl>
          <dd>
            <input name="u_name" type="text" size="25" placeholder="用户名"  id='u_name'/>
          </dd>
        </dl>
        <dl>
          <dd>
            <input name="u_pwd" type="password" size="25" placeholder="登录密码"  id="u_pwd"/>
        </dl>
        <dl>
          <dd>
            <input name="repas" type="password" size="25" placeholder="确认密码"  id="repas"/>
          </dd>
        </dl>
        <dl>
          <dd>
            <input name="mobile" type="text" size="25"  placeholder="手机号"  id="mobile"  onBlur="hidetipsCode()"/>
          </dd>
        </dl>
        <dl>
          <dd style="position:relative;">
            <input id="Validate_Code" name="Validate_Code" maxlength="4" size="15"  type="text" class="form-control" style=" width:88%;" placeholder="验证码" onBlur="hidetipsCode()">
            &nbsp;&nbsp;<span style="position:absolute;right:-10px;top:-1px; width:180px; height:37px; line-height:37px;display:inline-table;display:inline-block;zoom:1;*display:inline; background:#fff;border-left:1px solid #ddd; padding:0 0 0 5px;"><a href="javascript:void(0);" onClick="reflash_image_reg()"><img src="/include/Imagecode/Imagecode.php" id="imgCaptcha" height="37" width="100"></a> <a class="refresh" href="javascript:void(0);" onClick="reflash_image_reg()" style="position:relative;top:-15px;">&nbsp;&nbsp;换一张</a></span></dd>
        </dl>
        <!--  <dl>
        <dt>短信验证码</dt>
        <dd style="border:none; position:relative;">
			<p style="float:left; width:55%; height:36px;display:inline-table;display:inline-block;zoom:1;*display:inline;color:#999;border:1px solid #ccc;border-radius:2px;"><input type="text" value="" id="code" name="code" onBlur="getcode()" style="width:100%; background:none;border:none;" /></p>
			<p style="float:right; position:absolute;left:55%; height:38px;width:45%;display:inline-table;display:inline-block;zoom:1;*display:inline; text-align:center; background:#6f6f6f;color:#fff;"><input type="button" value="发送短信验证码" onClick="sendcode()" id="settimecode" class="code" style="border:none; background:none; cursor:pointer; text-align:center;" /></p>
        </dd>  
      </dl>-->
        <div class="tijiao">
          <input name="submit" type="submit" value="注&nbsp;册"  />
        </div>
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
					$("#tips100").html('<span>验证码正确</span>');
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>