<?php /* Smarty version 2.6.17, created on 2018-03-04 23:08:02
         compiled from user_score_tran.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_score_tran.html', 1, false),)), $this); ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<script language="javascript">
var ZY_CDN = '<?php echo @STATICS_BASE_URL; ?>
';
</script>
<body>
<script type="text/javascript">
$(function() {
	$("#submit").submit(function(){
		if(isNaN($("#gift").val())) {
			alert('请输入正确的数字');
			return false;
		}
		if (!confirm('兑换过程不可逆，您确定兑换？')) {
			return false;
		}
		return true;
	});
});
</script>
<style>
.tabuser{padding:30px 0 0 0;}
.tabuser ul{display:inline-table;display:inline-block;zoom:1;*display:inline;height:40px;line-height:40px;border-bottom:1px solid #ddd;width:100%; margin:0; padding:0;}
.tabuser ul li{display:inline-table;display:inline-block;zoom:1;*display:inline;margin:0 0 0 5px;}
.tabuser ul li a{display:inline-table;display:inline-block;zoom:1;*display:inline;padding:0 15px;color:#000;font-size:14px; text-decoration:none;}
.tabuser ul li a.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-1px;font-weight:300; font-family:'';}
.tabuser ul li.active{border:1px solid #ddd;border-bottom:1px solid #fff;position:relative;top:-2px;font-weight:300;}
</style>
<!--积分兑换 start-->
<div class="rightcenetr">
  <h1><span>▌</span>积分换彩金</h1>
  <div class="tabuser">
    <ul>
      <li><a href="http://www.shunjubao.xyz/account/user_gift_tran.php">彩金兑换积分</a></li>
      <li><a href="http://www.shunjubao.xyz/account/user_score_tran.php"  class="active">积分兑换彩金</a></li>
      <li><a href="http://www.shunjubao.xyz/account/user_money_tran.php">余额兑换积分</a></li>
    </ul>
  </div>
  <div> <?php if (! $this->_tpl_vars['userVirtualTicketInfo']): ?>
    <h2 style="height:30px; line-height:30px; background:#FFFFCC; padding:30px 10px;">抱歉，您没参与积分投注，没有兑换资格</h2>
    <?php else: ?>
    <h2 style="font-size:14px;">您的总积分：<span><?php echo $this->_tpl_vars['userAccountInfo']['score']; ?>
</span>&nbsp;&nbsp;可兑换彩金：<span><?php echo $this->_tpl_vars['gift']; ?>
</span></h2>
    <div class="userbiaodan">
      <form action="" method="post" id="submit">
        <dl>
          <dt>兑换积分：</dt>
          <dd style="position:relative;left:-50px;">
            <input type="text" name="score" value="<?php echo $this->_tpl_vars['userAccountInfo']['score']; ?>
" id="score"/>
            <input type="submit" class="sub" style="width:80px; height:30px; line-height:30px; position:relative;top:1px;border-radius:3px;" value="兑&nbsp;&nbsp;换" />
            <input type='hidden' name='action' value='tran'/>
          </dd>
        </dl>
        <?php if ($this->_tpl_vars['msg_error']): ?>
        <dl style="position:relative;left:-50px;">
          <dt></dt>
          <dd style="color:red;"> <?php echo $this->_tpl_vars['msg_error']; ?>
 </dd>
        </dl>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['msg_success']): ?>
        <dl style="position:relative;left:-50px;">
          <dt></dt>
          <dd style="color:red;"> <?php echo $this->_tpl_vars['msg_success']; ?>
 </dd>
        </dl>
        <?php endif; ?>
      </form>
    </div>
    <br/>
    <div  style=" font-size:12px;color:#777; line-height:24px;">
      <p>各位会员，积分是智赢网回馈用户的一种方式，积分可用于积分投注，积分可以兑换成彩金，彩金可以购买国彩。为使每个用户都能获取到智赢赠送的积分，现对原有积分规则中，月投注额区间段未有赠送积分的部分进行调整，调整的积分新规则于2017年4月1号00：00：00执行，请须知。</p>
      <p><b>积分获取规则</b></p>
      <p>1、月投注额500-8888元赠送5%；</p>
      <p>2、月投注额8888-58888元赠送6%；</p>
      <p>3、月投注额58888-188888元赠送7%；</p>
      <p>4、月投注额188888-以上元赠送8%；</p>
      <p><b>积分返还及兑换日期</b></p>
      <p>账户原有积分可任何时间段兑换彩金。当月投注总额所得积分，智赢将按照“积分获取规则”于每月月初第一天早上9点前，派送上月（月末最后一天23：59：59前的投注总额）。</p>
      <p>温馨提示：彩金、余额目前都是可以跟积分互相兑换。兑换比例：1块钱=10积分,10积分=1块彩金。</p>
      <br/>
      <?php endif; ?> </div>
  </div>
</div>
<!--积分兑换 end-->
</body>
</html>