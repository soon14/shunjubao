<?php /* Smarty version 2.6.17, created on 2017-11-06 09:33:06
         compiled from user_account_log.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_account_log.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<style>
.calendar{border:none;}
table{text-align:center;border-bottom-width:0px;border-collapse:collapse;background:#fff;margin:0 auto;overflow:hidden; font-size:12px;}
table tr{}
table tr td{background:#fff;border:1px solid #e9e9e9;height:26px;line-height:26px;}
.shaidantable{border-top:none; margin:20px auto; width:99%; font-size:12px;}
.shaidantable table{text-align:center;border-bottom-width:0;border-collapse:collapse;background:#fff;margin:0 0 30px 0;}
.shaidantable table tr{}
.shaidantable table tr:hover{background:#f9f9f9;}
.shaidantable table tr th{height:34px;line-height:34px;font-weight:300; background:#eee;}
.shaidantable table tr th span{ padding:0 0 0 10px;}
.shaidantable table tr td{height:36px;line-height:36px;border:none;border-bottom:1px solid #eee;}
.shaidantable table tr td.first{text-align:left;}
.shaidantable table tr td b{ont-weight:300;}
.shaidantable table tr td u{text-decoration:none;color:#666;}
.shaidantable table tr td em{border:1px solid #dc0000;padding:5px 7px;display:inline-table;display:inline-block;zoom:1;*display:inline;height:12px;line-height:12px;position:relative;top:-3px;left:10px;font-style:normal;color:#dc0000;}
.shaidantable table tr td b span{position:relative;top:-3px;}
.shaidantable table tr td b img{width:30px;height:30px;border:1px solid #ccc;border-radius:30px;margin:0 10px 0 2px;position:relative;top:7px;}
.shaidantable table tr td a{border:1px solid #ccc;color:#000;display:inline-table;display:inline-block;zoom:1;*display:inline;text-align:center;height:26px;line-height:26px; padding:0 8px;}
.shaidantable table tr td strong a:hover{}
.chaxunuser{ width:99%;margin:18px auto auto auto;}
.chaxunuser ul{width:100%;height:40px;}
.chaxunuser ul li{ float:left;height:32px;line-height:32px;text-align:left;}
.chaxunuser ul li.jiange{width:10px; text-align:center;}
.chaxunuser ul li.text{border:1px solid #ccc;width:30.2%;}
.chaxunuser ul li.text input{ background:#fff;border:1px solid #fff;color:#000;border:none;width:100%;height:30px;line-height:30px;text-align:left; padding:0;}
.chaxunuser ul li.sub{ background:#BC1E1F;width:32%;border-radius:2px;height:34px;line-height:34px;margin:0 2px 0 0;cursor:pointer; float:right;}
.chaxunuser ul li input{ background:none;color:#fff;border:none;width:100%;height:32px;line-height:32px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
#start_time{background:none;border:none;width:100%;display:inline-table;display:inline-block;zoom:1;*display:inline;}
#end_time{background:none;border:none;width:100%;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.wapTAB{ height:50px; line-height:50px;border-bottom:2px solid #ddd; width:98%; margin:0 auto; text-align:center;}
.wapTAB dl{ height:50px; line-height:50px;}
.wapTAB dl dt{ float:left;margin:0 15px 0 0; position:relative;}
.wapTAB dl dt span{ border-bottom:2px solid #dc0000; height:50px; line-height:50px; display:block; position:relative;top:-1px;}
.wapTAB dl dt em{ border-bottom:2px solid #dc0000; height:50px; line-height:50px; display:block; font-style:normal;width:60px;}
.wapTAB dl dt a{color:#000;height:50px; line-height:50px;color:#000; display:block; font-size:14px; font-weight:300;height:50px; line-height:50px;}
.wapTAB dl dd{ font-size:12px; position:absolute;right:2%;}
.wapTAB dl dd span{color:#dc0000;}
</style>
</head><body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
$(function() {
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
    });
	
	$("#end_time").focus(function(){
        showCalendar('end_time', 'y-mm-dd');
    });	
});
</script>
<!--用户中心账户明 细 start-->
<div class="wapTAB">
  <dl>
    <dt style="border-bottom:2px solid #dc0000; position:relative;top:0px;"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_account_log.php">全部明细</a></dt>
  </dl>
</div>
<form method="post">
  <div class="chaxunuser">
    <ul>
      <li class="text">
        <input type="text" value="<?php echo $this->_tpl_vars['start_time']; ?>
" id="start_time" name="start_time">
      </li>
      <li class="jiange">-</li>
      <li class="text">
        <input type="text" value="<?php echo $this->_tpl_vars['end_time']; ?>
" id="end_time" name="end_time">
      </li>
      <li class="sub">
        <input type="submit" class="sub" value="查询" name="">
        </td>
      </li>
      <li class="none">
        <input type="hidden" value="show" name="action">
      </li>
    </ul>
  </div>
</form>
<div class="Paymingxi">
  <div>
    <div class="shaidantable">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <th align="left">&nbsp;&nbsp;类型</th>
          <th align="left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;时间</th>
          <th>收入</th>
          <th>支出</th>
          <th>余额</th>
        </tr>
        <?php $this->assign('trade_amount_out', 0); ?>
        <?php $this->assign('trade_amount_in', 0); ?>
        <?php $this->assign('trade_money_out', 0); ?>
        <?php $this->assign('trade_money_in', 0); ?>
        <?php $_from = $this->_tpl_vars['userAccountLogInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userAccountLogInfo']):
        $this->_foreach['log']['iteration']++;
?>
        <?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 1): ?>
        <?php $this->assign('trade_amount_in', $this->_tpl_vars['trade_amount_in']+1); ?>
        <?php $this->assign('trade_money_in', $this->_tpl_vars['trade_money_in']+$this->_tpl_vars['userAccountLogInfo']['money']); ?>
        <?php else: ?>
        <?php $this->assign('trade_money_out', $this->_tpl_vars['trade_money_out']+$this->_tpl_vars['userAccountLogInfo']['money']); ?>
        <?php $this->assign('trade_amount_out', $this->_tpl_vars['trade_amount_out']+1); ?>
        <?php endif; ?>
        <tr>
          <td><p style="width:59px; height:30px; line-height:30px; overflow:hidden;"><?php echo $this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['desc']; ?>
</p></td>
          <td><p style="width:65px; height:30px; line-height:30px; overflow:hidden;color:#999;"><?php echo $this->_tpl_vars['userAccountLogInfo']['create_time']; ?>
</p></td>
          <td><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 1): ?><?php echo $this->_tpl_vars['userAccountLogInfo']['money']; ?>
<?php endif; ?></td>
          <td><?php if ($this->_tpl_vars['bankrollChangeType'][$this->_tpl_vars['userAccountLogInfo']['log_type']]['direction'] == 2): ?><?php echo $this->_tpl_vars['userAccountLogInfo']['money']; ?>
<?php endif; ?></td>
          <td><?php echo $this->_tpl_vars['userAccountLogInfo']['old_money']; ?>
</td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
    </div>
    <?php if (! $this->_tpl_vars['userAccountLogInfos']): ?>
    <div class="tips">暂时没有您的信息! </div>
    <?php endif; ?>
    <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
    <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
    <?php endif; ?>
    <?php endif; ?> </div>
</div>
</div>
<!--用户中心账户明细 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>