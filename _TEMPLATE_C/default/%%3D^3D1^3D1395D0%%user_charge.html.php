<?php /* Smarty version 2.6.17, created on 2018-05-23 15:36:27
         compiled from user_charge.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', 'user_charge.html', 2, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link type="text/css" rel="stylesheet" href="<?php echo ((is_array($_tmp='user.css')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
" >
<body style=" background:#f9f9f9;">
<script language="javascript" src="<?php echo ((is_array($_tmp='payment.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script> 
<script type="text/javascript" src="http://www.shunjubao.xyz/www/statics/j/jquery.js"></script> 
<script type="text/javascript">
TMJF(function($) {
});
</script>
<div class="head">
  <h1><a href="/"></a><u></u>
    <ul>
      <li><!--<a href="/">返回首页</a>--><!--<span>|</span><a href="<?php echo @ROOT_DOMAIN; ?>
/account/user_center.php?p=account_log">用户中心</a>--></li>
    </ul>
  </h1>
</div>
<!--center start-->
<div class="cnetr">
  <div class="payname">
    <ul>
      <li>实时到账支付，手续费为0。</li>
      <li>充值账户：<b><?php echo $this->_tpl_vars['userInfo']['u_name']; ?>
</b></li>
      <li>账户余额：<strong>&yen;<?php echo $this->_tpl_vars['userAccount']['cash']; ?>
元</strong></li>
    </ul>
  </div>
  <div class="pay"> 
    <!---->
    <form action='' method="post" id="gotocash">
      <div class="paycenter">
        <dl>
          <dt>充值金额：</dt>
          <dd>
            <ul>
              <li><a href="" class="charge_cash" payment="50">50元</a></li>
              <li><a href="" class="charge_cash" payment="100">100元</a></li>
              <li><a href="" class="charge_cash" payment="500">500元</a></li>
              <li>
                <div>
                  <input type="text" name="" value="其他金额" style="width:90px;height:32px;line-height:32px;border-radius:2px;border:1px solid #ccc;text-align:center;" id="inputc1"/>
                  <span style="margin-left: 10px;color: red;">其他金额单笔不超过3000元</span>
                </div>
              </li>
            </ul>
          </dd>
        </dl>
        <div class="clear"></div>
        <dl class="show">
          <dt>选择支付方式：</dt>
          <dd>
            <ol>
            
            <!--
            	说明:
                ALIPAY2  南粤支付宝扫码
                wx  南粤  中信网银_微信
               rhwx   融汇_微信 
               rhALIPAY 融汇_支付宝
               
               alipay  聚宝支付宝
               cibALIPAY 兴业银行支付宝
                
                
            -->
          	  <!--<li class="weixin" style=""><a href="" class="pay_bank" pay_bank="wx" >微信充值</a></li>-->
              <!--<li class="paypal" style=""><a href="" class="pay_bank" pay_bank="<?php echo $this->_tpl_vars['pc_charge_mark']; ?>
">支付宝</a></li>-->
              <li class="weixin" style=""><a href="" class="pay_bank" pay_bank="kjWX" >微信充值</a></li>
              <li class="paypal"><a href="" class="pay_bank" pay_bank="kjALIPAY">支付宝</a></li>
		
           <!--   <li class="jingdong" ><a href="" class="pay_bank" pay_bank="jdPayDebitCredit" >银行快捷</a></li>
              
			  <li class="jianshe"><a href="" class="pay_bank" pay_bank="CCB1">建设银行</a></li>
              <li class="zhaoshang"><a href="" class="pay_bank" pay_bank="CMB1">招商银行</a></li>
              <li class="nongye"><a href="" class="pay_bank" pay_bank="ABC1">农业银行</a></li>
              <li class="zhongguo"><a href="" class="pay_bank" pay_bank="BOC1">中国银行</a></li>
              <li class="zhongxin"><a href="" class="pay_bank" pay_bank="CITIC1">中信银行</a></li>
              <li class="guangfa"><a href="" class="pay_bank" pay_bank="CGB1">广发银行</a></li>
              <li class="guangda"><a href="" class="pay_bank" pay_bank="CEB1">光大银行</a></li>
              <li class="pingan"><a href="" class="pay_bank" pay_bank="PAYH1">平安银行</a></li>
              <li class="xingye"><a href="" class="pay_bank" pay_bank="CIB1">兴业银行</a></li>
              <li class="gongshang"><a href="" class="pay_bank" pay_bank="ICBC1">工商银行</a></li>
              <li class="jiaotong"><a href="" class="pay_bank" pay_bank="BOCM1">交通银行</a></li>
              <li class="youzheng"><a href="" class="pay_bank" pay_bank="PSBC1">邮政</a></li>
              <li class="pufa"><a href="" class="pay_bank" pay_bank="SPDB1">浦发银行</a></li>
              <li class="huaxia"><a href="" class="pay_bank" pay_bank="HXB1">华夏银行</a></li>
              <li class="shanghai"><a href="" class="pay_bank" pay_bank="SHBANK1">上海银行</a></li>-->
               

               
              
              <!--<li class="tenpay"><a href="" class="pay_bank" pay_bank="">财付通</a></li>--> 
             <!-- <li class="jianshe"><a href="" class="pay_bank" pay_bank="CCB">建设银行</a></li>
              <li class="zhaoshang"><a href="" class="pay_bank" pay_bank="CMB">招商银行</a></li>
              <li class="nongye"><a href="" class="pay_bank" pay_bank="ABC">农业银行</a></li>
              <li class="zhongguo"><a href="" class="pay_bank" pay_bank="BOCB2C">中国银行</a></li>
			  <li class="gongshang"><a href="" class="pay_bank" pay_bank="ICBCB2C">工商银行</a></li>
              <li class="guangfa"><a href="" class="pay_bank" pay_bank="GDB">广发银行</a></li>
              <li class="guangda"><a href="" class="pay_bank" pay_bank="CEBBANK">光大银行</a></li>
              <li class="zhongxin"><a href="" class="pay_bank" pay_bank="CITIC">中信银行</a></li>
              <li class="guangda"><a href="" class="pay_bank" pay_bank="CEBBANK">光大银行</a></li>
              <li class="pingan"><a href="" class="pay_bank" pay_bank="SPABANK">平安银行</a></li>
              <li class="xingye"><a href="" class="pay_bank" pay_bank="CIB">兴业银行</a></li>              
              <li class="jiaotong"><a href="" class="pay_bank" pay_bank="COMM">交通银行</a></li>              
              <li class="youzheng"><a href="" class="pay_bank" pay_bank="PSBC-DEBIT">邮政</a></li>
              <li class="minsheng"><a href="" class="pay_bank" pay_bank="CMBC">民生银行</a>
              <li class="pufa"><a href="" class="pay_bank" pay_bank="SPDB">浦发银行</a></li>
              <li class="nanjing"><a href="" class="pay_bank" pay_bank="NJBANK">南京银行</a>
              <li class="ningbo"><a href="" class="pay_bank" pay_bank="NBBANK">宁波银行</a></li>-->
            <!--  <li class="yeepay" style="display:none;"><a href="" class="pay_bank" pay_bank="yeepay" style="color:#fff;">易宝支付</a></li>-->
            </ol>
          </dd>
        </dl>
        <div class="clear"></div>
        <div class="payNext">
          <p><a href="" id="payment" target="_blank">下一步
            <input id="u_id" type="hidden" value="<?php echo $this->_tpl_vars['userAccount']['u_id']; ?>
"/>
            </a></p>
        </div>
      </div>
    </form>
    <!---->
    <div class="bottips">如您在充值过程中遇到问题，请联系我们客服热线:QQ:1323698651,或联系我们在线客服&nbsp;<a style="position:relative;top:3px;" href="http://wpa.qq.com/msgrd?v=3&amp;uin=1323698651&amp;site=qq&amp;menu=yes" target="_blank"><img border="0" title="在线客服" alt="在线客服" src="<?php echo @ROOT_DOMAIN; ?>
/www/statics/i/ServicesQ.jpg"></a><br/>
      <br/>
      <br/>
      <br/>
    </div>
  </div>
</div>

<style>
.tips{margin:0 auto;width:350px;text-align:center;font-size:26px;font-family:'Microsoft YaHei';font-weight:900;padding:12px 0 0 0;}
.aaaaa{font-size:14px;text-align:center;width:550px;margin:0 auto;text-align:left;font-size:18px;font-family:'Microsoft YaHei';font-weight:300;line-height:30px;text-indent:38px;line-height:40px;padding:20px 0 0 0;}
.aaaaa p{font-size:14px;line-height:32px;font-size:16px;font-family:'Microsoft YaHei';font-weight:300;}
.aaaaa p span{ font-family:'宋体'}
.openwindowscenter{width:350px;height:500px;margin:0 auto;text-align:left;background:#fff;padding:10px 20px;position:relative;margin:0 auto;border-radius:7px;}
.openwindowscenter h1 a{padding:15px 15px 0 10px;position:absolute;right:10px;top:0;color:#565656;font-size:14px;color:#ed2424;font-family:'宋体';font-size:14px;font-weight:300;}
.openwindowspage{}
.openwindowspage h2{font-size:12px;color:#666;font-weight:300;margin:30px 0;height:36px;line-height:36px;background:#FFF5ED;padding:0 15px;}
.openwindowspage h5{font-size:12px;color:#666;font-weight:300;margin:0 0 10px 0;height:36px;line-height:26px;padding:0 15px;}
.openwindowspage h5 em{font-style:normal;color:#ed2424;padding:0 5px 0 0;}
.openwindowspage h6{font-size:12px;color:#666;font-weight:300;margin:0 0 10px 0;line-height:26px;border:1px solid #ed2424;background:#FFF5ED;padding:10px 20px;}
.openwindowspage h6 a{color:#ed2424;}
.openwindowspage h6 a:hover{text-decoration:underline;}
.openwindowspage h7{padding:0 0 0 100px;height:40px;line-height:40px;color:#ed2424;}
.black_overlay{display:none;background-color:#444;width:100%;height:100%;left:0;top:0;/*FF IE7*/
filter:alpha(opacity=80);/*IE*/
opacity:0.8;/*FF*/
z-index:9999999999999999999999;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/

}
.white_content{display:none;left:0%;/*FF IE7*/
top:15%;/*FF IE7*/

z-index:9999999999999999999999;margin:0 auto;width:100%;vertical-align:middle;position:fixed!important;/*FF IE7*/
position:absolute;/*IE6*/

_top:e&shy;xpression(eval(document.compatMode &&
            document.compatMode=='CSS1Compat') ?
            documentElement.scrollTop + (document.documentElement.clientHeight-

this.offsetHeight)/2 :/*IE6*/
            document.body.scrollTop + (document.body.clientHeight - 

this.clientHeight)/2);/*IE5 IE5.5*/}
</style>
<div id="fade" class="black_overlay"></div>
<!--弹出层start-->
<div style="display:;">
  <div id="light1" class="white_content">
    <div class="openwindowscenter" style="height:200px;width:580px;">
      <div>
        <h1 style="border:none;"><span><a href="javascript:void(0)" onClick="document.getElementById('light1').style.display='none';document.getElementById('fade').style.display='none';window.location.reload();" style="text-decoration:none;">关闭</a></span></h1>
        <div class="openwindowspage">
          <div class="tips">温馨提示</div>
          <div class="aaaaa">
            <p><span></span>需充值的会员请联系客服进行手工充值（客服微信：zy365118或a37573231,客服QQ3043163441或1323698651）为避免充不上，请于赛前20分钟完成充值<span></span></p>
            <p>
            <p style="text-align:right;font-size:14px;">聚宝网官方</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--弹出层end-->


<!--center end--> 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "foot.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 