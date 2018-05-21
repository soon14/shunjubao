<?php

include_once dirname( __FILE__).DIRECTORY_SEPARATOR.'init.php';
$refer = Request::getReferer();
$tpl = new Template ();
$TEMPLATE ['title'] = "智赢专家-专家申请";
$TEMPLATE['keywords'] = '专家推荐、单场推荐、付费推荐、专家订阅、竞彩足球、北单、单场竞猜、单场投注、大小球预测、亚盘、亚盘推荐、盘口玩法、赔率解析、亚洲盘口、NBA推荐、篮球推荐、盈利计划';
$TEMPLATE['description'] = '智赢专家,专家申请。';
if (Request::isPost()) {
	$submitInfo = array();	

	if (isset($_POST['submit'])) {
		$msg = array();
		do {

			#验证用户名
			$u_name = Request::p('u_name');
			$submitInfo['u_name'] = $u_name;
			
			#2、是否已经注册
			$objUserMemberFront = new UserMemberFront();
			$tmpResult = $objUserMemberFront->getByName($u_name);
			if (!$tmpResult) {
				$msg['u_name'] = '用户名不存在';
			}
			#3、手机是否合法
			$mobile = Request::r('mobile');
			$submitInfo['mobile'] = $mobile;
			if (!Verify::mobile($mobile)) {
				$msg['mobile'] = '手机号不合法';
			}
			
			
			//$addip = getonlineip();	
			
		} while ( FALSE );

      //  var_dump($msg);exit();
        #注册用户
		if (!$msg) {
			
			include_once ("config.inc.php");
			
			$u_name = get_param('u_name');
			$mobile = get_param('mobile');
			$sqqq = get_param('sqqq');
			$sqsc = get_param('sqsc');
			$ddesc = get_param('ddesc');	
			
			
			$eid = $tmpResult["u_id"];
			$u_nick = $tmpResult["u_nick"];
			
			$sql = "SELECT *  FROM ".tname("shengqing")."  where u_name = '".$u_name."' or  mobile = '".$mobile."' order by sysid desc limit 0,1";
			//echo $sql;die();
			$query = $conn -> Query($sql);
			$value = $conn -> FetchArray($query);
			//判断是否有申请过
			if($value["sysid"]){
				
					message("申请出错，此帐号或者手机号码已经申请过，如果有其它问题，请及时与客服联系，谢谢！","zhuanjiashenqing.php");
					exit();	
			}
			
		
			$arr = array(
					"eid"=>"'$eid'",
					"u_name"=>"'$u_name'",
					"u_nick"=>"'$u_nick'",
					"mobile"=>"'$mobile'",
					"sqqq"=>"'$sqqq'",
					"sqsc"=>"'$sqsc'",
					"ddesc"=>"'$ddesc'",
					"addtime"=>"'$dtime'",
					"addip"=>"'$dip'",
					"ifuse"=>"'$ifuse'"				
				);

		//	print_r($arr);exit();
				$res = add_record($conn, "shengqing", $arr);
				
				if($res['rows'] <= 0)
				{
					message("申请出错，如果有其它问题，请及时与客服联系，谢谢！","zhuanjiashenqing.php");
					exit();
				}else{
					
					message("成功申请，我们会尽快审核你的资料，如果有其它问题，请及时与客服联系，谢谢！","zhuanjiashenqing.php");
					exit();

				}

		
		
		
		
		}else{
			$tpl->assign ( 'msg', $msg );	
		}
//		pr($msg);exit;
	}
}




#标题
$TEMPLATE ['title'] = "专家列表 - ";


#埋藏跳转页面
$tpl->assign ('refer',$refer );

$YOKA ['output'] = $tpl->r ('zhuanjia/zhuanjiashenqing');
echo_exit ( $YOKA ['output'] );

