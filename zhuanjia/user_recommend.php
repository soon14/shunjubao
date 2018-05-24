
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
	
		case'update':
		$id = get_param('id');
		$pubdate = get_param('pubdate');
		$macth = get_param('macth');
		$duiwu = get_param('duiwu');
		$recommond = get_param('recommond');
		$pmoney = get_param('pmoney');
		$pname = get_param('pname');
		$pcontent = get_param('pcontent');
		$out_time = get_param('out_time');
	
			$arr = array(
					"pubdate"=>"'$pubdate'",
					"pcontent"=>"'$pcontent'",
					"pname"=>"'$pname'",
					"macth"=>"'$macth'",
					"duiwu"=>"'$duiwu'",
					"recommond"=>"'$recommond'",
					"pmoney"=>"'$pmoney'",
					"ifuse"=>"'0'",
					"out_time"=>"'$out_time'"	
				);

		//	print_r($arr);exit();
				$res = update_record( $conn,"recommond", $arr, "and sysid = $id");//修改会员资料
				
				if( $res > 0){
			
					message("修改成功，后台正在审核中","user_recommend.php");
					exit();
				}else{
					
					message("修改出错","user_recommend.php?action=edit&id=".$id);
					exit();

				}

			break;		
	
		
	
		case 'edit':
			$sysid = get_param('id');
			
			$sql = "SELECT * from  ".tname("recommond")."   where  sysid = ".$sysid." limit 0,1";
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);

			$tpl -> assign('value',$value);
			$YOKA ['output'] = $tpl->r ('zhuanjia/user_recommend_edit');
			echo_exit ( $YOKA ['output'] );
			
			
		   case 'mod':
		
			$sysid = get_param('id');
			$tag = get_param('tag');
		    $sql ="update ".tname("recommond")." set islottey=".$tag."  where u_id='".$u_id ."'  and sysid='".$sysid."' ";			
	
			$res = $conn -> Query($sql);
			if( $res > 0 )
			{
				message('操作成功！','user_recommend.php');
				
			}else{
				message('删除失败!','user_recommend.php');
				
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
		
		
		
			$YOKA ['output'] = $tpl->r ('zhuanjia/user_recommend_add');
			echo_exit ( $YOKA ['output'] );
		
		case'add_action':
		
		$pubdate = get_param('pubdate');
		$macth = get_param('macth');
		$duiwu = get_param('duiwu');
		$recommond = get_param('recommond');
		$pmoney = get_param('pmoney');
		$pname = get_param('pname');
		$pcontent = get_param('pcontent');
		$out_time = get_param('out_time');	
		
			$arr = array(
					"pubdate"=>"'$pubdate'",
					"pcontent"=>"'$pcontent'",
					"pname"=>"'$pname'",
					"macth"=>"'$macth'",
					"duiwu"=>"'$duiwu'",
					"recommond"=>"'$recommond'",
					"pmoney"=>"'$pmoney'",
					"u_id"=>"'$u_id'",
					"u_name"=>"'$u_name'",
					"u_nick"=>"'$u_nick'",
					"addtime"=>"'$dtime'",
					"addip"=>"'$dip'",
					"ifuse"=>"'1'",
					"out_time"=>"'$out_time'"					
				);

		//	print_r($arr);exit();
				$res = add_record($conn, "recommond", $arr);
				
				if($res['rows'] <= 0)
				{
					message("方案提交出错，如果有其它问题，请及时与客服联系，谢谢！","user_recommend.php?action=add");
					exit();
				}else{
					
					message("方案提交成功!","user_recommend.php");
					exit();

				}

			break;	
			case'view':
				$page = empty($_GET['page'])? 1:intval($_GET['page']);
				if($page < 1) $page = 1;
				$start = ($page - 1) * $pageSize;
				
				$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("booking")." where  e_id='".$u_id."' "),0);
				$sql ="SELECT *  FROM ".tname("booking")."  where   e_id='".$u_id."'  ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
				
				$objUserMemberFront = new UserMemberFront();
				
				$query = $conn -> Query($sql);
				while($value = $conn -> FetchArray($query)){
					
					$user = $objUserMemberFront->getByName($value["e_name"]);
					$value["e_name"]=$user['u_name'];

					//$recommond = show_recommond($value["bookid"]);
					$booking_money+=$value["booking_money"];

					if($value["booktype"]==1){
						$value["booktype_status"]="单场推荐";	
					}elseif($value["booktype"]==2){
						$value["booktype_status"]="订阅一周";		
					}else{
						$value["booktype_status"]="订阅一个月";	
					}
						
					$result[] = $value;
				}
				
		
				//print_r($result);die();
				$multi = multi($totalRecord,$pageSize,$page,"user_recommend.php?action=view");
	
				$tpl -> assign('booking_money',$booking_money);
				$tpl -> assign('multi',$multi);
				$tpl -> assign('pageSize',$pageSize);
				$tpl -> assign('totalRecord',$totalRecord);
				$tpl -> assign('datalist', $result);
				$tpl -> assign('page',ceil($totalRecord/$pageSize));

				$YOKA ['output'] = $tpl->r ('zhuanjia/view_user_recommend');
			echo_exit ( $YOKA ['output'] );
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
						
						$totalRecord = $conn -> NumRows($conn -> Query("SELECT * FROM ".tname("recommond")." where   u_id='".$u_id ."' "),0);
						$sql ="SELECT *  FROM ".tname("recommond")."  where  u_id='".$u_id ."' ORDER BY sysid DESC LIMIT ".$start.",".$pageSize;			
			
						$query = $conn -> Query($sql);
						while($value = $conn -> FetchArray($query)){
							
							if($value["ifuse"]==1){
								$value["ifuse_status"]="已通过";	
							}elseif($value["ifuse"]==2){
								$value["ifuse_status"]="未通过";		
							}else{
								$value["ifuse_status"]="审核中";	
							}
							
							
						
							
							
							if($value["iscommon"]==1){
								$value["iscommon_status"]="是";		
							}else{
								$value["iscommon_status"]="否";	
							}
							$value["dingyue_nums"] = show_dingyue_nums($value["sysid"]);
							
							if($value["islottey"]==1){
								$value["islottey_status"]="已中奖";		
							}else{
								$value["islottey_status"]="未中";	
							}
							
							
							
							
							$result[] = $value;
						}
						
						//print_r($result);die();
						$multi = multi($totalRecord,$pageSize,$page,"user_recommend.php?1=1");
						$tpl -> assign('multi',$multi);
						$tpl -> assign('pageSize',$pageSize);
						$tpl -> assign('totalRecord',$totalRecord);
						$tpl -> assign('datalist', $result);
						$tpl -> assign('page',ceil($totalRecord/$pageSize));
				}
				break;	

}
		

$YOKA ['output'] = $tpl->r ('zhuanjia/user_recommend');
echo_exit ( $YOKA ['output'] );

