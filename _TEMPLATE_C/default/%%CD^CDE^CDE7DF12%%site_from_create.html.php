<?php /* Smarty version 2.6.17, created on 2017-10-28 09:48:36
         compiled from ../admin/business/site_from_create.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
	$("#create_time").text(myDate.toLocaleDateString());
});
</script>
<div class="URcenter" style="border:none;">
  <h2> <b>●</b>网站代理人信息</h2>
  <div class="tabpading">
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tbody>
        <tr>
          <th>序号</th>
          <th>外站描述</th>
          <th>外站管理组用户名<p>（外站统计时会排除这里用户，用户名用英文逗号间隔）</p></th>
          <th>外站链接</th>
          <th>创建时间</th>
          <th>创建人</th>
          <th>操作</th>
        </tr>
      <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['name'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['name']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['name']['iteration']++;
?>
      <tr 
      <?php if ($this->_foreach['name']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
      <form method="post" action="">
        <td class="show"><input type='hidden' name='id' value="<?php echo $this->_tpl_vars['item']['id']; ?>
">
          <input type='hidden' name='operate' value="modify">
          <?php echo $this->_tpl_vars['item']['id']; ?>
</td>
        <td class="show"><textarea name='describe'><?php echo $this->_tpl_vars['item']['describe']; ?>
</textarea></td>
        <td class="show"><textarea name='admin_group'><?php echo $this->_tpl_vars['item']['admin_group']; ?>
</textarea></td>
        <td class="show"><?php echo $this->_tpl_vars['item']['link']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
        <td class="show"><?php echo $this->_tpl_vars['item']['create_uname']; ?>
</td>
        <td class="show"><input type='submit' value="修改">
          &nbsp;&nbsp;|&nbsp;&nbsp;<a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/site_from_detail.php?source_key=<?php echo $this->_tpl_vars['item']['source_key']; ?>
">详情</a></td>
      </form>
      </tr>
      
      <?php $this->assign('lastid', $this->_tpl_vars['item']['id']); ?>
      <?php endforeach; endif; unset($_from); ?>
      <tr 
      <?php if ($this->_tpl_vars['lastid'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
      <?php $this->assign('lastid', $this->_tpl_vars['lastid']+1); ?>
      <form method="post" action="">
        <td class="show"><input type='hidden' name='operate' value="add">
          <?php echo $this->_tpl_vars['lastid']; ?>
</td>
        <td class="show"><textarea name='describe'></textarea></td>
        <td class="show"><textarea name='admin_group'></textarea></td>
        <td class="show">添加成功后显示</td>
        <td class="show"><span id='create_time'></span></td>
        <td class="show"><?php echo $this->_tpl_vars['uname']; ?>
</td>
        <td class="show"><input type='submit' value="添加"></td>
      </form>
      </tr>
      
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
</body>
</html>