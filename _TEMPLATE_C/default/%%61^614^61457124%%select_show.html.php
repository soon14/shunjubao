<?php /* Smarty version 2.6.17, created on 2017-10-18 00:28:53
         compiled from select_show.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'select_show.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='other.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	
});
</script>
<!--当前位置 start-->
<div class="Cailocation">
  <div class="location_center">
    <h1><b>2串1高手榜</b><img src="<?php echo @STATICS_BASE_URL; ?>
/i/chuanHot.gif"></h1>
  </div>
</div>
<!--当前位置 end-->
<!--2串1 start-->
<div class="center">
  <div class="ChuanCenTer">
    <!---->
    <div class="Chuanl">
      <div class="Chuanlcur">
        <div id="tags1">
          <ul>
            <li <?php if ($this->_tpl_vars['sport'] == 'fb'): ?>class="selectTag1"<?php endif; ?> ><a href="<?php echo @ROOT_DOMAIN; ?>
/activity/select_show.php?sport=fb">足球2串1</a>
            </li>
            <li <?php if ($this->_tpl_vars['sport'] == 'bk'): ?>class="selectTag1"<?php endif; ?> ><a href="<?php echo @ROOT_DOMAIN; ?>
/activity/select_show.php?sport=bk">篮球2串1</a>
            </li>
          </ul>
        </div>
        <div>
          <div class="tagContent1 selectTag" id=""> <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <div class="Tbox">
              <dl>
                <dt><img src="<?php if ($this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']): ?><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>"/></dt>
                <dt class="name"><b><?php echo $this->_tpl_vars['users'][$this->_tpl_vars['item']['u_id']]['u_name']; ?>
</b></dt>
                <dd>
                  <div class="duiname"><b><?php if ($this->_tpl_vars['sport'] == 'bk'): ?>
                    <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match1']['id']]['a_cn']; ?>
 </b><span>VS</span><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match1']['id']]['h_cn']; ?>
 </b><i>＋</i><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match2']['id']]['a_cn']; ?>
</b><span>VS</span><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match2']['id']]['h_cn']; ?>

                    <?php else: ?>
                    <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match1']['id']]['h_cn']; ?>
 </b><span>VS</span><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match1']['id']]['a_cn']; ?>
 </b><i>＋</i><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match2']['id']]['h_cn']; ?>
</b><span>VS</span><b> <?php echo $this->_tpl_vars['matchInfos'][$this->_tpl_vars['item']['match2']['id']]['a_cn']; ?>

                    <?php endif; ?> </b>
                    <p><strong><?php $_from = $this->_tpl_vars['item']['match1']['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item1']):
?><span><i><?php echo $this->_tpl_vars['item1']; ?>
</i></span><?php endforeach; endif; unset($_from); ?></strong><em><?php $_from = $this->_tpl_vars['item']['match2']['option']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item2']):
?><span><i><?php echo $this->_tpl_vars['item2']; ?>
</i></span><?php endforeach; endif; unset($_from); ?></em></p>
                    <u>方案金额：<em>¥<?php echo $this->_tpl_vars['item']['money']; ?>
元</em></u></div>
                </dd>
              </dl>
            </div>
            <?php endforeach; endif; unset($_from); ?>
            <?php if ($this->_tpl_vars['total_page'] > 1): ?>
            <div class="page"> <a href="<?php echo @ROOT_DOMAIN; ?>
/activity/select_show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
">首页</a> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
" class="active">上一页</a> <?php endif; ?>
              <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
" class="active">下一页</a> <?php endif; ?> <a href="<?php echo @ROOT_DOMAIN; ?>
/activity/select_show.php?sport=<?php echo $this->_tpl_vars['sport']; ?>
&page=<?php echo $this->_tpl_vars['total_page']; ?>
">末页</a> </div>
            <?php endif; ?> </div>
        </div>
      </div>
    </div>
    <div class="Chuanpaihang">
      <div class="ypaihang">
        <h1>赢利率排行</h1>
        <dl>
          <dt class="first">用户名</dt>
          <dt>投注总额</dt>
          <dt>中奖总额</dt>
          <dt>赢利</dt>
        </dl>
        <?php $_from = $this->_tpl_vars['selectRank']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <?php $this->assign('num', $this->_foreach['name']['iteration']); ?> <dl <?php if ($this->_tpl_vars['num'] % 2 == 0): ?> class="active" <?php endif; ?> >
        <dd class="first"> <?php if ($this->_tpl_vars['num'] <= 3): ?> <span><?php echo $this->_tpl_vars['num']; ?>
</span><?php else: ?><em><?php echo $this->_tpl_vars['num']; ?>
</em><?php endif; ?>&nbsp;<u><?php echo $this->_tpl_vars['item']['u_name']; ?>
</u></dd>
        <dd><strong><?php echo $this->_tpl_vars['item']['money']; ?>
元</strong></dd>
        <dd><b><?php echo $this->_tpl_vars['item']['prize']; ?>
元</b></dd>
        <dd><?php echo $this->_tpl_vars['item']['rate']; ?>
%</dd>
        </dl>
        <?php endforeach; endif; unset($_from); ?>
        <div class="clear"></div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
</div>
<!--2串1 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 