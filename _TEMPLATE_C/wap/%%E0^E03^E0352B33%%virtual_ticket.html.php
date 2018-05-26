<?php /* Smarty version 2.6.17, created on 2018-03-08 22:37:00
         compiled from virtual_ticket.html */ ?>
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
.touzhutips{margin:0 auto;background:#FFFFCC;font-size:12px; height:30px; line-height:30px; text-align:center; clear:both;}
.touzhutips  strong{font-size:12px;font-weight:300;color:#dc0000;}
table tr th{ height:30px;line-height:30px;font-weight:300;border-right:1px solid #e9e9e9;border-bottom:1px solid #e9e9e9;border-top:1px solid #e9e9e9;background:url(http://m.shunjubao.xyz/www/statics/i/thBj.jpg) repeat-x;}
table tr td{ height:32px;line-height:32px;border-right:1px solid #e9e9e9;}
.zhuangTai b{font-size:12px;font-weight:300;}
.zhuangTai strong{color:#dc0000;}
.zhuangTai strong span{background:url(http://m.shunjubao.xyz/www/statics/i/bonus_redball.gif) no-repeat;text-align:center;color:#fff;font-size:12px;font-weight:300;font-family:'';display:inline-table;display:inline-block;zoom:1;*display:inline; width:23px; height:23px; line-height:23px;}
</style>
<body>
<div class="center" style="font-size:12px;">
  <div class="touzhutips">投注积分<strong><?php echo $this->_tpl_vars['userTicketInfo']['money']; ?>
</strong>&nbsp;&nbsp;&nbsp;积分奖金<strong><?php echo $this->_tpl_vars['userTicketInfo']['prize']; ?>
</strong> </div
  >
  <div class="BitCenter">
    <div class="ConfirmationTz">
      <!--投注确认过关方式 start-->
      <div class="querenguoguan">
        <!--方案内容 start-->
        <table border="0" cellpadding="0" cellspacing="0" style=" width:100%;">
          <tbody id="detail_tr">
            <tr>
              <th>主队</th>
              <th>客队</th>
              <th>我的选择</th>
              <th style="border-right:1px solid #6f6f6f;">状态</th>
            </tr>
          </tbody>
          <?php $_from = $this->_tpl_vars['matchInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['matchInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['matchInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['matchInfo']):
        $this->_foreach['matchInfo']['iteration']++;
?>
          <tr>
            <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php endif; ?></div></td>
            <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php endif; ?></div></td>
            <td><?php echo $this->_tpl_vars['matchInfo']['key_str']; ?>
</td>
            <td><?php if ($this->_tpl_vars['userTicketInfo']['prize'] > 0): ?>
              <div class="zhuangTai" style="COLOR:#"><strong><span>奖</span></strong></div>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>