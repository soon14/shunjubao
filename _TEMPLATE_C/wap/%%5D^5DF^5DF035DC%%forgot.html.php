<?php /* Smarty version 2.6.17, created on 2017-10-18 10:56:06
         compiled from forgot.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<div class="top">
  <h3>找回密码<a href="/">返回</a></h3>
  <div class="logo none">
    <h1 ><a href="/">聚宝网</a><em>找回密码</em></h1>
  </div>
</div>
<div class="center">
  <div class="biaodan">
    <form method="post" action="<?php echo $this->_tpl_vars['smart']['const']['ROOT_DOMAIN']; ?>
/passport/reset.php" name='f' id='f' >
      <dl>
        <dt></dt>
        <dd>
          <input name="mobile" id="mobile" placeholder="手机号" type="text" size="25" />
        </dd>
      </dl>
      <dl>
        <dd style="position:relative;">
          <input id="Validate_Code" name="Validate_Code" maxlength="4" size="15" type="text" class="form-control" style=" width:88%;" placeholder="验证码" onBlur="hidetipsCode()">
          <span style="position:absolute;right:-10px;top:-1px; width:180px; height:37px; line-height:37px;display:inline-table;display:inline-block;zoom:1;*display:inline; background:#fff;border-left:1px solid #ddd; padding:0 0 0 5px;"><a href="javascript:void(0);" onClick="reflash_image_reg()"><img src="/include/Imagecode/Imagecode.php" id="imgCaptcha" height="37" width="100"></a> <a class="refresh" href="javascript:void(0);" onClick="reflash_image_reg()" style="position:relative;top:-15px;">&nbsp;&nbsp;换一张</a></span> <font id="tipsCode" style="color:#F00;" class="none"></font> </dd>
      </dl>
      <dl>
        <dd style="border:none; position:relative;">
          <p style="float:left; width:55%; height:36px;display:inline-table;display:inline-block;zoom:1;*display:inline;color:#999;border:1px solid #ccc;border-radius:2px;">
            <input name="code" type="text" size="25" placeholder="短信验证码" style="width:100%; background:none;border:none;" id="code"/>
          </p>
          <p style="float:right; position:absolute;left:55%; height:38px;width:45%;display:inline-table;display:inline-block;zoom:1;*display:inline; text-align:center; background:#6f6f6f;color:#fff;">
            <input name="getcode" type="button" value="发送短信验证码" size="25" id="getcode" onClick="send_message()"  style="border:none; background:none; cursor:pointer; text-align:center;"/>
          </p>
        </dd>
      </dl>
      <div class="tips" id="tips"><?php if ($this->_tpl_vars['msg']): ?><?php echo $this->_tpl_vars['msg']; ?>
<?php endif; ?></div>
      <div class="tijiao">
        <input name="button" type="button" value="点击找回密码"  onClick="resetsub()"/>
        <input name="hadsend"  id="hadsend" type="hidden" value="1">
      </div>
    </form>
  </div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
<script>
function resetsub(){	
	var mobile = $("#mobile").val();
	if(mobile==''){
		$("#tips").html('手机号不能为空！');
		return false;
	}	
	var code = $("#code").val();
	if(code==''){
		$("#tips").html('验证码不能为空！');
		return false;
	}
	var hadsend = $("#hadsend").val();
	if(hadsend == '0'){
		$("#tips").html('请先发送验证码！');
		return false;
	}
	$("#f").submit();
}

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
	
	
	$("#tips").html('');
	var mobile = $("#mobile").val();
	if(mobile == ''){
		 $("#tips").html('请先输入您注册时使用的手机号！');
		return;
	}

	var Validate_Code = $("#Validate_Code").val();
	if(Validate_Code==''){
		$("#tipsCode").removeClass("none");
		$("#tipsCode").html("请先输入验证码");
		return false;
	}

	
	$.ajax({
			type:'POST', 
			url: Domain + '/sms/send.php', 
			data:'mobile='+mobile+'&Validate_Code='+Validate_Code, 
			dataType: 'json', 
			success: function(data) {
				if (data.ok) {
					$("#hadsend").val('1');
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
</body>
</html>