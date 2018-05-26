<?php /* Smarty version 2.6.17, created on 2016-02-27 11:56:23
         compiled from site_from.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
table{text-align:center;border-bottom-width:0px;border-collapse:collapse;background:#e9e9e9;margin:0 auto;overflow:hidden;}
table tr{}
table tr th{border:1px solid #e9e9e9;height:22px;line-height:22px;background:url(http://www.zhiying365.com/www/statics/i/thBj.jpg) repeat-x;font-weight:300;}
table tr td{background:#fff;border:1px solid #e9e9e9;height:22px;line-height:22px;}
</style>
<div class="ustitle">
  <h1><em>用户推广<b></b><i></i></em></h1>
</div>
<?php if (! $this->_tpl_vars['action']): ?>
    <?php if ($this->_tpl_vars['siteFromInfo']): ?>
<div class="mylink">
  <div class="tipss">
    <p><b>推广好处：</b></p>
    <br/>
    <p>1）用户推广领彩金(充值并投注)；</p>
	<p>2）用户投注再拿1%返点；
    <p>3）复制下边的链接可进行推广，让您在智赢的帐号更具价值！</p>
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
  <p><b>温馨提示!</b></p>
  <p>达到人数获取相应彩金范围：</p>
  <p>1）3人*3彩金=9彩金；</p>
  <p>2）6人—10人获得20彩金；</p>
  <p>3）11人—19人获得30彩金；</p>
  <p>4）20人—29人获得40彩金；</p>
  <p>5）30人—39人获得60彩金；</p>
  <p>6）40人—49人获得80彩金；</p>
  <p>7）50人以上（含50 人）获得100彩金。</p>
</div>
<div class="smlink"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php?action=create">创建我的推广链接</a></div>
<?php endif; ?><?php endif; ?>
    <?php if ($this->_tpl_vars['action'] == 'show'): ?>
<form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/account/user_site_from.php">
  <div class="timechaxun">
    <dl>
      <dt>开始时间：</dt>
      <dd>
        <input type="text" value="2015-02-25" id="start_time" name="start_time">
      </dd>
      <dt>结束时间：</dt>
      <dd>
        <input type="text" value="2015-03-04" id="end_time" name="end_time">
      </dd>
      <dd class="sub">
        <input type="submit" value="查询" name="">
        <input type="hidden" value="show" name="action">
      </dd>
    </dl>
  </div>
</form>
<div>
  <table cellpadding="5" cellspacing="0" width="100%">
    <tr>
      <th>注册用户总数</th>
      <th>认证用户总数</th>
      <th>有效投注量</th>
    </tr>
    <tr>
      <td class="untd"><?php echo $this->_tpl_vars['return']['total_registers']; ?>
</td>
      <td class="untd"><?php echo $this->_tpl_vars['return']['total_idcards']; ?>
</td>
      <td class="untd"><?php echo $this->_tpl_vars['return']['total_money']; ?>
</td>
    </tr>
  </table>
</div>
<div class="tipss">
  <p><b>温馨提示!</b></p>
  <p>达到人数获取相应彩金范围：</p>
  <p>1）3人*3彩金=9彩金；</p>
  <p>2）6人—10人获得20彩金；</p>
  <p>3）11人—19人获得30彩金；</p>
  <p>4）20人—29人获得40彩金；</p>
  <p>5）30人—39人获得60彩金；</p>
  <p>6）40人—49人获得80彩金；</p>
  <p>7）50人以上（含50 人）获得100彩金。</p>
</div>
<?php endif; ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../app/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>