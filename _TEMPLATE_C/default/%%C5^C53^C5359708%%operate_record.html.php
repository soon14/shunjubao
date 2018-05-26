<?php /* Smarty version 2.6.17, created on 2018-03-05 14:17:48
         compiled from ../admin/system/operate_record.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://www.shunjubao.xyz/www/statics/j/jquery-1.9.1.min.js"></script>
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
});
</script>
<!--投注记录 start-->
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li>操作类型：
          <select name='type' id='type' >
            <option value="all" selected>全部类型</option>
            <?php $_from = $this->_tpl_vars['typeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['type'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
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
    <h2> <b>●</b>操作记录(<?php echo $this->_tpl_vars['num']; ?>
)</h2>
    <div class="admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>操作人</th>
            <th>类型</th>
            <th>日志</th>
            <th>时间</th>
          </tr>
        <?php $_from = $this->_tpl_vars['logInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <tr>
          <td><?php echo $this->_tpl_vars['item']['id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['item']['o_uname']; ?>
</td>
          <td><?php echo $this->_tpl_vars['typeDesc'][$this->_tpl_vars['item']['type']]; ?>
</td>
          <td><?php $_from = $this->_tpl_vars['item']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key1'] => $this->_tpl_vars['item1']):
?>
            <?php if ($this->_tpl_vars['key1'] != 'id' && $this->_tpl_vars['key1'] != 'o_uname' && $this->_tpl_vars['key1'] != 'type' && $this->_tpl_vars['key1'] != 'create_time'): ?>
            <p><span style="display:inline-table;display:inline-block;zoom:1;*display:inline; width:100px; text-align:right;overflow:hidden;"><?php echo $this->_tpl_vars['key1']; ?>
：</span>&nbsp;<b style=" font-weight:300;display:inline-table;display:inline-block;zoom:1;*display:inline; width:200px; text-align:left;overflow:hidden;"><?php echo $this->_tpl_vars['item1']; ?>
</b></p>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?> </td>
          <td align="center"><?php echo $this->_tpl_vars['item']['create_time']; ?>
</td>
          </td>
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