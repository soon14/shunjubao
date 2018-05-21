<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<title>赛事取消或者延迟公告-智赢网。</title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=1' name='viewport' />
<meta content='yes' name='apple-mobile-web-app-capable' />
<meta content='black' name='apple-mobile-web-app-status-bar-style' />
<meta content='telephone=no' name='format-detection' />
<meta name="keywords" content="赛事取消或者延迟公告-智赢网。" />
<meta name="description" content="赛事取消或者延迟公告-智赢网。" />
<link type="text/css" rel="stylesheet" href="http://www.zhiying365.com/www/statics/c/wap_header.css" />
<link type="text/css" rel="stylesheet" href="http://www.zhiying365.com/www/statics/c/wap_footer.css" />
<style>
.saishi{ width:100%; margin:0 auto; text-align:center;}
.saishi ul{border-bottom:1px solid #dedede; width:97%; text-align:left; margin:10px auto 15px auto; line-height:28px; padding:0 0 18px 0;}
.saishi ul li{ line-height:22px; font-size:12px;color:#444; padding:0 5px;}
.saishi ul li.cc{ padding:0 5px;}
.saishi ul li b{display:inline-table;display:inline-block;zoom:1;*display:inline;font-size:14px; font-weight:300;color:#D20000; background:url(http://www.zhiying365.com/www/statics/i/cailogo.jpg) no-repeat left center; padding:0 0 0 35px; height:30px; line-height:30px; font-family:'微软雅黑';}
.footer{line-height:40px;text-align:center;height:40px;background:#ddd;font-size:12px;color:#777;}
</style>
<body>
<div style="background:#BC1E1F; height:40px; line-height:40px; text-align:center; font-size:14px;color:#fff;"> 中国体育彩票销售公告</div>
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
    <li class="cc"><?php echo iconv('GB2312', 'UTF-8', $list_note);?></li>
  </ul>
</div>
<?php
}
?>
<div class="footer" style="height:auto; line-height:26px;padding:14px 0; background:#f4f4f4;position:relative;top:-15px;"><p style=" height:32px;width:40%;padding:0 30px; line-height:30px;border:1px solid #e2e2e2; border-radius:5px; margin:0 auto;">客服热线：010-57190959</p><p style="padding:5px 0 0 0;">京ICP备14016851-1号&nbsp;京ICP证150586号</p><p>2014-2016&copy;智赢彩票&nbsp;京公安网备11011402000202</p></div>
<span class="none">
<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https:\/\/" : " http:\/\/");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000441119'%3E%3C\/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com\/z_stat.php%3Fid%3D1000441119%26show%3Dpic' type='text\/javascript'%3E%3C\/script%3E"));</script>
<span id="cnzz_stat_icon_1000441119"><a title="站长统计" target="_blank" href="http://www.cnzz.com/stat/website.php?web_id=1000441119"><img vspace="0" hspace="0" border="0" src="http://icon.cnzz.com/img/pic.gif"></a></span>
<script type="text/javascript" src=" http://s4.cnzz.com/z_stat.php?id=1000441119&amp;show=pic"></script>
<script type="text/javascript" charset="utf-8" src="http://c.cnzz.com/core.php?web_id=1000441119&amp;show=pic&amp;t=z"></script>
</span>
</body>
</html>