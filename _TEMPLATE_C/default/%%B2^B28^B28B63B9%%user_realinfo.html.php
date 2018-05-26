<?php /* Smarty version 2.6.17, created on 2017-10-15 18:02:03
         compiled from user_realinfo.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_realinfo.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
<script type="text/javascript">
TMJF(function($) {
	$("#submit").submit(function(){
		if ($("#realname").val() == '') {
			alert('真实姓名不能为空');
			return false;
		}
		if ($("#idcard").val() == '') {
			alert('身份证号不能为空');
			return false;
		}
		if ($("#reidcard").val() != $("#idcard").val()) {
			alert('两次身份证号不一致');
			return false;
		}
		return true;
	});
});
function checksub(){
	if ($("#realname").val() == '') {
		alert('真实姓名不能为空');
		return false;
	}
	var reg=/^[1-9]{1}[0-9]{14}$|^[1-9]{1}[0-9]{16}([0-9]|[xX])$/;
	var idcard=$("#idcard").val();
	if(!reg.test(idcard)){
		alert("身份证号不正确");
		return false;
	}
	if ($("#idcard").val() == '') {
		alert('身份证号不能为空');
		return false;
	}
	if ($("#reidcard").val() != $("#idcard").val()) {
		alert('两次身份证号不一致');
		return false;
	}

	if ($("#mobile").val() =='') {
		alert('请输入手机号');
		return false;
	}

	if ($("#code").val() =='') {
		alert('请输入手机验证码');
		return false;
	}

	if ($("#Validate_Code").val() =='') {
		alert('请输入验证码');
		return false;
	}
}
</script>
<!--实名认证 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>我的账户-实名认证 </h1>
    <div style="padding:50px 0 0 0;">
      <div class="tabuser">
        <ul>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" class="active">实名认证</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php">绑定银行卡</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">绑定支付宝</a></li>
        </ul>
      </div>
    </div>
    <style>
.userbiaodan dl dt{display:inline-table;display:inline-block;zoom:1;*display:inline;width:100px;text-align:right;margin:0 10px 0 0;}
	</style>
    <h2><em>!</em>真实姓名是您提款时的重要依据，填写后不可更改。网站不向未满18周岁的青少年出售彩票。</h2>
    <form method="post" id="submit" onSubmit="return checksub();">
      <div class="userbiaodan">
        <dl>
          <dt>真实姓名：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>

            <?php else: ?>
            <input type="text" class="ustext" name="realname" id="realname"/>
            <?php endif; ?></dd>
        </dl>
        <dl>
          <dt>身份证号：</dt>
          <dd><?php if ($this->_tpl_vars['userRealInfo']['idcard']): ?>
            <?php echo $this->_tpl_vars['userRealInfo']['idcard']; ?>

            <?php else: ?>
            <input type="text" name="idcard"  id="idcard"/>
            <span>正确的身份证号码为15-18的数字，请您正确的输入。</span> </dd>
          <?php endif; ?>
        </dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['idcard']): ?>
        <dl>
          <dt>再次确认：</dt>
          <dd>
            <input type="text" name="reidcard" id="reidcard"/>
            <span>请再输入一次您的身份证号码。</span></dd>
        </dl>
        <dl>
          <dt>验证码：</dt>
          <dd style="position:relative;">
            <input id="Validate_Code" name="Validate_Code" maxlength="4" size="15" type="text"   style=" width:178px;" placeholder="&nbsp;验证码" >
            <span style=" position:absolute;left:184px; top:0; width:300px;display:inline-table;display:inline-block;zoom:1;*display:inline;"><a href="javascript:void(0);" onClick="reflash_image_reg()"><img src="/include/Imagecode/Imagecode.php" id="imgCaptcha" height="36" width="108" ></a>&nbsp;<a class="refresh" href="javascript:void(0);" onClick="reflash_image_reg()" style="position:relative;top:-13px;">换一张</a></span> </dd>
        </dl>
        <dl>
          <dt>手机号码：</dt>
          <dd>
            <input name="mobile" type="text" size="25"  id="mobile" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
"  />
            <span>请输入您的手机号码。</span></dd>
        </dl>
        <dl>
          <dt>短信验证码：</dt>
          <dd>
            <input type="text" value="" style="width:178px;" id="code" name="code" onBlur="getcode()">
            <input type="text" value="发送短信验证码" style="width:110px;" onClick="send_message()" id="settimecode" class="code">
            <span>请输入您收到的短信验证码。</span> </dd>
        </dl>
        <dl>
          <dt></dt>
          <dd> <span id="showtips"></span> </dd>
        </dl>
        <dl>
          <dt></dt>
          <dd>
            <input type="submit" class="sub" value="提&nbsp;&nbsp;&nbsp;交" />
          </dd>
        </dl>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['msg_error']): ?>
        <dl>
          <dt></dt>
          <dd> <?php echo $this->_tpl_vars['msg_error']; ?>
 </dd>
        </dl>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['msg_success']): ?>
        <dl>
          <dt></dt>
          <dd> <?php echo $this->_tpl_vars['msg_success']; ?>
 </dd>
        </dl>
        <?php endif; ?> </div>
    </form>
    <div class="imgtips">
      <p>温馨提示：</b>1)暂不支持港澳台身份证，军官证，护照等相关证件进行实名认证。如果您没有中国大陆内地身份证，请咨询客服热线010-64344882。
        2)您的个人信息将被严格保密，不会用于任何第三方用途。如有问题，请联系我们的客服。</p>
    </div>
  </div>
</div>
<script>
	function getcode(){					
	var count = 60;
	var countdown = setInterval(CountDown, 1000);
	function CountDown() {
		$("#getcode").attr("disabled", true);
		$("#getcode").val("已发送," + count + "秒可重发");
		if (count == 0) {
			$("#getcode").val("获取验证码").removeAttr("disabled");
			clearInterval(countdown);
		}
		count--;
	}
}

function send_message(){
	$("#showtips").html('');
	var mobile = $("#mobile").val();
	if(mobile == ''){
		 $("#showtips").html('请先输入您注册时使用的手机号！');
		return;
	}

	var Validate_Code = $("#Validate_Code").val();
	if(Validate_Code==''){
		$("#showtips").html('请先输入验证码！');
		return false;
	}

	
	$.ajax({
			type:'POST', 
			url: Domain + '/sms/send_realinfo.php', 
			data:'mobile='+mobile+'&Validate_Code='+Validate_Code, 
			dataType: 'json', 
			success: function(data) {
				if(data=="-1"){
					alert('请输入正确的验证码！');
					return;
				}
				
				if (data.ok) {
					getcode();
					$("#showtips").html('已发送，请在手机上查看验证码！');
					return;
				} else {
					
					$("#showtips").html('' + data.msg);
					return;
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
<!--实名认证 end-->
</body>
</html>