<!DOCTYPE html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>方案详情-【智赢网】彩票赢家首选_中国竞彩网_足彩_篮彩_单场_福彩_体彩_人气最旺的彩票网站</title>
<meta name="keywords" content="竞彩,中国竞彩网,足彩,中国足彩网,篮彩,单场,福彩,体彩,足球彩票,篮球彩票" />
<meta name="description" content="智赢网是彩票赢家的聚集地，口碑最好的彩票做单网站，竞彩、单场彩票、篮球彩票、足球彩票人气超旺，可以通过网站和手机客户端使用。提供福利彩票和体育彩票的开奖、走势图表、缩水过滤、奖金评测、比分直播等资讯服务。" />
<link href="http://www.zhiying365365.com/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link href="http://www.zhiying365365.com/www/statics/c/footer.css" type="text/css" rel="stylesheet" />
<link href="http://www.zhiying365365.com/www/statics/c/user.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="http://www.zhiying365365.com/www/statics/j/jquery.js"></script>
<script type="text/javascript" src="http://www.zhiying365365.com/www/statics/j/jquery-1.9.1.min.js"></script>
<script language="javascript" src="http://www.zhiying365365.com/www/statics/j/common.js"></script>
<link rel="shortcut icon" href="http://www.zhiying365365.com/www/statics/i/zhiying.icon" type="image/x-icon" />
<?php
require_once "../include/init.php";
$id=$_REQUEST["id"];
// 验证方案是否显示
$sql="select * from user_ticket_all where id=$id and combination_type=0";	
$query=mysql_query($sql,$db_r);
if($d=mysql_fetch_array($query)){
	$uid=$d["u_id"];
	$combination_type=$d["combination_type"];
	$sql="select * from user_member where u_id=$uid";
	$query1=mysql_query($sql,$db_r);
	if($d1=mysql_fetch_array($query1)){
		$uname=iconv("utf-8","gbk",$d1["u_nick"]?$d1["u_nick"]:$d1["u_name"]);
	}
}
/* 方案未公开
if($combination_type==0){
	exit;	
}
*/
?>
</head>
<link href="http://www.zhiying365365.com/www/statics/c/confirmbet.css" type="text/css" rel="stylesheet" />
<body>
<!--页面头部 start-->
<script src="http://www.zhiying365365.com/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="http://www.zhiying365365.com/zy/www/statics/j/headNav.js" type="text/javascript"></script>
<!--center start-->
<div class="center">
  <!--确认投注center start-->
  <div class="BitCenter">
    <div class="ConfirmationTz">
      <!--投注确认过关方式 start-->
    <div class="querenguoguan">
    <div class="TouXiang">
    <dl><dt><img src="http://www.zhiying365365.com/www/statics/i/touxiang.jpg" /> <a href="http://www.zhiying365365.com/account/user_center.php"><?php echo $uname?></a> </dt>
        <dd><p>方案类型：<i><?php echo $SPORT[$d["sport"]]."-".$POOL[$d["pool"]]?></i></p>
            <p>累计中奖：<strong>&yen;</strong></p></dd>
        <dd><p>方案金额：<i>&yen;<?php echo $d["money"]?></i></p>
            <p>倍数：<strong><?php echo $d["multiple"]?></strong></p></dd>
        <dd><p>过关方式：<em><?php echo $d["select"]?></em></p>
            <p>方案奖金：<strong>&yen;</strong></p></dd>
        <dd><p>认购时间：<i><?php echo $d["datetime"]?></i></p></dd>
    </dl>
    <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <h1 style="position:relative; margin:20px 0;"><b>■</b>方案内容
    <div class="Fshare">
    <div class="gdTips"><span>*</span>该方案详细内容需要晒单结束才能查看。</div>
    <div class="share"></div>
    <div class="clear"></div>
    </div>
    </h1>
