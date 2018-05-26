<?php /* Smarty version 2.6.17, created on 2017-12-07 04:38:10
         compiled from zhuanjia/user_booking.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'zhuanjia/user_booking.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body>
<!--专家单场订阅 start-->
<div class="UserRight" style=" padding:18px 0 0 0;">
  <h3>我的订阅（单场)<span><a href="http://www.zhiying365.com/zhuanjia/" target="_blank">专家中心</a></span></h3>
  <div class="URcenter">
    <div class="tabpading">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="4" >
        <tr>
          <th>ID</th>
          <th>订阅类型</th>
          <th>专家</th>
          <th>订阅金额</th>
          <th>订阅时间</th>
          <th>赛事</th>
          <th>主队 VS 客队</th>
          <th>推荐</th>
        </tr>
        <?php unset($this->_sections['a']);
$this->_sections['a']['name'] = 'a';
$this->_sections['a']['loop'] = is_array($_loop=$this->_tpl_vars['datalist']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['a']['show'] = true;
$this->_sections['a']['max'] = $this->_sections['a']['loop'];
$this->_sections['a']['step'] = 1;
$this->_sections['a']['start'] = $this->_sections['a']['step'] > 0 ? 0 : $this->_sections['a']['loop']-1;
if ($this->_sections['a']['show']) {
    $this->_sections['a']['total'] = $this->_sections['a']['loop'];
    if ($this->_sections['a']['total'] == 0)
        $this->_sections['a']['show'] = false;
} else
    $this->_sections['a']['total'] = 0;
if ($this->_sections['a']['show']):

            for ($this->_sections['a']['index'] = $this->_sections['a']['start'], $this->_sections['a']['iteration'] = 1;
                 $this->_sections['a']['iteration'] <= $this->_sections['a']['total'];
                 $this->_sections['a']['index'] += $this->_sections['a']['step'], $this->_sections['a']['iteration']++):
$this->_sections['a']['rownum'] = $this->_sections['a']['iteration'];
$this->_sections['a']['index_prev'] = $this->_sections['a']['index'] - $this->_sections['a']['step'];
$this->_sections['a']['index_next'] = $this->_sections['a']['index'] + $this->_sections['a']['step'];
$this->_sections['a']['first']      = ($this->_sections['a']['iteration'] == 1);
$this->_sections['a']['last']       = ($this->_sections['a']['iteration'] == $this->_sections['a']['total']);
?>
        <dt>
          <tr>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['bookid']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['booktype_status']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['e_nick']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['booking_money']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['addtime']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['macth']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['duiwu']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['datalist'][$this->_sections['a']['index']]['recommond']; ?>
</td>
          </tr>
          <?php endfor; endif; ?>
      </table>
      <div class="dytips"><?php echo $this->_tpl_vars['error_tips']; ?>
</div>
      <div class="clear"></div>
      <div class="sharepages">
        <div align="center"><?php echo $this->_tpl_vars['multi']; ?>
</div>
      </div>
    </div>
  </div>
</div>
<!--专家单场订阅 end-->
</body>
</html>