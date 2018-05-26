<?php /* Smarty version 2.6.17, created on 2017-10-17 16:51:05
         compiled from ../admin/user/user_connect.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://www.zhiying365.com/www/statics/j/jquery-1.9.1.min.js"></script>

<body>
<script type="text/javascript">
TMJF(function($) {
	var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";
	$("#start_time").focus(function(){
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
	});
	
	$("#end_time").focus(function(){
	    //if (!$("#end_time").val()) {
	    showCalendar('end_time', 'y-mm-dd');
	    //}
	});
	$(".unbind").click(function(){
		if (!confirm("确定为:  "+$(this).attr('u_name')+"   执行"+$(this).text()+"操作吗？")) return false; 
		$.post(root_domain + '/admin/admin_operate.php'
                , {connect_id: $(this).attr('connect_id'),
					type:'unbind'
                  }
                , function(data) {
                	alert(data.msg);
                	if (data.ok) {
                		window.location.reload(true);
                	}
                }
                , 'json'
            );
	});	
});
</script>
<script type="text/javascript">
      /* 当鼠标在表格上移动时，离开的那一行背景恢复 */
      $(document).ready(function(){ 
            $(".admintable tr td").mouseout(function(){
                var bgc = $(this).parent().attr("bg");
                $(this).parent().find("td").css("background-color",bgc);
            });
      })
      
      $(document).ready(function(){ 
            var color="#DCF2FC"
            $(".admintable tr:odd td").css("background-color",color);  //改变偶数行背景色
            /* 把背景色保存到属性中 */
            $(".admintable tr:odd").attr("bg",color);
            $(".admintable tr:even").attr("bg","#fff");
      })
      </script>
<!--投注记录 start-->
<div class="UserRight">
<form method="post">
<div class="timechaxun" style="height:45px;">
  <ul>
  <li>
      用户名：
      <input type="text" name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
">|
      平台用户名：
      <input type="text" name="c_name" id="c_name" value="<?php echo $this->_tpl_vars['c_name']; ?>
">|
    开始时间：
      <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
    结束时间：
      <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
      登录类型：
      <select id='type' name='type'>
      <option value='0' selected>==全部类型==</option>
      <?php $_from = $this->_tpl_vars['typeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
      <option value='<?php echo $this->_tpl_vars['key']; ?>
' <?php if ($this->_tpl_vars['type'] == $this->_tpl_vars['key']): ?>selected<?php endif; ?>><?php echo $this->_tpl_vars['item']['desc']; ?>
</option>
      <?php endforeach; endif; unset($_from); ?>
      </select>
      是否绑定：
      <select id='status' name='status'>
      <option value='0' selected>==全部类型==</option>
      <option value='1' <?php if ($this->_tpl_vars['status'] == 1): ?>selected<?php endif; ?>>已绑定</option>
      <option value='2' <?php if ($this->_tpl_vars['status'] == 2): ?>selected<?php endif; ?>>未绑定</option>
      </select>
      <input type="submit" name="" value="查询">
    </li>
  </ul>
  <div class="clear"></div>
</div>
</form>
<div>
  <h2>
  <b>●</b>用户绑定信息</h2>
  <div class="admintable">
    <table width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5" >
      <tbody>
        <tr>
          <th>序号</th>
          <th>我方用户名</th>
          <th>我方用户id</th>
          <th>平台用户名</th>
          <th>平台用户id</th>
          <th>初次绑定时间</th>
          <th>绑定更新时间</th>
          <th>类型</th>
          <th>状态</th>
        </tr>
        <?php $_from = $this->_tpl_vars['results']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
          <td class="show"><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['u_name']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['u_id']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['c_name']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['c_uid']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['item']['modify_time']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['typeDesc'][$this->_tpl_vars['item']['type']]['desc']; ?>
</td>
          <td class="show">
          <?php if ($this->_tpl_vars['item']['status'] == 1): ?>已绑定<a href="javascript::void(0);" class="unbind" connect_id="<?php echo $this->_tpl_vars['item']['id']; ?>
" u_name="<?php echo $this->_tpl_vars['item']['u_name']; ?>
">解绑帐号</a><?php endif; ?>
          <?php if ($this->_tpl_vars['item']['status'] == 2): ?>未绑定<?php endif; ?>
          </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
      </tbody>
    </table>
  </div>
  <div class="pages"> <?php if ($this->_tpl_vars['previousUrl']): ?> <a href="<?php echo $this->_tpl_vars['previousUrl']; ?>
">上页</a> <?php endif; ?>
            <?php if ($this->_tpl_vars['nextUrl']): ?> <a href="<?php echo $this->_tpl_vars['nextUrl']; ?>
">下页</a> <?php endif; ?></div>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>