<!--方案内容 start-->
<table class="hacker" border="0" cellpadding="0" cellspacing="0">
<tbody id="detail_tr">
<tr>
<th>序号</th>
<th>场次</th>
<th>赛事</th>
<th>主队VS客队</th>
<th>我的选择</th>
<th>彩果</th>
<th>比分</th>
<th style="border-right:1px solid #6f6f6f;">状态</th>
</tr>
<?php
$sql="select * from user_ticket_all where id=$id";	
$query=mysql_query($sql,$db_r);
if($d=mysql_fetch_array($query)){
	$c=$d["combination"];
	$c=explode(",",$c);
	switch($d["sport"]){
		case "fb":$table="fb_betting";break;
		case "bk":$table="bk_betting";break;	
	}
	foreach($c as $k => $v){
		$ms=explode("|",$v);
		$sql="select * from $table where id=".$ms[1];
 		$query1=mysql_query($sql,$db_r);
		if($m=mysql_fetch_array($query1)){ }
		
		$odds=explode("&",$ms[2]);
		$strs="";
		foreach($odds as $k1 => $v1){
			$str=explode("#",$v1);
 			switch($ms[0]){
				case "hhad":$key=$HHAD ;break;
				case "had":$key=$HAD ;break;
				case "ttg":$key=$TTG ;break;
				case "hafu":$key=$HAFU ;break;
				case "crs":$key=$CRS ;break;
				case "mnl":$key=$MNL ;break;
				case "wnm":$key=$WNM ;break;
				case "hdc":$key=$HDC ;break;
				case "hilo":$key=$HILO ;break;
			}
			$strs.=$key[strtoupper($str[0])]." [ ".$str[1]." ]"; 
		}
?>
<tr>
<td valign="middle" class="x1"><?php echo $k+1?></td>
<td valign="middle" class="x2"><?php echo show_num($m["num"]);?></td>
<td valign="middle" class="x3"><?php echo $m["l_cn"];?></td>
<td valign="middle" class="x4"><div class="XinagQingL"><b><?php echo $m["h_cn"];?></b><span>VS</span><b><?php echo $m["a_cn"];?></b></div></td>
<td valign="middle" class="x5"><div class="Anfax"><b><span>&nbsp;&nbsp;&nbsp;<?php echo $strs;?>&nbsp;&nbsp;&nbsp;</span></b></div></td>
<td valign="middle" class="x6"><div class="wAnfa"><b><u><span></span></u></b></div></td>
<td valign="middle" class="x7"></td>
<td valign="middle" class="x8"><div class="zhuangTai"><b class=""></b></div></td>
</tr>
<?php } }?>
          </tbody>
        </table>
        <!--方案内容 end-->
        <!-- 跟单start-->
        <div class="gandanCenter">
          <dl>
            <dt>跟单金额：<span>&yen;2元</span></dt>
            <!--<dt>提成比例：<b>5%</b></dt>-->
            <dt class="first">跟单倍数：</dt>
            <dt class="first">
              <ul>
                <li><a href="javascript:void(0);" id="subBtn">-</a></li>
                <li>
                  <input type="text" value="" maxlength="" autocomplete="" id="">
                </li>
                <li><a href="javascript:void(0);" id="addBtn">+</a></li>
              </ul>
            </dt>
            <dt class="first">最高999999倍</dt>
            <dd>
              <input type="submit" value="跟单" class="gdsub">
            </dd>
          </dl>
          <div class="clear"></div>
        </div>
        <!-- 跟单end-->
      </div>
    </div>
    <!--投注确认过关方式 end-->
  </div>
</div>
<!--确认投注center end-->
<!--center end-->
<!--footer start-->
<div class="footer">
  <div id="gotop"><a href="javascript:void(0)">返回顶部</a></div>
  <div id="Rightsubnav">
    <ul>
      <li class="service"><a href="http://wpa.qq.com/msgrd?v=1&uin=2733292184&site=qq&menu=yes" target="_blank">在线客服</a></li>
      <li class="help"><a href="http://www.zhiying365365.com/help" target="_blank">帮助中心</a></li>
    </ul>
  </div>
  <div class="footerNav"> <a href="http://www.zhiying365365.com/passport/reg.php" target="_blank">用户注册</a><span>|</span> <a href="http://www.zhiying365365.com/about/index.html" target="_blank">关于我们</a><span>|</span> <a href="http://www.zhiying365365.com/about/baozhang.html" target="_blank">安全保障</a><span>|</span> <a href="http://www.zhiying365365.com/about/contactus.html" target="_blank">联系方式</a><span>|</span> <a href="http://www.zhiying365365.com/about/job.html" target="_blank">人才招聘</a><span>|</span> <a href="http://www.zhiying365365.com/about/bd.html" target="_blank">商务合作</a><span>|</span> <a href="http://www.zhiying365365.com/about/Sitemap.html" target="_blank">站点地图</a><span>|</span> <a href="http://www.zhiying365365.com/about/lawfirm.html" target="_blank">法律声明</a><span>|</span> <a href="http://www.zhiying365365.com/about/xieyi.html" target="_blank">网站协议</a> </div>
  <div class="footdaodu">热点导读： <a href="http://www.zhiying365365.com/zixun/" target="_blank">资讯中心</a><span>|</span> <a href="#" target="_blank">智赢2串1</a><span>|</span> <a href="http://www.zhiying365365.com/news/footballtj/" target="_blank">竞彩足球</a><span>|</span> <a href="http://www.zhiying365365.com/news/NBAxw/" target="_blank">竞彩篮球</a><span>|</span> <a href="http://www.zhiying365365.com/news/footballtj/" target="_blank">足球推荐</a><span>|</span> <a href="http://www.zhiying365365.com/news/NBAtj/" target="_blank">篮球推荐</a><span>|</span> <a href="http://www.zhiying365365.comnews/touzhujiqiao/" target="_blank">投注技巧</a></div>
  <div class="FootPic">
    <ul>
      <li><a href=""><img src="http://www.zhiying365365.com/www/statics/i/FootPic2.jpg"/></a></li>
      <li><a href=""><img src="http://www.zhiying365365.com/www/statics/i/FootPic3.jpg"/></a></li>
      <li><a href=""><img src="http://www.zhiying365365.com/www/statics/i/FootPic4.jpg"/></a></li>
      <li><a href=""><img src="http://www.zhiying365365.com/www/statics/i/FootPic5.jpg"/></a></li>
      <li><a href=""><img src="http://www.zhiying365365.com/www/statics/i/FootPic6.jpg"/></a></li>
    </ul>
  </div>
  <div class="FooterOhter"> 2014&nbsp;&nbsp;&copy;&nbsp;Copyright&nbsp;&nbsp;&nbsp;&nbsp;智赢网&nbsp;&nbsp;&nbsp;
    All rights reserved。备案号：京ICP备14016851-1号&nbsp;彩票有风险，投注需谨慎  不向未满18周岁的青少年出售彩票&nbsp;&nbsp;&nbsp;&nbsp; <span class="none">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https:\/\/" : " http:\/\/");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000441119'%3E%3C\/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com\/z_stat.php%3Fid%3D1000441119%26show%3Dpic' type='text\/javascript'%3E%3C\/script%3E"));</script>
    </span> </div>
</div>
<!--footer end-->
</body>
</html>