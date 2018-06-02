<?php /* Smarty version 2.6.17, created on 2016-02-20 22:45:55
         compiled from forgot.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
		 $("#tips").html('请输入注册时使用的手机号！');
		return;
	}
	$.ajax({
			type:'POST', 
			url: Domain + '/sms/send.php', 
			data:'mobile='+mobile, 
			dataType: 'json', 
			success: function(data) {
				if (data.ok) {
					$("#hadsend").val('1');
					getcode();
					 $("#tips").html('短信验证码已经发送至您手机！');
					return;
				} else {
					$("#tips").html('' + data.msg);
					return;
				}
			}
		});	
	}
</script>
</head>
<body>
<div class="top">
  <h3>找回密码-聚宝网</h3>
  <div class="logo none">
    <h1 ><a href="/">聚宝网</a><em>找回密码</em></h1>
  </div>
</div>
<div class="center">
  <div class="biaodan">
    <form method="post" action="<?php echo $this->_tpl_vars['smart']['const']['ROOT_DOMAIN']; ?>
/passport/reset.php" name='f' id='f' >
      <div class="tips" id="tips" style="height:50px; line-height:24px; padding:25px 0 0 0;"><?php if ($this->_tpl_vars['msg']): ?><?php echo $this->_tpl_vars['msg']; ?>
<?php endif; ?></div>
      <dl>
        <dt>手机号</dt>
        <dd>
          <input name="mobile" id="mobile"  type="text" size="25" />
        </dd>
      </dl>
      <dl>
        <dt>验证码</dt>
        <dd>
          <input name="code" type="text" size="25" id="code"/>
      </dl>
      <div class="link">
        <input name="getcode" type="button" value="发送验证码" size="25" id="getcode" onClick="send_message()" style="font-size:14px; background:none; border:none;color:#999; text-align:left; position:relative;left:-15px;" />
      </div>
      </dl>
      <div class="tijiao">
        <input name="button" type="button" value="点击找回密码"  onClick="resetsub()"/>
        <input name="hadsend"  id="hadsend" type="hidden" value="1">
      </div>
    </form>
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