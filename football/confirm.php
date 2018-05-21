<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>投注确认-【智赢网】彩票赢家首选_中国竞彩网_足彩_篮彩_单场_福彩_体彩_人气最旺的彩票网站</title>
<meta name="keywords" content="竞彩,中国竞彩网,足彩,中国足彩网,篮彩,单场,福彩,体彩,足球彩票,篮球彩票" />
<meta name="description" content="智赢网是彩票赢家的聚集地，口碑最好的彩票做单网站，竞彩、单场彩票、篮球彩票、足球彩票人气超旺，可以通过网站和手机客户端使用。提供福利彩票和体育彩票的开奖、走势图表、缩水过滤、奖金评测、比分直播等资讯服务。" />
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/header.css">
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/confirmbet.css">
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/footer.css">
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/jquery.js"></script>
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/jquery-1.9.1.min.js"></script>
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/MFloat.js"></script>
</head>
<body>
<!--页面头部 start-->
<script src="/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="/zy/www/statics/j/menu.js" type="text/javascript"></script>
<!--页面头部 end-->
<!--当前位置 start-->
<script src="/zy/www/statics/j/cailocation.js" type="text/javascript"></script>
<!--当前位置 end-->
<?php
include_once "../interface/matchlist.php";

$s=$_REQUEST["sport"];
$select=$_REQUEST["select"];
$multiple=$_REQUEST["multiple"];
$money=$_REQUEST["money"];
$c=$_REQUEST["combination"];
$p=$_REQUEST["pool"];
$uid=$_SESSION["u_id"];
$host = $_SERVER['HTTP_HOST'];
$from = $_SERVER['HTTP_REFERER'];
$user_select=$_REQUEST["user_select"]?$_REQUEST["user_select"]:$select;

// 验证用户余额
$sql="select cash,rebate_per from user_account where u_id=$uid";            
$query1=mysql_query($sql,$db_r);
if($d=mysql_fetch_array($query1)){ 
	$user_cash=$d["cash"];
	$rebate_per=$d["rebate_per"];
}
?>
<form action="combination_submit.php" target="_self" name="form1" method="post">
  <input type="hidden" name="sport" value="<?php echo $s?>">
  <input type="hidden" name="select" value="<?php echo $select?>">
  <input type="hidden" name="user_select" value="<?php echo $user_select?>">
  <input type="hidden" name="multiple" value="<?php echo $multiple?>">
  <input type="hidden" name="money" value="<?php echo $money?>">
  <input type="hidden" name="combination" value="<?php echo $c?>">
  <input type="hidden" name="pool" value="<?php echo $p?>">
  <input type="hidden" name="from" value="<?php echo $from?>">
  <!--center start-->
  <div class="cnetr">
    <!--确认投注center start-->
    <div class="BitCenter">
      <!--提示文字信息  start-->
      <div class="touzhutips"><em>!</em>重要提示：您投注时的竞彩奖金指数有可能在出票时发生变化，实际数值以票样信息为准。 请仔细查看以下<b>"投注信息"</b>校对本方案是否与您的投注相符，一旦提交，将按照本方案交易，无法更改！ </div>
      <!--提示文字信息  end-->
      <div class="ConfirmationTz">
        <!--投注确认账户信息 start-->
        <div class="">
          <h1><b>■</b>投注信息 【<?php echo $POOL[$p]?>】</h1>
          <div class="Confirmauser">
            <ul>
              <li><a href="http://<?php echo $host.'/zy/account/user_charge.php'?>">充值</a></li>
              <li>账户余额：<em>&yen;&nbsp;<?php echo $user_cash?></em>元</li>
              <li>总金额：<b>&yen;&nbsp;<?php echo $money?></b>元</li>
              <li>方案倍数：<strong><?php echo $multiple?></strong>倍</li>
              <li>过关方式：<strong><?php echo $user_select?></strong></li>
            </ul>
          </div>
        </div>
        <!--投注确认账户信息 end-->
        <!--投注竞彩足彩总进球\过关比分\单关比分\半全场确认 start-->
        <div class="">
          <div id="touzhuchack">
            <table class="hacker" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th>序号</th>
                <th>场次</th>
                <th>主队</th>
                <th>VS</th>
                <th>客队</th>
                <th>玩法</th>
                <th>您的选项</th>
              </tr>
              <?php
	$table=$s."_betting";
	$matchs=explode(',',$c);
	foreach($matchs as $k => $v){
		$mid=explode("|",$v);	
		$sql="select * from $table where id=".$mid[1];
 		$query1=mysql_query($sql,$db_r);
		if($d=mysql_fetch_array($query1)){
	?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo show_num($d["num"]);?></td>
                <td><div class="Checktded"><?php echo $d["h_cn"];?></div></td>
                <td>VS</td>
                <td><div class="Checktded"><?php echo $d["a_cn"];?></div></td>
                <td><?php echo $POOL[$mid[0]];?></td>
                <td><?php
        $option=explode("&",$mid[2]);
        $key_str='';
        foreach($option as $k1 => $v1){
            $key=explode("#",$v1);
            echo $key_str='<span class="wAnfa"><b><u><span></span>'.chinese($key[0],$mid[0]).'<em>['.$key[1].']</em></u></b></span> ';
        }
        ?></td>
              </tr>
              <?php
        }
    }?>
            </table>
          </div>
        </div>
        <!--投注竞彩足彩总进球\过关比分\单关比分\半全场确认 end-->
        <!--投注确认提交 start-->
        <div>
          <div class="confiRma">
            <p class="check">
              <input type="checkbox" checked>
              同意<a href="">《智赢网代购协议》</a>，并已确认投注详情。</p>
            <p>
              <input type="submit" id="form_submit" class="confiRmaSub" value="确认购买" />
            </p>
          </div>
        </div>
        <!--投注确认提交 end-->
      </div>
    </div>
    <!--确认投注center end-->
  </div>
</form>
<!--center end-->
<!--Help start-->
<script src="/zy/www/statics/j/help.js" type="text/javascript"></script>
<!--Help end-->
<!--footer start-->
<script src="/zy/www/statics/j/footer.js" type="text/javascript"></script>
<!--footer end-->
</body>
</html>