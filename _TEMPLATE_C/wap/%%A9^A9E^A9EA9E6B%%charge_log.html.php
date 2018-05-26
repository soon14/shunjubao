<?php /* Smarty version 2.6.17, created on 2018-01-04 10:58:27
         compiled from ../admin/user/charge_log.html */ ?>
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
        充值状态：
          <select name='charge_type' id='charge_type' >
            <option value="all" selected>充值方式</option>
            <?php $_from = $this->_tpl_vars['chargeTypeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['charge_type'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
          |
        
        充值状态：
          <select name='charge_status' id='charge_status' >
            <option value="all" selected>全部状态</option>
            <?php $_from = $this->_tpl_vars['chargeStatusDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['charge_status'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>
          |
          用户名：
          <input type="text" name="u_name" id="u_name" style="width:120px;" value="<?php echo $this->_tpl_vars['u_name']; ?>
">
          |
          开始日期：
          <input type="text" name="start_time" id="start_time"  style="width:80px" value="<?php echo $this->_tpl_vars['start_time']; ?>
" >
           <input type="text" name="start_time2" id="start_time2"  style="width:80px"  value="<?php echo $this->_tpl_vars['start_time2']; ?>
">
          
          结束日期：
          <input type="text" name="end_time" id="end_time"  style="width:80px"  value="<?php echo $this->_tpl_vars['end_time']; ?>
">
          <input type="text" name="end_time2" id="end_time2"  style="width:80px"  value="<?php echo $this->_tpl_vars['end_time2']; ?>
">
          |第三方商户号：
          <input type="text" name="return_message" style="width:80px;"  id="return_message" value="<?php echo $this->_tpl_vars['return_message']; ?>
">
          |手动充值操作人：
          <input type="text" name="o_uname" style="width:80px;" id="o_uname" value="<?php echo $this->_tpl_vars['o_uname']; ?>
">
          |到帐方式：
           <select name='manu_income' id='manu_income' >
            <option value="" selected>全部方式</option>
           <?php $_from = $this->_tpl_vars['getCHARGEmanuincomeDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['manu_income'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select>

          <input type="submit" name="" value="查询">
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </form>
  <div>
    <div class="admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>真实姓名</th>
            <th>金额</th>
            <th>充值状态</th>
            <th>支付方</th>
            <th>支付来源</th>
            <th>交易时间</th>
            <th>银行信息</th>
            <th>账户信息</th>
            <th>当前账户</th>
            <th>平台订单号</th>
            <th>订单流水号</th>
            <th>第三方商户号</th>
            <th>到帐方式</th>
            <th>手动充值操作人</th>
            
          </tr>
        <?php $this->assign('trade_money', 0); ?>
        <?php $_from = $this->_tpl_vars['chargeInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['chargeInfo']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr>
          <td class="show"><?php echo $this->_tpl_vars['chargeInfo']['charge_id']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['realname']; ?>
</td>
          <td class="show"><?php echo $this->_tpl_vars['chargeInfo']['money']; ?>
元</td>
          <?php $this->assign('trade_money', $this->_tpl_vars['trade_money']+$this->_tpl_vars['chargeInfo']['money']); ?>
          <td class="show"><?php if ($this->_tpl_vars['chargeInfo']['charge_status'] == 2): ?> <span style="color:red;"><?php echo $this->_tpl_vars['chargeStatusDesc'][$this->_tpl_vars['chargeInfo']['charge_status']]['desc']; ?>
</span> <?php else: ?>
            <?php echo $this->_tpl_vars['chargeStatusDesc'][$this->_tpl_vars['chargeInfo']['charge_status']]['desc']; ?>

            <?php endif; ?> </td>
          <td><?php echo $this->_tpl_vars['chargeTypeDesc'][$this->_tpl_vars['chargeInfo']['charge_type']]['desc']; ?>
</td>
          <td><?php if ($this->_tpl_vars['chargeInfo']['charge_source'] == 1): ?>主站<?php endif; ?>
            <?php if ($this->_tpl_vars['chargeInfo']['charge_source'] == 10): ?>wap<?php endif; ?>
            <?php if ($this->_tpl_vars['chargeInfo']['charge_source'] == 11): ?>app<?php endif; ?>
            <?php if ($this->_tpl_vars['chargeInfo']['charge_source'] == 12): ?>ios<?php endif; ?></td>
          <td title="接口通知时间:<?php echo $this->_tpl_vars['chargeInfo']['return_time']; ?>
"><?php echo $this->_tpl_vars['chargeInfo']['create_time']; ?>
</td>
          <td class="show"> 银行卡号：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bankcard']; ?>
<br/>
            开户行：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank']; ?>
<br/>
            省市：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_province']; ?>
-<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_city']; ?>
<br/>
            支行：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['bank_branch']; ?>
<br/>
          </td>
          <td class="show"> 用户名：<?php echo $this->_tpl_vars['userInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['u_name']; ?>
<br/>
            手机号：<?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['mobile']; ?>
<br/>
          </td>
          <td class="show"> 可用余额：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['cash']; ?>
<br/>
            彩金账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['gift']; ?>
<br/>
            返点账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['rebate']; ?>
<br/>
            冻结资金：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['chargeInfo']['u_id']]['frozen_cash']; ?>
<br/>
          </td>
          <td><?php echo $this->_tpl_vars['chargeInfo']['pay_order_id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['chargeInfo']['return_code']; ?>
</td>
          <td><?php echo $this->_tpl_vars['chargeInfo']['return_message']; ?>
</td>
          <td><?php echo $this->_tpl_vars['getCHARGEmanuincomeDesc'][$this->_tpl_vars['chargeInfo']['manu_income']]['desc']; ?>
<br><?php echo $this->_tpl_vars['chargeInfo']['manu_desc']; ?>

	</td>
          <td><?php echo $this->_tpl_vars['chargeInfo']['o_uname']; ?>
</td>
          
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
          <td colspan="15" align="left"> 当前页总计:<?php echo $this->_tpl_vars['trade_money']; ?>
元,本次查询总金额：<?php echo $this->_tpl_vars['total_money']; ?>
</td>
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
</div>
<!--投注记录 end-->
</body>
</html>