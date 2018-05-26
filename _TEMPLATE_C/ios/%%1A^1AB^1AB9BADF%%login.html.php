<?php /* Smarty version 2.6.17, created on 2016-02-18 18:58:46
         compiled from login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'login.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='wap_login.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script language="javascript" src="<?php echo ((is_array($_tmp='float.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='login.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
</head><body>
<div class="center">
  <div class="logincenter">
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/passport/login.php?from=<?php echo $this->_tpl_vars['from']; ?>
" name='frm_login' id='frm_login'>
      <div class="wap_loginC">
        <p class="name">您的用户名</p>
        <p>
          <input name="u_name" type="text" size="25" class="inputc1" id="u_name"/>
        </p>
        <p class="tip"><?php if ($this->_tpl_vars['msg']['u_name']): ?><span class=""><?php echo $this->_tpl_vars['msg']['u_name']; ?>
</span><?php else: ?><u class="none">此用户名可用</u><?php endif; ?></p>
        <p class="name">请输入密码</p>
        <p>
          <input name="u_pwd" type="password" size="25" class="inputc1" id="u_pwd"/>
        </p>
        <p class="tip"><?php if ($this->_tpl_vars['msg']['pwd']): ?><span class="none"><?php echo $this->_tpl_vars['msg']['pwd']; ?>
</span><?php else: ?><u class="none">密码正确</u><?php endif; ?></p>
        <?php if ($this->_tpl_vars['msg']['loginerror']): ?>
        <p class="error"><?php echo $this->_tpl_vars['msg']['loginerror']; ?>
</p>
        <?php endif; ?>
        
                <p class="denglu">
          <input name="submit" type="submit" value="登&nbsp;录" class="loginsub" />
        </p>
      </div>
      <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
" />
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