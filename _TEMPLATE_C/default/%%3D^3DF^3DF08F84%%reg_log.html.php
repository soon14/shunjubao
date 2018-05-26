<?php /* Smarty version 2.6.17, created on 2018-03-15 11:49:16
         compiled from ../admin/user/reg_log.html */ ?>
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
		//if (!$("#start_time").val()) {
		showCalendar('start_time', 'y-mm-dd');
		//}
	});
	
	$("#end_time").focus(function(){
	    //if (!$("#end_time").val()) {
	    showCalendar('end_time', 'y-mm-dd');
	    //}
	});
		
});
</script>
<!--投注记录 start-->
<div class="UserRight">
  <form method="post">
    <div class="timechaxun" style="height:45px;">
      <ul>
        <li> 用户名：
          <input type="text" name="u_name" id="u_name" value="<?php echo $this->_tpl_vars['u_name']; ?>
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
    <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
      <tr><?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <td><?php echo $this->_tpl_vars['key']; ?>
</td>
        <?php endforeach; endif; unset($_from); ?></tr>
      <tr><?php $_from = $this->_tpl_vars['total']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
        <td><?php if ($this->_tpl_vars['key'] == '总人数'): ?><?php echo $this->_tpl_vars['item']; ?>
<?php else: ?>&yen;<?php echo $this->_tpl_vars['item']; ?>
元<?php endif; ?></td>
        <?php endforeach; endif; unset($_from); ?></tr>
    </table>
    <h2> <b>●</b>账户信息</h2>
    <div class="admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>真实姓名</th>
            <th>银行信息</th>
            <th>通讯信息</th>
            <th>账户信息</th>
            <th>注册时间</th>
                        <th>最后登录时间</th>
          </tr>
        <?php $_from = $this->_tpl_vars['chargeInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['chargeInfo']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr>
          <td><?php echo $this->_tpl_vars['chargeInfo']['u_id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['realname']; ?>
</td>
          <td> 银行卡号：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bankcard']; ?>
<br/>
            开户行：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank']; ?>
<br/>
            省市：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_province']; ?>
-<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_city']; ?>
<br/>
            支行：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_branch']; ?>
<br/>
          </td>
          <td> 用户名：<?php echo $this->_tpl_vars['userInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['u_name']; ?>
<br/>
            手机号：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['mobile']; ?>
<br/>
          </td>
          <td> 可用余额：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['cash']; ?>
<br/>
            彩金账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['gift']; ?>
<br/>
            返点账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['rebate']; ?>
<br/>
            冻结资金：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['frozen_cash']; ?>
<br/>
          </td>
          <td><?php echo $this->_tpl_vars['chargeInfo']['u_jointime']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['chargeInfo']['u_logintime']; ?>
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