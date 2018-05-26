<?php /* Smarty version 2.6.17, created on 2018-03-04 22:56:29
         compiled from confirm/confirm.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/confirm.html', 20, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($){
var is_confirm = false;
	$("#form_submit").click(function(){
		//防止重复提交
		if (is_confirm) {
			return false;
		}
		is_confirm = true;
		return true;
	});
	$("#jjyh").click(function(){
	   $("#form1").attr('action','http://prize.shunjubao.xyz/j/index.php?act=jc');
       $("#form1").submit();	   
	})
});
</script>
<body>
<link href="<?php echo ((is_array($_tmp='confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<!--页面头部 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/menu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--页面头部 end-->
<!--当前位置 start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "cailocation.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--当前位置 end-->
<?php if ($this->_tpl_vars['prize']): ?>
<form action="http://prize.shunjubao.xyz/j/index.php?act=jc" target="_self" id="form1" name="form1" method="post">
<?php else: ?>
<form action="<?php echo @ROOT_DOMAIN; ?>
/confirm/combination_submit<?php if ($this->_tpl_vars['s'] == 'bd'): ?>_bd<?php endif; ?>.php" target="_self"  id="form1" name="form1" method="post">
<?php endif; ?>
  <input type="hidden" name="sport" value="<?php echo $this->_tpl_vars['s']; ?>
">
  <input type="hidden" name="select" value="<?php echo $this->_tpl_vars['select']; ?>
">
  <input type="hidden" name="user_select" value="<?php echo $this->_tpl_vars['user_select']; ?>
">
  <input type="hidden" name="multiple" value="<?php echo $this->_tpl_vars['multiple']; ?>
">
  <input type="hidden" name="money" value="<?php echo $this->_tpl_vars['money']; ?>
">
  <input type="hidden" name="combination" value="<?php echo $this->_tpl_vars['c']; ?>
">
  <input type="hidden" name="pool" value="<?php echo $this->_tpl_vars['p']; ?>
">
  <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
">
  <!--center start-->
  <div class="cnetr">
    <!--确认投注center start-->
    <div class="BitCenter">
      <!--提示文字信息  start-->
      <div class="touzhutips"><em>!</em>重要提示：
        <?php if ($this->_tpl_vars['s'] != 'bd'): ?>
        您投注时的竞彩奖金指数有可能在出票时发生变化，实际数值以票样信息为准
        <?php else: ?>
        北单奖金SP值以北京体彩中心官方开奖为准，页面SP仅为投注时参考
        <?php endif; ?>
        。 请仔细查看以下<b>"投注信息"</b>校对本方案是否与您的投注相符，一旦提交，将按照本方案交易！<span style="color:red;">错误的串关将无法出票！！！</div>
      <!--提示文字信息  end-->
      <div class="ConfirmationTz">
        <!--投注确认账户信息 start-->
        <div class="touzhuxuanxiang">
          <ul>
            <li><?php echo $this->_tpl_vars['chinese_pool']; ?>
投注总金额：<b><?php echo $this->_tpl_vars['money']; ?>
</b>元</li>
            <li>倍数：<strong><?php echo $this->_tpl_vars['multiple']; ?>
</strong>倍</li>
            <li>过关方式：<span><?php if ($this->_tpl_vars['user_select'] == '1x1'): ?>单关<?php else: ?><?php echo $this->_tpl_vars['user_select']; ?>
<?php endif; ?></span><u>错误的串关将无法出票，请确认。</u></li>
            <li>账户余额：<b><?php echo $this->_tpl_vars['user_cash']; ?>
</b>元</li>
            <li class="pay"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_charge.php">充值</a></li>
			<!--<li class="pay"><span href="javascript:void(0);" id="jjyh" style="color:#fff">奖金优化</span></li>-->
          </ul>
        </div>
        <!--投注确认账户信息 end-->
        <!--投注竞彩足彩总进球\过关比分\单关比分\半全场确认 start-->
        <div class="">
          <div id="touzhuchack">
            <table class="hacker" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th>序号</th>
                <th>场次</th>
                <?php if ($this->_tpl_vars['s'] == 'bk'): ?>
                <th>客队</th>
                <th>VS</th>
                <th>主队</th>
                <?php else: ?>
                <th>主队</th>
                <th>VS</th>
                <th>客队</th>
                <?php endif; ?>
                <th>玩法</th>
                <th style="border-right:1px solid #6f6f6f;">您的选项</th>
              </tr>
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
                <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
<?php endif; ?></div></td>
                <td>VS</td>
                <td><div class=""><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['h_cn']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['a_cn']; ?>
<?php endif; ?></div></td>
                <td><?php echo $this->_tpl_vars['matchInfo']['chinese_pool']; ?>
</td>
                <td style="border-right:none;"><?php echo $this->_tpl_vars['matchInfo']['key_str']; ?>
</td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>
            </table>
          </div>
        </div>
        <!--投注竞彩足彩总进球\过关比分\单关比分\半全场确认 end-->
        <!--投注确认提交 start-->
        <div>
          <div class="confiRma">
            <p class="check">
              <input type="checkbox" checked>
              同意<a href="<?php echo @ROOT_DOMAIN; ?>
/about/xieyi.html" target="_blank">《智赢网代购协议》</a>，并已确认投注详情。</p>
            <p>
              <input type="submit" id="form_submit" class="confiRmaSub" value="确认购买" />
            </p>
          </div>
        </div>
        <!--投注确认提交 end-->
      </div>
    </div>
    <!--确认投注center end-->
  </div>
</form>
<!--center end-->
<!--Help start-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../default/foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>