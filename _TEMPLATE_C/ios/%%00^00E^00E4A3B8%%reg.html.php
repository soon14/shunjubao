<?php /* Smarty version 2.6.17, created on 2016-04-13 05:10:35
         compiled from reg.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'reg.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='wap_login.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script language="javascript" src="<?php echo ((is_array($_tmp='float.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='reg.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head>
<body>
<div class="center">
  <div class="logincenter">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/reg.php?refer=<?php echo $this->_tpl_vars['refer']; ?>
" name='frm_reg' id='frm_reg'>
      <div class="regC">
        <p><b>用户名：</b>
          <input name="u_name" type="text" size="25" class="inputc1" id='u_name'/>
        </p>
        <p class="tip"><font class="<?php if ($this->_tpl_vars['msg']['u_name']): ?><?php else: ?>none<?php endif; ?>" id='tips1'> <?php if ($this->_tpl_vars['msg']['u_name']): ?><span id='u_name_err'><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><u class="none" id='tips1'></u><?php endif; ?> </font></p>
        <p><b>登录密码：</b>
          <input name="u_pwd" type="password" size="25" class="inputc1" id="u_pwd"/>
        </p>
        <p class="tip"><font class="<?php if ($this->_tpl_vars['msg']['newpas']): ?><?php else: ?>none<?php endif; ?>" id='tips2'> <?php if ($this->_tpl_vars['msg']['newpas']): ?><span class=""><?php echo $this->_tpl_vars['msg']['newpas']; ?>
</span><?php else: ?><u class="">请输入密码</u><?php endif; ?> </font></p>
        <p><b>确认密码：</b>
          <input name="repas" type="password" size="25" class="inputc1" id="repas"/>
        </p>
        <p class="tip"><font class="<?php if ($this->_tpl_vars['msg']['repas']): ?><?php else: ?>none<?php endif; ?>" id='tips3'> <?php if ($this->_tpl_vars['msg']['repas']): ?><span class=""><?php echo $this->_tpl_vars['msg']['repas']; ?>
</span><?php else: ?><u class="none">&nbsp;&nbsp;</u><?php endif; ?> </font></p>
        <p><b>手机号：</b>
        	<input name="mobile" type="text" size="25" class="inputc1" id="mobile"/>
        	<font class="<?php if ($this->_tpl_vars['msg']['mobile']): ?><?php else: ?>none<?php endif; ?>" id='tips4'> <?php if ($this->_tpl_vars['msg']['mobile']): ?><span class=""><?php echo $this->_tpl_vars['msg']['mobile']; ?>
</span><?php else: ?><u class="none">&nbsp;&nbsp;</u><?php endif; ?> </font> </p>
                <p><b>&nbsp;</b>
          <input name="submit" type="submit" value="注&nbsp;册" class="loginsub" />
        </p>
      </div>
      <div class="clear"></div>
    </form>
  </div>
</div>
<!--center end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>