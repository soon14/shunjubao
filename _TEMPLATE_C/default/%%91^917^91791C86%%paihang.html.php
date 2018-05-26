<?php /* Smarty version 2.6.17, created on 2018-03-04 23:16:39
         compiled from paihang.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'paihang.html', 7, false),)), $this); ?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title><?php echo $this->_tpl_vars['TEMPLATE']['title']; ?>
-智赢网|智赢竞彩|彩票赢家首选人气最旺的网站！</title>
<meta name="keywords" content="<?php echo $this->_tpl_vars['TEMPLATE']['keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['TEMPLATE']['description']; ?>
" />
<link href="<?php echo ((is_array($_tmp='header.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='msg.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link href="<?php echo ((is_array($_tmp='footer.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<link rel="shortcut icon" type="image/ico" href="http://www.shunjubao.xyz/www/statics/i/favicon.ico">
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
$(function(){
	$("#list tr:odd").addClass('listtd');
});
</script>
<style>
#toubang{ height:100px; width:980px; margin:0 auto 30px auto; text-align:left;border:1px solid #ccc; padding:10px; background:#f9f9f9; display:none;}
#toubang dl{ float:left; width:80px; text-align:center; padding:0 10px;}
#toubang dl dt{}
#toubang dl dt img{ width:45px; height:45px; line-height:45px;padding:3px;border-radius:45px;}
#toubang dl dd{ margin:0 10px;padding:0 0 5px 0;}
toubang dl dd p{ line-height:24px; height:24px;}
</style>
<body>
<!--center start-->
<div class="Center">
  <div style="padding:20px 0 0 0;">
    <div id="toubang"> <?php $_from = $this->_tpl_vars['topranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <dl>
        <dt><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"></dt>
        <dd>

          <p style="color:#777;"><?php echo $this->_tpl_vars['item']['prize']; ?>
</p>
        </dd>
      </dl>
      <?php endforeach; endif; unset($_from); ?> </div>
    <div class="phangC">
      <div class="phangCtab">
        <ul>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=1" <?php if ($this->_tpl_vars['type'] == 1): ?>class="active"<?php endif; ?>>周排行</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=2" <?php if ($this->_tpl_vars['type'] == 2): ?>class="active"<?php endif; ?>>月排行</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=6" <?php if ($this->_tpl_vars['type'] == 6): ?>class="active"<?php endif; ?>>跟单排行</a></li>
          <li><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/paihang.php?type=5" <?php if ($this->_tpl_vars['type'] == 5): ?>class="active"<?php endif; ?>>总排行</a></li>
        </ul>
      </div>
    </div>
    <div class="paihanglist">
      <dl>
        <dd class="first"><span style="position:relative;left:-15px;">排名</span></dd>
        <dd class="three">姓名</dd>
        <dd class="four">升降<a class="tooltips" href="#tooltips"><img src="http://www.shunjubao.xyz/www/statics/i/question.png"><span>用户排名的升降规则为开奖之后，依照用户的中奖情况而做出的升降。</span></a></dd>
        <dd class="eight">注册日期</dd>
        <dd class="five">积分<a class="tooltips" href="#tooltips"><img src="http://www.shunjubao.xyz/www/statics/i/question.png"><span>各位会员，积分是智赢网回馈用户的一种方式，积分可用于虚拟投注中超或CBA，并可以兑换彩金！</span></a></dd>
        <dd class="six" style="text-align:right;">累积中奖</dd>
      </dl>
      <div class="clear"></div>
      <table width="1000" border="0" cellspacing="0" cellpadding="0" id="list">
        <?php $_from = $this->_tpl_vars['paihangtopranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
          <td><div class="paiming"><b><?php echo $this->_tpl_vars['item']['rank']; ?>
</b></div></td>
          <td><div class="phname"><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"><b><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b><?php if ($this->_tpl_vars['item']['up_down'] > 0): ?><span>&uarr;</span><?php endif; ?><?php if ($this->_tpl_vars['item']['up_down'] < 0): ?><em>&darr;</em><?php endif; ?></div></td>
          <td style="color:#777;"><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_jointime']; ?>
</td>
          <td><div class="jifen"><?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['item']['u_id']]['score']; ?>
</div></td>
          <td style="text-align:right"><?php echo $this->_tpl_vars['item']['prize']; ?>
元</td>
                    <td><div class="dengji"><img src=""></div></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?> 
        <?php $_from = $this->_tpl_vars['ranks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
          <td><div class="paiming"><strong><?php echo $this->_tpl_vars['item']['rank']; ?>
</strong></div></td>
          <td><div class="phname"><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"><b><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b><?php if ($this->_tpl_vars['item']['up_down'] > 0): ?><span>&uarr;</span><?php endif; ?><?php if ($this->_tpl_vars['item']['up_down'] < 0): ?><em>&darr;</em><?php endif; ?></div></td>
          <td><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_jointime']; ?>
</td>
          <td><div class="jifen"><?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['item']['u_id']]['score']; ?>
</div></td>
          <td width="150" style="text-align:right"><div class="jiangjin"><?php echo $this->_tpl_vars['item']['prize']; ?>
元</div></td>
                    <td><div class="dengji"><img src=""></div></td>
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
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>