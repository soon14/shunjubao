<?php /* Smarty version 2.6.17, created on 2016-06-14 14:16:39
         compiled from user_pms.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_pms.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='wap_user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" />
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.9.1.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var TMJF = jQuery.noConflict(true);
</script>
</head><body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
TMJF(function($) {
	
	$(".operate").click(function(){
		var type = $(this).attr('type');
		if (type == 'PmsToDelete') {
			if (!confirm('确定删除这条短消息吗？')) return false;
		}
		$.post(Domain + '/pms/operate.php'
                , {pmsId: $(this).attr('pmsId'),
				type : type
                  }
                , function(data) {
                    if (data.ok) {
                    	window.location.reload(true);
                    } else {
                    	alert(data.msg);
                    	return;
                    }
                }
                , 'json'
            );
	});	
	
});
</script>
<!--用户中心消息 start-->
<div class="center">
  <div class="Paymingxi">
    <div class="wapxtags">
      <ul>
	    <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_head_img.php"><img src="<?php if ($this->_tpl_vars['userInfo']['u_img']): ?><?php echo $this->_tpl_vars['userInfo']['u_img']; ?>
<?php else: ?><?php echo @STATICS_BASE_URL; ?>
/i/touxiang.jpg<?php endif; ?>" /></a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=1">未读消息<b>&nbsp;<?php echo $this->_tpl_vars['unRecieviSum']; ?>
&nbsp;</b>封</a><span>|</span></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=2">已读消息</a> </li>
      </ul>
      <div class="clear"></div>
    </div>
    <div>
      <div class="msginfor">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <?php $_from = $this->_tpl_vars['userPMSInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pms'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pms']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['pms']['iteration']++;
?>
          <tr>
            <td><div class="msgC">
                <dl class="<?php if ($this->_foreach['pms']['iteration'] % 2 == 0): ?>gehang<?php else: ?>first<?php endif; ?>">
                  <dt><?php echo $this->_tpl_vars['item']['subject']; ?>
&nbsp;&nbsp;<?php if ($this->_tpl_vars['item']['status'] == 1): ?><a class="operate" href="javascript:void(0)" type="PmsToReceive" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >已读</a> <?php elseif ($this->_tpl_vars['item']['status'] == 2): ?><a class="operate" href="javascript:void(0)" type="PmsToDelete" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >删除</a><?php endif; ?><span><?php echo $this->_tpl_vars['item']['create_time']; ?>
</span></dt>
                  <dd><?php echo $this->_tpl_vars['item']['body']; ?>
</dd>
                </dl>
              </div></td>
          </tr>
          <?php endforeach; endif; unset($_from); ?>
        </table>
      </div>
      <div>
        <div class="msgpages">
          <ul>
            <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?>
            <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=<?php echo $this->_tpl_vars['status']; ?>
">首页</a></li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['previousUrl']): ?>
            <li><a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a></li>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['nextUrl']): ?>
            <li><a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a></li>
            <?php endif; ?>
          </ul>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
</div>
<!--用户中心消息 end-->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../ios/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>