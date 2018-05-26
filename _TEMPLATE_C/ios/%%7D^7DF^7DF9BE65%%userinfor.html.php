<?php /* Smarty version 2.6.17, created on 2016-04-06 15:51:17
         compiled from userinfor.html */ ?>
<div class="Userlocation" style="display:none;">
  <dl>
    <dt><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php" target="rightFrame"> <img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /></a></dt>
    <dd class="first"><strong><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</strong></dd>
    <dd><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php">充值</a></dd>
    <dd><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_withdraw.php" class="hover">提现</a></dd>
  </dl>
</div>
