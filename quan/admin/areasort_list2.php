<?
include("config.inc.php");
include('checklogin.php');
$tablename = "areatsort2";




$type_arr = array();			
$type = get_info($conn, $tablename, $type_arr, $type_arr, $type_arr, true , "and ifuser=1 and parentid=1 ");  //获取类型信息
$tpl -> assign( 'type', $type);
						
switch (get_param('action')){

		case 'add':
			$tpl -> display('areasort_list_add.html');
			break;
		case 'addit':			
			$typename = get_param('group');
			$parentid = get_param('groupid');
			$orderby = get_param('orderby');
			$ifuser = get_param('ifuser');
			
			
			$isql = "INSERT INTO ".tname($tablename)." (`sysid` ,`typename` ,`parentid` ,`tdesc` ,`orderby` ,`ifuser` ,`dtime`)VALUES (NULL , '".$typename."', '".$parentid."', '".$tdesc."', '".$orderby."', '".$ifuser."', '".time()."');";
			$query = $conn -> Query($isql);
			if($query){
				message('成功增加资料','areasort_list2.php');			
			}else{
			
				message('增加资料出错','areasort_list2.php');		
			}
			
			break;
		case 'mod':
			$aid = get_param('updateid');
			$sql = "SELECT * FROM ".tname($tablename)." where sysid = ".$aid;
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);
			
			
			$tpl -> assign('parentid', '<option value="'.$value["parentid"].'" style="color:#ff0000" selected="selected">'.showgroup($value["parentid"],$tablename).'</option>');
			$tpl -> assign('aid', $aid);
			$tpl -> assign('typename', $value["typename"]);
			$tpl -> assign('orderby', $value["orderby"]);
			
			$tpl -> assign('ifuser', $value["ifuser"] == "1" ? "checked" : "");
		
	

			$tpl -> display('areasort_list_edit.html');
			break;
			
		case 'delete':	
			$fields = array('sysid');
			$values = array( intval(get_param('id')) );
    		$res = delete_record( $conn, $tablename, $fields, $values);
			
			if( $res > 0 )
			{
				message('删除成功！','areasort_list2.php');
			}else{
				message('删除失败!','areasort_list2.php');
			}

    		break;
		case 'update':

			$aid = get_param('aid');
			$typename = get_param('typename');
			$parentid = get_param('parentid');
			$orderby = get_param('orderby');
			$ifuser = get_param('ifuser');
			
			 $usql = "update ".tname($tablename)." set parentid='".$parentid."',`typename` ='".$typename."',orderby ='".$orderby."',ifuser ='".$ifuser ."' where sysid = ".$aid;
		
		
			$query = $conn -> Query($usql);
			if($query){
				message('成功修改资料','areasort_list2.php');			
			}else{
			
				message('修改资料出错','areasort_list2.php');		
			}

			break;
	
		default:

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link type="text/css" rel="stylesheet" href="treeneed/css4cnltreemenu.css" />
<script type="text/javascript" src="treeneed/js4cnltreemenu.js"></script>
<script>
function checkdel(myid){
	if(myid==""){
		alert("操作错误！");
		return false;
	}
	if(confirm("注意：\n 您真的要删除该信息吗？")==true){
		location.href="areasort_list2.php?action=delete&id=" + myid;
		return true;
	}
	return false;
}

</script>
</head>
<body style="background-color:#F7F7F7">
<div class="mainright" style="background-color:#F7F7F7;">
	<div class="maintitle" style="background-color:#F7F7F7"><strong>展览展示类别</strong></div>
    <div class="maincon">
  
 <!--CNLTreeMenu Start:-->
<div class="CNLTreeMenu" id="CNLTreeMenu1" style="background-color:#F7F7F7">
<h4>&nbsp;</h4>
<p><a id="AllOpen_1" href="#" onclick="MyCNLTreeMenu1.SetNodes(0);Hd(this);Sw('AllClose_1');" style="display:none;">全部展开</a><a id="AllClose_1" href="#" onclick="MyCNLTreeMenu1.SetNodes(1);Hd(this);Sw('AllOpen_1');" >全部折叠</a></p>

<?
adminListSort($conn,0,"parentid",1,"typename","km_areatsort2","sysid","areasort_list2.php");

?>
</div>
<script type="text/javascript">
<!--
var MyCNLTreeMenu1=new CNLTreeMenu("CNLTreeMenu1","li");
MyCNLTreeMenu1.InitCss("Opened","Closed","Child","treeneed/s.gif");
MyCNLTreeMenu1.SetNodes(0);;
-->
</script> 
  
  </div>
  </div>
  </div>


</body>
</html>
<?

		break;
		}
?>
