<?php /* Smarty version 2.6.17, created on 2016-09-29 23:40:18
         compiled from show.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'show.html', 3, false),array('modifier', 'getPoolDesc', 'show.html', 25, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_shaidan.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<body>
<!--center start-->
<div class="tipsters">
  <div class="NewsNav">
    <h1><b>跟单中心</b><em>停止盲目投注...<br/>
      <span>跟随聚宝高手，让您的利润蒸蒸日上 ! </span></em></h1>
  </div>
</div>
<div class="gendanCenter">
  <div>
    <div style="border:1px solid #eee;">
      <table class="" width="100%"  border="0" cellspacing="0" cellpadding="0" style="width:100%; overflow:hidden;">
        <tr>
          <td><div class="sdType"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=fb" <?php if ($this->_tpl_vars['sport'] == 'fb'): ?> class='active'<?php endif; ?> >竞彩足球</a></div></td>
          <td><div class="sdType"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=bk" <?php if ($this->_tpl_vars['sport'] == 'bk'): ?> class='active'<?php endif; ?> >竞彩篮球</a></div></td>
          <td><div class="sdType"><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=bd" <?php if ($this->_tpl_vars['sport'] == 'bd'): ?> class='active'<?php endif; ?> >北京单场</a></div></td>
        </tr>
      </table>
    </div>
    <?php $_from = $this->_tpl_vars['show_tickets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
    <div class="btsdList">
      <h1><img src="<?php if ($this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"><b><?php echo $this->_tpl_vars['show_users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b><strong><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['sport'])) ? $this->_run_mod_handler('getPoolDesc', true, $_tmp, $this->_tpl_vars['item']['pool']) : getPoolDesc($_tmp, $this->_tpl_vars['item']['pool'])); ?>
</strong><span><?php echo $this->_tpl_vars['item']['datetime']; ?>
</span></h1>
      <dl>
        <dt class="over"><em>结束时间：</em>&nbsp;<span><?php echo $this->_tpl_vars['item']['endtime']; ?>
</span></dt>
        <dt><em>倍数：</em>&nbsp;<b><?php echo $this->_tpl_vars['item']['multiple']; ?>
倍</b></dt>
        <dt><em>投注额：</em>&nbsp;<strong><?php echo $this->_tpl_vars['item']['money']; ?>
元</strong></dt>
        <dt><em>跟单总金额：</em>&nbsp;<strong><?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_money']; ?>
元</strong></dt>
        <dt><em>跟单总人数：</em>&nbsp;<i style="color:#777;"><?php echo $this->_tpl_vars['follow_infos'][$this->_tpl_vars['item']['id']]['total_sum']; ?>
人</i></dt>
        <dd><?php if ($this->_tpl_vars['item']['prize_state'] == 1): ?><span>赢</span><?php endif; ?><a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/follow.php?userTicketId=<?php echo $this->_tpl_vars['item']['id']; ?>
"> <?php if ($this->_tpl_vars['item']['is_end']): ?><b>查看详细</b><?php else: ?>我要跟单<?php endif; ?></a></dd>
      </dl>
    </div>
    <?php endforeach; endif; unset($_from); ?>
    <?php if ($this->_tpl_vars['total_page'] > 1): ?>
    <div class="sharepages"> <a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
">首页</a> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
" class="active">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
" class="active">下一页</a> <?php endif; ?> <a href="<?php echo @ROOT_DOMAIN; ?>
/ticket/show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
&page=<?php echo $this->_tpl_vars['total_page']; ?>
">末页</a> </div>
    <?php endif; ?> </div>
</div>
<!--center end-->
<!--footer start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>