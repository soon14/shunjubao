<?php /* Smarty version 2.6.17, created on 2017-10-20 13:22:30
         compiled from confirm/confirm_vb.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'confirm/confirm_vb.html', 3, false),)), $this); ?>
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
<link href="<?php echo ((is_array($_tmp='wap_confirmbet.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" type="text/css" rel="stylesheet" />
<script type="text/javascript">
TMJF(function($){
var is_confirm = false;$("#form_submit").click(function(){
		//防止重复提交
		if (is_confirm) {
			return false;}
		is_confirm = true;return true;});});</script>
<body>
<style>
.touzhutips{margin:0 auto;background:#FFFFCC;font-size:12px;}
.touzhutips ul{display:inline-table;display:inline-block;zoom:1;*display:inline;}
.touzhutips ul li{display:inline-table;display:inline-block;zoom:1;*display:inline;}
.touzhutips ul li b{font-size:12px;font-weight:300;color:#dc0000;}
.touzhutips ul li strong{font-size:12px;font-weight:300;color:#dc0000;}
table tr th{ height:30px;line-height:30px;font-weight:300;border-right:1px solid #e2e2e2;background:url(http://m.zhiying365.com/www/statics/i/thBj.jpg) repeat-x;}
table tr td{ height:30px;line-height:30px;border-right:1px solid #e2e2e2;}
</style>
<div class="touzhutips">
  <ul>
    <li>投注<b><?php echo $this->_tpl_vars['money']; ?>
</b>&nbsp;积分</li>
    <li>方案<strong><?php echo $this->_tpl_vars['multiple']; ?>
</strong>&nbsp;倍数</li>
  </ul>
</div>
<!---->
<div class="tipsters">
  <div class="NewsNav none">
    <h1><em>2015中国足球超级联赛...支持人中国人自己的联赛！</em></h1>
  </div>
</div>
<!---->
<form action="<?php echo @ROOT_DOMAIN; ?>
/confirm/combination_submit_vb.php" target="_self" name="form1" method="post">
  <input type="hidden" name="multiple" value="<?php echo $this->_tpl_vars['multiple']; ?>
">
  <input type="hidden" name="money" value="<?php echo $this->_tpl_vars['money']; ?>
">
  <input type="hidden" name="combination" value="<?php echo $this->_tpl_vars['combination']; ?>
">
  <input type="hidden" name="from" value="<?php echo $this->_tpl_vars['from']; ?>
">
  <!--center start-->
  <div class="center">
    <!--确认投注center start-->
    <div class="BitCenter">
      <div class="ConfirmationTz">
        <!--投注确认 start-->
        <div class="">
          <div id="touzhuchack">
            <table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
              <tr> <?php if ($this->_tpl_vars['s'] == 'bk'): ?>
                <th>客队</th>
                <th>VS</th>
                <th>主队</th>
                <?php else: ?>
                <th>主队</th>
                <th>客队</th>
                <?php endif; ?>
                <th>我的选择</th>
			  </tr>
              <?php $_from = $this->_tpl_vars['matchInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['matchInfo'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['matchInfo']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['matchInfo']):
        $this->_foreach['matchInfo']['iteration']++;
?>
              <tr>
                <td><div><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php endif; ?></div></td>
                <td><div><?php if ($this->_tpl_vars['s'] == 'bk'): ?><?php echo $this->_tpl_vars['matchInfo']['host_team']; ?>
<?php else: ?><?php echo $this->_tpl_vars['matchInfo']['guest_team']; ?>
<?php endif; ?></div></td>
                <td><div><?php echo $this->_tpl_vars['matchInfo']['key_str']; ?>
</div></td>
              </tr>
              <?php endforeach; endif; unset($_from); ?>
            </table>
          </div>
        </div>
        <!--投注确认 end-->
        <!--投注确认提交 start-->
        <div>
          <div class="confiRma">
            <p class="check none">
              <input type="checkbox" checked>
              同意<a href="<?php echo @ROOT_DOMAIN; ?>
/about/xieyi.html" target="_blank">《聚宝网代购协议》</a>，并已确认投注详情。</p>
            <p style=" padding:25px 0  15px 0;">
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<!--footer end-->
</body>
</html>