<?php /* Smarty version 2.6.17, created on 2018-03-05 17:46:06
         compiled from site_from.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'site_from.html', 2, false),array('modifier', 'number_format', 'site_from.html', 116, false),)), $this); ?>
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
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script language="javascript">
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';</script>
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
<style>
.calendar{border:none;}
table{text-align:center;border-bottom-width:0px;border-collapse:collapse;background:#fff;margin:0 auto;overflow:hidden; font-size:12px;}
table tr{}
table tr th{border:1px solid #e9e9e9;height:36px;line-height:36px;background:#f9f9f9 url(http://www.zhiying365365.com/www/statics/i/thBj.jpg) repeat-x left center;font-weight:300;}
table tr td{background:#fff;border:1px solid #e9e9e9;height:26px;line-height:26px;}
.Jifenes p{color:#555;}
.Jifenes p b{ font-weight:900;color:#000; background:#f1f1f1;display:block; height:30px; line-height:30px; margin:0 0 25px 0;border-left:2px solid #dc0000; padding:0 0 0 5px;}
.chaxunuser{ width:99%;margin:18px auto;}
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
.wapTAB dl dt span{ border-bottom:2px solid red; height:50px; line-height:50px; display:block; position:relative;top:-1px;}
.wapTAB dl dt em{ border-bottom:2px solid red; height:50px; line-height:50px; display:block; font-style:normal;width:60px;}
.wapTAB dl dt a{color:#000;height:50px; line-height:50px;color:#000; display:block; font-size:14px; font-weight:300;height:50px; line-height:50px;}
.wapTAB dl dd{ font-size:12px; position:absolute;right:2%;}
.wapTAB dl dd span{color:#dc0000;}
.mylink p b{font-weight:900;color:#000; background:#f1f1f1;display:block; height:30px; line-height:30px; margin:0 0 25px 0;border-left:2px solid #dc0000; padding:0 0 0 5px;}
</style>
<div class="wapTAB">
  <dl>
    <dt style="border-bottom:2px solid #dc0000; position:relative;top:0px;"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">推&nbsp;&nbsp;&nbsp;广</a></dt>
  </dl>
</div>
<?php if (! $this->_tpl_vars['action']): ?>
    <?php if ($this->_tpl_vars['siteFromInfo']): ?>
<div class="mylink">
  <div class="tipss">
    <p><strong>推广好处：用户投注拿1%返点!!!</strong></p>
    <br/>
    <br/>
    <p>1) 还在等什么？让您的账号更具价值-智赢推广中心期待您的加入;</p>
    <p>2）复制下边的链接可进行推广，让您在智赢的帐号更具价值！</p>
    <br/>
    <br/>
    <br/>
    <p>我的推广链接地址：</p>
    <p><?php echo $this->_tpl_vars['siteFromInfo']['link']; ?>
</p>
  </div>
  <div class="smlink"> <br/>
    <br/>
    <a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php?action=show">查看我带来的用户</a> </div>
</div>
<?php else: ?>
<div class="tipss">
  <p><b>推广概述：</b></p>
  <br/>
  <br/>
  <p>简单的说就是智赢用户生成一个推广链接地址，之后拿生成出来的链接去推广（QQ群、微信、图片、文字等等资源），通过此链接进来注册的用户，并产生投注行为，就可以拿到1%的返点啦~~~返点于每星期一早上9：00发放至账户余额里边，返点可以用于投注或直接申请提现。</p>
</div>
<div class="smlink"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php?action=create">创建我的推广链接</a></div>
<?php endif; ?><?php endif; ?>
    <?php if ($this->_tpl_vars['action'] == 'show'): ?>
<form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">
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
      </li>
      <li class="none">
        <input type="hidden" value="show" name="action">
      </li>
    </ul>
  </div>
</form>
<div >
  <table width="99%" border="0" cellpadding="0" cellspacing="0" class="stripese">
    <tr>
      <th>注册日期</th>
      <th align="center">用户名</th>
      <th align="center">认证用户</th>
      <th align="center">充值金额</th>
      <th align="center">投注金额</th>
    </tr>
    <?php $_from = $this->_tpl_vars['site_from_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['a'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['a']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['site_from_list']):
        $this->_foreach['a']['iteration']++;
?>
    <tr>
      <td align="center"><div style="color:#777; width:70px; height:24px; line-height:24px; overflow:hidden;"><?php echo $this->_tpl_vars['site_from_list']['u_jointime']; ?>
</div></td>
      <td align="center"><?php echo $this->_tpl_vars['site_from_list']['u_name']; ?>
</td>
      <td align="center"><?php if ($this->_tpl_vars['site_from_list']['idcard'] > 0): ?> 是 <?php else: ?>  <?php endif; ?></td>
      <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['charge_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
      <td align="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['site_from_list']['total_money'])) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
</td>
    </tr>
    <?php endforeach; endif; unset($_from); ?>
    <?php if (! $this->_tpl_vars['site_from_list']): ?>
    <tr>
      <td colspan="5" class="show" style="border-bottom:none; background:#FFFFcc;">未有记录数据~赶紧去宣传推广吧!</td>
    </tr>
    <?php endif; ?>
  </table>
  <div style="padding:20px 0 30px 20px; font-size:12px; text-align:left;">用户总数：<?php echo $this->_tpl_vars['return']['total_registers']; ?>
人&nbsp;&nbsp;认证总数：<?php echo $this->_tpl_vars['return']['total_idcards']; ?>
人&nbsp;&nbsp;有效投注量：<?php echo $this->_tpl_vars['return']['total_money']; ?>
元&nbsp;&nbsp;</div>
  <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
  <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
    <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> </div>
  <?php endif; ?>
  <?php endif; ?> </div>
<div class="tipss" style="padding:0;">
  <p><b style="font-weight:900;color:#000; background:#f1f1f1;display:block; height:30px; line-height:30px; margin:0 0 25px 0;border-left:2px solid #dc0000; padding:0 0 0 5px;">推广概述：</b></p>
  <br/>
  <p>简单的说就是智赢用户生成一个推广链接地址，之后拿生成出来的链接去推广（QQ群、微信、图片、文字等等资源），通过此链接进来注册的用户，并产生投注行为，就可以拿到1%的返点啦~~~返点于每星期一早上9：00发放至账户余额里边，返点可以用于投注或直接申请提现。</p>
  <p>特别说明：推广所获得返点于每星期一早上9：00发放至账户余额里边，返点可以直接申请提现。</p>
</div>
<br/>
<br/>
</div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>