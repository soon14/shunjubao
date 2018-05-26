<?php /* Smarty version 2.6.17, created on 2017-10-20 11:26:55
         compiled from ../admin/user/message_list.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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
	$(".not_shenhe").click(function(){
		$.post(root_domain + '/admin/admin_operate.php'
                , {id: $(this).attr('message_id'),type:'message_to_not_shenhe'
                  }
                , function(data) {
                	alert(data.msg);
					if(data.ok) {
						window.location=root_domain+'/admin/user/message_list.php';
					}
                	
                }
                , 'json'
            );
	});	
	$(".shenhe").click(function(){
		$.post(root_domain + '/admin/admin_operate.php'
                , {id: $(this).attr('message_id'),type:'message_to_shenhe'
                  }
                , function(data) {
                	alert(data.msg);
					if(data.ok) {
						window.location=root_domain+'/admin/user/message_list.php';
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
            $(".UserRight tr td").mouseout(function(){
                var bgc = $(this).parent().attr("bg");
                $(this).parent().find("td").css("background-color",bgc);
            });
      })
      
      $(document).ready(function(){ 
            var color="#f1f1f1"
            $(".UserRight tr:odd td").css("background-color",color);  //改变偶数行背景色
            /* 把背景色保存到属性中 */
            $(".UserRight tr:odd").attr("bg",color);
            $(".UserRight tr:even").attr("bg","#fff");
      })
      </script>
<!--投注记录 start-->
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 用户名：
          <input type="text" name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
">
          状态：
          <select name="status">
            <option value='all' selected>==全部状态==</option>
            <option value='2' <?php if ($this->_tpl_vars['status'] == 2): ?>selected<?php endif; ?>>未审核
            </option>
            <option value='1' <?php if ($this->_tpl_vars['status'] == 1): ?>selected<?php endif; ?>>已审核
            </option>
          </select>
                    <input type="submit" name="" value="查询">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
  <div>
    <h2> <b>●</b>用户留言信息</h2>
	<style>
	.tabimg table tr td img{ width:100px; height:70px;}
	</style>
    <div class="tabimg admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5" >
        <tbody>
          <tr>
            <th>序号</th>
            <th>真实姓名</th>
            <th>标题</th>
            <th>留言</th>
            <th>图片</th>
            <th>发表时间</th>
            <th>状态</th>
            <th>操作</th>
          </tr>
        <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['message'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['message']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['message']['iteration']++;
?>
        <tr 
        <?php if ($this->_foreach['message']['iteration'] % 2 == 0): ?>style='background-color:#DCF2FC'<?php endif; ?>>
        <td><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['u_name']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['title']; ?>
</td>
          <td width="100"><?php echo $this->_tpl_vars['item']['message']; ?>
</td>
          <td width="200"><?php if ($this->_tpl_vars['item']['img']): ?><img src="<?php echo $this->_tpl_vars['item']['img']; ?>
"/><?php endif; ?></td>
          <td><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td><?php echo $this->_tpl_vars['statusDesc'][$this->_tpl_vars['item']['status']]['desc']; ?>
</td>
          <td><?php if ($this->_tpl_vars['item']['status'] == 2): ?>
            <input type="button" message_id='<?php echo $this->_tpl_vars['item']['id']; ?>
' value="通过" class="shenhe"/>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['item']['status'] == 1): ?>
            <input type="button" message_id='<?php echo $this->_tpl_vars['item']['id']; ?>
' value="不通过" class="not_shenhe"/>
            <?php endif; ?> </td>
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