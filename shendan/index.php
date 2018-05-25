<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
header("Content-type:text/html;charset=utf-8");
$tpl = new Template();
$conn = @mysql_connect("localhost", "root","1q2w3e4R!") or die("Could not connect to database");
@mysql_select_db("zhiying_quan", $conn) or die ("Could not select database");



$spage = $_GET['spage'];
if($spage){
	$page_s=1;
}else{
	$page_s = empty($_GET['page_s'])? 1:intval($_GET['page_s']);
}
if($page_s < 1) $page_s = 1;
$start = ($page_s - 1) * $pageSize;
$sql ="SELECT count(*) as nums FROM  q_god_dan where  1 ";
$query = mysql_query($sql,$conn);	
$value = mysql_fetch_array($query);
$totalRecord = $value["nums"];
$pageSize = 50;





$multi = multi($totalRecord,$pageSize,$page_s,'index.php?1=1',"page_s");
$tpl->assign('multi', $multi);


$sql ="SELECT * FROM  q_god_dan where  1 order by orderby desc LIMIT ".$start.",".$pageSize;
$query = mysql_query($sql,$conn);
while($value = mysql_fetch_array($query)){	
	$results[]=$value;
}



$tpl->assign('results', $results);
$TEMPLATE['title'] = '聚宝网聚宝神单展厅';
$TEMPLATE['keywords'] = '竞彩晒单,竞彩跟单,晒单跟单,聚宝网跟单,聚宝网竞猜跟单,竞彩投注,聚宝晒单中心,大力水手,王忠仓,寻鸡情求鸭迫,红姐,聚宝红姐。 ';
$TEMPLATE['description'] = '晒单中心展现的是聚宝网专家和明星会员推荐方案的页面，致力于打造竞彩中奖的福地。';
echo_exit($tpl->r('shendan'));     



function multi($num, $perpage, $curr_page, $mpurl,$pramname="page") {
	$multipage = '';
	if($num > $perpage) {
		
		$page = 6;
		$offset = 2;
		$pages = ceil($num / $perpage);
		$from = $curr_page - $offset;
		$to = $curr_page + $page - $offset - 1;
			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				if($from < 1) {
					$to = $curr_page + 1 - $from;
					$from = 1;
					if(($to - $from) < $page && ($to - $from) < $pages) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $curr_page - $pages + $to;
					$to = $pages;
						if(($to - $from) < $page && ($to - $from) < $pages) {
							$from = $pages - $page + 1;
						}
				}
			}
			//上一页，下一页
			if($curr_page>1){
				$prepage = $curr_page-1;
			}else{
				$prepage = 1;
			}
			
		
			if($curr_page<$pages){
			
				$nextpage = $curr_page+1;
			}else{
				$nextpage = $curr_page; 
			}
			//
			
			if($curr_page > 1) {
				$multipage .= "<li><a href='{$mpurl}&".$pramname."=1'>首页</a>&nbsp;<a href='{$mpurl}&".$pramname."={$prepage}'>上一页</a><li>";
			} else {
				$multipage .= "<li><a>首页</a></li>";
			}
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= "<li><a href='{$mpurl}&".$pramname."=$i'>$i</a></li>";
				} else {
					$multipage .= "<li class='thisclass'>$i</li>";
				}
			}
			$maxpage = ceil($num/$perpage);
			if($curr_page < $maxpage) {
				$multipage .= "&nbsp;<li><a href='{$mpurl}&".$pramname."={$nextpage}'>下一页</a>&nbsp;<a href='{$mpurl}&".$pramname."={$maxpage}'>末页</a></li>";
			} else {
				$multipage .= "&nbsp;<li class='disabled'><a>下一页</a></li>&nbsp;<li class='disabled'><a>末页</a></li>";
			}
			
	}
	return $multipage;
}




 /*<li>首页</li>
  <li class="thisclass">1</li>
  <li><a href='list_4_2.html'>2</a></li>
  <li><a href='list_4_3.html'>3</a></li>
  <li><a href='list_4_2.html'>下一页</a></li>
  <li><a href='list_4_647.html'>末页</a></li>*/





