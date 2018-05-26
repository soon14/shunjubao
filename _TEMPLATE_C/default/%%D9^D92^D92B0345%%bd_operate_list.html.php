<?php /* Smarty version 2.6.17, created on 2017-10-23 01:16:05
         compiled from ../admin/game/bd_operate_list.html */ ?>
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
<table>
<tr><td>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/bd_get_result.php">
  <tr>
    <td><h3>更新北单赛果</h3></td>
    <td>
    <select name='lotteryId'>
    <option value='SPF' selected>胜平负</option>
    <option value='SF'>胜负</option>
    <option value='BF'>比分</option>
    <option value='JQS'>进球数</option>
    <option value='BQC'>半全场</option>
    <option value='SXDS'>上下单双</option>
    </select>
    </td>
    <td>期数:<input name='issueNumber' value=''/></td>
    <td><input class="sub" type="submit" value="提交" name="submit"/></td>
  </tr>
  </form>
</table>
</td></tr>

<tr><td>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/bd_get_game.php">
  <tr>
    <td><h3>更新北单赛程</h3></td>
    <td>
    <select name='lotteryId'>
    <option value='SPF' selected>胜平负</option>
    <option value='SF'>胜负</option>
    <option value='BF'>比分</option>
    <option value='JQS'>进球数</option>
    <option value='BQC'>半全场</option>
    <option value='SXDS'>上下单双</option>
    </select>
    </td>
    <td>期数:<input name='issueNumber' value=''/></td>
    <td><input class="sub" type="submit" value="提交" name="submit"/></td>
  </tr>
  </form>
</table>
</td></tr>

<tr><td>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/bd_get_game_sp.php">
  <tr>
    <td><h3>更新北单SP</h3></td>
    <td>
    <select name='lotteryId'>
    <option value='SPF' selected>胜平负</option>
    <option value='SF'>胜负</option>
    <option value='BF'>比分</option>
    <option value='JQS'>进球数</option>
    <option value='BQC'>半全场</option>
    <option value='SXDS'>上下单双</option>
    </select>
    </td>
    <td>期数:<input name='issueNumber' value=''/></td>
    <td><input class="sub" type="submit" value="提交" name="submit"/></td>
  </tr>
  </form>
</table>
</td></tr>

<tr><td>
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
  <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/game/bd_get_issueinfo.php">
  <tr>
    <td><h3>更新北单期数</h3></td>
    <td>
    <select name='lotteryId'>
    <option value='SPF' selected>胜平负</option>
    <option value='SF'>胜负</option>
    <option value='BF'>比分</option>
    <option value='JQS'>进球数</option>
    <option value='BQC'>半全场</option>
    <option value='SXDS'>上下单双</option>
    </select>
    </td>
    <td>期数:<input name='issueNumber' value=''/></td>
    <td><input class="sub" type="submit" value="提交" name="submit"/></td>
  </tr>
  </form>
</table>
</td>
</tr>

<tr><td>以上操作中期数不填则表示当前期</td></tr>

</table>
</body>
</html>