<?php
/**
 * 上传头像
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

$refer = $_GET['from']?$_GET['from']:ROOT_DOMAIN;
$userInfo = Runtime::getUser();

#未登录用户跳转
if (!$userInfo) {
	redirect(ROOT_DOMAIN . '/passport/login.php?from=' . ROOT_DOMAIN . $_SERVER['PHP_SELF']);
	exit;
}

$img_size = 80*1024;//单位bit，即20k
$img_error = '';//报错信息


$tpl = new Template();
$tpl->assign('userInfo', $userInfo);
$TEMPLETE['title'] = '智赢网用户中心上传头像';
$TEMPLATE['keywords'] = '智赢竞彩,智赢网,智赢用户中心';
$TEMPLATE['description'] = '智赢网用户中心上传头像。';

if (!$_FILES['fileField']['tmp_name']) {
	$objUserRealInfoFront = new UserRealInfoFront();
	$userRealInfo = $objUserRealInfoFront->get($userInfo['u_id']);
	$tpl->assign('userRealInfo',$userRealInfo);
	echo_exit($tpl->r('user_head_img'));
}

do {
	if($_FILES['fileField']['error'] > 0){
	   switch($_FILES['fileField']['error']) {  
	     case 1: $img_error =  '文件大小超过服务器限制';  
	             break;  
	     case 2: $img_error =  '文件太大！';  
	             break;  
	     case 3: $img_error =  '文件只加载了一部分！';  
	             break;  
	     case 4: $img_error =  '文件加载失败！';  
	             break;
	             
	     default: $img_error = '未知错误';
	   }  
	   break;  
	}
	  
	if($_FILES['fileField']['size'] > $img_size){  
	   $img_error =  '文件大于20kb！';
	   break;
	}
	  
	if($_FILES['fileField']['type']!='image/jpeg' && $_FILES['fileField']['type']!='image/gif' && $_FILES['fileField']['type']!='image/png'){  
	   $img_error =  '文件不是JPG、GIF或者PNG图片！';  
	   break;  
	}
	//防止图片伪装
	$isImage = getimagesize($_FILES['fileField']['tmp_name']);
	if ($isImage == false) {
		$img_error =  '图片错误！';  
	   	break; 
	}
	
	$today = date("YmdHis");  
	$filetype = $_FILES['fileField']['type']; 
	 
	if($filetype == 'image/jpeg'){  
	  $type = '.jpg';  
	}  
	if($filetype == 'image/gif'){  
	  $type = '.gif';  
	}
	if($filetype == 'image/png'){  
	  $type = '.png';  
	}
	
	#上传文件地址,包含文件名
	$ext = '/zy_head_img-'. $userInfo['u_id'] . $today . $type;
	$upfile = USER_HEAD_IMG_PATH . $ext;
	#文件访问路径
	$imgurl = USER_HEAD_IMG_URL . $ext;
	if(is_uploaded_file($_FILES['fileField']['tmp_name'])) {  
	   if(!move_uploaded_file($_FILES['fileField']['tmp_name'], $upfile)) {  
	     $img_error =  '移动文件失败！';  
	     break;  
	    }
	} else {  
	   $img_error =  'not uploaded file!';  
	   break;  
	}
	
	#把img路径存入用户信息
	$objUserMemberFront = new UserMemberFront();
	$userInfo['u_img'] = $imgurl;
	$tmpResult = $objUserMemberFront->modify($userInfo);
	if (!$tmpResult->isSuccess()) {
		$img_error = $tmpResult->getData();
	}
	
}while (false);
$tpl->assign('img_error', $img_error);
echo_exit($tpl->r('user_head_img'));
?> 