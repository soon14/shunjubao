<!DOCTYPE html><head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>��������-����Ӯ������ƱӮ����ѡ_�й�������_���_����_����_����_���_���������Ĳ�Ʊ��վ</title>
<meta name="keywords" content="����,�й�������,���,�й������,����,����,����,���,�����Ʊ,�����Ʊ" />
<meta name="description" content="��Ӯ���ǲ�ƱӮ�ҵľۼ��أ��ڱ���õĲ�Ʊ������վ�����ʡ�������Ʊ�������Ʊ�������Ʊ��������������ͨ����վ���ֻ��ͻ���ʹ�á��ṩ������Ʊ��������Ʊ�Ŀ���������ͼ����ˮ���ˡ��������⡢�ȷ�ֱ������Ѷ����" />
<link href="http://www.shunjubao.com/www/statics/c/header.css" type="text/css" rel="stylesheet" />
<link href="http://www.shunjubao.com/www/statics/c/footer.css" type="text/css" rel="stylesheet" />
<link href="http://www.shunjubao.com/www/statics/c/user.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="http://www.shunjubao.com/www/statics/j/jquery.js"></script>
<script type="text/javascript" src="http://www.shunjubao.com/www/statics/j/jquery-1.9.1.min.js"></script>
<script language="javascript" src="http://www.shunjubao.com/www/statics/j/common.js"></script>
<link rel="shortcut icon" href="http://www.shunjubao.com/www/statics/i/zhiying.icon" type="image/x-icon" />
<?php
require_once "../include/init.php";
$id=$_REQUEST["id"];
// ��֤�����Ƿ���ʾ
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
/* ����δ����
if($combination_type==0){
	exit;	
}
*/
?>
</head>
<link href="http://www.shunjubao.com/www/statics/c/confirmbet.css" type="text/css" rel="stylesheet" />
<body>
<!--ҳ��ͷ�� start-->
<script src="http://www.shunjubao.com/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="http://www.shunjubao.com/zy/www/statics/j/headNav.js" type="text/javascript"></script>
<!--center start-->
<div class="center">
  <!--ȷ��Ͷעcenter start-->
  <div class="BitCenter">
    <div class="ConfirmationTz">
      <!--Ͷעȷ�Ϲ��ط�ʽ start-->
    <div class="querenguoguan">
    <div class="TouXiang">
    <dl><dt><img src="http://www.shunjubao.com/www/statics/i/touxiang.jpg" /> <a href="http://www.shunjubao.com/account/user_center.php"><?php echo $uname?></a> </dt>
        <dd><p>�������ͣ�<i><?php echo $SPORT[$d["sport"]]."-".$POOL[$d["pool"]]?></i></p>
            <p>�ۼ��н���<strong>&yen;</strong></p></dd>
        <dd><p>������<i>&yen;<?php echo $d["money"]?></i></p>
            <p>������<strong><?php echo $d["multiple"]?></strong></p></dd>
        <dd><p>���ط�ʽ��<em><?php echo $d["select"]?></em></p>
            <p>��������<strong>&yen;</strong></p></dd>
        <dd><p>�Ϲ�ʱ�䣺<i><?php echo $d["datetime"]?></i></p></dd>
    </dl>
    <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <h1 style="position:relative; margin:20px 0;"><b>��</b>��������
    <div class="Fshare">
    <div class="gdTips"><span>*</span>�÷�����ϸ������Ҫɹ���������ܲ鿴��</div>
    <div class="share"></div>
    <div class="clear"></div>
    </div>
    </h1>
<!--�������� start-->
<table class="hacker" border="0" cellpadding="0" cellspacing="0">
<tbody id="detail_tr">
<tr>
<th>���</th>
<th>����</th>
<th>����</th>
<th>����VS�Ͷ�</th>
<th>�ҵ�ѡ��</th>
<th>�ʹ�</th>
<th>�ȷ�</th>
<th style="border-right:1px solid #6f6f6f;">״̬</th>
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
        <!--�������� end-->
        <!-- ����start-->
        <div class="gandanCenter">
          <dl>
            <dt>������<span>&yen;2Ԫ</span></dt>
            <!--<dt>��ɱ�����<b>5%</b></dt>-->
            <dt class="first">����������</dt>
            <dt class="first">
              <ul>
                <li><a href="javascript:void(0);" id="subBtn">-</a></li>
                <li>
                  <input type="text" value="" maxlength="" autocomplete="" id="">
                </li>
                <li><a href="javascript:void(0);" id="addBtn">+</a></li>
              </ul>
            </dt>
            <dt class="first">���999999��</dt>
            <dd>
              <input type="submit" value="����" class="gdsub">
            </dd>
          </dl>
          <div class="clear"></div>
        </div>
        <!-- ����end-->
      </div>
    </div>
    <!--Ͷעȷ�Ϲ��ط�ʽ end-->
  </div>
