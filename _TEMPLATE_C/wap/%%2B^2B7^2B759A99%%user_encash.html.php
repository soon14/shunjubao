<?php /* Smarty version 2.6.17, created on 2017-11-06 09:15:48
         compiled from user_encash.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_encash.html', 2, false),)), $this); ?>
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
.chaxunuser{ width:98%;margin:18px auto auto auto;}
.chaxunuser ul{width:100%;height:40px;}
.chaxunuser ul li{ float:left;height:32px;line-height:32px;text-align:left;}
.chaxunuser ul li.jiange{width:10px; text-align:center;}
.chaxunuser ul li.text{border:1px solid #ccc;width:30.2%;}
.chaxunuser ul li.text input{ background:#fff;border:1px solid #fff;color:#000;border:none;width:100%;height:30px;line-height:30px;text-align:left; padding:0;}
.chaxunuser ul li.sub{ background:#BC1E1F;width:32%;border-radius:2px;height:34px;line-height:34px;margin:0 2px 0 0;cursor:pointer; float:right;}
.chaxunuser ul li input{ background:none;color:#fff;border:none;width:100%;height:32px;line-height:32px;display:inline-table;display:inline-block;zoom:1;*display:inline;}
#start_time{background:none;border:none;width:100%;display:inline-table;display:inline-block;zoom:1;*display:inline;}
#end_time{background:none;border:none;width:100%;display:inline-table;display:inline-block;zoom:1;*display:inline;}
.NavphTab{ width:98%; margin:0 auto; height:45px;}
.NavphTab table{border:none;}
.NavphTab table tr{border:none;}
.NavphTab table tr td{background:#fff;border:none;}
.NavphTab table tr td a{color:#000;font-weight:300;font-size:14px;border-bottom:2px solid #ddd;height:40px;line-height:40px;display:block;}
.NavphTab table tr td a:hover{}
.NavphTab table tr td a.active{display:block;width:100%;color:#000;border-bottom:2px solid #dc0000; font-weight:300;}
</style>
</head><body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
    });
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
	$("#end_time").focus(function(){
        //if (!$("#end_time").val()) {
        showCalendar('end_time', 'y-mm-dd');
        //}
    });	
});
</script>
<!--提现记录 start-->
<div class="NavphTab">
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php" class="active">提现记录</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php"  style="color:#fff;" >提现记录</a></td>
      <td><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php"  style="color:#fff;" >提现记录</a></td>
      <td style="text-align:right;"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_encash.php" style="color:#777;font-size:12px;">冻结资金：<?php echo $this->_tpl_vars['userAccountInfo']['frozen_cash']; ?>
&nbsp;&nbsp;</a></td>
    </tr>
  </table>
</div>
<form method="post">
  <div class="chaxunuser">
    <ul>
      <li class="text">
        <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
      </li>
      <li class="jiange">-</li>
      <li class="text">
        <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
      </li>
      <li class="sub">
        <input class="sub" name="" type="submit" value="查询">
      </li>
    </ul>
  </div>
</form>
<div>
  <div class="shaidantable">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
      <tr>
        <th align="left">&nbsp;&nbsp;提现额度</th>
        <th>提现时间</th>
        <th align="right">状态&nbsp;&nbsp;</th>
      </tr>
      <?php $_from = $this->_tpl_vars['userEncashInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['log'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['log']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['userEncashInfo']):
        $this->_foreach['log']['iteration']++;
?>
      <tr>
        <td align="left">&nbsp;&nbsp;<?php echo $this->_tpl_vars['userEncashInfo']['money']; ?>
元</td>
        <td style="color:#999;"><?php echo $this->_tpl_vars['userEncashInfo']['create_time']; ?>
</td>
        <td align="right"><?php echo $this->_tpl_vars['EncashStatusDesc'][$this->_tpl_vars['userEncashInfo']['encash_status']]['desc']; ?>
&nbsp;&nbsp;</td>
      </tr>
      <?php endforeach; endif; unset($_from); ?>
    </table>
  </div>
  <br/>
  <br/>
  <div class="clear"></div>
  <div> <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
    <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> </div>
    <?php endif; ?>
    <?php endif; ?> </div>
</div>
<!--提现记录 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>