<?php /* Smarty version 2.6.17, created on 2017-10-15 15:03:09
         compiled from reg_success.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reg_success.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script src="<?php echo ((is_array($_tmp='timecount.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<div class="head_tips">
  <h1><b><a href="">智赢网</a></b><strong style="left:90px;">System Tips</strong></h1>
</div>
<!--center start-->
<div class="Tipcenter">
  <div class="systemtips">
    <p><span>&nbsp;</span>恭喜您!注册成功o(∩_∩)o</p>
  </div>
  <div class="ohter">
    <script language="javascript">    
                      auto_jump("<?php echo $this->_tpl_vars['refer']; ?>
");
                     </script>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span></span><a href="<?php echo $this->_tpl_vars['refer']; ?>
">返回上一页</a>&nbsp;&nbsp;&nbsp;&nbsp;<span></span><a href="<?php echo @ROOT_DOMAIN; ?>
">进入首页>></a><br />
    </p>
  </div>
  <div class="Tips">智赢网业界中奖率最高的网站，数千万彩民的信赖！</div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 