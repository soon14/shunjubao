<?php /* Smarty version 2.6.17, created on 2017-10-20 11:26:30
         compiled from ../admin/admin_operate.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/admin_operate.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
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
<script type="text/javascript">
TMJF(function($) {
	$(".start_time").focus(function(){
		showCalendar($(this).attr('itemId')+'start_time', 'y-mm-dd');
	});
	$(".end_time").focus(function(){
		showCalendar($(this).attr('itemId')+'end_time', 'y-mm-dd');
	});
	$(".del").click(function(){
		if(!confirm('确定删除这条记录吗？')) return false;
		return true;
	});
	//获取日期与时间
	var myDate = new Date();
	$("#create_time").text(myDate.toLocaleString());
	
	$("form").submit(function(){
		var msg = '';
		$(".limit_money").each(function(){
			var limit_money = $(this).val();
			if(isNaN(limit_money)) {
				msg = '限制金额必须为整数';
				$(this).focus();
			}
		});
		//判断金额是否正确
		if(msg != '') {
			alert(msg);
			return false;	
		}
		return true;
	});
});
</script>

<div>
  <h2>
  <b>●</b><?php echo $this->_tpl_vars['adminOperateTypeDesc'][$this->_tpl_vars['type']]['desc']; ?>
</h2>
  <div>
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
                <?php if ($this->_tpl_vars['type'] == 1): ?>
          <td>序号</td>
          <td>玩法</td>
          <td>串关</td>
          <td>说明</td>
          <td>开始时间</td>
          <td>结束时间</td>
          <td>操作</td>
        <?php elseif ($this->_tpl_vars['type'] == 2): ?>
                  <td>序号</td>
          <td>用户名</td>
          <td>添加时间</td>
          <td>操作</td>
		<?php elseif ($this->_tpl_vars['type'] == 4): ?>
                  <td>序号</td>
          <td>功能</td>
          <td>提示信息</td>
          <td>添加时间</td>
          <td>操作</td>
        <?php elseif ($this->_tpl_vars['type'] == 5): ?>
                  <td>序号</td>
          <td>玩法</td>
          <td>星期</td>
          <td>场次</td>
          <td>添加时间</td>
          <td>操作</td>
        <?php endif; ?>
        </tr>
                <?php if ($this->_tpl_vars['type'] == 1): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">
        <select name='limit_pool'>
        <?php $_from = $this->_tpl_vars['sportAndPoolDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
        <option  value="<?php echo $this->_tpl_vars['key1']; ?>
" <?php if ($this->_tpl_vars['key1'] == $this->_tpl_vars['item']['limit_pool']): ?> selected<?php endif; ?> ><?php echo $this->_tpl_vars['item1']['desc']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
        </td>
        <td class="show"><input type='text' name='limit' value="<?php echo $this->_tpl_vars['item']['limit']; ?>
"></td>
        <td class="show"><textarea name='limit_msg'><?php echo $this->_tpl_vars['item']['limit_msg']; ?>
</textarea></td>
        <td class="show"><input type='text' name='start_time' value="<?php echo $this->_tpl_vars['item']['start_time']; ?>
" class="start_time" itemId="<?php echo $this->_tpl_vars['item']['id']; ?>
" id="<?php echo $this->_tpl_vars['item']['id']; ?>
start_time"></td>
        <td class="show"><input type='text' name='end_time' value="<?php echo $this->_tpl_vars['item']['end_time']; ?>
" class="end_time" itemId="<?php echo $this->_tpl_vars['item']['id']; ?>
" id="<?php echo $this->_tpl_vars['item']['id']; ?>
end_time"></td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">
        <select name='limit_pool' >
        <?php $_from = $this->_tpl_vars['sportAndPoolDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
        <option value="<?php echo $this->_tpl_vars['key1']; ?>
"><?php echo $this->_tpl_vars['item1']['desc']; ?>
</option>
        <?php endforeach; endif; unset($_from); ?>
        </select>
        </td>
        <td class="show"><input type='text' name='limit' value=""></td>
        <td class="show"><textarea name='limit_msg'></textarea></td>
        <td class="show"><input type='text' name='start_time' value="" class="start_time" itemId="<?php echo $this->_tpl_vars['lastid']; ?>
" id="<?php echo $this->_tpl_vars['lastid']; ?>
start_time"></td>
        <td class="show"><input type='text' name='end_time' value="" class="end_time" itemId="<?php echo $this->_tpl_vars['lastid']; ?>
" id="<?php echo $this->_tpl_vars['lastid']; ?>
end_time"></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        </tr>
         <?php elseif ($this->_tpl_vars['type'] == 2): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show"><input type='text' name='u_name' value="<?php echo $this->_tpl_vars['item']['u_name']; ?>
"></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="删除" class="del"> </td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show"><input type='text' name='u_name' value=""></td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        </tr>
        <?php elseif ($this->_tpl_vars['type'] == 3): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show"><input type='text' name='u_name' value="<?php echo $this->_tpl_vars['item']['u_name']; ?>
"></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="删除" class="del"> | <?php if ($this->_tpl_vars['item']['leitai'] == 0): ?> <a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=leitai&leitai=1">设为擂台</a><?php else: ?>   <a style="color:#F00"  href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=leitai&leitai=0">取消擂台</a><?php endif; ?></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show"><input type='text' name='u_name' value=""></td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        </tr>
        <?php elseif ($this->_tpl_vars['type'] == 4): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">所有竞彩投注暂停</td>
        <td class="show"><textarea  name="msg"><?php echo $this->_tpl_vars['item']['msg']; ?>
</textarea></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <?php if (! $this->_tpl_vars['results']): ?>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">所有竞彩投注暂停</td>
        <td class="show"><textarea  name="msg"></textarea></td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        <?php endif; ?>
        </tr>
        <tr>
        <?php elseif ($this->_tpl_vars['type'] == 5): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">
        <select name='pool'>
        <option value="had" <?php if ($this->_tpl_vars['item']['pool'] == 'had'): ?>selected<?php endif; ?>>竞彩-胜平负</option>
        <option value="SPF" <?php if ($this->_tpl_vars['item']['pool'] == 'SPF'): ?>selected<?php endif; ?>>北单-胜平负</option>
        </select></td>
        <td>
       <select name="week">
       <option value="1" <?php if ($this->_tpl_vars['item']['week'] == 1): ?>selected<?php endif; ?>>星期一</option>
       <option value="2" <?php if ($this->_tpl_vars['item']['week'] == 2): ?>selected<?php endif; ?>>星期二</option>
       <option value="3" <?php if ($this->_tpl_vars['item']['week'] == 3): ?>selected<?php endif; ?>>星期三</option>
       <option value="4" <?php if ($this->_tpl_vars['item']['week'] == 4): ?>selected<?php endif; ?>>星期四</option>
       <option value="5" <?php if ($this->_tpl_vars['item']['week'] == 5): ?>selected<?php endif; ?>>星期五</option>
       <option value="6" <?php if ($this->_tpl_vars['item']['week'] == 6): ?>selected<?php endif; ?>>星期六</option>
       <option value="7" <?php if ($this->_tpl_vars['item']['week'] == 7): ?>selected<?php endif; ?>>星期日</option>
       </select>
       </td>
       <td><input name="num" id="num" type="text" value="<?php echo $this->_tpl_vars['item']['num']; ?>
"/></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <?php if (! $this->_tpl_vars['results']): ?>
        <tr>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">
        <select name='pool' >
        <option value="had">竞彩-胜平负</option>
        <option value="SPF">北单-胜平负</option>
        </select>
        </td>
        <td>
       <select name="week" id="week">
       <option value="1">星期一</option>
       <option value="2">星期二</option>
       <option value="3">星期三</option>
       <option value="4">星期四</option>
       <option value="5">星期五</option>
       <option value="6">星期六</option>
       <option value="7">星期日</option>
       </select>
       </td>
       <td><input name="num" id="num" type="text"/></td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </tr>
        <?php endif; ?>
        <?php elseif ($this->_tpl_vars['type'] == 6): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">所有北单投注暂停</td>
        <td class="show"><textarea  name="msg"><?php echo $this->_tpl_vars['item']['msg']; ?>
</textarea></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <?php if (! $this->_tpl_vars['results']): ?>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">所有北单投注暂停</td>
        <td class="show"><textarea  name="msg"></textarea></td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        <?php endif; ?>
        <?php elseif ($this->_tpl_vars['type'] == 7): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">竞彩订单转为人工投注--添加成功</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <?php if (! $this->_tpl_vars['results']): ?>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">竞彩订单转为人工投注</td>
        <td class="show">成功添加后所有竞彩的订单均转为人工投注</td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        <?php endif; ?>
        <?php elseif ($this->_tpl_vars['type'] == 8): ?>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show">北单订单转为人工投注--添加成功</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
        </form>
        </tr>
        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
        <?php if (! $this->_tpl_vars['results']): ?>
        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show">北单订单转为人工投注</td>
        <td class="show">成功添加后所有北单的订单均转为人工投注</td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><input type='submit' value="添加"></td>
        </form>
        <?php endif; ?>
        </tr>
        
	        <?php elseif ($this->_tpl_vars['type'] == 9): ?>
	        <tr><td>ID</td><td>限额</td><td>提示信息</td><td>类型</td><td>创建时间</td><td>操作人</td><td>操作</td></tr>
		        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
			        <tr <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
			        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=edit">
			        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
			        <td class="show"><input type='text' class="limit_money" name='limit_money' value="<?php echo $this->_tpl_vars['item']['limit_money']; ?>
"></td>
			        <td class="show"><textarea  name="msg"><?php echo $this->_tpl_vars['item']['msg']; ?>
</textarea></td>
			        <td class="show"><?php echo $this->_tpl_vars['adminOperateTypeDesc'][$this->_tpl_vars['type']]['desc']; ?>
--添加成功</td>
			        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
			        <td class="show"><?php echo $this->_tpl_vars['item']['operate_uname']; ?>
</td>
			        <td class="show"><input type='submit' value="修改">&nbsp;&nbsp;|&nbsp;&nbsp;<a class="del" href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=del">删除</a></td>
			        </form>
			        </tr>
			        <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
		        <?php endforeach; endif; unset($_from); ?>
		        
	        <tr>
	        <?php if (! $this->_tpl_vars['results']): ?>
		        <form method="post" action="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=<?php echo $this->_tpl_vars['type']; ?>
&&status=<?php echo $this->_tpl_vars['status']; ?>
&&id=<?php echo $this->_tpl_vars['item']['id']; ?>
&&operate=add">
		        <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
		        <td class="show"><input type='hidden' name='type' value="<?php echo $this->_tpl_vars['type']; ?>
"><?php echo $this->_tpl_vars['lastid']; ?>
</td>
		        <td class="show"><input type='text' class="limit_money" name='limit_money' value="50"></td>
		        <td class="show"><textarea  name="msg">本时段投注限额，必须大于50元!</textarea></td>
		        <td class="show"><?php echo $this->_tpl_vars['adminOperateTypeDesc'][$this->_tpl_vars['type']]['desc']; ?>
</td>
		        <td class="show"><span id='create_time'></span></td>
		        <td class="show"><?php echo $this->_tpl_vars['operate_uname']; ?>
</td>
		        <td class="show"><input type='submit' value="添加"></td>
		        </form>
	        <?php endif; ?>
	        </tr>
	        
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>