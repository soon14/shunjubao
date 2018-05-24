<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>����Ӯ������ƱӮ����ѡ_�й�������_���_����_����_����_���_���������Ĳ�Ʊ��վ</title>
<meta name="keywords" content="����,�й�������,���,�й������,����,����,����,���,�����Ʊ,�����Ʊ" />
<meta name="description" content="��Ӯ���ǲ�ƱӮ�ҵľۼ��أ��ڱ���õĲ�Ʊ������վ�����ʡ�������Ʊ�������Ʊ�������Ʊ��������������ͨ����վ���ֻ��ͻ���ʹ�á��ṩ������Ʊ��������Ʊ�Ŀ���������ͼ����ˮ���ˡ��������⡢�ȷ�ֱ������Ѷ����" />
<link href="http://www.shunjubao.xyz/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link type="text/css" rel="stylesheet" href="css/shaidan.css">
<link type="text/css" rel="stylesheet" href="http://www.shunjubao.xyz/zy/www/statics/c/footer.css">
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
<!--ҳ��ͷ�� start-->
<script src="http://www.shunjubao.xyz/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="http://www.shunjubao.xyz/zy/www/statics/j/headNav.js" type="text/javascript"></script>
<!--ҳ��ͷ�� end-->
<!--��ǰλ�� start-->
<div class="Cailocation">
    <div class="location_center">
        <h1><b>��Ӯ��</b><img src="http://www.shunjubao.xyz/www/statics/i/showRight.png"><strong>ɹ��</strong></h1>
    </div>
</div>
<!--��ǰλ�� end-->
<!--center start-->
<div class="tjCenter">
  <div class="shaiTag">
    <ul>
      <li><a href="index.php?s=fb" <?php if($s=="fb"){ echo "class='active'"; }?>>��������</a></li>
      <li><a href="index.php?s=bk" <?php if($s=="bk"){ echo "class='active'"; }?>>��������</a></li>
    </ul>
    <div class="share">
    <!-- 
    <strong class="bdsharebuttonbox">
    <a href="#" class="bds_more" data-cmd="more"></a><a title="��������΢��" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="������Ѷ΢��" href="#" class="bds_tqq" data-cmd="tqq"></a><a title="����΢��" href="#" class="bds_weixin" data-cmd="weixin"></a><a title="����QQ�ռ�" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="����������" href="#" class="bds_douban" data-cmd="douban"></a>
    </strong>
    -->
    </div>
    <div class="clear"></div>
  </div>
  <div class="center">
    <div class="tjBody">
      <h1><b>��</b>ɹ���б�</h1>
    <table class="hacker" border="0" cellpadding="0" cellspacing="0">
    <tr><th>������</th><th>ɹ��ʱ��</th>
        <th>����ʱ��</th><th>�淨</th>
        <th>��ע</th><th>����</th><th>Ͷע��</th>
        <th>�����ܽ��</th>
        <th style="border-right:1px solid #6f6f6f;">����</th></tr>
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
    <td><div class="gendan"><a href="gendan.php?id=<?php echo $d["id"]?>" target="_blank">����</a></div></td>
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
<script src="http://www.shunjubao.xyz/www/statics/j/footer.js" type="text/javascript"></script>
<!--footer end-->
</body>
</html>