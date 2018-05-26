<?php /* Smarty version 2.6.17, created on 2018-02-28 10:17:12
         compiled from ../admin/left.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'getStaticsUrl', '../admin/left.html', 5, false),)), $this); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='jquery-1.5.2.min.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='admin/chili-1.7.pack.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='admin/jquery.easing.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='admin/jquery.dimensions.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp='admin/jquery.accordion.js')) ? $this->_run_mod_handler('getStaticsUrl', true, $_tmp) : getStaticsUrl($_tmp)); ?>
"></script>
<script language="javascript">
    jQuery().ready(function(){
        jQuery('#navigation').accordion({
            header: '.head',
            navigation1: true, 
            event: 'click',
            fillSpace: false,            
            animated: 'bounceslide',
        });
    });
</script>
<style type="text/css">
<!--
body {
    margin:0px;
    padding:0px;
    font-size: 12px;
}
#navigation {
    margin:0px;
    padding:0px;
    width:147px;
}
#navigation a.head {
    cursor:pointer;
    background:url(<?php echo @STATICS_BASE_URL; ?>
/i/admin/main_34.gif) no-repeat scroll;
    display:block;
    font-weight:bold;
    margin:0px;
    padding:5px 0 5px;
    text-align:center;
    font-size:12px;
    text-decoration:none;
}
#navigation ul {
    border-width:0px;
    margin:0px;
    padding:0px;
    text-indent:0px;
}
#navigation li {
    list-style:none; display:inline;
}
#navigation li li a {
    display:block;
    font-size:12px;
    text-decoration: none;
    text-align:center;
    padding:3px;
}
#navigation li li a:hover {
    background:url(<?php echo @STATICS_BASE_URL; ?>
/i/admin/tab_bg.gif) repeat-x;
        border:solid 1px #adb9c2;
}
-->
</style>
</head>
<body style=" overflow-x:hidden;">
<div  style="width:147px;  height:100%;">
  <ul id="navigation">
    <li> <a class="head">CMS管理</a>
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/create.php" target="rightFrame">创建CMS推荐</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/subscribe_email.php" target="rightFrame">添加推荐邮箱</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/cms/reset_pwd.php" target="rightFrame">重置推荐邮箱密码</a></li>
        <li><a href="<?php echo @ROOT_CMS_SITE; ?>
/WQ2GNJQk8MSUPER/index.php" target="_blank">新闻推荐系统</a></li>
      </ul>
    </li>
    <li> <a class="head">运营功能</a>
      <ul>
                <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/site_from_create.php?operate=show" target="rightFrame">外站代理人信息</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/site_from_users.php" target="rightFrame">站内代理人信息</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/site_from_detail.php" target="rightFrame">代理信息详情</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/send_pms.php" target="rightFrame">发送站内信</a></li>
      </ul>
    </li>
    <li> <a class="head">用户管理</a>
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/modify.php" target="rightFrame">用户资料查询和修改</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/reset_pwd.php" target="rightFrame">用户密码修改</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/tickets.php" target="rightFrame">用户投注纪录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/gift_log.php" target="rightFrame">用户彩金纪录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/account_log.php" target="rightFrame">用户余额纪录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/score_log.php" target="rightFrame">用户积分纪录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=2&&status=1&&operate=show" target="rightFrame">运营用户</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=3&&status=1&&operate=show" target="rightFrame">晒单用户</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/message_list.php" target="rightFrame">用户留言</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/user_connect.php" target="rightFrame">联合登录查询</a></li>
              </ul>
    </li>
    <li> <a class="head">赛事管理</a>
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_game.php" target="rightFrame">修改赛事信息</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/edit_odds.php" target="rightFrame">修改赛事SP值</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=1&&status=1&&operate=show" target="rightFrame">受限投注</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=4&&status=1&&operate=show" target="rightFrame">竞彩投注开关</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=6&&status=1&&operate=show" target="rightFrame">北单投注开关</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=5&&status=1&&operate=show" target="rightFrame">首页单关投注</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=7&&status=1&&operate=show" target="rightFrame">竞彩人工投注开关</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=8&&status=1&&operate=show" target="rightFrame">北单人工投注开关</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/admin_operate_view.php?type=9&&status=1&&operate=show" target="rightFrame">限额开关</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/bd_operate_list.php" target="rightFrame">北单赛事相关修改</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/virtual_game.php" target="rightFrame">运营赛事相关修改</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/game/score_match.php" target="rightFrame">即时比分对比</a></li>
      </ul>
    </li>
    <li> <a class="head">订单管理</a>
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/user_orders.php" target="rightFrame">订单明细</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/virtual_orders.php" target="rightFrame">积分投注</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/manul_ticket_show.php" target="rightFrame">人工出票</a></li>
      </ul>
    </li>
    
    <li> <a class="head">财务功能</a>
      <ul>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/charge.php" target="rightFrame">账户充值</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/cut_charge.php" target="rightFrame">账户系统扣款</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/rebate.php" target="rightFrame">修改返点比例</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/encash.php" target="rightFrame">用户提现</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/cash_frozen.php" target="rightFrame">冻结资金恢复</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/charge_log.php" target="rightFrame">第三方支付查询</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/user/reg_log.php" target="rightFrame">注册用户查询</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/getInfo.php" target="rightFrame">出票公司账户查询</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/business/company_account.php" target="rightFrame">出票公司对帐查询</a></li>
      </ul>
    </li>
    <li> <a class="head">日志管理</a>
      <ul>
      	<li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/system/operate_record.php" target="rightFrame">后台操作记录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/order/user_ticket_operate.php" target="rightFrame">订单操作记录</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/system/search_log.php" target="rightFrame">问题日志</a></li>
        <li><a href="<?php echo @ROOT_DOMAIN; ?>
/admin/system/data_monitor.php" target="rightFrame">数据监控</a></li>
      </ul>
    </li>
  </ul>
</div>
</body>
</html>