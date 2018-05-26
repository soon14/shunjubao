<?php /* Smarty version 2.6.17, created on 2018-01-09 11:58:53
         compiled from ../admin/game/edit_game.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<body>
<script type="text/javascript">
TMJF(function($) {
	$("#select_all_pool").click(function(){
		$(".pool").each(function(){
			$(this).attr('checked','checked');
		});
	});
	//没选择单关时不允许提交
	$("#danguan").submit(function(){
		var can_submit = false;
		$(".pool").each(function(){
			if($(this).attr('checked')) can_submit = true;
		});
		if (!can_submit) {
			alert('请至少选择一个玩法');
			return false;
		}
		return true;
	});
});
</script>
<div>
  <h2> <b>●</b>赛事信息修改</h2>
  <?php if ($this->_tpl_vars['matchInfo']): ?>
  <div>
    <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_game.php">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>场次</th>
            <th><?php if ($this->_tpl_vars['sport'] == 'bk'): ?>客VS主<?php else: ?>主VS客<?php endif; ?></th>
            <th>状态</th>
            <th>比赛日期</th>
            <th>比赛时间</th>
            <th>操作</th>
          </tr>
          <tr>
            <input name="sport"  type="hidden" value="<?php echo $this->_tpl_vars['sport']; ?>
"/>
            <input name="operate"  type="hidden" value="edit"/>
            <input name="id"  type="hidden" value="<?php echo $this->_tpl_vars['matchInfo']['id']; ?>
"/>
            <input name="index_show"  type="hidden" value="1"/>
            <td class="show"><?php echo $this->_tpl_vars['matchInfo']['id']; ?>
</td>
            <td class="show"><?php echo $this->_tpl_vars['matchInfo']['num']; ?>
</td>
            <td><?php if ($this->_tpl_vars['sport'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
VS<?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
VS<?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
<?php endif; ?></td>
            <td class="show"><select name="status">
                <?php $_from = $this->_tpl_vars['statusDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['matchInfo']['status'] == $this->_tpl_vars['key']): ?> selected<?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

                </option>
                <?php endforeach; endif; unset($_from); ?>
              </select>
            </td>
            <td class="show"><input name="date"  type="text" value="<?php echo $this->_tpl_vars['matchInfo']['date']; ?>
"/></td>
            <td class="show"><input name="time"  type="text" value="<?php echo $this->_tpl_vars['matchInfo']['time']; ?>
"/></td>
            <td class="show"><input type='submit' value="修改"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <br/>
    <h2><b>●</b>单关修改</h2>
    <form method="post" action="" id='danguan'>
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>玩法</th>
            <th>操作</th>
          </tr>
          <tr>
            <input name="sport"  type="hidden" value="<?php echo $this->_tpl_vars['sport']; ?>
"/>
            <input name="operate"  type="hidden" value="add_danguan"/>
            <input name="matchid"  type="hidden" value="<?php echo $this->_tpl_vars['matchInfo']['id']; ?>
"/>
            <td class="show"><a href="javascript::void(0)" id="select_all_pool">全选</a>&nbsp;&nbsp;|
              <?php if ($this->_tpl_vars['sport'] == 'fb'): ?>
              胜平负<input class='pool' type="checkbox" name='pool[]' value='had' <?php if ($this->_tpl_vars['danguanInfo']['had']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              让球胜平负<input class='pool' type="checkbox" name='pool[]' value='hhad' <?php if ($this->_tpl_vars['danguanInfo']['hhad']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              比分<input class='pool' type="checkbox" name='pool[]' value='crs' <?php if ($this->_tpl_vars['danguanInfo']['crs']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              总进球<input class='pool' type="checkbox" name='pool[]' value='ttg' <?php if ($this->_tpl_vars['danguanInfo']['ttg']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              半全场<input class='pool' type="checkbox" name='pool[]' value='hafu' <?php if ($this->_tpl_vars['danguanInfo']['hafu']): ?>checked<?php endif; ?>>&nbsp;&nbsp;
              <?php else: ?>
              胜负<input class='pool' type="checkbox" name='pool[]' value='mnl' <?php if ($this->_tpl_vars['danguanInfo']['mnl']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              让分胜负<input class='pool' type="checkbox" name='pool[]' value='hdc' <?php if ($this->_tpl_vars['danguanInfo']['hdc']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              胜分差<input class='pool' type="checkbox" name='pool[]' value='wnm' <?php if ($this->_tpl_vars['danguanInfo']['wnm']): ?>checked<?php endif; ?>>&nbsp;&nbsp;|&nbsp;&nbsp;
              大小分<input class='pool' type="checkbox" name='pool[]' value='hilo' <?php if ($this->_tpl_vars['danguanInfo']['hilo']): ?>checked<?php endif; ?>>&nbsp;&nbsp;
              <?php endif; ?> </td>
            <td class="show"><input type='submit' value="修改"></td>
          </tr>
        </tbody>
      </table>
    </form>
    <?php else: ?>
    <form action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_game.php" method="post">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>彩种</th>
            <th>星期</th>
            <th>场次</th>
            <th>赛事系统ID(管理员使用)</th>
            <th>操作</th>
          </tr>
          <tr>
            <td><input name="operate"  type="hidden" value="show"/>
              <select name="sport" id="sport">
                <option value="fb">竞彩足球</option>
                <option value="bk">竞彩篮球</option>
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
            <td><input name="id" id="id" type="text"/></td>
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