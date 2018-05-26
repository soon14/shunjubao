<?php /* Smarty version 2.6.17, created on 2017-11-23 14:54:31
         compiled from ../admin/game/edit_odds.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getChineseByPoolCode', '../admin/game/edit_odds.html', 47, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<script type="text/javascript">
TMJF(function($) {
});
</script>
<div>
  <h2> <b>●</b>SP值修改</h2>
  <?php if ($this->_tpl_vars['pool'] && $this->_tpl_vars['matchInfo']): ?>
  <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
    <tbody>
      <tr>
        <td>玩法</td>
        <td><?php if ($this->_tpl_vars['sport'] == 'bk'): ?>客VS主<?php else: ?>主VS客<?php endif; ?></td>
        <td>比赛日期</td>
      </tr>
      <tr>
        <td><?php echo $this->_tpl_vars['sportAndPoolDesc'][$this->_tpl_vars['pool']]['desc']; ?>
</td>
        <td><?php if ($this->_tpl_vars['sport'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
VS<?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
VS<?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
<?php endif; ?></td>
        <td><?php echo $this->_tpl_vars['matchInfo']['date']; ?>
&nbsp;&nbsp;<?php echo $this->_tpl_vars['matchInfo']['time']; ?>
</td>
      </tr>
    </tbody>
  </table>
  <?php endif; ?>
  <div> <?php if ($this->_tpl_vars['odd']): ?>
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_odds.php">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr> <?php $_from = $this->_tpl_vars['odd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php if ($this->_tpl_vars['key'] == 'id'): ?>
            <th>序号</th>
            <?php elseif ($this->_tpl_vars['key'] == 'm_num'): ?>
            <th>场次</th>
            <?php elseif ($this->_tpl_vars['key'] == 's_code'): ?>
            <th>彩种</th>
            <?php elseif ($this->_tpl_vars['key'] == 'm_id'): ?>
            <th>赛事ID</th>
            <?php elseif ($this->_tpl_vars['key'] == 'goalline'): ?>
            <th>让球</th>
            <?php elseif ($this->_tpl_vars['key'] == 'date'): ?>
            <th>最后更新日期</th>
            <?php elseif ($this->_tpl_vars['key'] == 'time'): ?>
            <th>最后更新时间</th>
            <?php elseif ($this->_tpl_vars['key'] == 'p_id'): ?>
            <th>p_id</th>
            <?php else: ?>
            <th class="show"><?php echo ((is_array($_tmp=$this->_tpl_vars['pool'])) ? $this->_run_mod_handler('getChineseByPoolCode', true, $_tmp, $this->_tpl_vars['key']) : getChineseByPoolCode($_tmp, $this->_tpl_vars['key'])); ?>
</th>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?> </tr>
          <tr>
            <input name="sport"  type="hidden" value="<?php echo $this->_tpl_vars['sport']; ?>
"/>
            <input name="pool"  type="hidden" value="<?php echo $this->_tpl_vars['pool']; ?>
"/>
            <input name="operate"  type="hidden" value="edit"/>
            <input name="id"  type="hidden" value="<?php echo $this->_tpl_vars['odd']['id']; ?>
"/>
            <?php $_from = $this->_tpl_vars['odd']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <?php if ($this->_tpl_vars['key'] == 'id' || $this->_tpl_vars['key'] == 'm_num' || $this->_tpl_vars['key'] == 's_code' || $this->_tpl_vars['key'] == 'p_id' || $this->_tpl_vars['key'] == 'm_id' || $this->_tpl_vars['key'] == 'goalline' || $this->_tpl_vars['key'] == 'date' || $this->_tpl_vars['key'] == 'time'): ?>
            <td class="show"><?php if ($this->_tpl_vars['item'] == 'FB'): ?>竞足<?php elseif ($this->_tpl_vars['item'] == 'BK'): ?>竞篮<?php else: ?><?php echo $this->_tpl_vars['item']; ?>
<?php endif; ?></td>
            <?php else: ?>
            <td class="show"><input name='<?php echo $this->_tpl_vars['key']; ?>
' value='<?php echo $this->_tpl_vars['item']; ?>
'/></td>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
            <td class="show"><input type='submit' value="修改"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <?php else: ?>
    <form action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_odds.php" method="post">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>彩种</th>
            <th>玩法</th>
            <th>星期</th>
            <th>场次</th>
			<th>操作</th>
          </tr>
          <tr>
            <td><input name="operate"  type="hidden" value="show"/>
              <select name="sport" id="sport">
                <option value="fb">竞彩足球</option>
                <option value="bk">竞彩篮球</option>
              </select>
            </td>
            <td><select name="pool">
                <?php $_from = $this->_tpl_vars['sportAndPoolDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
                <option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
                <?php endforeach; endif; unset($_from); ?>
              </select>
            </td>
            <td><select name="week" id="week">
                <option value="1">星期一</option>
                <option value="2">星期二</option>
                <option value="3">星期三</option>
                <option value="4">星期四</option>
                <option value="5">星期五</option>
                <option value="6">星期六</option>
                <option value="7">星期日</option>
              </select>
            </td>
            <td><input name="num" id="num" type="text"/></td>
			<td><input type="submit" value="查询"/></td>
          </tr>
        </tbody>
      </table>
    </form>
    <?php endif; ?> </div>
</div>
<!--投注记录 end-->
</body>
</html>