<?php /* Smarty version 2.6.17, created on 2017-11-01 23:37:44
         compiled from ../admin/fail_exit.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table>
    <tr>
        <td><h1><font color="red">操作失败</font></h1></td>
    </tr>
    <tr>
        <td>原因：<?php echo $this->_tpl_vars['msg']; ?>
</td>
    </tr>
    <tr>
        <td>
        你可以：&nbsp;&nbsp;<a href="javascript:history.go(-1);"><<返回上一页</a>
        <?php $_from = $this->_tpl_vars['redirect_navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nav']):
?>
        &nbsp;&nbsp;<a href="<?php echo $this->_tpl_vars['nav']['href']; ?>
" <?php if ($this->_tpl_vars['nav']['target']): ?> target="<?php echo $this->_tpl_vars['nav']['target']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['nav']['title']; ?>
</a>
        <?php endforeach; endif; unset($_from); ?>
        </td>
    </tr>
</table>