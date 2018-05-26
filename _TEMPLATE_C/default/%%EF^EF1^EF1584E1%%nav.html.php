<?php /* Smarty version 2.6.17, created on 2017-10-14 18:28:24
         compiled from ../admin/nav.html */ ?>


</head><body>

<?php if ($this->_tpl_vars['navs']): ?>
<table class="nav">
    <tr>
        <td>当前位置
        <?php $_from = $this->_tpl_vars['navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['nav']):
?>
            &nbsp;>>&nbsp;
            <?php if ($this->_tpl_vars['nav']['href']): ?>
                <a href="<?php echo $this->_tpl_vars['nav']['href']; ?>
" <?php if ($this->_tpl_vars['nav']['target']): ?> target="<?php echo $this->_tpl_vars['nav']['target']; ?>
"<?php endif; ?> ><?php echo $this->_tpl_vars['nav']['title']; ?>
</a>
            <?php else: ?>
                <?php echo $this->_tpl_vars['nav']['title']; ?>

            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
    </tr>
</table>
<?php endif; ?>