<?php /* Smarty version 2.6.17, created on 2017-11-06 08:08:18
         compiled from user_realinfo.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
			
		
		return true;
	});
});
</script>
<!--实名认证 start-->
<div class="center">
  <div class="NavphTab">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_realinfo.php" class="active">实名认证</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_bank.php">绑定银行卡</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_payment.php">绑定支付宝</a></td>
      </tr>
    </table>
  </div>
  <div class="tipss">
    <p><b>温馨提示：</b></p>
    <p>1）名认证只是为了更加确保账户的安全；</p>
    <p>2）真实姓名是您提款时的重要依据。</p>
  </div>
  <form method="post" id="submit">
    <div class="biaodan"> <?php if ($this->_tpl_vars['msg_error']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_error']; ?>
</div>
      <?php endif; ?>
      <?php if ($this->_tpl_vars['msg_success']): ?>
      <div class="tips"><?php echo $this->_tpl_vars['msg_success']; ?>
</div>
      <?php endif; ?>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['realname']): ?>
        <dt>真实姓名 <span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['realname']; ?>
<span></dt>
        <?php else: ?>
        <dd>
          <input type="text" name="realname" placeholder="真实姓名" id="realname"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if ($this->_tpl_vars['userRealInfo']['idcard']): ?>
        <dt> 身份证号<span style="float:right; position:relative;right:0;"><?php echo $this->_tpl_vars['userRealInfo']['idcard']; ?>
<span></dt>
        <?php else: ?>
        <dd>
          <input type="text" name="idcard" placeholder="身份证号"  id="idcard"/>
        </dd>
        <?php endif; ?>
      </dl>
      <dl>
        <?php if (! $this->_tpl_vars['userRealInfo']['idcard']): ?>
        <dd>
          <input type="text" name="reidcard" placeholder="再次确认" id="reidcard"/>
        </dd>
      </dl>
      <dl>
        <dd style="position:relative;">
          <input id="Validate_Code" name="Validate_Code" maxlength="4" size="15" type="text"  style="width:88%;" placeholder="验证码" >
          <span style="position:absolute;right:-10px;top:-1px; width:180px; height:37px; line-height:37px;display:inline-table;display:inline-block;zoom:1;*display:inline; background:#fff;border-left:1px solid #ddd; padding:0 0 0 5px;"><a href="javascript:void(0);" onClick="reflash_image_reg()"><img src="/include/Imagecode/Imagecode.php" id="imgCaptcha" height="37" width="100"></a> <a class="refresh" href="javascript:void(0);" onClick="reflash_image_reg()" style="position:relative;top:-15px;">&nbsp;&nbsp;换一张</a></span> </dd>
      </dl>
      <dl>
        <dd>
          <input name="mobile" type="text" size="25"  placeholder="" id="mobile" value="<?php echo $this->_tpl_vars['userRealInfo']['mobile']; ?>
"  />
        </dd>
      </dl>
      <dl>
        <dd style="border:none; position:relative;">
          <p style="float:left; width:55%; height:36px;display:inline-table;display:inline-block;zoom:1;*display:inline;color:#999;border:1px solid #ccc;border-radius:2px;">
            <input type="text" value="" style="width:85%;" id="code" placeholder="短信验证码" name="code" onBlur="getcode()">
          </p>
          <p style="float:right; position:absolute;left:55%; height:38px;width:45%;display:inline-table;display:inline-block;zoom:1;*display:inline; text-align:center; background:#6f6f6f;color:#fff;">
            <input type="text" value="发送短信验证码" style=" background:none; text-align:center;" onClick="send_message()" id="settimecode" class="code">
          </p>
        </dd>
      </dl>
      <div style="padding:5px 0; text-align:left; width:88%; margin:0 auto;color:#dc0000;">
        <div id="showtips" style="border:none;"></div>
      </div>
      <div class="tijiao">
        <input type="submit" value="提&nbsp;&nbsp;&nbsp;交" />
      </div>
      <?php endif; ?> </div>
  </form>
</div>
<!--实名认证 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
</body>
</html>