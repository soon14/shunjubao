<?php /* Smarty version 2.6.17, created on 2017-10-19 15:47:14
         compiled from user_pms.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_pms.html', 5, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "top.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='navigator.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
var Domain = '<?php echo @ROOT_DOMAIN; ?>
';
var TMJF = jQuery.noConflict(true);
</script>
<script type="text/javascript">
TMJF(function($) {
	
	$(".operate").click(function(){
		var type = $(this).attr('type');
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
    <div class="wapTAB">
      <dl>
        <dt><strong><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=1">未读消息<span>(<?php echo $this->_tpl_vars['unRecieviSum']; ?>
)</span></a></strong></dt>
        <dt><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=2">已读消息</a></dt>
      </dl>
    </div>
    <div>
      <div class="msginfor">
        <table width="99%" border="0" cellpadding="0" cellspacing="0">
          <?php $_from = $this->_tpl_vars['userPMSInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pms'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pms']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['pms']['iteration']++;
?>
          <tr>
            <td><div class="msgC">
                <dl class="<?php if ($this->_foreach['pms']['iteration'] % 2 == 0): ?>gehang<?php else: ?>first<?php endif; ?>">
                  <dd><b>[&nbsp;<?php echo $this->_tpl_vars['item']['subject']; ?>
&nbsp;]</b></dd>
                  <dd><?php echo $this->_tpl_vars['item']['body']; ?>
</dd>
                  <dd><span><?php echo $this->_tpl_vars['item']['create_time']; ?>
</span><em><?php if ($this->_tpl_vars['item']['status'] == 1): ?><a class="operate" href="javascript:void(0)" type="PmsToReceive" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >已读</a> <?php elseif ($this->_tpl_vars['item']['status'] == 2): ?><a class="operate" href="javascript:void(0)" type="PmsToDelete" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >删除</a><?php endif; ?></em></dd>
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
$this->_smarty_include(array('smarty_include_tpl_file' => "../wap/footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>