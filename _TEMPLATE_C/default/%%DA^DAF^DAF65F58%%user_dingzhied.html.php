<?php /* Smarty version 2.6.17, created on 2018-03-05 05:29:12
         compiled from user_dingzhied.html */ ?>
<!DOCTYPE html>
<head>
<title>定制我的-定制管理-用户中心-智赢网</title>
<meta name="keywords" content="智赢竞彩,智赢网,智赢跟单定制管理" />
<meta name="description" content="定制我的，定制管理，智赢定制跟单不错失任何一红单。" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="http://www.zhiying365365.com/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link href="http://www.zhiying365365.com/www/statics/c/footer.css" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="http://www.zhiying365365.com/www/statics/c/user.css" >
<!--用户中心我的定制 start-->

<div>
  <div class="rightcenetr">
    <h1><span>▌</span>定制管理-定制我的</h1>
  </div>
  <div class="msg" style="text-align:left;">
    <div class="tabuser">
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_dingzhi.php" >我的定制</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_dingzhied.php" class="active">定制我的</a></li>
      </ul>
    </div>
    <div style="padding:20px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <th>定制我的</th>
          <th align="center">开始时间</th>
          <th align="center">截止时间</th>
          <th align="center">定制周期</th>
          <th align="center">定制倍数</th>
          <th align="center">当前状态</th>
          <th align="center">操作时间</th>
        </tr>
        <?php $_from = $this->_tpl_vars['dingzhi_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item']['iteration']++;
?>
        <tr>
          <td><?php echo $this->_tpl_vars['item']['u_name']; ?>
</td>
          <td align="center" style="color:#999;"><?php echo $this->_tpl_vars['item']['start_time']; ?>
</td>
          <td align="center" style="color:#999;"><?php echo $this->_tpl_vars['item']['end_time']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['cycle_show']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['multiple']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['status_show']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        
        <?php if (! $this->_tpl_vars['dingzhi_array']): ?>
        <tr>
          <td colspan="7" class="show" style="border-bottom:none; background:#FFFFCC;">暂时没有定制的信息!</td>
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
<!--用户中心我的定制 end-->
</body></html>