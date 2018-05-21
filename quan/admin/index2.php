<?php
include("config.inc.php");

include('checklogin.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML style="padding:0px;">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?=$shop_title?>
_</title>
<link href="css/main.css" rel="stylesheet" type="text/css">
<link href="css/layout.css" rel="stylesheet" type="text/css">
<link href="css/font.css" rel="stylesheet" type="text/css">
<script src="js/js.js" language="javascript" type="text/javascript"></script>
</head>
<BODY style="overflow-y:hidden;overflow-x:auto;">
<TABLE cellSpacing=0 cellPadding=0 id="maintab">
  <TR>
    <TD id="m_top"><div id="A_head">
        <div id="hostname"><h1 style="font-family:微软雅黑; font-size:20px; position:relative;top:6px;">智赢后台管理系统</h1></div>
        <div id="mtright">
          <div id="mt_menu"> 当前日期: 
            <script>DateInfo();</script></div>
          <div id="mtr_time"> 当前日期: 
            <script>DateInfo();</script> <a href="../" class="fc_2" target="_blank">前台首页</a>&nbsp; <a href="main_index.php" class="fc_2" target="if_content_t">后台首页</a>&nbsp;&nbsp;|&nbsp; <a href="admin_update.php" class="fc_2" target="if_content_t">修改资料</a>&nbsp;&nbsp;|&nbsp; <a href="admin_log.php?action=user_log" class="fc_2" target="if_content_t">操作日志</a>&nbsp;&nbsp;|&nbsp; <a href="loginaction.php?action=logout" class="fc_2">安全退出</a> </div>
        </div>
      </div>
      <div id="m_min-width"> 
        <!--控制最小宽度--> 
      </DIV></TD>
  </TR>
  <TR>
    <TD id="m_middle"><DIV id="sidebar">
    
  	  <div class="item_list open" id="item_list_10" >
          <div class="il_title" onClick="onechangClass('item_list_10','item_list','item_list open')">智赢管理</div>
          <ul>
          
         
          
          
            <li><a href="member_list.php" target="if_content_t">智赢会员列表</a>  </li>
     	 <li><a href="member_list.php?action=show_area" target="if_content_t">出票权限列表</a>  </li>
         <li><a href="user_ticket_all.php" target="if_content_t">投注列表 </a> </li>
         
          <li><a href="betting_log.php" target="if_content_t">赛事修改日志</a></li>

          <li><a href="user_ticket_report.php" target="if_content_t">中奖报表</a>  </li>
          </ul>
        </div>
        <div class="item_list" id="item_list_14" >
          <div class="il_title" onClick="onechangClass('item_list_14','item_list','item_list open')">智赢充值管理</div>
          <ul>
                     <li><a href="payment_list.php" target="if_content_t">扫码商户列表</a> [<a href="payment_list.php?action=add" target="if_content_t">添加</a> ] </li>
         <li><a href="user_charge_list.php" target="if_content_t">支付帐号管理</a> [<a href="user_charge_list.php?action=add" target="if_content_t">添加</a> ] </li>
         <li><a href="charge_alipay_unusual.php" target="if_content_t">充值异常用户</a> [<a href="charge_alipay_unusual.php?action=add" target="if_content_t">添加</a> ]</li>
          <li><a href="user_charge_count.php" target="if_content_t">充值报表</a></li>
          </ul>
        </div>
        
        
        
         <div class="item_list" id="item_list_15" >
          <div class="il_title" onClick="onechangClass('item_list_15','item_list','item_list open')">商城管理</div>
          <ul>
            <li><a href="hdp_list.php" target="if_content_t">幻灯片管理</a> [<a href="hdp_list.php?action=add" target="if_content_t">添加</a>] </li>
             <li><a href="product_list.php" target="if_content_t">商品列表</a> [<a href="product_list.php?action=add" target="if_content_t">添加</a>] </li>
              <li><a href="#" target="if_content_t">订单管理</a>  </li>
             <li><a href="news_list.php" target="if_content_t">文章管理</a> [<a href="news_list.php?action=add" target="if_content_t">添加</a>] </li>
          </ul>
        </div>
        <div class="item_list" id="item_list_13" >
          <div class="il_title" onClick="onechangClass('item_list_13','item_list','item_list open' )">用户定制</div>
          <ul>
          <li><a href="user_dingzhi.php" target="if_content_t">可定制用户管理</a></li>
            <li><a href="follow_ticket.php" target="if_content_t">已定制用户列表</a></li>
             <li><a href="follow_ticket_log.php" target="if_content_t">自动跟单日志</a></li>
             <li><a href="follow_prize.php" target="if_content_t">跟单分成日志</a></li>
              <li><a href="addtips_log.php" target="if_content_t">跟单打赏记录</a></li>
          </ul>
        </div>
        
         
    
        <div class="item_list " id="item_list_110" >
          <div class="il_title" onClick="onechangClass('item_list_110','item_list','item_list open')">众筹管理</div>
          <ul>
            <li><a href="project_list.php" target="if_content_t">项目管理</a> [<a href="project_list.php?action=add" target="if_content_t">添加</a>] </li>
           <li><a href="project_pay.php" target="if_content_t">项目支持列表</a>  </li>
          </ul>
        </div>
          <div class="item_list " id="item_list_120" >
          <div class="il_title" onClick="onechangClass('item_list_120','item_list','item_list open')">圈子管理</div>
          <ul>
            <li><a href="quan_member.php" target="if_content_t">圈子用户</a></li>
            <li><a href="quan_post.php" target="if_content_t">圈子贴子</a></li>
           <li><a href="quan_post_reply.php" target="if_content_t">贴子回复</a></li>
            <li><a href="quan_dslist.php?type=1" target="if_content_t">金额打赏列表</a></li> 
            <li><a href="quan_dslist.php?type=2" target="if_content_t">积分打赏列表</a></li> 
          </ul>
        </div> 
       
        
        
        <div class="item_list " id="item_list_11" >
          <div class="il_title" onClick="onechangClass('item_list_11','item_list','item_list open')">基础数据</div>
          <ul>
            <li><a href="bascdata_list.php" target="if_content_t">数据列表</a></li>
            <li><a href="bascdata_list.php?action=add" target="if_content_t">添加数据</a></li>
           <!-- <li><a href="areasort_list.php" target="if_content_t">地区列表</a>[<a href="areasort_list.php?action=add" target="if_content_t">添加</a>]</li>-->
          </ul>
        </div>
        <div class="item_list" id="item_list_12">
          <div class="il_title" onClick="onechangClass('item_list_12','item_list','item_list open')">系统管理</div>
          <ul>
            <li><a href="permission.php?action=manage" target="if_content_t">权限管理</a></li>
            <li><a href="dept.php?action=manage" target="if_content_t">部门管理</a></li>
            <li><a href="dp_member.php?action=manage" target="if_content_t">部门成员管理</a></li>
          </ul>
        </div>
      </DIV>
      <DIV id="content">
        <div id="content_title">
          <div id="content_t_s">
            <div id="content_t_s_l">&nbsp;</div>
            <div id="content_t_s_c">您现在的位置： 管理后台</div>
            <div id="content_t_s_r">&nbsp;</div>
          </div>
        </div>
        <iframe style="margin:10px 0 0px 0px;padding:0;" id="if_content" name="if_content_t" scrolling="auto" frameborder="0" src="main_index.php"></iframe>
      </DIV></TD>
  </TR>
  <tr>
    <td id="m_bottom"></td>
  </tr>
</TABLE>
</BODY>
</HTML>
