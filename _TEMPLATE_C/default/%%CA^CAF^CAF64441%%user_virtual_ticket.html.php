<?php /* Smarty version 2.6.17, created on 2017-10-14 19:15:50
         compiled from user_virtual_ticket.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_virtual_ticket.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='calendar.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-zh.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" ></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='calendar-setup.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='winmac.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
var TMJF = jQuery.noConflict(true);
TMJF.conf = {
    	cdn_i: "<?php echo @STATICS_BASE_URL; ?>
/i"
    	, domain: "<?php echo @ROOT_DOMAIN; ?>
"
};
</script>
</head><body>
<script type="text/javascript">
TMJF(function($) {
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
	});
	$("#end_time").focus(function(){
	   // if (!$("#end_time").val()) {
	    showCalendar('end_time', 'y-mm-dd');
	   // }
	});
	$("table tr:nth-child(odd)").css("background-color","#f9f9f9");
});
</script>
<!--投注记录 start-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>投注管理-积分投注记录</h1>
    <div>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese" style="background:none;">
        <tr>
          <td colspan="7" style="padding:30px 0 20px 0;border-bottom:none; background:#fff;">开始时间：
            <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
            &nbsp;结束时间：
            <input type="text" name="end_time” id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
            &nbsp;
            <input class="sub"  style="width:188px;" name="" type="submit" value="查询"></td>
          </form>
        </tr>
        <tbody>
          <tr>
            <th>方案类型</th>
            <th align="center">投注积分</th>
            <th align="center">倍数</th>
            <th align="center">彩票标识</th>
            <th align="center">状态</th>
            <th align="center">认购时间</th>
            <th align="right">方案详情</th>
          </tr>
        <?php $_from = $this->_tpl_vars['userTicketInfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr>
          <td>积分投注</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['money']; ?>
积分</td>
          <td align="center"><?php echo $this->_tpl_vars['item']['multiple']; ?>
</td>
          <td align="center"><?php echo $this->_tpl_vars['statusDesc'][$this->_tpl_vars['item']['status']]['desc']; ?>
</td>
          <td align="center"><div class="jiesuancaozuo"> <?php if ($this->_tpl_vars['item']['prize'] > 0): ?>
              中奖<?php echo $this->_tpl_vars['item']['prize']; ?>
积分
              <?php endif; ?>
              <?php if ($this->_tpl_vars['item']['status'] == 2): ?> <span style="color:#000;">未中奖</span> <?php endif; ?> </div></td>
          <td align="center"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td align="right"><div class="caozuo"> <a target="_blank" href="<?php echo @ROOT_DOMAIN; ?>
/account/virtual_ticket.php?userTicketId=<?php echo $this->_tpl_vars['item']['id']; ?>
">方案详情</a> </div></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        </tbody>
        
      </table>
      <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
      <div class="pageC">
        <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
          <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?> </div>
      </div>
      <?php endif; ?> </div>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>