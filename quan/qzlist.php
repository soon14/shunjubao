<?php
/**
 * passport之：注册界面
 */
include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$userInfo = Runtime::getUser();
$refer = Request::getReferer();
$tpl = new Template ();
#标题
$TEMPLATE ['title'] = "智赢专家";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '智赢网专家订阅为彩民提供订阅推荐服务，聘请实战专家指导竞彩、北单及篮彩的投注。';
#埋藏跳转页面
$tpl->assign ('refer',$refer );
include_once ("config.inc.php");
//通过审核的专家  推荐专家
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$u_nick = $userInfo['u_nick'];
//var_dump($userInfo);exit();

switch (get_param('action')){
	
	/*	case'zd'://置顶操作
			if(empty($u_id)){
				message("请先登录!","http://www.zhiying365.com/passport/login.php");
				exit();	
			}
			
			
			$postid = get_param('postid');
			$qid = get_param('qid');
			//判读该会员是不是管理员
			$sql = "SELECT * FROM   ".tname("post_member")."  where  qid='".$qid."'  and u_id='".$u_id."'   ";
			
			$query = $conn->Query($sql);
			$value = $conn -> FetchArray($query);
			if($value["isman"]!=1){
	
				message("你不是管理员，不能置顶操作!","/qzlist.php?qid=$qid&postid=$postid");
				exit();	
				
			}
	
		
			$sql = "SELECT * FROM   ".tname("post")."  where  qid='".$qid."' order by orderby desc limit 0,1   ";
			$query = $conn->Query($sql);
			$value = $conn -> FetchArray($query);
			$order_nums = $value["orderby"]+1;
			
	 		$usql = "update ".tname("post")." set istop='1' ,orderby='".$order_nums."'  where id = ".$postid;
			
			$query = $conn->Query($usql);	
				
			message("帖子操作成功!","./qzlist.php?qid=$qid&postid=$postid");
			exit();*/
	
		case'add_action':
		
		
		
		
		if(empty($u_id)){
			message("请先登录!","http://www.zhiying365.com/passport/login.php");
			exit();	
		}		

		$dtime = time();
	//var_dump($_FILES);var_dump($_POST);exit();
	
		//上传图片操作
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
	
		$qid = get_param('qid');//板块id
		$postid = get_param('postid');//贴子id
		$q_content = base64_encode(get_param('q_content'));
		//$q_pic = get_param('q_pic');
		
		
		if(!empty($postid)){//回复id
			
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
			//print_r($arr);exit();
					$res = add_record($conn, "post_reply", $arr);
				//	die("dddd");
					message("回复贴子成功!","./qzlist.php?qid=$qid&postid=$postid");
					exit();
		
			
		}else{
			
			$arr = array(
					"qid"=>"'$qid'",
					"u_id"=>"'$u_id'",
					"u_name"=>"'$u_name'",
					"u_nick"=>"'$u_nick'",
					"q_content"=>"'$q_content'",
					"q_pic"=>"'$q_pic'",
					"dtime"=>"'$dtime'",
					"dip"=>"'$dip'"			
				);
			//print_r($arr);exit();
					$res = add_record($conn, "post", $arr);
				//	die("dddd");
					message("发布成功!","./qzlist.php?qid=$qid");
					exit();
		
		}

	
		
		
		
			break;	
		default:
			$qid = get_param('qid');
			$t = get_param('t');
			$postid = get_param('postid');
			
			$page = empty($_GET['page'])? 1:intval($_GET['page']);
			if($page < 1) $page = 1;
			$start = ($page - 1) * $pageSize;
			
			

			if(empty($qid)){
				$qid=1;	
			}
			
			if(empty($t)){
				$t="nf";	
			}
			
			$tpl -> assign('t', $t);
			
			
			
			if($u_id>0){
				//进入圈子人数
					$sql ="SELECT * FROM ".tname("post_member")." where u_id=$u_id and qid ='".$qid."' LIMIT 0,1";	
					$query = $conn -> Query($sql);
					$value = $conn -> FetchArray($query);
					if(empty($value)){
						$arr = array(
							"u_id"=>"'$u_id'",
							"u_name"=>"'$u_name'",
							"u_nick"=>"'$u_nick'",
							"qid"=>"'$qid'",
							"firsttime"=>"'$dtime'",
							"lasttime"=>"'$dtime'",
							"dip"=>"'$dip'"			
						);
		
						add_record($conn, "post_member", $arr);
						
					}else{
						$sql ="update ".tname("post_member")." set lasttime='".$dtime."',loginnums=loginnums+1 WHERE `u_id` = '".$value["u_id"]."' and qid ='".$qid."'";
						$conn -> Query($sql);		
						
					}
			}
			
	
			$tpl -> assign('qid', $qid);
			
			
			$tpl -> assign('postid', $postid);
			//==========================================================================================列表 
			
			
			if($t=="nh"){//回复列表
			
				/*$sql ="SELECT * FROM ".tname("post")." where qid=$qid    LIMIT 0,1";
				$query = $conn -> Query($sql);
				$quan_tizhi = $conn -> FetchArray($query);
				$quan_tizhi["img"]=show_img($quan_tizhi["u_id"]);
				
				
				$tpl -> assign('quan_tizhi', $quan_tizhi);*/
				
				
				$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("post_reply")." where 1 and   qid=$qid  order by  id desc "),0);
				

				$sql ="SELECT * FROM ".tname("post_reply")." where qid=$qid   order by  id desc  LIMIT ".$start.",".$pageSize;
				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){
					$value["img"]=show_img($value["u_id"]);
					if(empty($value["img"])){
						$value["img"]='http://www.zhiying365.com/www/statics/i/touxiang.jpg	';
					}
					
					$result[] = $value;
				}
			
				
			}else{//贴子列表 
			
				$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("post")." where 1 and   qid=$qid  order by istop desc,orderby DESC "),0);
			    $sql ="SELECT * FROM ".tname("post")." where qid=$qid order by istop desc,orderby DESC, id desc  LIMIT ".$start.",".$pageSize;

				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){
					$value["img"]=show_img($value["u_id"]);
					if(empty($value["img"])){
						$value["img"]='http://www.zhiying365.com/www/statics/i/touxiang.jpg';
					}
					$value["q_content"] =  base64_decode($value["q_content"]);
					
					
					//查回复数
					$value["postnums"]=show_post_nums($value["id"]);
					
					$value["isman"]=show_post_isman($value["u_id"],$value["qid"]);
					//var_dump($value["isman"]);exit();

					$result[] = $value;
				}
				
				
			}
			
		

			
			$multi = multi($totalRecord,$pageSize,$page,"qzlist.php?qid=$qid&t=$t&postid=$postid");
			//	var_dump($multi);exit();
			
			$tpl -> assign('datalist', $result);
			$tpl -> assign('multi',$multi);
			$quan_info  = quan_info($qid);
			$tpl -> assign('quan_info', $quan_info);

			$YOKA ['output'] = $tpl->r ('quan/qzlist');
			
			
			echo_exit ( $YOKA ['output'] );
		break;	
}


