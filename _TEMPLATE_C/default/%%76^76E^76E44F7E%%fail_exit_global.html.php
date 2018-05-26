<?php /* Smarty version 2.6.17, created on 2017-10-14 18:06:21
         compiled from fail_exit_global.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="content-bg">
    <div class="content">
        <div class="formblank">
            <span class="blank30"></span>

            <div class="paynote">
                <div class="suc-txt2"><?php echo $this->_tpl_vars['title']; ?>
</div> 
                <div class="suc-num2"><?php echo $this->_tpl_vars['msg']; ?>
<br />
                    您可以：<a href="<?php echo @ROOT_DOMAIN; ?>
">返回首页>></a><br />
                <?php $_from = $this->_tpl_vars['redirect_navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['redirect_navs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['redirect_navs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['redirect_nav']):
        $this->_foreach['redirect_navs']['iteration']++;
?>
                　　　　<a href="<?php echo $this->_tpl_vars['redirect_nav']['href']; ?>
" <?php if ($this->_tpl_vars['redirect_nav']['target']): ?>target="<?php echo $this->_tpl_vars['redirect_nav']['target']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['redirect_nav']['title']; ?>
>></a>
                    <?php if (! ($this->_foreach['redirect_navs']['iteration'] == $this->_foreach['redirect_navs']['total'])): ?><br /><?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                </div>
                <div class="suc-service2"></div>
                <span class="blank50"></span>
            </div>
            <span class="blank50" style="height:200px;"></span>
        </div>
    </div>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "bottom.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>