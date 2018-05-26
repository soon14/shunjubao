<?php /* Smarty version 2.6.17, created on 2017-10-14 18:53:41
         compiled from user_pms.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_pms.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
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
<body>
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
<!--用户中心消息-->
<div>
  <div class="rightcenetr">
    <h1><span>▌</span>个人信息-站内信<span style="padding:0 0 0 10px; font-size:12px; font-weight:300;color:#dc0000;">（<?php echo $this->_tpl_vars['unRecieviSum']; ?>
）</span></h1>
  </div>
  <div class="msg" style="text-align:left;">
    <div class="tabuser">
      <ul>
        <li class="active" style="border-bottom:1px solid #fff; position:relative;top:-1px;"><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=1">未读消息</a> </li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=2" >已读消息</a> </li>
      </ul>
    </div>
    <div class="" style="padding:20px 0 0 0;">
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="stripese">
        <tr>
          <th>主题</th>
          <th>内容</th>
          <th>时间</th>
          <th>操作</th>
        </tr>
        <?php $_from = $this->_tpl_vars['userPMSInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['pms'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['pms']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['pms']['iteration']++;
?>
        <tr>
          <td><b><?php echo $this->_tpl_vars['item']['subject']; ?>
</b></td>
          <td><?php echo $this->_tpl_vars['item']['body']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td><div class="caozuo"><?php if ($this->_tpl_vars['item']['status'] == 1): ?><a class="operate" href="javascript:void(0)" type="PmsToReceive" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >已读</a> <?php elseif ($this->_tpl_vars['item']['status'] == 2): ?><a class="operate" href="javascript:void(0)" type="PmsToDelete" pmsId=<?php echo $this->_tpl_vars['item']['id']; ?>
 >删除</a><?php endif; ?></div></td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </table>
    </div>
    <div class="pages"> <?php if ($this->_tpl_vars['previousUrl'] || $this->_tpl_vars['nextUrl']): ?> <a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_pms.php?status=<?php echo $this->_tpl_vars['status']; ?>
">首页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上一页</a> <?php endif; ?>
      <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下一页</a> <?php endif; ?> </div>
  </div>
</div>
<!--用户中心消息 end-->
</body>
</html>