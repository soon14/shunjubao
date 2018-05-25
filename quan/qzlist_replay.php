<?php
/**
 * passport之：注册界面
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$userInfo = Runtime::getUser();
$refer = Request::getReferer();
$tpl = new Template ();
#标题
$TEMPLATE ['title'] = "聚宝专家";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '聚宝网专家订阅为彩民提供订阅推荐服务，聘请实战专家指导竞彩、北单及篮彩的投注。';
#埋藏跳转页面
$tpl->assign ('refer',$refer );
include_once ("config.inc.php");
//通过审核的专家  推荐专家
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$u_nick = $userInfo['u_nick'];
//var_dump($userInfo);exit();

switch (get_param('action')){
		
		case'add_action':
		
		$qid = get_param('qid');//板块id
		$postid = get_param('postid');//贴子id
		$postid2 = get_param('postid2');//回复***回复ID 
		
		$q_content = get_param('q_content');
		
		
		$file = $_FILES["q_pic"];
		$oldpath = $file['tmp_name'];
		$filename=strtolower(basename($file['name']));//取上传文件的小写文件名
		$fileext=explode('.', $filename);//取后缀名
		$arraynum = count($fileext) - 1;

		$file_size = ceil(filesize($oldpath)/1024);//文件大小(K)

		$newpath = "uploads/images/".date("Y-m-d")."/";
		if (!file_exists($newpath)){
			@umask(0);
			@mkdir($newpath, 0777);
		}
		$newname = time().".".$fileext[$arraynum];//新文件名
		$newpath .=  $newname;//新文件名
		
		if($myfile->cp($oldpath,$newpath,true)){
			
			$q_pic =$newpath;
		}else{
			$q_pic ="";
			//die("upload error!");
		}
		
		
		
		
		
		if(empty($u_id)){
			message("请先登录!","http://www.shunjubao.xyz/passport/login.php");
			exit();	
		}		

		$dtime = time();
	//var_dump($_FILES);var_dump($_POST);exit();
	
		if(empty($qid)||empty($postid)){
				message("访问出错!","index.php");
				exit();	
			}
	
		if($postid2){
					$arr = array(
					"qid"=>"'$qid'",
					"u_id"=>"'$u_id'",
					"postid"=>"'$postid'",
					"postid2"=>"'$postid2'",	
					"u_name"=>"'$u_name'",
					"u_nick"=>"'$u_nick'",
					"q_content"=>"'$q_content'",
					"q_pic"=>"'$q_pic'",
					"dtime"=>"'$dtime'",
					"dip"=>"'$dip'"			
				);

					$res = add_record($conn, "post_reply2", $arr);
				//	die("dddd");
			
		}else{
				$arr = array(
					"qid"=>"'$qid'",
					"u_id"=>"'$u_id'",
					"postid"=>"'$postid'",
	
					"u_name"=>"'$u_name'",
					"u_nick"=>"'$u_nick'",
					"q_content"=>"'$q_content'",
					"q_pic"=>"'$q_pic'",
					"dtime"=>"'$dtime'",
					"dip"=>"'$dip'"			
				);
					$res = add_record($conn, "post_reply", $arr);
		}


					message("回复贴子成功!","./qzlist_replay.php?qid=$qid&postid=$postid");
					exit();
		


	
		
		
		
			break;	
		default:
		
		
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
		
			$qid = get_param('qid');
	
			$postid = get_param('postid');

			$tpl -> assign('qid', $qid);
			$tpl -> assign('postid', $postid);
			

			if(empty($qid)||empty($postid)){
				message("访问出错!","index.php");
				exit();	
			}
			
			
			$sql ="SELECT * FROM ".tname("post")." where id=$postid    LIMIT 0,1";
			$query = $conn -> Query($sql);
			$quan_tizhi = $conn -> FetchArray($query);
			$quan_tizhi["img"]=show_img($quan_tizhi["u_id"]);
			$quan_tizhi["isman"]=show_post_isman($quan_tizhi["u_id"],$quan_tizhi["qid"]);
			
			//var_dump($quan_tizhi);exit();
			
			$tpl -> assign('quan_tizhi', $quan_tizhi);
		
		
		
			$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("post_reply")." where qid=$qid and postid='".$postid."'  "),0);
			$sql ="SELECT * FROM ".tname("post_reply")." where qid=$qid and postid='".$postid."' order by id desc  LIMIT ".$start.",".$pageSize;
		

			
			//$sql ="SELECT * FROM ".tname("post_reply")." where qid=$qid and postid='".$postid."'  order by  id desc  LIMIT ".$start.",".$pageSize;
			$query = $conn -> Query($sql);
			while($value = $conn -> FetchArray($query)){
				$value["img"]=show_img($value["u_id"]);
				if(empty($value["img"])){
					$value["img"]='http://www.shunjubao.xyz/www/statics/i/touxiang.jpg	';
				}
				
				//查看贴子还有没有回复
				$sql2 ="SELECT * FROM ".tname("post_reply2")." where  postid2='".$value["id"]."'  order by  id desc  ";
			
				$query2 = $conn -> Query($sql2);
				while($value2= $conn -> FetchArray($query2)){
				
					$value["post_reply2"][]= $value2;
				
				}
				
				
				
				$result[] = $value;
			}
		
			
			
			//var_dump($result);exit();
			
			
			
			$multi = multi($totalRecord,$pageSize,$page,"qzlist_replay.php?qid=$qid&t=$t&postid=$postid");
			$tpl -> assign('multi',$multi);
			
			$tpl -> assign('datalist', $result);
			$quan_info  = quan_info($qid);
			$tpl -> assign('quan_info', $quan_info);

			$YOKA ['output'] = $tpl->r ('quan/qzlist_replay');
			
			
			echo_exit ( $YOKA ['output'] );
		break;	
}













