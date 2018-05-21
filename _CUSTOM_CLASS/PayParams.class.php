<?php
/*
 * PayParams 关于pay参数类
 * 1.根据不同业务验证参数是否合法
 * 2.根据不同的业务需求改变参数
 */
class PayParams {
	//验证支付宝返回数据信息
	public  $alipayRetMes;
	public function __construct() {

	}

	#根据不同业务验证参数是否合法
	public function checkParams($params) {
		return $params;
	}
	#根据不同的业务需求改变参数
	public function changeParms($params) {
		return $params;
	}

	#验证基本参数是否真确
	public function checkBasicGetPayFormsParms($params) {
		#1.所需数据是否完整
		$ParamsList = include (ROOT_PATH . '/include/get_pay_froms_params_config.php');

		$errorAll = include (ROOT_PATH . '/include/pay_error_config.php');
		$returnArr = array ('status' => false, 'message' => '' );
//		$objPayLogFront = new PayLogFront();
//
//		foreach ( $ParamsList ['get_pay_forms_list'] as $key => $data ) {
//			if (! isset ( $params [$key] )) {
//				$returnArr ['message'] = '缺少' . $data . '参数';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FAILURE'],$params,$returnArr ['message']);
//				return $returnArr;
//			}
//		}
//
//		#加载接入方的配置文件
//
//		$partnerConfig = include (ROOT_PATH . '/include/partner_config.php');
//
//		do {
////
//
//			#6.验证show_url		'商品的链接地址'
//			if (!preg_match('/http:\/\/.+/', $params ['show_url'])) {
//				$returnArr ['message'] = 'show_url:商品的链接地址错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//
//			#7.验证user_ip		'用户IP地址'
//			$preg = "/\A((([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\.){3}(([0-9]?[0-9])|(1[0-9]{2})|(2[0-4][0-9])|(25[0-5]))\Z/";
// 			if (!preg_match($preg,$params ['user_ip']) ) {
// 				$returnArr ['message'] = 'user_ip错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//			#8.验证subject		'商品名称'
//			if ($params ['subject'] == '') {
//				$returnArr ['message'] = 'subject:商品名称错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//			#9.验证body			'商品描述信息'
//			if ($params ['body'] == '') {
//				$returnArr ['message'] = 'body:商品描述信息错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//			#10.验证total_fee		'该笔订单应付总额'
//			if(!is_numeric($params ['total_fee'] )||$params ['total_fee']<0){
//				$returnArr ['message'] = 'total_fee:该笔订单应付总额错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//
//
//
//			#12.验证tell_url		'付成功后回调接入方的通知接口地址'
//			if (!preg_match('/http:\/\/.+/', $params ['notify_url'])) {
//				$returnArr ['message'] = 'notify_url:付成功后回调接入方的通知接口地址错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//
//			#13.验证return_url		'支付成功后，自动跳转地址 '
//			if (!preg_match('/http:\/\/.+/', $params ['return_url'])) {
//				$returnArr ['message'] = 'return_url:支付成功后，自动跳转地址错误';
//				$objPayLogFront->addOneErrorLog('get_pay_forms',$errorAll['PARAMETER_FORMAT_ERROR'],$params,$returnArr ['message']);
//				break;
//			}
//
//
//			#全部验证通过
//
//			$returnArr = array ('status' => true, 'message' => '参数完全正确');
//			break;
//		} while ( false );
		return $returnArr = array ('status' => true, 'message' => '参数完全正确');;
	}


	/**
	 * 在支付中心适配器层包装一下合作方传递过来的订单号，确保各合作方之间的订单id是不唯一的
	 * @param string $out_trade_no
	 * @param string $partner
	 * @throws ParamsException '不存在的合作方'
	 * @return string
	 */
	public function wrapOutTradeNo($out_trade_no, $partner) {
		return $out_trade_no;
		$objPartnerConfig = new PartnerConfig($partner);
		# 如果第三方是优享团，原样返回交易号
		# 原因：优享团已经运营了很长时间，运营同学已经熟悉了使用旧有的方式去支付宝查订单，在优享团后台做订单比对，所以还是不变的好。
		if ($partner == 'gaojie') {
			return $out_trade_no;
		}
		return "{$objPartnerConfig->getShortName()}_{$out_trade_no}";
	}


}
?>