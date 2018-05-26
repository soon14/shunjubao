<?php /* Smarty version 2.6.17, created on 2017-10-18 11:11:03
         compiled from paihang.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
$(function(){
	$("#list tr:odd").addClass('listtd');
});
</script>
<style>
.Center{ text-align:left;}
.wapTop{ line-height:24px; padding:3px 0;}
.wapTop h1{ font-size:16px; font-weight:300; font-family:'微软雅黑';}
.wapTop h1 em span{ font-family:'宋体';}
.NavphTab{ padding:0;}
.NavphTab table{}
.NavphTab table tr{}
.NavphTab table tr td{background:#fff; }
.NavphTab table tr td a{color:#000;font-weight:300;font-size:14px;border-bottom:2px solid #ddd;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000;font-weight:900;}
.listtd{background:#f9f9f9;height:30px; line-height:30px; overflow:hidden;}
table{font-size:14px;}
table tr{}
table tr th{ font-size:12px; font-weight:300;}
table tr td{ height:30px; line-height:30px; overflow:hidden;}
.paiming{ width:50px;display:inline-table;display:inline-block;zoom:1;*display:inline;text-align:center; margin:0 0 0 5px;}
.paiming b{width:30px;height:30px;line-height:30px;text-align:center;background:#fff;font-size:12px;font-weight:300;color:#000;display:block;background:#dc0000;color:#fff;}
.paiming strong{width:30px;height:30px;line-height:30px;text-align:center;background:#ddd;font-size:12px;font-weight:300;color:#000;display:block;position:relative;top:1px;}
.phname{ width:120px; text-align:left; height:32px; line-height:32px;}
.phname img{ width:25px; height:25px; line-height:25px; float:left;-moz-border-radius:25px;-webkit-border-radius:25px;border-radius:25px; margin:4px 0 4px 0; display:none;}
.phname b{ font-size:14px; font-weight:300; height:30px; line-height:30px; padding:0 0 0 4px;}
.time{ width:68px; height:30px; line-height:30px; overflow:hidden;}
.time span{ font-size:14px;color:#dc0000;}
.time em{ font-size:14px;color:#dc0000; font-style:normal;color:green;}
.sharepages{clear:both;text-align:center;padding:20px 0;height:30px;line-height:30px;width:auto;margin:0 auto;}
.sharepages a{border:1px solid #ccc;padding:5px 10px;color:#000;font-size:14px;margin:0 3px;border-radius:1px;}
.sharepages span{background:#dc0000;padding:5px 10px;color:#000;font-size:14px;margin:0 3px;border-radius:1px;color:#fff;}
.sharepages span.disabled{border:1px solid #ccc;padding:5px 10px;color:#000;font-size:14px;margin:0 3px;border-radius:1px;background:none;}
.sharepages a:hover{border:1px solid #dc0000;background:#f9f9f9;}
.sharepages a.hover{border:1px solid #dc0000;background:#fff;background:#416C97;color:#fff;}
</style>
<body>
<!--center start-->
<div class="Center">
  <div class="NavphTab">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=1" <?php if ($this->_tpl_vars['type'] == 1): ?>class="active"<?php endif; ?>>周排行</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=2" <?php if ($this->_tpl_vars['type'] == 2): ?>class="active"<?php endif; ?>>月排行</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=6" <?php if ($this->_tpl_vars['type'] == 6): ?>class="active"<?php endif; ?>>跟单排行</a></td>
        <td><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=5" <?php if ($this->_tpl_vars['type'] == 5): ?>class="active"<?php endif; ?>>总排行</a></td>
      </tr>
    </table>
  </div>
  <div style="padding:15px 0 0 0;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="list">
      <?php $_from = $this->_tpl_vars['paihangtopranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <tr>
        <td align="left"><div class="paiming"><b><?php echo $this->_tpl_vars['item']['rank']; ?>
</b></div></td>
        <td><div class="phname"><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"><b><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b></div></td>
        <td><div class="time"><?php if ($this->_tpl_vars['item']['up_down'] > 0): ?><span>&uarr;</span><?php endif; ?><?php if ($this->_tpl_vars['item']['up_down'] < 0): ?><em>&darr;</em><?php endif; ?></div></td>
        <td align="right" style="padding:0 10px 0 0;"><?php echo $this->_tpl_vars['item']['prize']; ?>
</td>
         </tr>
      <?php endforeach; endif; unset($_from); ?> 
      <?php $_from = $this->_tpl_vars['ranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <tr>
        <td align="left"><div class="paiming"><strong><?php echo $this->_tpl_vars['item']['rank']; ?>
</strong></div></td>
        <td><div class="phname"><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"><b><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b></div></td>
        <td><div class="time"><?php if ($this->_tpl_vars['item']['up_down'] > 0): ?><span>&uarr;</span><?php endif; ?><?php if ($this->_tpl_vars['item']['up_down'] < 0): ?><em>&darr;</em><?php endif; ?></div></td>
        <td align="right" style="padding:0 10px 0 0;"><div class="jiangjin"><?php echo $this->_tpl_vars['item']['prize']; ?>
</div></td>
         </tr>
      <?php endforeach; endif; unset($_from); ?>
    </table>
  </div>
  <div class="sharepages">
    <div align="center"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> <?php endif; ?> </div>
  </div>
</div>
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>