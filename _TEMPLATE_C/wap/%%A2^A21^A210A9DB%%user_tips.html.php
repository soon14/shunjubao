<?php /* Smarty version 2.6.17, created on 2017-11-06 08:41:06
         compiled from user_tips.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
.shaidantable{border-top:none; margin:20px auto; width:98%; font-size:12px;}
.shaidantable table{text-align:center;border-bottom-width:0;border-collapse:collapse;background:#fff;margin:0 0 30px 0;}
.shaidantable table tr{}
.shaidantable table tr:hover{background:#f9f9f9;}
.shaidantable table tr th{height:34px;line-height:34px;font-weight:300; background:#eee;}
.shaidantable table tr th span{ padding:0 0 0 10px;}
.shaidantable table tr td{height:36px;line-height:36px;border-bottom:1px solid #eee;}
.shaidantable table tr td.first{text-align:left;}
.shaidantable table tr td b{ont-weight:300;}
.shaidantable table tr td u{text-decoration:none;color:#666;}
.shaidantable table tr td em{border:1px solid #dc0000;padding:5px 7px;display:inline-table;display:inline-block;zoom:1;*display:inline;height:12px;line-height:12px;position:relative;top:-3px;left:10px;font-style:normal;color:#dc0000;}
.shaidantable table tr td b span{position:relative;top:-3px;}
.shaidantable table tr td b img{width:30px;height:30px;border:1px solid #ccc;border-radius:30px;margin:0 10px 0 2px;position:relative;top:7px;}
.shaidantable table tr td a{border:1px solid #ccc;color:#000;display:inline-table;display:inline-block;zoom:1;*display:inline;text-align:center;height:26px;line-height:26px; padding:0 8px;}
.shaidantable table tr td strong a:hover{}
.sharepages{ padding:30px 0 50px 0;}
.sharepages a{display:inline-table;display:inline-block;zoom:1;*display:inline; padding:8px 10px;border:1px solid #ccc;color:#000; margin:0 3px;}
.sharepages a:hover{color:#dc0000;border:1px solid #dc0000;}
.NavphTab{ width:98%; margin:0 auto; }
.NavphTab table{}
.NavphTab table tr{}
.NavphTab table tr td{background:#fff;}
.NavphTab table tr td a{color:#000;font-weight:300;font-size:14px;border-bottom:2px solid #ddd;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000; font-weight:300;}
</style>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--用户中心我的定制 start-->
<div>
  <div class="NavphTab">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php" class="active">我的打赏</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php" >打赏我的</a></td>
		<td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tips.php" style="color:#fff;">我的打赏</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_tipsed.php" style="color:#fff;">打赏我的</a></td>
      </tr>
    </table>
  </div>
  <div class="msg" style="text-align:left;">
    <div class="shaidantable">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <th align="left">&nbsp;我的打赏</th>
          <th align="center">打赏金额</th>
          <th align="center">晒单订单</th>
          <th align="center">打赏时间</th>
        </tr>
        <?php $_from = $this->_tpl_vars['data_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item']['iteration']++;
?>
        <tr>
          <td align="left">&nbsp;<?php echo $this->_tpl_vars['item']['u_name']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['addtips_money']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['ticket_id']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['addtime']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        
        <?php if (! $this->_tpl_vars['data_array']): ?>
        <tr>
          <td colspan="5" class="show" style="border-bottom:none; background:#FFFF99;">暂时没有打赏的信息!</td>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body></html>