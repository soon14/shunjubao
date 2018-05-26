<?php /* Smarty version 2.6.17, created on 2018-03-05 15:14:39
         compiled from reg_success.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reg_success.html', 19, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<style>
/*系统提示*/
.Tipcenter{padding:20px 0 0 0;background:#fff; min-height:300px;}
.Tips{text-align:center;border-top:1px dashed #fff;height:24px;line-height:18px;color:#000;font-size:12px; background:url(http://www.zhiying365365.com/www/statics/i/wbg.gif) repeat-x;}
.systemtips{padding:70px 0 0 0;width:320px; margin:0 auto; text-align:cenetr;}
.systemtips p{font-size:12px;font-family:'';line-height:32px;height:32px;}
.systemtips p span{background:url(http://www.zhiying365365.com/www/statics/i/raster.jpg) no-repeat 0 -96px;width:50px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.systemtips p em{background:url(http://www.zhiying365365.com/www/statics/i/raster.jpg) no-repeat 61% 90%;width:50px;display:inline-table;display:inline-block;zoom:1;*display:inline;font-style:normal;}
.ohter{height:100px;}
.ohter p{height:30px;line-height:30px;padding:28px 0 0 10px;}
.ohter p span{background:url(http://www.zhiying365365.com/www/statics/i/showRight.png) no-repeat left bottom;width:16px;height:14px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.ohter p em{ font-style:normal;position:relative;top:-2px; font-size:12px;}
.ohter p a{text-decoration:none;color:#000;font-size:12px;padding:0 10px 0 5px;position:relative;top:-3px;}
.ohter p a:hover{text-decoration:none;color:#dc0000;}
.ohter p a.active{text-decoration:none;color:#dc0000;}
</style>
<body>
<script src="<?php echo ((is_array($_tmp='timecount.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<!--center start-->
<div class="Tipcenter">
    <div class="systemtips">
      <p><span>&nbsp;</span>恭喜您!注册成功o(∩_∩)o</p>
    </div>
    <div class="ohter">
      <p><span></span><a href="<?php echo $this->_tpl_vars['refer']; ?>
">返回上一页</a><span></span><a href="<?php echo @ROOT_WEBSITE; ?>
/account/user_center.php">用户中心</a></p>
    </div>
  </div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 