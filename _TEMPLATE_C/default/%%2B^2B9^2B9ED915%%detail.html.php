<?php /* Smarty version 2.6.17, created on 2017-10-14 18:16:18
         compiled from detail.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'detail.html', 2, false),array('modifier', 'convertToMoney', 'detail.html', 113, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo ((is_array($_tmp='confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
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
<div class="center">
  <div class="BitCenter">
    <div class="ConfirmationTz">
      <div class="querenguoguan">
        <h3><b>|</b><strong>投注详情</strong>
          <p>过关方式：<span><?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><?php echo $this->_tpl_vars['item']; ?>
;<?php endforeach; endif; unset($_from); ?></span><span>倍数：<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍</span><span>方案总金额：</span><em><?php echo $this->_tpl_vars['return']['money']; ?>
元</em></p>
        </h3>
        <div id="touzhuchack">
          <table class="hackermx" border="0" cellpadding="0" cellspacing="0" style="width:958px;">
            <tr>
              <th>赛事编号</th>
              <th>对阵</th>
              <th>您的选项</th>
              <th>最小赔率</th>
              <th style="border-right:1px solid #545454;">最大赔率</th>
            </tr>
            <?php $_from = $this->_tpl_vars['return']['matchInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <tr>
              <td><?php echo $this->_tpl_vars['item']['num']; ?>
</td>
              <td><?php if ($this->_tpl_vars['return']['sport'] == 'bk'): ?>
                <div class="XinagQingL"><em><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</em><span>VS</span><em><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</em></div>
                <?php else: ?>
                <div class="XinagQingL"><em><?php echo $this->_tpl_vars['item']['h_cn']; ?>
</em><span>VS</span><em><?php echo $this->_tpl_vars['item']['a_cn']; ?>
</em></div>
                <?php endif; ?></td>
              <td class="x5"><p><?php $_from = $this->_tpl_vars['item']['options']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?><?php echo $this->_tpl_vars['item1']; ?>
<?php endforeach; endif; unset($_from); ?></p></td>
              <td><?php echo $this->_tpl_vars['return']['spInfo'][$this->_tpl_vars['key']]['min_sp']; ?>
</td>
              <td style="border-right:none;"><?php echo $this->_tpl_vars['return']['spInfo'][$this->_tpl_vars['key']]['max_sp']; ?>
</td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
          </table>
        </div>
      </div>
      <!--投注确认过关方式 start-->
      <div class="querenguoguan">
        <h3><b>|</b><strong>方案明细</strong></h3>
        <div id="touzhuchack">
          <table class="hackermx" border="0" cellpadding="0" cellspacing="0" style="width:958px;">
            <tr>
              <th width="80">命中场数</th>
              <th><div class="zJbox" id="zJbox" style="height:26px; line-height:26px;">
                  <p><?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?><strong><?php echo $this->_tpl_vars['item']; ?>
</strong><?php endforeach; endif; unset($_from); ?></p>
                </div></th>
              <th width="80">倍数</th>
              <th width="350" style="border-right:1px solid #6f6f6f;"><div class="zjjbox">
                  <ul class="show">
                    <li>最小</li>
                    <li><u style="padding:0 50px; text-decoration:none;">奖金范围</u></li>
                    <li>最大</li>
                  </ul>
                </div></th>
            </tr>
            <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <tr>
              <td valign="middle"><?php echo $this->_tpl_vars['key']; ?>
</td>
              <td valign="middle"><div class="zCji">
                  <p><?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?><strong><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
</strong><?php endforeach; endif; unset($_from); ?></p>
                </div></td>
              <td valign="middle"><?php echo $this->_tpl_vars['return']['multiple']; ?>
</td>
              <td valign="middle" style="border-right:none;"><div class="zCjilist">
                  <ul>
                    <li class="first"><strong><?php echo $this->_tpl_vars['item']['min_money']; ?>
</strong></li>
                    <li><a href="javascript:void(0);" class="mx" typeId="min_<?php echo $this->_tpl_vars['key']; ?>
">明细</a></li>
                    <li class="show"><strong><?php echo $this->_tpl_vars['item']['max_money']; ?>
</strong></li>
                    <li><a href="javascript:void(0);"class="mx" typeId="max_<?php echo $this->_tpl_vars['key']; ?>
">明细</a></li>
                  </ul>
                </div></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
          </table>
          <div class="chai_detail">             <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <table class="hacker chai none" id="min_<?php echo $this->_tpl_vars['key']; ?>
" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th class="">过关方式</th>
                <th class="">中奖注数</th>
                <th class="">中奖明细(最小)</th>
                <th class="" style="border-right:1px solid #545454;">奖金</th>
              </tr>
              <?php $this->assign('zhushu', 0); ?>
              <?php $this->assign('total_sum', 0); ?>
              <?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
              <?php $this->assign('col_sum', 0); ?>              <?php if ($this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num'] > 0): ?>
              <tr>
                <td class="cwhite"><span style="color:#0B7A01; font-size:14px;"><?php echo $this->_tpl_vars['item1']; ?>
</span></td>
                <?php $this->assign('zhushu', $this->_tpl_vars['zhushu']+$this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']); ?>
                <td class="cwhite"><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
注</td>
                <td class="cwhite"><div class="jjMingxi"> <?php $_from = $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_min']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>
                    <?php $this->assign('zhu_money', $this->_tpl_vars['return']['multiple']*2); ?>                    <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*0.65); ?><?php endif; ?>
                    <p> <?php $_from = $this->_tpl_vars['item2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['item3']):
?>
                      <?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*$this->_tpl_vars['item3']); ?>
                      <?php echo $this->_tpl_vars['item3']; ?>
x
                      <?php endforeach; endif; unset($_from); ?>
                      2x<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍<?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>x65%<?php endif; ?>=<b><?php echo ((is_array($_tmp=$this->_tpl_vars['zhu_money'])) ? $this->_run_mod_handler('convertToMoney', true, $_tmp) : convertToMoney($_tmp)); ?>
</b> <?php $this->assign('col_sum', $this->_tpl_vars['col_sum']+$this->_tpl_vars['zhu_money']); ?> </p>
                    <?php endforeach; endif; unset($_from); ?> </div></td>
                <?php $this->assign('total_sum', $this->_tpl_vars['total_sum']+$this->_tpl_vars['col_sum']); ?>
                <td class="cwhite" style="border-right:none;"><div class="jjMingxi"><strong><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_min_money']; ?>
元</strong></div></td>
              </tr>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>
              <tr>
                <td  colspan="4" class="cwhite" align="right"; style="padding:0 50px 0 0;border-right:1px solid #fff;">合计&nbsp;<span><?php echo $this->_tpl_vars['zhushu']; ?>
注</span><strong style="font-size:12px;color:#dc0000;font-weight:300;">&nbsp;<?php echo $this->_tpl_vars['item']['min_money']; ?>
元</strong></td>
              </tr>
            </table>
            <?php endforeach; endif; unset($_from); ?>
            
                        <?php $_from = $this->_tpl_vars['return']['detail']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
            <table class="hacker chai none" id="max_<?php echo $this->_tpl_vars['key']; ?>
" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th class="">过关方式</th>
                <th class="">中奖注数</th>
                <th class="">中奖明细(最大)</th>
                <th class="" style="border-right:1px solid #545454;">奖金</th>
              </tr>
              <?php $this->assign('zhushu', 0); ?>
              <?php $this->assign('total_sum', 0); ?>
              <?php $_from = $this->_tpl_vars['return']['select']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
              <?php $this->assign('col_sum', 0); ?>              <?php if ($this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num'] > 0): ?>
              <tr>
                <td class="cwhite"><span style="color:#0B7A01; font-size:14px;"><?php echo $this->_tpl_vars['item1']; ?>
</span></td>
                <?php $this->assign('zhushu', $this->_tpl_vars['zhushu']+$this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']); ?>
                <td class="cwhite"><?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['hit_num']; ?>
注</td>
                <td class="cwhite"><div class="jjMingxi"> <?php $_from = $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_max']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key2'] => $this->_tpl_vars['item2']):
?>
                    <?php $this->assign('zhu_money', $this->_tpl_vars['return']['multiple']*2); ?>                    <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?><?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*0.65); ?><?php endif; ?>
                    <p> <?php $_from = $this->_tpl_vars['item2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key3'] => $this->_tpl_vars['item3']):
?>
                      <?php $this->assign('zhu_money', $this->_tpl_vars['zhu_money']*$this->_tpl_vars['item3']); ?>
                      <?php echo $this->_tpl_vars['item3']; ?>
x
                      <?php endforeach; endif; unset($_from); ?>
                      2x<?php echo $this->_tpl_vars['return']['multiple']; ?>
倍<?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>x65%<?php endif; ?>=<b>&nbsp;<?php echo ((is_array($_tmp=$this->_tpl_vars['zhu_money'])) ? $this->_run_mod_handler('convertToMoney', true, $_tmp) : convertToMoney($_tmp)); ?>
</b> <?php $this->assign('col_sum', $this->_tpl_vars['col_sum']+$this->_tpl_vars['zhu_money']); ?> </p>
                    <?php endforeach; endif; unset($_from); ?> </div></td>
                <?php $this->assign('total_sum', $this->_tpl_vars['total_sum']+$this->_tpl_vars['col_sum']); ?>
                <td class="cwhite" style="border-right:none;"><div class="jjMingxi"><strong>&nbsp;<?php echo $this->_tpl_vars['item'][$this->_tpl_vars['item1']]['prize_detail_max_money']; ?>
元</strong></div></td>
              </tr>
              <?php endif; ?>
              <?php endforeach; endif; unset($_from); ?>
              <tr>
                <td  colspan="4" class="cwhite" align="right"; style="padding:0 50px 0 0;border-right:1px solid #fff;">合计<?php echo $this->_tpl_vars['zhushu']; ?>
注<strong style="font-size:12px;color:#dc0000;font-weight:300;">&nbsp;<?php echo $this->_tpl_vars['item']['max_money']; ?>
元</strong></td>
              </tr>
            </table>
            <?php endforeach; endif; unset($_from); ?> </div>
          <div class="zhu"><span>注：</span>
            <p> <?php if ($this->_tpl_vars['return']['sport'] == 'bd'): ?>
              奖金评测的为北单即时奖金指数，最终实际奖金按照北单官方给定的指数计算，仅供参考。
              <?php else: ?>
              奖金评测的为即时竞彩奖金指数，仅供参考；最终实际奖金请按照出票后票样中的指数计算。<br/>
              该奖金评测计算中已包含单一玩法的奖金，仅供参考。
              <?php endif; ?> </p>
          </div>
        </div>
      </div>
      <!--投注确认过关方式 end-->
    </div>
  </div>
  <!--确认投注center end-->
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 