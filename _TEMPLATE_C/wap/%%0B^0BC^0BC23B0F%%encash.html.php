<?php /* Smarty version 2.6.17, created on 2017-10-18 11:17:09
         compiled from ../admin/user/encash.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "../admin/header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="http://www.zhiying365.com/www/statics/j/jquery-1.9.1.min.js"></script>
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
	$("#start_date").focus(function(){
		//if (!$("#start_time").val()) {
			showCalendar('start_date', 'y-mm-dd');
		//}
	});
	
	$("#end_date").focus(function(){
	    //if (!$("#end_time").val()) {
	  showCalendar('end_date', 'y-mm-dd');
	    //}
	});
	
	var is_confirming = false;
	$(".confirm").click(function(){
		if (is_confirming) return false;
		if (!confirm('执行这个操作('+ $(this).html() + ')?申请人：' + $(this).attr('userName'))) {
			return false;
		}
		var pms_msg = '';
		if($(this).attr('operate') == 'cancel') {
			var pms_msg = prompt("为这个用户发送站内信","您的提现申请已经被撤销，理由是:");			 
		}
		$.post(root_domain + '/admin/user/encash.php'
                , {operate: $(this).attr('operate'),
			userEncashId :$(this).attr('userEncashId'),
			pms_msg:pms_msg
                  }
                , function(data) {
                	is_confirming = true;
                	alert(data.msg);
                    if (data.ok) {
                    	window.location.reload(true) 
                    }
                }
                , 'json'
            );
	})
	
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
          提款状态：
          <select name='encash_status' id='encash_status' >
            <option value="all" selected>全部状态</option>
            <?php $_from = $this->_tpl_vars['encashStatusDesc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?> <option value="<?php echo $this->_tpl_vars['key']; ?>
" <?php if ($this->_tpl_vars['encash_status'] == $this->_tpl_vars['key']): ?> selected <?php endif; ?> ><?php echo $this->_tpl_vars['item']['desc']; ?>

            </option>
            <?php endforeach; endif; unset($_from); ?>
          </select><br>

          开始日期：
      <input type="text" name="start_date" id="start_date"  value="<?php echo $this->_tpl_vars['start_date']; ?>
">
    开始时间：
      <input type="text" name="start_time" id="start_time" value="<?php echo $this->_tpl_vars['start_time']; ?>
">
    结束日期：
      <input type="text" name="end_date" id="end_date" value="<?php echo $this->_tpl_vars['end_date']; ?>
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
    <div class="admintable">
      <table class="" width="100%" bordercolor="#ddd" border="1" cellspacing="0" cellpadding="5">
        <tbody>
          <tr>
            <th>序号</th>
            <th>姓名</th>
            <th>手机号</th>
            <th>金额</th>
            <th>状态</th>
            <th>银行信息</th>
            <th>用户信息</th>
            <th>支付方式</th>
            <th>提现方式</th>
            <th>账户信息</th>
            <th>申请时间</th>
            <th>操作
              </td>
          </tr>
        <?php $this->assign('trade_money', 0); ?>
        <?php $_from = $this->_tpl_vars['encashInfos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['ticket'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['ticket']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['encashInfo']):
        $this->_foreach['ticket']['iteration']++;
?>
        <tr>
          <td><?php echo $this->_tpl_vars['encashInfo']['encash_id']; ?>
</td>
          <td><?php echo $this->_tpl_vars['encashInfo']['realname']; ?>
</td>
          <td><?php if ($this->_tpl_vars['encashInfo']['mobile']): ?>
            <?php echo $this->_tpl_vars['encashInfo']['mobile']; ?>

            <?php else: ?>
            <?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['encashInfo']['u_id']]['mobile']; ?>

            <?php endif; ?> </td>
          <td <?php if ($this->_tpl_vars['encashInfo']['payment'] == 2): ?>style="color:#F00"<?php endif; ?>><?php echo $this->_tpl_vars['encashInfo']['money']; ?>
元</td>
          <?php $this->assign('trade_money', $this->_tpl_vars['trade_money']+$this->_tpl_vars['encashInfo']['money']); ?>
          <td width="100"><?php if ($this->_tpl_vars['encashInfo']['encash_status'] == 1): ?> <span style="color:red;"><?php echo $this->_tpl_vars['encashStatusDesc'][$this->_tpl_vars['encashInfo']['encash_status']]['desc']; ?>
</span> <?php elseif ($this->_tpl_vars['encashInfo']['encash_status'] == 6): ?>
            <?php echo $this->_tpl_vars['encashInfo']['process_message']; ?>

            <?php else: ?>
            <?php echo $this->_tpl_vars['encashStatusDesc'][$this->_tpl_vars['encashInfo']['encash_status']]['desc']; ?>

            <?php endif; ?> </td>
          <td width="120"> 卡号： <span <?php if ($this->_tpl_vars['encashInfo']['payment'] == 2): ?>style="color:#F00"<?php endif; ?>> <?php echo $this->_tpl_vars['encashInfo']['bankcard']; ?>
</span><br/>
          开户行：<?php echo $this->_tpl_vars['encashInfo']['bank']; ?>
<br/>
            省市：<?php echo $this->_tpl_vars['encashInfo']['bank_province']; ?>
-<?php echo $this->_tpl_vars['encashInfo']['bank_city']; ?>
<br/>
            支行：<?php echo $this->_tpl_vars['encashInfo']['bank_branch']; ?>
<br/>
          </td>
          <td style="width:40px;"> 用户名：<br/>
           <span <?php if ($this->_tpl_vars['encashInfo']['payment'] == 2): ?>style="color:#F00"<?php endif; ?>> <?php echo $this->_tpl_vars['userInfos'][$this->_tpl_vars['encashInfo']['u_id']]['u_name']; ?>
</span><br/>
            手机号：<br/>
            <?php echo $this->_tpl_vars['userRealInfos'][$this->_tpl_vars['encashInfo']['u_id']]['mobile']; ?>
<br/>
          </td>
          <?php $this->assign('userPaymentInfo', $this->_tpl_vars['userPaymentInfos'][$this->_tpl_vars['encashInfo']['u_id']]); ?>
          <?php if ($this->_tpl_vars['userPaymentInfo']): ?>
          <td width="40"><?php echo $this->_tpl_vars['payTypeDesc'][$this->_tpl_vars['userPaymentInfo']['pay_type']]['desc']; ?>
<br/>
            帐号：<br/>
            <?php echo $this->_tpl_vars['userPaymentInfo']['pay_account']; ?>
</td>
          <?php else: ?>
          <td width="40">暂无</td>
          <?php endif; ?>
          <td><?php echo $this->_tpl_vars['EncashPaymentDesc'][$this->_tpl_vars['encashInfo']['payment']]['desc']; ?>
</td>
          <td> 可用余额：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['encashInfo']['u_id']]['cash']; ?>
<br/>
            彩金账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['encashInfo']['u_id']]['gift']; ?>
<br/>
            返点账户：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['encashInfo']['u_id']]['rebate']; ?>
<br/>
            冻结资金：<?php echo $this->_tpl_vars['userAccountInfos'][$this->_tpl_vars['encashInfo']['u_id']]['frozen_cash']; ?>
<br/>
          </td>
          <td><?php echo $this->_tpl_vars['encashInfo']['create_time']; ?>
</td>
          <td><?php if ($this->_tpl_vars['encashInfo']['encash_status'] == 2): ?> <a href="javascript:void(0);" class="confirm" userEncashId="<?php echo $this->_tpl_vars['encashInfo']['encash_id']; ?>
" operate="encash" userName="<?php echo $this->_tpl_vars['encashInfo']['realname']; ?>
">确认提现</a> <?php elseif ($this->_tpl_vars['encashInfo']['encash_status'] == 1): ?> <a href="javascript:void(0);" class="confirm" userEncashId="<?php echo $this->_tpl_vars['encashInfo']['encash_id']; ?>
" operate="verify" userName="<?php echo $this->_tpl_vars['encashInfo']['realname']; ?>
">确认审核</a>| <a href="javascript:void(0);" class="confirm" userEncashId="<?php echo $this->_tpl_vars['encashInfo']['encash_id']; ?>
" operate="cancel" userName="<?php echo $this->_tpl_vars['encashInfo']['realname']; ?>
">撤销提现</a> <?php endif; ?> </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?>
        <tr>
          <td colspan="12" align="left">总计：<?php echo $this->_tpl_vars['trade_money']; ?>
元</td>
        </tr>
        </tbody>
        
      </table>
    </div>
  </div>
</div>
<!--投注记录 end-->
</body>
</html>