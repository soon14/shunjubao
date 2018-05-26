<?php /* Smarty version 2.6.17, created on 2018-03-12 03:34:32
         compiled from user_money_tran.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_money_tran.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script language="javascript">
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
</script>
<body>
<script type="text/javascript">
$(function() {
	$("#submit").submit(function(){
		if(isNaN($("#cash").val())) {
			alert('请输入正确的数字');
			return false;
		}
		if (!confirm('兑换过程不可逆，您确定兑换？')) {
			return false;
		}
		return true;
	});
});
</script>
<style>
.Jifenes{width:98%;margin:0 auto;text-align:left;line-height:24px;font-size:14px; padding:20px 0;}
.Jifenes dl{ height:40px; line-height:40px;}
.Jifenes dl dt{ float:left;}
.Jifenes dl dd{ float:right;}
.jftext{border:none; background:none; height:28px; line-height:28px; width:100%; padding:2px 0; text-align:center;font-size:14px;color:#888;}
.jfsub{border:none; background:none;color:#fff; height:41px; line-height:32px; width:100%;display:block;font-size:14px; border-radius:2px;}
.Jifenes dl.active{ padding:15px 0 30px 0;}
.Jifenes dl.active input{}
.Jftips{ height:40px; line-height:40px;color:#dc0000; font-size:14px;margin:auto auto 10px auto;}
.Jftips em{ width:20px; height:20px; line-height:20px; text-align:center;color:#fff; background:#dc0000; margin:0 5px;display:inline-table;display:inline-block;zoom:1;*display:inline; font-style:normal;border-radius:20px;}
.Jifenes p{color:#555;}
.Jifenes p b{ font-weight:900;color:#000; background:#f1f1f1;display:block; height:30px; line-height:30px; margin:0 0 25px 0;border-left:2px solid #dc0000; padding:0 0 0 5px;}
.Jifenes p.right{color:#dc0000;height:30px;line-height:30px;}
.Jifenes p.error{color:#dc0000;height:30px;line-height:30px;}
.NavphTab{ width:98%; margin:0 auto; }
.NavphTab table{}
.NavphTab table tr{}
.NavphTab table tr td{background:#fff;}
.NavphTab table tr td a{color:#000;font-weight:300;font-size:14px;border-bottom:2px solid #ddd;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000;}
</style>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--积分兑换 start-->
<div class="NavphTab">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="http://m.zhiying365365.com/account/user_score_tran.php">积分换彩金</a></td>
      <td><a href="http://m.zhiying365365.com/account/user_gift_tran.php">彩金换积分</a></td>
      <td><a href="http://m.zhiying365365.com/account/user_money_tran.php" class="active">余额换积分</a></td>
    </tr>
  </table>
</div>
<div class="Jifenes">
  <form action="" method="post" id="submit">
    <dl>
      <dt>您的余额</dt>
      <dd><?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
元</dd>
    </dl>
    <dl>
      <dt>可兑换积分</dt>
      <dd><?php echo $this->_tpl_vars['gift']; ?>
</dd>
    </dl>
    <dl>
      <dt>输入要兑换积分额度，1块钱等于10积分！</dt>
    </dl>
    <dl class="active">
      <dt style="width:69%;border:1px solid #ddd;">
        <input type="text" name="cash" value="<?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
" class="jftext" id="cash"/>
      </dt>
      <dd style="width:30%; background:#dc0000;color:#fff;">
        <input type="submit" value="兑&nbsp;&nbsp;换" class="jfsub" />
        <input type='hidden' name='action' value='tran'/>
      </dd>
    </dl>
    <?php if ($this->_tpl_vars['msg_error']): ?>
    <dl style="line-height:20px; line-height:20px;">
      <dt><?php echo $this->_tpl_vars['msg_error']; ?>
 </dt>
    </dl>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['msg_success']): ?>
    <dl style="line-height:20px; line-height:20px;">
      <dt><?php echo $this->_tpl_vars['msg_success']; ?>
 </dt>
    </dl>
    <?php endif; ?>
  </form>
  <p><b>特别说明</b></p>
  <div>
    <p>一旦兑换，将从您账户余额扣除相对的额度；积分不能兑换余额，但可兑换彩金。</p>
  </div>
</div>
<!--积分兑换 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>