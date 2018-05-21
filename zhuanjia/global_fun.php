<?php







header("Content-Type:text/html;charset=utf-8");





/**

* 查找某个程序目录下所有文件

* @param string dir 文件夹目录

*/

function rec_scandir($dir){

   $files = array();

   if ( $handle = opendir($dir) ) {

       while ( ($file = readdir($handle)) !== false ) {

           if ( $file != ".." && $file != "." ) {

               if(is_dir($dir . "/" . $file)) {

                   $files[$file] = rec_scandir($dir . "/" . $file);

               }else {

			   		//echo $file;

                   $files[] = $dir."/".$file;  				   

               }

           }

       }

       closedir($handle);

       return $files;

   } 

}





/**

* 生成fck编辑器

* @param string inputName 输入框名称

* @param string inputValue 输入框值

* @param string height 高

* @param string toolbarSet 工具条设置

*/

function createEditor($inputName, $inputValue,$height="",$toolbarSet=""){



    $editor = new FCKeditor($inputName) ;

    $editor->BasePath = "./myeditor2/";

    $editor->ToolbarSet = $toolbarSet;

    $editor->Width = "800";

    $editor->Height = $height;

    $editor->Value = $inputValue;

    $GLOBALS['sm']->assign("editor", $editor->CreateHtml());



}





function createEditor_1($inputName, $inputValue,$height,$toolbarSet){



    $editor = new FCKeditor($inputName) ;

    $editor->BasePath = "../libs/fckeditor/";

    $editor->ToolbarSet = $toolbarSet;

    $editor->Width = "800";

    $editor->Height = $height;

    $editor->Value = $inputValue;

    $GLOBALS['sm']->assign("editor_1", $editor->CreateHtml());

}







function message($msg,$direct = "1"){	



  	switch($direct){

		case '0':

			$script = "";

		case '1':

    		$script = "location.href=\"".$_SERVER["HTTP_REFERER"]."\";";

    		break;



  		 case '2':

			$script = "history.back();";

    		break;

   		default:

    		$script = "location.href=\"".$direct."\";";

	}

	echo "<script language='javascript'>window.alert('".$msg."');".$script."</script>";

	exit();

}







function image_size($filename){



	return filesize($filename);

}







function image_type($filename){



	return filetype($filename);

}







function file_extend($file_name) 

{ 

	$extend = pathinfo($file_name); 

	$extend = strtolower($extend["extension"]); 

	return $extend; 

}





//以指定key值进行二维数组降序排列







function array_sort($arr,$keys,$type){   







  $keysvalue  =  array();







  $i = 0;







  foreach($arr   as   $key=>$val)   {  







  $val[$keys] = str_replace("-","",$val[$keys]);







  $val[$keys] = str_replace(" ","",$val[$keys]);







  $val[$keys] = str_replace(":","",$val[$keys]);







  $keysvalue[]   =  $val[$keys];







 







  }   







  asort($keysvalue); //key值排序  







  reset($keysvalue); //指针重新指向数组第一个







  foreach($keysvalue   as   $key=>$vals)   {   







  $keysort[]   =   $key;   







  }   







  $new_array   =   array();  







  if($type != "asc"){







  for($ii=count($keysort)-1; $ii>=0; $ii--)   {   







  $new_array[]   =   $arr[$keysort[$ii]];   







  } 







  }else{







      for($ii=0; $ii<count($keysort); $ii++){







          $new_array[] = $arr[$keysort[$ii]];







      }







  }







  return   $new_array;   







  }







 //找出时间段内周末天数 







function weekend($time1,$time2)

{	

  for ($i=$time1;$i<$time2;$i=$i+86400)

  {

  	  $day   =   date("D",   $i);  

  	  if   (   $day   ==   "Fri"   ||   $day   ==   "Sat"   )   

	  {

		$arr[]=$i;

	  }

  }

  return  sizeof($arr);

}







/**

* 获取浏览器类型

*

* @return string

*/

function get_browser2()

