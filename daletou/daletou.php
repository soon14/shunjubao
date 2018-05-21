<?php
header("Content-type:text/html;charset=utf-8");
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
if (Runtime::isLogin()==false) {
	redirect('/passport/login.php');
}else{
	$data['multinum'] = Request::r('MultiNum');  // 倍数
	$data['wagercount'] = Request::r('WagerCount');  // 注数
	$data['wagertype'] = Request::r('WagerType');  // 注数
	$data['wagerstore'] = Request::r('WagerStore');
	$data['manner'] = Request::r('manner');
	$data['totalmoney'] = Request::r('TotalMoney');
	$data['lotteryno'] = Request::r('LotteryNo');
	$data['lotterytype'] = Request::r('LotteryType');
	$data['together'] = Request::r('ConsignType');
	$data['u_id'] = Runtime::getUid();  //用户uid
	if(empty($data['wagerstore'])){
		echo "<script type='text/javascript'>alert('投注失败');window.location.href='/daletou/index.php'</script>";
		die;
	}else{
		$daletou = new Daletou();
		$result = $daletou->daletousave($data);
		if($result=='-1'){
			redirect('http://www.shunjubao.com/account/user_charge.php');// 跳转充值页面
		}elseif($result=='1'){
			echo "<script type='text/javascript'>alert('投注成功');window.location.href='/daletou/index.php'</script>";
			die;
		}else{
			echo "<script type='text/javascript'>alert('支付失败');window.location.href='/daletou/index.php'</script>";
		}
	}
	
}
?>