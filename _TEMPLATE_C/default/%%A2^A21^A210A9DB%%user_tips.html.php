<?php /* Smarty version 2.6.17, created on 2018-03-05 05:30:18
         compiled from user_tips.html */ ?>
<!DOCTYPE html><head>
<title>我的打赏-打赏管理-用户中心-聚宝网</title>
<meta name="keywords" content="聚宝竞彩,聚宝网,聚宝跟单打赏管理" />
<meta name="description" content="我的打赏，打赏管理，聚宝打赏跟单不错失任何一红单。" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://www.shunjubao.xyz/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link href="http://www.shunjubao.xyz/www/statics/c/footer.css" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/user.css" >
<!--用户中心我的打赏 start-->


<div>
  <div class="rightcenetr">
    <h1><span>▌</span>账户明细-我的打赏</h1>
  </div>
  <div class="msg" style="text-align:left;">
    <div class="tabuser">
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">账户明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_gift_log.php">彩金明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge_log.php">充值记录</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php">提现记录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_ticket_log.php">奖金派送</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_follow_prize.php">提成明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php" class="active">我的打赏</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php">打赏我的</a></li>
		<li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">我的推广</a></li>
      </ul>
    </div>
    <div style="padding:15px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <th align="left">打赏用户</th>
          <th align="center">打赏订单</th>
          <th align="center">打赏时间</th>
          <th align="right">金额</th>
        </tr>
        <?php $_from = $this->_tpl_vars['data_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item']['iteration']++;
?>
        <tr>
          <td><div align="left"><?php echo $this->_tpl_vars['item']['u_name']; ?>
</div></td>
          <td align="center"><?php echo $this->_tpl_vars['item']['ticket_id']; ?>
</td>
          <td align="center" style="color:#999;"><?php echo $this->_tpl_vars['item']['addtime']; ?>
</td>
          <td align="right"><?php echo $this->_tpl_vars['item']['addtips_money']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['total_money'] > 0): ?>
        <tr>
          <td colspan="5" class="show" style="border-bottom:none; background:#FFFFCC;">小计:<?php echo $this->_tpl_vars['total_money']; ?>
元</td>
        </tr>
        <?php endif; ?>
        
        <?php if (! $this->_tpl_vars['data_array']): ?>
        <tr>
          <td colspan="5" class="show" style="border-bottom:none; background:#FFFFCC;">暂时没有打赏的信息!</td>
        </tr>
        <?php endif; ?>
      </table>
    </div>
  </div>
  <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
  <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
    <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
  <?php endif; ?>
  <?php endif; ?> </div>
<!--用户中心我的打赏 end-->
</body></html>