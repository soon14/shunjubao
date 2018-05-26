<?php /* Smarty version 2.6.17, created on 2018-03-15 21:14:23
         compiled from ../admin/system/search_log.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://www.zhiying365365.com/www/statics/j/jquery-1.9.1.min.js"></script>
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
<body>
<script type="text/javascript">
TMJF(function($) {
	var root_domain = "<?php echo @ROOT_DOMAIN; ?>
";
	$("#start_time").focus(function(){
		showCalendar('start_time', 'y-mm-dd');
	});
	
	$("#end_time").focus(function(){
	    showCalendar('end_time', 'y-mm-dd');
	});
	$(".delete_log").click(function(){
		if(!confirm('确定删除这条记录吗？')) return false;
		$.post(root_domain + '/admin/admin_operate.php'
                , {id: $(this).attr('log_id'),
					type:'delete_log'
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
	$("#delete_log_all").click(function(){
		if(!confirm('确定全部删除记录吗？')) return false;
		var ids = '';
		$(".delete_log").each(function(){
			ids += $(this).attr('log_id')+',';
		});
		$.post(root_domain + '/admin/admin_operate.php'
                , {ids: ids,
					type:'delete_log_all'
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
<!--投注记录 start-->
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li>
        ID：
          <input type="text" name="id" id="id"  style="width:60px;" value="<?php echo $this->_tpl_vars['id']; ?>
">
          ,
        状态：
          <select name='status' id='status' >
            <option value="all" selected>全部状态</option>
            <option value="1" <?php if ($this->_tpl_vars['status'] == 1): ?> selected <?php endif; ?> >正常
            </option>
            <option value="2" <?php if ($this->_tpl_vars['status'] == 2): ?> selected <?php endif; ?> >错误
            </option>
          </select>
          |
          类型：
          <input type="text" name="type" id="type" value="<?php echo $this->_tpl_vars['type']; ?>
">
          |
          开始时间：
          <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
          结束时间：
          <input type="text" name="end_time" id="end_time" value="<?php echo $this->_tpl_vars['end_time']; ?>
">
          <input type="submit" name="" value="查询">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
  <div>
    <h2> <b>●</b>充值信息(<?php echo $this->_tpl_vars['num']; ?>
)</h2>
    <div class="admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>状态</th>
            <th>类型</th>
            <th>日志</th>
            <th>时间</th>
            <th>操作<a href="javascript::void(0);"  id="delete_log_all">全删</a></th>
          </tr>
        <?php $_from = $this->_tpl_vars['logInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
          <td><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['status']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['type']; ?>
</td>
          <td><textarea style="width:300px;"><?php echo $this->_tpl_vars['item']['log']; ?>
</textarea></td>
          <td><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          <td><a href="javascript::void(0);" class="delete_log" log_id="<?php echo $this->_tpl_vars['item']['id']; ?>
">删除</a> </td>
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