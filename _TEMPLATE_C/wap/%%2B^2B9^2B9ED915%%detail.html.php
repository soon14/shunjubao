<?php /* Smarty version 2.6.17, created on 2017-10-18 10:52:13
         compiled from detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'convertToMoney', 'detail.html', 103, false),)), $this); ?>
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
<style>
.detail{padding:0;clear:both; margin:0;}
.detail table{margin:0 auto;width:100%;text-align:center;position:relative;top:0;}
.detail table tr th{line-height:32px;background:#545454;color:#fff;text-align:center;font-size:12px;font-weight:300;height:32px;}
.detail table tr{border-bottom:1px solid #e4e4e4;}
.detail table tr td{border-right:1px solid #e4e4e4;margin:0;height:auto; height:30px;}
.detail table tr td a{float:right;padding:0 10px 0 0;}
.detail table th{background:#545454;border-right:1px solid #fff;font-weight:300;border-bottom:1px solid #fff;padding:0;margin:0;}
.mingxitable{}
.mingxitable table{border-bottom:1px solid #e4e4e4;border-collapse:collapse;border-bottom-width:0;}
.mingxitable table tr th{line-height:32px;background:#545454;color:#fff;text-align:center;font-size:12px;font-weight:300;height:32px;}
.mingxitable table tr td{border-right:1px solid #e4e4e4;margin:0;border-bottom:1px solid #e4e4e4;height:auto; height:30px}
</style>
<body>
<script type="text/javascript">
TMJF(function($) {
	$(".mx").click(function(){
		$(".chai").hide();
		var typeId = $(this).attr('typeId');
		var obj = $("#"+typeId);
		if (obj.css('display') == 'none') {
			obj.show();
		}
	});
});
</script>
<!--center start-->
<div class="center" style="font-size:12px;">
<div>
  <p style="line-height:36px; text-align:left;padding:0 10px;">投注详情：<?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><?php echo $this->_tpl_vars['item']; ?>
<?php endforeach; endif; unset($_from); ?>&nbsp;投注金额：<span style="color:#dc0000;"><?php echo $this->_tpl_vars['return']['money']; ?>
元</span>&nbsp;<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍</p>
</div>
<div class="detail">
  <table border="0" width="100%" cellspacing="0" cellpadding="0">
    <tr> <?php if ($this->_tpl_vars['userTicketInfo']['sport'] == 'bk'): ?>
      <th>客队</th>
      <th>主队</th>
      <?php else: ?>
      <th>主队</th>
      <th>客队</th>
      <?php endif; ?>
      <th>您的选项</th>
      <th>低赔</th>
      <th>高赔</th>
    </tr>
    <?php $_from = $this->_tpl_vars['return']['matchInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr> <?php if ($this->_tpl_vars['return']['sport'] == 'bk'): ?>
      <td><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</td>
      <td><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</td>
      <?php else: ?>
      <td><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</td>
      <td><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</td>
      <?php endif; ?>
      <td><p><?php $_from = $this->_tpl_vars['item']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?><?php echo $this->_tpl_vars['item1']; ?>
<?php endforeach; endif; unset($_from); ?></p></td>
      <td><?php echo $this->_tpl_vars['return']['spInfo'][$this->_tpl_vars['key']]['min_sp']; ?>
</td>
      <td><?php echo $this->_tpl_vars['return']['spInfo'][$this->_tpl_vars['key']]['max_sp']; ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
</div>
<div class="detail">
  <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
    <tr>
      <th>场数</th>
      <th><?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><?php echo $this->_tpl_vars['item']; ?>
<?php endforeach; endif; unset($_from); ?></th>
      <th>最小</th>
      <th>最大</th>
    </tr>
    <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
    <tr>
      <td valign="middle" width="10%"><?php echo $this->_tpl_vars['key']; ?>
</td>
      <td valign="middle" width="10%"><?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
&nbsp;&nbsp;&nbsp;<?php endforeach; endif; unset($_from); ?></td>
      <td valign="middle">&nbsp;&nbsp;&nbsp;<?php echo $this->_tpl_vars['item']['min_money']; ?>
 <a href="javascript:void(0);" class="mx" typeId="min_<?php echo $this->_tpl_vars['key']; ?>
">明细</a></td>
      <td valign="middle">&nbsp;&nbsp;&nbsp;
        <?php echo $this->_tpl_vars['item']['max_money']; ?>
<a href="javascript:void(0);" class="mx" typeId="max_<?php echo $this->_tpl_vars['key']; ?>
">明细</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
  </table>
</div>
  <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<div class="mingxitable">
  <table class="chai none" id="min_<?php echo $this->_tpl_vars['key']; ?>
" border="1" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <th>过关</th>
      <th>注数</th>
      <th>中奖明细(最小)</th>
      <th>奖金</th>
    </tr>
    <?php $this->assign('zhushu', 0); ?>
    <?php $this->assign('total_sum', 0); ?>
    <?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
    <?php $this->assign('col_sum', 0); ?>    <?php if ($this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num'] > 0): ?>
    <tr>
      <td width="10%"><?php echo $this->_tpl_vars['item1']; ?>
</td>
      <?php $this->assign('zhushu', $this->_tpl_vars['zhushu']+$this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']); ?>
      <td width="10%"><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
注</td>
      <td><?php $_from = $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_min']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>
        <?php $this->assign('zhu_money', $this->_tpl_vars['return']['multiple']*2); ?>        <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*0.65); ?><?php endif; ?>
        <p style="line-height:22px; padding:0; margin:0;"> <?php $_from = $this->_tpl_vars['item2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['item3']):
?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*$this->_tpl_vars['item3']); ?><?php echo $this->_tpl_vars['item3']; ?>
x<?php endforeach; endif; unset($_from); ?>2x<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍<?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>x65%<?php endif; ?>=<?php echo ((is_array($_tmp=$this->_tpl_vars['zhu_money'])) ? $this->_run_mod_handler('convertToMoney', true, $_tmp) : convertToMoney($_tmp)); ?>
<?php $this->assign('col_sum', $this->_tpl_vars['col_sum']+$this->_tpl_vars['zhu_money']); ?></p>
        <?php endforeach; endif; unset($_from); ?></td>
      <?php $this->assign('total_sum', $this->_tpl_vars['total_sum']+$this->_tpl_vars['col_sum']); ?>
      <td><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_min_money']; ?>
元</td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td  colspan="4" align="right";>合计&nbsp;<span><?php echo $this->_tpl_vars['zhushu']; ?>
注</span><strong style="font-size:12px;color:#dc0000;font-weight:300;">&nbsp;<?php echo $this->_tpl_vars['item']['min_money']; ?>
元</strong>&nbsp;</td>
    </tr>
  </table>
</div>
<?php endforeach; endif; unset($_from); ?> 
   <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
<div class="mingxitable">
  <table class="chai none" id="max_<?php echo $this->_tpl_vars['key']; ?>
" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <th>过关</th>
      <th>注数</th>
      <th>中奖明细(最大)</th>
      <th>奖金</th>
    </tr>
    <?php $this->assign('zhushu', 0); ?>
    <?php $this->assign('total_sum', 0); ?>
    <?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
    <?php $this->assign('col_sum', 0); ?>    <?php if ($this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num'] > 0): ?>
    <tr>
      <td width="10%"><?php echo $this->_tpl_vars['item1']; ?>
</td>
      <?php $this->assign('zhushu', $this->_tpl_vars['zhushu']+$this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']); ?>
      <td width="10%"><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
注</td>
      <td><?php $_from = $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_max']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>
        <?php $this->assign('zhu_money', $this->_tpl_vars['return']['multiple']*2); ?>        <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*0.65); ?><?php endif; ?>
        <p style="line-height:22px;"> <?php $_from = $this->_tpl_vars['item2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['item3']):
?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*$this->_tpl_vars['item3']); ?><?php echo $this->_tpl_vars['item3']; ?>
x<?php endforeach; endif; unset($_from); ?>2x<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍<?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>x65%<?php endif; ?>=&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['zhu_money'])) ? $this->_run_mod_handler('convertToMoney', true, $_tmp) : convertToMoney($_tmp)); ?>
<?php $this->assign('col_sum', $this->_tpl_vars['col_sum']+$this->_tpl_vars['zhu_money']); ?> </p>
        <?php endforeach; endif; unset($_from); ?></td>
      <?php $this->assign('total_sum', $this->_tpl_vars['total_sum']+$this->_tpl_vars['col_sum']); ?>
      <td><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_max_money']; ?>
元</td>
    </tr>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
    <tr>
      <td  colspan="4" align="right">合计&nbsp;<span><?php echo $this->_tpl_vars['zhushu']; ?>
注</span><strong style="font-size:12px;color:#dc0000;font-weight:300;">&nbsp;<?php echo $this->_tpl_vars['item']['max_money']; ?>
元</strong>&nbsp;</td>
    </tr>
  </table>
</div>
<?php endforeach; endif; unset($_from); ?>
<div style="text-align:left;padding:15px 10px 25px 10px; line-height:22px;border-top:1px solid #e4e4e4;">
  <p><span>注：</span> <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>
    奖金评测的为北单即时奖金指数，最终实际奖金按照北单官方给定的指数计算，仅供参考。
    <?php else: ?>
    奖金评测的为即时竞彩奖金指数，仅供参考；最终实际奖金请按照出票后票样中的指数计算。<br/>
    该奖金评测计算中已包含单一玩法的奖金，仅供参考。
    <?php endif; ?> </p>
</div>
<!--center END-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 