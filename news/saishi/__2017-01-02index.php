<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>赛事取消或者延迟公告-智赢网。</title>
<meta name="keywords" content="赛事取消或者延迟公告-智赢网。" />
<meta name="description" content="赛事取消或者延迟公告-智赢网。" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/header.css" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/news.css" />
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/www/statics/c/footer.css" />
<script src="http://www.shunjubao.xyz/www/statics/j/jquery-1.9.1.min.js"></script>
<script src="http://www.shunjubao.xyz/www/statics/j/float.js"></script>

<script src="http://www.shunjubao.xyz/www/statics/j/top.js"></script>
<script src="http://www.shunjubao.xyz/www/statics/j/menu.js"></script>
<script src="http://www.shunjubao.xyz/www/statics/j/winmac.js"></script>
<style>
.saishi{ width:1000px; margin:0 auto; text-align:center;}
.saishi ul{border-bottom:1px solid #dedede; width:1000px; text-align:left; margin:15px auto; line-height:28px; padding:0 0 15px 0;}
.saishi ul li{ line-height:28px; font-size:12px;color:#444;}
.saishi ul li b{display:inline-table;display:inline-block;zoom:1;*display:inline;font-size:14px; font-weight:900;color:#D20000; background:url(http://www.shunjubao.xyz/www/statics/i/cailogo.jpg) no-repeat left center; padding:0 0 0 35px; height:35px; line-height:35px;}
</style>
<body>
<div class="nav-box">
  <ul>
    <li class="cur"><img src="http://www.shunjubao.xyz/www/statics/i/ciapiaoxiaoshou.gif"></li>
  </ul>
</div>
<?php
$content_start = '<div class="line"></div>'; 
$content_end = '<div class="page_3_right'; 


$url ="http://info.sporttery.cn/iframe/lottery_notice.php";
$contents = file_get_contents($url); 

$intH1start= strpos($contents, $content_start);
$intH1end = strpos($contents, $content_end);
$strH1 = substr($contents,$intH1start,$intH1end);
$contents_list_array = explode('<div class="dot"></div>',$strH1);
for($i=0;$i<count($contents_list_array)-1;$i++){	
	preg_match_all('(<div class="stitle">(.*)<div class="stext">)', $contents_list_array[$i], $matches);
	$title = strip_tags($matches[1][0]);	
	preg_match_all('(<div class="stext">(.*)</div>)', $contents_list_array[$i], $matches);
	$list_note = strip_tags($matches[1][0]);
?>

<div class="saishi">

<ul>
<li><b><?php echo iconv('GB2312', 'UTF-8', $title);?></b></li>

<li><?php echo iconv('GB2312', 'UTF-8', $list_note);?></li>
</ul>
</div>



<?php
}
?>

</body>
<script src="http://www.shunjubao.xyz/www/statics/j/footer.js"></script>
</html>