<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>Ͷעȷ��-����Ӯ������ƱӮ����ѡ_�й�������_���_����_����_����_���_���������Ĳ�Ʊ��վ</title>
<meta name="keywords" content="����,�й�������,���,�й������,����,����,����,���,�����Ʊ,�����Ʊ" />
<meta name="description" content="��Ӯ���ǲ�ƱӮ�ҵľۼ��أ��ڱ���õĲ�Ʊ������վ�����ʡ�������Ʊ�������Ʊ�������Ʊ��������������ͨ����վ���ֻ��ͻ���ʹ�á��ṩ������Ʊ��������Ʊ�Ŀ���������ͼ����ˮ���ˡ��������⡢�ȷ�ֱ������Ѷ����" />
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/header.css">
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/confirmbet.css">
<link type="text/css" rel="stylesheet" href="/zy/www/statics/c/footer.css">
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/jquery.js"></script>
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/jquery-1.9.1.min.js"></script>
<script language="javascript" type="text/javascript" src="/zy/www/statics/j/MFloat.js"></script>
</head>
<body>
<!--ҳ��ͷ�� start-->
<script src="/zy/www/statics/j/top.js" type="text/javascript"></script>
<script src="/zy/www/statics/j/menu.js" type="text/javascript"></script>
<!--ҳ��ͷ�� end-->
<!--��ǰλ�� start-->
<script src="/zy/www/statics/j/cailocation.js" type="text/javascript"></script>
<!--��ǰλ�� end-->
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

// ��֤�û����
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
    <!--ȷ��Ͷעcenter start-->
    <div class="BitCenter">
      <!--��ʾ������Ϣ  start-->
      <div class="touzhutips"><em>!</em>��Ҫ��ʾ����Ͷעʱ�ľ��ʽ���ָ���п����ڳ�Ʊʱ�����仯��ʵ����ֵ��Ʊ����ϢΪ׼�� ����ϸ�鿴����<b>"Ͷע��Ϣ"</b>У�Ա������Ƿ�������Ͷע�����һ���ύ�������ձ��������ף��޷����ģ� </div>
      <!--��ʾ������Ϣ  end-->
      <div class="ConfirmationTz">
        <!--Ͷעȷ���˻���Ϣ start-->
        <div class="">
          <h1><b>��</b>Ͷע��Ϣ ��<?php echo $POOL[$p]?>��</h1>
          <div class="Confirmauser">
            <ul>
              <li><a href="http://<?php echo $host.'/zy/account/user_charge.php'?>">��ֵ</a></li>
              <li>�˻���<em>&yen;&nbsp;<?php echo $user_cash?></em>Ԫ</li>
              <li>�ܽ�<b>&yen;&nbsp;<?php echo $money?></b>Ԫ</li>
              <li>����������<strong><?php echo $multiple?></strong>��</li>
              <li>���ط�ʽ��<strong><?php echo $user_select?></strong></li>
            </ul>
          </div>
        </div>
        <!--Ͷעȷ���˻���Ϣ end-->
        <!--Ͷע��������ܽ���\���رȷ�\���رȷ�\��ȫ��ȷ�� start-->
        <div class="">
          <div id="touzhuchack">
            <table class="hacker" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <th>���</th>
                <th>����</th>
                <th>����</th>
                <th>VS</th>
                <th>�Ͷ�</th>
                <th>�淨</th>
                <th>����ѡ��</th>
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
        <!--Ͷע��������ܽ���\���رȷ�\���رȷ�\��ȫ��ȷ�� end-->
        <!--Ͷעȷ���ύ start-->
        <div>
          <div class="confiRma">
            <p class="check">
              <input type="checkbox" checked>
              ͬ��<a href="">����Ӯ������Э�顷</a>������ȷ��Ͷע���顣</p>
            <p>
              <input type="submit" id="form_submit" class="confiRmaSub" value="ȷ�Ϲ���" />
            </p>
          </div>
        </div>
        <!--Ͷעȷ���ύ end-->
      </div>
    </div>
    <!--ȷ��Ͷעcenter end-->
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