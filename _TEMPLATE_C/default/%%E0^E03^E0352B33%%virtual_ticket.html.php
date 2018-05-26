<?php /* Smarty version 2.6.17, created on 2017-10-14 19:15:52
         compiled from virtual_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'virtual_ticket.html', 3, false),)), $this); ?>
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
<link href="<?php echo ((is_array($_tmp='confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="center">
  <!--确认投注center start-->
  <div class="BitCenter">
    <div class="ConfirmationTz">
      <!--投注确认过关方式 start-->
      <div class="querenguoguan">
        <div class="TouXiang">
          <dl>
            <dt><img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</dt>
            <dd class="first">
              <p id="ticket_prize"><span>积分奖金：</span><strong><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</strong></p>
              <p style="position:relative;top:-3px;">方案类型：积分投注</p>
            </dd>
            <dd>
              <p>方案积分：<i><?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
</i></p>
              <p>方案倍数：<i><?php echo $this->_tpl_vars['userTicketInfo']['multiple']; ?>
</i>&nbsp;倍</p>
            </dd>
            <dd>
              <p>过关方式：单关</p>
              <p>认购时间：<i><?php echo $this->_tpl_vars['userTicketInfo']['create_time']; ?>
</i></p>
            </dd>
			<dd>
            <p>&nbsp;</p>
            <p>分享：
              <!-- JiaThis Button BEGIN -->
            <div class="jiathis_style" style=" position:relative;top:-25px;left:40px;"><a class="jiathis_button_qzone"></a> <a class="jiathis_button_tsina"></a> <a class="jiathis_button_tqq"></a> <a class="jiathis_button_weixin"></a> <a class="jiathis_button_renren"></a> <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a> <a class="jiathis_counter_style"></a></div>
            <script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>
            <!-- JiaThis Button END -->
            </p>
          </dd>
          </dl>
          <div class="clear"></div>
        </div>
       
        <!--方案内容 start-->
        <table class="hacker" border="0" cellpadding="0" cellspacing="0" id="hacker">
          <tbody id="detail_tr">
            <tr>
              <th>序号</th>
              <th>场次</th>
              <th>主队</th>
              <th>客队</th>
              <th>我的选择</th>
              <th>彩果</th>
              <th style="border-right:1px solid #6f6f6f;">状态</th>
            </tr>
          </tbody>
          <?php $_from = $this->_tpl_vars['matchInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['matchInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['matchInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['matchInfo']):
        $this->_foreach['matchInfo']['iteration']++;
?>
          <tr>
            <td><?php echo $this->_foreach['matchInfo']['iteration']; ?>
</td>
            <td><?php echo $this->_tpl_vars['matchInfo']['num']; ?>
</td>
            <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php endif; ?></div></td>
            <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php endif; ?></div></td>
            <td><?php echo $this->_tpl_vars['matchInfo']['key_str']; ?>
</td>
            <td><?php echo $this->_tpl_vars['resultDesc'][$this->_tpl_vars['matchInfo']['lottery_result']]['desc']; ?>
</td>
            <td><?php if ($this->_tpl_vars['userTicketInfo']['prize'] > 0): ?>
              <div class="zhuangTai"><strong><span>奖</span></strong></div>
              <?php endif; ?>
              <?php if ($this->_tpl_vars['userTicketInfo']['status'] == 2): ?>
              <div class="zhuangTai"><b class="">未中奖</b></div>
              <?php endif; ?> </td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
        <!--方案内容 end-->
      </div>
    </div>
    <!--投注确认过关方式 end-->
  </div>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>