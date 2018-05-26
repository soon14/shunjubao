<?php /* Smarty version 2.6.17, created on 2018-02-21 16:47:52
         compiled from ../admin/game/score_match_sp.html */ ?>
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
  <!--<form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 彩种：
          <select name="sport">
            <option value="fb">===竞猜足球===</option>
            <option value="bk">===竞猜篮球===</option>
          </select>
          <input type="submit" value="查询即时赔率对比">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>-->
</div>
<h1>新旧雷达接口sp对比(当前服务器时间:<?php echo $this->_tpl_vars['cur_time']; ?>
)</h1>
<table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">

  <tr>
    <td>赛事ID</td>
    <td>赛事场次</td>
    <td>赛事日期</td>
    <td>联赛</td>
    <td>主队VS客队</td>
    <td>开赛时间</td>
    <td>胜平负(旧|新)</td>
    <td>让胜平负(旧|新)</td>
    <td>总进球(旧|新)</td>
    <td>半全场(旧|新)</td>
    <td>比分(旧|新)</td>
  </tr>
  <tbody>
  <?php $_from = $this->_tpl_vars['return']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['match'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['match']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['match']['iteration']++;
?>
    <tr 
  <?php if ($this->_foreach['match']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
  <tr>
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
    <td class="show"><?php echo $this->_tpl_vars['item']['had']; ?>
</td>
    <td class="show"><?php echo $this->_tpl_vars['item']['hhad']; ?>
</td>
    <td class="show"><?php echo $this->_tpl_vars['item']['ttg']; ?>
</td>
    <td class="show"><?php echo $this->_tpl_vars['item']['hafu']; ?>
</td>
    <td class="show"><?php echo $this->_tpl_vars['item']['crs']; ?>
</td>
  </tr>
  <?php endforeach; endif; unset($_from); ?>
    </tbody>
  

</table>
</body></html>