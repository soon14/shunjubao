<?php /* Smarty version 2.6.17, created on 2017-12-13 20:53:10
         compiled from ../admin/game/score_match.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getPoolDesc', '../admin/game/score_match.html', 32, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">

TMJF(function ($) {

});
</script>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/nav.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 彩种：
        <select name="sport">
        <option value="fb">===竞猜足球===</option>
        <option value="bk">===竞猜篮球===</option>
        </select>
          <input type="submit" value="查询最近三期即时比分">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
</div>
<h1>比分对比(彩果信息是即时比分转换而来)</h1>
<table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
<?php if ($this->_tpl_vars['sport'] == 'fb'): ?>
<tr>
<td>赛事ID</td><td>赛事场次</td><td>赛事日期</td><td>联赛</td><td>主队VS客队</td><td>开赛时间</td>
<td>上半场比分(即时|现有)</td><td>全场比分(即时|现有)</td>
<?php $_from = $this->_tpl_vars['sportPoolFb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?><td><?php echo ((is_array($_tmp=$this->_tpl_vars['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['item']) : getPoolDesc($_tmp, $this->_tpl_vars['item'])); ?>
</td><?php endforeach; endif; unset($_from); ?>
</tr>
<tbody>
<?php $_from = $this->_tpl_vars['return']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['match'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['match']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['match']['iteration']++;
?>
	<tr <?php if ($this->_foreach['match']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>> 
		<td class="show"><?php echo $this->_tpl_vars['item']['matchId']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['num']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['b_date']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['l_cn']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['h_cn']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;VS&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['item']['a_cn']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['date']; ?>
 <?php echo $this->_tpl_vars['item']['time']; ?>
</td>
		<td class="show">
		<?php echo $this->_tpl_vars['item']['half_jishi']; ?>
<?php if (! $this->_tpl_vars['item']['half_jishi']): ?>暂无<?php endif; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $this->_tpl_vars['item']['half_leida']; ?>
<?php if (! $this->_tpl_vars['item']['half_leida']): ?>暂无<?php endif; ?>
		<?php if ($this->_tpl_vars['item']['half_jishi'] != $this->_tpl_vars['item']['half_leida']): ?><font style="color:red;">(有误)</font><?php endif; ?>
		</td>
		<td class="show">
		<?php echo $this->_tpl_vars['item']['full_jishi']; ?>
<?php if (! $this->_tpl_vars['item']['full_jishi']): ?>暂无<?php endif; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $this->_tpl_vars['item']['full_leida']; ?>
<?php if (! $this->_tpl_vars['item']['full_leida']): ?>暂无<?php endif; ?>
		<?php if ($this->_tpl_vars['item']['full_jishi'] != $this->_tpl_vars['item']['full_leida']): ?><font style="color:red;">(有误)</font><?php endif; ?></td>
		<?php $_from = $this->_tpl_vars['sportPoolFb']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item1']):
?>
		<td><?php echo $this->_tpl_vars['item']['poolResult'][$this->_tpl_vars['item1']]['desc']; ?>
</td>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>
<?php else: ?>
<tr>
<td>赛事ID</td><td>赛事场次</td><td>赛事日期</td><td>联赛</td><td>客队VS主队</td><td>开赛时间</td>
<td>全场比分(即时|现有)</td><?php $_from = $this->_tpl_vars['sportPoolBk']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><td><?php echo ((is_array($_tmp=$this->_tpl_vars['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['item']) : getPoolDesc($_tmp, $this->_tpl_vars['item'])); ?>
</td><?php endforeach; endif; unset($_from); ?>
</tr>
<tbody>
<?php $_from = $this->_tpl_vars['return']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['match'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['match']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['match']['iteration']++;
?>
	<tr <?php if ($this->_foreach['match']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>> 
		<td class="show"><?php echo $this->_tpl_vars['item']['matchId']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['num']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['b_date']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['l_cn']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['a_cn']; ?>
&nbsp;&nbsp;&nbsp;&nbsp;VS&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['item']['h_cn']; ?>
</td>
		<td class="show"><?php echo $this->_tpl_vars['item']['date']; ?>
 <?php echo $this->_tpl_vars['item']['time']; ?>
</td>
		<td class="show">
		<?php echo $this->_tpl_vars['item']['full_jishi']; ?>
<?php if (! $this->_tpl_vars['item']['full_jishi']): ?>暂无<?php endif; ?>
		&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $this->_tpl_vars['item']['full_leida']; ?>
<?php if (! $this->_tpl_vars['item']['full_leida']): ?>暂无<?php endif; ?>
		<?php if ($this->_tpl_vars['item']['full_jishi'] != $this->_tpl_vars['item']['full_leida']): ?><font style="color:red;">(有误)</font><?php endif; ?>
		</td>
		<?php $_from = $this->_tpl_vars['sportPoolBk']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item1']):
?>
		<td><?php echo $this->_tpl_vars['item']['poolResult'][$this->_tpl_vars['item1']]['desc']; ?>
</td>
		<?php endforeach; endif; unset($_from); ?>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</tbody>
<?php endif; ?>
</table>

</body>
</html>