</div>
<!--ȷ��Ͷעcenter end-->
<!--center end-->
<!--footer start-->
<div class="footer">
  <div id="gotop"><a href="javascript:void(0)">���ض���</a></div>
  <div id="Rightsubnav">
    <ul>
      <li class="service"><a href="http://wpa.qq.com/msgrd?v=1&uin=2733292184&site=qq&menu=yes" target="_blank">���߿ͷ�</a></li>
      <li class="help"><a href="http://www.shunjubao.com/help" target="_blank">��������</a></li>
    </ul>
  </div>
  <div class="footerNav"> <a href="http://www.shunjubao.com/passport/reg.php" target="_blank">�û�ע��</a><span>|</span> <a href="http://www.shunjubao.com/about/index.html" target="_blank">��������</a><span>|</span> <a href="http://www.shunjubao.com/about/baozhang.html" target="_blank">��ȫ����</a><span>|</span> <a href="http://www.shunjubao.com/about/contactus.html" target="_blank">��ϵ��ʽ</a><span>|</span> <a href="http://www.shunjubao.com/about/job.html" target="_blank">�˲���Ƹ</a><span>|</span> <a href="http://www.shunjubao.com/about/bd.html" target="_blank">�������</a><span>|</span> <a href="http://www.shunjubao.com/about/Sitemap.html" target="_blank">վ���ͼ</a><span>|</span> <a href="http://www.shunjubao.com/about/lawfirm.html" target="_blank">��������</a><span>|</span> <a href="http://www.shunjubao.com/about/xieyi.html" target="_blank">��վЭ��</a> </div>
  <div class="footdaodu">�ȵ㵼���� <a href="http://www.shunjubao.com/zixun/" target="_blank">��Ѷ����</a><span>|</span> <a href="#" target="_blank">��Ӯ2��1</a><span>|</span> <a href="http://www.shunjubao.com/news/footballtj/" target="_blank">��������</a><span>|</span> <a href="http://www.shunjubao.com/news/NBAxw/" target="_blank">��������</a><span>|</span> <a href="http://www.shunjubao.com/news/footballtj/" target="_blank">�����Ƽ�</a><span>|</span> <a href="http://www.shunjubao.com/news/NBAtj/" target="_blank">�����Ƽ�</a><span>|</span> <a href="http://www.shunjubao.comnews/touzhujiqiao/" target="_blank">Ͷע����</a></div>
  <div class="FootPic">
    <ul>
      <li><a href=""><img src="http://www.shunjubao.com/www/statics/i/FootPic2.jpg"/></a></li>
      <li><a href=""><img src="http://www.shunjubao.com/www/statics/i/FootPic3.jpg"/></a></li>
      <li><a href=""><img src="http://www.shunjubao.com/www/statics/i/FootPic4.jpg"/></a></li>
      <li><a href=""><img src="http://www.shunjubao.com/www/statics/i/FootPic5.jpg"/></a></li>
      <li><a href=""><img src="http://www.shunjubao.com/www/statics/i/FootPic6.jpg"/></a></li>
    </ul>
  </div>
  <div class="FooterOhter"> 2014&nbsp;&nbsp;&copy;&nbsp;Copyright&nbsp;&nbsp;&nbsp;&nbsp;��Ӯ��&nbsp;&nbsp;&nbsp;
    All rights reserved�������ţ���ICP��14016851-1��&nbsp;��Ʊ�з��գ�Ͷע�����  ����δ��18�������������۲�Ʊ&nbsp;&nbsp;&nbsp;&nbsp; <span class="none">
    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https:\/\/" : " http:\/\/");document.write(unescape("%3Cspan id='cnzz_stat_icon_1000441119'%3E%3C\/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com\/z_stat.php%3Fid%3D1000441119%26show%3Dpic' type='text\/javascript'%3E%3C\/script%3E"));</script>
    </span> </div>
</div>
<!--footer end-->
</body>
</html>