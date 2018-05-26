<?php /* Smarty version 2.6.17, created on 2018-03-09 06:35:30
         compiled from user_money_tran.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_money_tran.html', 1, false),)), $this); ?>
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
.tabuser{padding:30px 0 0 0;}
.tabuser ul{display:inline-table;display:inline-block;zoom:1;*display:inline;height:40px;line-height:40px;border-bottom:1px solid #ddd;width:100%; margin:0; padding:0;}
.tabuser ul li{display:inline-table;display:inline-block;zoom:1;*display:inline;margin:0 0 0 5px;}
.tabuser ul li a{display:inline-table;display:inline-block;zoom:1;*display:inline;padding:0 15px;color:#000;font-size:14px; text-decoration:none;}
.tabuser ul li a.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-1px;font-weight:300; font-family:'';}
.tabuser ul li.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-2px;font-weight:300;}
</style>
<!--积分兑换 start-->
<div class="rightcenetr">
  <h1><span>▌</span>余额换积分</h1>
  <div class="tabuser">
     <ul>
      <li><a href="http://www.shunjubao.xyz/account/user_gift_tran.php">彩金兑换积分</a></li>
      <li><a href="http://www.shunjubao.xyz/account/user_score_tran.php">积分兑换彩金</a></li>
      <li><a href="http://www.shunjubao.xyz/account/user_money_tran.php" class="active">余额兑换积分</a></li>
    </ul>
  </div>
  <div>
    <h2 style="font-size:14px;">您的余额：<span><?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
</span>&nbsp;&nbsp;可兑换积分：<span><?php echo $this->_tpl_vars['gift']; ?>
</span></h2>
    <div class="userbiaodan">
      <form action="" method="post" id="submit">
        <dl>
          <dt>兑换积分：</dt>
          <dd style="position:relative;left:-50px;">
            <input type="text" name="cash" value="<?php echo $this->_tpl_vars['userAccountInfo']['cash']; ?>
" id="cash"/>
            <input type="submit" class="sub" style="width:80px; height:30px; line-height:30px; position:relative;top:1px;border-radius:3px;" value="兑&nbsp;&nbsp;换" />
            <input type='hidden' name='action' value='tran'/>
          </dd>
        </dl>
        <?php if ($this->_tpl_vars['msg_error']): ?>
        <dl style="position:relative;left:-50px;">
          <dt></dt>
          <dd style="color:red;"> <?php echo $this->_tpl_vars['msg_error']; ?>
 </dd>
        </dl>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['msg_success']): ?>
        <dl style="position:relative;left:-50px;">
          <dt></dt>
          <dd style="color:red;"> <?php echo $this->_tpl_vars['msg_success']; ?>
 </dd>
        </dl>
        <?php endif; ?>
      </form>
    </div>
    <br/>
    <div  style=" font-size:12px;color:#777;">
      <p>特别说明：一旦兑换，将从您账户余额扣除相对的额度；积分不能兑换余额，但可兑换彩金。</p>
    </div>
  </div>
</div>
<!--积分兑换 end-->
</body>
</html>