{

	$agent = $_SERVER['HTTP_USER_AGENT'];

	$browser = '';

	if(strpos($agent, 'MSIE')) 

	{

	  if (preg_match("/MSIE ([0-9].[0-9]+);/",$agent,$matches))

	  {

			$browser = 'Internet Explorer '.$matches[1];

	  } else {

			$browser = 'Internet Explorer (hack)';

	  }

	

	}elseif(strpos($agent, "NetCaptor")) {

	

	

	

	  $browser = "NetCaptor";

	

	

	

	} elseif(strpos($agent, "Netscape")) {

	

	

	

	  $browser = "Netscape";

	

	

	

	} elseif(strpos($agent, "Lynx")) {

	

	

	

	  $browser = "Lynx";

	

	

	

	} elseif(strpos($agent, "Opera")) {

	

	

	

	  $browser = "Opera";

	

	

	

	} elseif(strpos($agent, "Konqueror")) {

	

	

	

	  $browser = "Konqueror";

	

	

	

	} elseif(strpos($agent, "Mozilla")) {

	

	

	

	  if (preg_match("/ Firefox/([0-9](.[0-9])+)/",$agent,$matches)){

	

	

	

	   $browser = 'Firefox '.$matches[1];

	

	

	

	  } else {

	

	

	

	   $browser = 'Moziila';

	

	

	

	  }

	

	

	

	} else {

	

	

	

	  $browser = 'other';

	

	

	

	}

	

	

	

	return $browser;

	

	



}



















  







 function get_name_byid($id,$table){







  	$sql="select name from $table where uid=$id";







  	$result=Execute($sql);







  	return $result->fields['name'];







  }

















// 清除HTML代码







function html_clean($content) {







    $content = htmlspecialchars($content);







    $content = str_replace("\n", "<br />", $content);







    $content = str_replace("  ", "&nbsp;&nbsp;", $content);







    $content = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $content);







    return $content;







}





/* *

*	检查相关记录是否存在

*

*	$table 数据库表名

*	$fields 检查字段

*	$value 与$fields对应的值

* */

function exist_check($conn,$table,$fields = array(),$value = array()){

	global $TABLE_NAME_INC,$MYSQL_DB;

	

	$where = '';

	foreach($fields as $key=>$val){

		$where .= " AND `".$val."`='".$value[$key]."' ";

	}



	$exist= "SELECT 1 FROM ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` WHERE 1 ".$where;

	$res = $conn->Query($exist);

	if($conn->NumRows($res))

	{

		return true;

	}else{

		return false;

	}

}





/* *

*	在数据库表$table中增加一条记录

*

*	$table 数据库表名

*	$arr 字段名与值

*	$unique_check_field 检查值需要唯一的字段,如果已存在相同值则取消插入

*	$unique_check_value 与$unique_check_field对应的值

* */

function add_record($conn,$table,$arr = array(),$unique_check_table='',$unique_check_field = array(),$unique_check_value = array())

{

	global $TABLE_NAME_INC,$MYSQL_DB;

	

	$exists = 0;

	

	if(!empty($unique_check_table))

	{

		$exists = exist_check($conn,$unique_check_table,$unique_check_field,$unique_check_value);

	}

	if($exists)

	{

		return 0;

	}

	

	$field_str = '';

	$value_str = '';

	foreach ($arr as $key=>$value){ 



		$field_str=$field_str.",".$key;



		$value_str=$value_str.",".$value."";



	    }

	

	

	$field_str = substr($field_str,1);

	$value_str = substr($value_str,1);

	

	$insert_sql = "INSERT INTO ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` ($field_str) VALUES($value_str);";

	//print_r($insert_sql);die();

	$conn->Query($insert_sql);

	

	$result = array();

	$result['rows'] = $conn->AffectedRows();

	$result['id'] = $conn->InsertID();

	//print_r($result);

	return $result;

}



function add_record2($conn,$table,$arr = array(),$unique_check_table='',$unique_check_field = array(),$unique_check_value = array())

{

	global $TABLE_NAME_INC,$MYSQL_DB;

	

	$exists = 0;

	

	if(!empty($unique_check_table))

	{

		$exists = exist_check($conn,$unique_check_table,$unique_check_field,$unique_check_value);

	}

	if($exists)

	{

		return 0;

	}

	

	$field_str = '';

	$value_str = '';

	foreach ($arr as $key=>$value){ 



		$field_str=$field_str.",".$key;



		$value_str=$value_str.",".$value."";



	    }

	

	

	$field_str = substr($field_str,1);

	$value_str = substr($value_str,1);

	

	$insert_sql = "INSERT INTO ".$MYSQL_DB.".`".$table."` ($field_str) VALUES($value_str);";

	//print_r($insert_sql);die();

	$conn->Query($insert_sql);

	

	$result = array();

	$result['rows'] = $conn->AffectedRows();

	$result['id'] = $conn->InsertID();

	//print_r($result);

	return $result;

}



/* *

*	在数据库表$table中更新一条记录

*

*	$table 	数据库表名

*	$arr 字段与对应的值

*	$where_ 条件字段与值

* */


function update_record2($conn,$table, $arr = array(),$where='',$where_field = array(),$where_value = array())

