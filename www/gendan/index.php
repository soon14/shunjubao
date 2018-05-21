<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>【智赢网】彩票赢家首选_中国竞彩网_足彩_篮彩_单场_福彩_体彩_人气最旺的彩票网站</title>
<meta name="keywords" content="竞彩,中国竞彩网,足彩,中国足彩网,篮彩,单场,福彩,体彩,足球彩票,篮球彩票" />
<meta name="description" content="智赢网是彩票赢家的聚集地，口碑最好的彩票做单网站，竞彩、单场彩票、篮球彩票、足球彩票人气超旺，可以通过网站和手机客户端使用。提供福利彩票和体育彩票的开奖、走势图表、缩水过滤、奖金评测、比分直播等资讯服务。" />
<link href="http://www.zhiying365365.com/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="css/shaidan.css">
<link type="text/css" rel="stylesheet" href="http://www.zhiying365365.com/zy/www/statics/c/footer.css">
<?php
require_once "../include/init.php";
$s=$_REQUEST["s"]?$_REQUEST["s"]:"fb";
$sql_str="where `sport`='".$s."' and combination_type=0"; 
$search="s=$s"; 
$search_page="index.php";
$page=$_REQUEST["page"]?$_REQUEST["page"]:1;
$order="order by datetime desc"; 
$count_sql="user_ticket_all $sql_str $order";
$page_info=page_all($page,$count_sql);
?>
</head>
<body>
<!--页面头部 start-->
<script src="http://www.zhiying365365.com/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="http://www.zhiying365365.com/zy/www/statics/j/headNav.js" type="text/javascript"></script>
<!--页面头部 end-->
<!--当前位置 start-->
<div class="Cailocation">
    <div class="location_center">
        <h1><b>智赢网</b><img src="http://www.zhiying365365.com/www/statics/i/showRight.png"><strong>晒单</strong></h1>
    </div>
</div>
<!--当前位置 end-->
<!--center start-->
<div class="tjCenter">
  <div class="shaiTag">
    <ul>
      <li><a href="index.php?s=fb" <?php if($s=="fb"){ echo "class='active'"; }?>>竞彩足球</a></li>
      <li><a href="index.php?s=bk" <?php if($s=="bk"){ echo "class='active'"; }?>>竞彩篮球</a></li>
    </ul>
    <div class="share">
    <!-- 
    <strong class="bdsharebuttonbox">
    <a href="#" class="bds_more" data-cmd="more"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到豆瓣网" href="#" class="bds_douban" data-cmd="douban"></a>
    </strong>
    -->
    </div>
    <div class="clear"></div>
  </div>
  <div class="center">
    <div class="tjBody">
      <h1><b>▋</b>晒单列表</h1>
    <table class="hacker" border="0" cellpadding="0" cellspacing="0">
    <tr><th>发起人</th><th>晒单时间</th>
        <th>结束时间</th><th>玩法</th>
        <th>单注</th><th>倍数</th><th>投注额</th>
        <th>跟单总金额</th>
        <th style="border-right:1px solid #6f6f6f;">操作</th></tr>
	<?php
	$sql="select * from user_ticket_all $sql_str $order limit $page_info[2],$page_info[3]";	
	$query=mysql_query($sql,$db_r);
	while($d=mysql_fetch_array($query)){
		$uid=$d["u_id"];
		$id=$d["id"]; 
		$sql="select * from user_member where u_id=$uid";
 		$query1=mysql_query($sql,$db_r);
		if($d1=mysql_fetch_array($query1)){
 			$uname=iconv("utf-8","gbk",$d1["u_nick"]?$d1["u_nick"]:$d1["u_name"]);
  		}
		$sql="select sum(money) money from user_ticket_all where partent_id=$id";	
		$query1=mysql_query($sql,$db_r);
		if($d1=mysql_fetch_array($query1)){
			$money=$d1["money"];
		}
	?>        
    <tr>
    <td><div class="touxiang"><img src="images/touxiang.jpg"><?php echo $uname?></div></td>
    <td><?php echo substr($d["datetime"],5,-3)?></td>
    <td><?php echo substr($d["endtime"],5,-3)?></td>
    <td><?php echo $SPORT[$d["sport"]]."-".$POOL[$d["pool"]]?></td>
    <td><?php echo $d["money"]/$d["multiple"]?></td>
    <td><?php echo $d["multiple"]?></td>
    <td><div class="clo1">&yen;<?php echo $d["money"]?></div></td>
    <td><div class="clo2">&yen;<?php echo $money?></div></td>
    <td><div class="gendan"><a href="gendan.php?id=<?php echo $d["id"]?>" target="_blank">跟单</a></div></td>
    </tr>
	<?php } ?></table>
    <div class="sharepages"><?php echo page_list($page_info[1],$search_page,$page,10,$search); ?></div>
    </div>
  </div>
</div>
<!--center end-->
<!--Help start-->
<!--Help end-->
<!--footer start-->
<script src="http://www.zhiying365365.com/www/statics/j/footer.js" type="text/javascript"></script>
<!--footer end-->
</body>
</html>