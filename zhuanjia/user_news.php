
<?php
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
$userInfo = Runtime::getUser();

#标题
$TEMPLATE ['title'] = "智赢网竞彩专家";
$TEMPLATE['keywords'] = '智赢竞彩投注,竞彩投注,竞彩篮球投注,竞彩足球投注。';
$TEMPLATE['description'] = '智赢网竞彩专家。';
$u_id = $userInfo['u_id'];
$u_name = $userInfo['u_name'];
$u_nick = $userInfo['u_nick'];

$tpl = new Template();


include_once ("config.inc.php");

switch (get_param('action')){
	
		   case 'delete':
		
			$sysid = get_param('id');
			
		   $sql ="delete FROM ".tname("news")."  where e_id='".$u_id ."'  and sysid='".$sysid."' ";			
			$res = $conn -> Query($sql);
			if( $res > 0 )
			{
				message('删除成功！','user_news.php');
			}else{
				message('删除失败!','user_news.php');
			}

    		break;
		
		
		case'add':
		
				$error_tips="";
				//检查是否申请专家并且有通过审核 
				$sql ="SELECT *  FROM ".tname("shengqing")."  where  u_name='".$u_name ."'  limit 0,1 ";			
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				
				if($value["sysid"]){
					if($value["ifuse"]!=1){
							$error_tips = "你已请申请,后台在审核中,如有其它疑问，请及时与我们客服联系，谢谢";		
					}
				}else{
					
					$error_tips = " 未申请专家,点击<a href='http://www.shunjubao.xyz/zhuanjia/zhuanjiashenqing.php' target='_blank'>申请</a>";	
				}
				$tpl -> assign('error_tips',$error_tips);
		
		
		
			$YOKA ['output'] = $tpl->r ('zhuanjia/user_news_add');
			echo_exit ( $YOKA ['output'] );
		
		case'add_action':
		
		$pubdate = get_param('pubdate');
		$dtitle = get_param('dtitle');
		$docontent = get_param('docontent');

		
		
			$arr = array(
					"pubdate"=>"'$pubdate'",
					"dtitle"=>"'$dtitle'",
					"docontent"=>"'$docontent'",
					"e_id"=>"'$u_id'",
					"addtime"=>"'$dtime'",
					"addip"=>"'$dip'"	
				);

		//	print_r($arr);exit();
				$res = add_record($conn, "news", $arr);
				
				if($res['rows'] <= 0)
				{
					message("推荐新闻提交出错，如果有其它问题，请及时与客服联系，谢谢！","user_news.php?action=add");
					exit();
				}else{
					
					message("推荐新闻添加成功","user_news.php");
					exit();

				}

			break;	

		default:
				$error_tips="";
				//检查是否申请专家并且有通过审核 
			 	$sql ="SELECT *  FROM ".tname("shengqing")."  where  u_name='".$u_name ."'  limit 0,1 ";			
			
				$query = $conn -> Query($sql);
				$value = $conn -> FetchArray($query);
				
				if($value["sysid"]){
					if($value["ifuse"]!=1){
							$error_tips = "你已请申请,后台正在审核中,如有其它疑问，请及时与我们客服联系，谢谢";		
					}
				}else{
					
					$error_tips = " 未申请专家,点击<a href='http://www.shunjubao.xyz/zhuanjia/zhuanjiashenqing.php' target='_blank'>申请</a>";	
				}
				$tpl -> assign('error_tips',$error_tips);
				
				
				if(!$error_tips){
						$page = empty($_GET['page'])? 1:intval($_GET['page']);
						if($page < 1) $page = 1;
						$start = ($page - 1) * $pageSize;
						
						$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("news")." where   e_id='".$u_id ."' "),0);
						$sql ="SELECT *  FROM ".tname("news")."  where  e_id='".$u_id ."' ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
			
						$query = $conn -> Query($sql);
						while($value = $conn -> FetchArray($query)){
							
	
							$value["mycontent"] =cut_str($value["docontent"],20)."..."; 
							$result[] = $value;
						}
						
						//print_r($result);die();
						$multi = multi($totalRecord,$pageSize,$page,"user_news.php?1=1");
						$tpl -> assign('multi',$multi);
						$tpl -> assign('pageSize',$pageSize);
						$tpl -> assign('totalRecord',$totalRecord);
						$tpl -> assign('datalist', $result);
						$tpl -> assign('page',ceil($totalRecord/$pageSize));
				}
				break;	

}
		

$YOKA ['output'] = $tpl->r ('zhuanjia/user_news');
echo_exit ( $YOKA ['output'] );