{	

	global $TABLE_NAME_INC,$MYSQL_DB;

	

	$update_str = '';

	

	foreach ($arr as $key=>$value){



		  $update_str=$update_str.$key."=".$value.",";



		}

	if(empty($where))

	{

		foreach($where_field as $key=>$val)

		{

			$where .= " AND `".$val."`='".$where_value[$key]."' ";

		}

	}

	

	$update_str = substr($update_str,0,-1);

	

	$sql = "UPDATE ".$MYSQL_DB.".`".$table."` SET $update_str WHERE 1 $where;";

	//exit($sql);

	$conn->Query($sql);

	

	return $conn->AffectedRows();

}





function update_record($conn,$table, $arr = array(),$where='',$where_field = array(),$where_value = array())

{	

	global $TABLE_NAME_INC,$MYSQL_DB;

	

	$update_str = '';

	

	foreach ($arr as $key=>$value){



		  $update_str=$update_str.$key."=".$value.",";



		}

	if(empty($where))

	{

		foreach($where_field as $key=>$val)

		{

			$where .= " AND `".$val."`='".$where_value[$key]."' ";

		}

	}

	

	$update_str = substr($update_str,0,-1);

	

	$sql = "UPDATE ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` SET $update_str WHERE 1 $where;";

	//exit($sql);

	$conn->Query($sql);

	

	return $conn->AffectedRows();

}





/* *

*	在数据库表$table中删除多条记录

*	$table 	数据库表名

* */

function delete_more_record($conn,$table,$where)

{	

	global $TABLE_NAME_INC,$MYSQL_DB;

	$sql = "DELETE FROM ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` WHERE 1 $where ";



	$conn->Query($sql);

	return $conn->AffectedRows();

}









/* *

*	在数据库表$table中删除(物理删除)或更新(逻辑删除)一条记录

*

*	$table 	数据库表名

*	$where_ 条件字段与值

*

*	$field 	字段

*	$value 	与$field对应的值

* */



function delete_record($conn,$table,$where_field = array(),$where_value = array(),$field = array(),$value = array())

{	

	global $TABLE_NAME_INC,$MYSQL_DB;



	$update_str = '';

	$where = '';

	foreach($where_field as $key=>$val)

	{

		$where .= " AND `".$val."`='".$where_value[$key]."' ";

	}



	if(count($field)>0)

	{

		foreach($field as $key=>$val)

		{

			$update_str .= "`".$val."`='".$value[$key]."',";		

		}

		

		$update_str = substr($update_str,0,-1);

		

		$sql = "UPDATE ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` SET $update_str WHERE 1 $where;";

	}

	else

	{

		$sql = "DELETE FROM ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` WHERE 1 $where;";

	}

	

	$conn->Query($sql);

	return $conn->AffectedRows();

}











/**

*	获取数据库表$table中字段$info的信息

*

*	$table 数据库表名

*	$fields 条件字段名

*	$value 字段($fields)对应值

*	$info 返回信息字段名

*	$all 是否返回所有记录

**/

function get_info($conn,$table,$fields = array(),$value = array(),$info = array(),$all = false,$where='',$OrderBy=''){

	global $TABLE_NAME_INC,$MYSQL_DB;

	if(empty($where))

	{

		foreach($fields as $key=>$val)

		{

			$where .= " AND `".$val."`='".$value[$key]."' ";

		}

	}

	if(!empty($info))

	{

		$str = implode('`,`',$info);

		$str = '`'.$str.'`';

		echo $str;

	}

	else

	{

		$str = '*';

	}

	if ($OrderBy != ""){

        $where .= $OrderBy;

	}

	$sql= "SELECT $str FROM ".$MYSQL_DB.".`".$TABLE_NAME_INC.$table."` WHERE 1 ".$where.'';

	//echo $sql;

	$res = $conn->Query($sql);

	

	if($arr = $conn->FetchArray($res))

	{

		if(!$all)

		{

			return $arr;

		}

		else

		{

			$all_record = array();

			$all_record[] = $arr;

			while($arr = $conn->FetchArray($res))

			{

				$all_record[] = $arr;

			}

			

			return $all_record;

		}

	}

	else

	{

		return array();

	}

}



/*记录用户操作日志

**	$conn 数据库连接

**	$user 用户名

**  $log  操作

*/

function admin_log($conn,$al_user,$al_action,$al_sql='')

{

	$ip=$_SERVER['REMOTE_ADDR'];

	$time=time();

	if($al_user!='')

	{

		$arr = array(

				"al_user"=>"'$al_user'",

				"al_action"=>"'$al_action'",

				"al_sql"=>"'$al_sql'",

				"al_create_time"=>"$time",

				"al_ip"=>"'$ip'"

			);

			

		//$res = add_record();

		$res = add_record( $conn, "adminlog", $arr);

		//die();

		if($res>0)

		{

			return true;

		}else {

			return false;

		}

	}else{

		exit();

	}

}







?>