<?php
/**
 *功能：派洛贝云计费接口公用函数
 *版本：1.0
 *修改日期：2016-06-08
 '说明：
 '以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己的需要，按照技术文档编写,并非一定要使用该代码。
 '该代码仅供学习和研究派洛贝云计费接口使用，只是提供一个参考。
 */

if (!defined("prlpay_sdk_ROOT"))
{
	define("prlpay_sdk_ROOT", dirname(__FILE__) . DIRECTORY_SEPARATOR);
}
 
require_once(prlpay_sdk_ROOT . 'config.php');

if (!function_exists('curl_init')) {
	exit('您的PHP没有安装 配置cURL扩展，请先安装配置cURL，具体方法可以上网查。');
}

if (!function_exists('json_decode')) {
	exit('您的PHP不支持JSON，请升级您的PHP版本。');
}

// 私钥 pp_conf::PP_APP_KEY;

class prlpay_sdk{
	
	function __construct(){
	}

	// 创建订单
	function create_order($params){
		if (empty($params ['version']) || empty($params ['subject']) ||
				 empty($params ['outTradeNo']) ||
				 empty($params ['appId']) ||
				 empty($params ['payAmount']) ||
				 empty($params ['signType']) ){
			echo '参数错误';
			return false;
		}

		$content = $this->composeReq($params);
		return $this->request(pp_conf::PP_CREATE_ORDER_URL,$content,'demo');
	}

	// 查询订单
	function query_order($params){
		if (empty($params ['version']) || 
				 (empty($params ['outTradeNo']) && empty($params ['payNo']) ) ||
				 empty($params ['appId']) ||
				 empty($params ['signType']) ){
			echo '参数错误';
			return false;
		}

		$content = $this->composeReq($params);
		return $this->request(pp_conf::PP_QUERY_ORDER_URL,$content,'demo');
	}

	// 申请退款
	function refund_order($params){
		if (empty($params ['version']) || 
				 (empty($params ['outRefundNo']) && empty($params ['payNo']) ) ||
				 empty($params ['refundType']) ||
				 empty($params ['refundAmount']) ||
				 empty($params ['appId']) ||
				 empty($params ['signType']) ){
			echo '参数错误';
			return false;
		}

		$content = $this->composeReq($params);
		return $this->request(pp_conf::PP_REFUND_ORDER_URL,$content,'demo');
	}

	// 查询订单
	function query_refund($params){
		if (empty($params ['version']) || 
				 (empty($params ['outRefundNo']) && empty($params ['payNo']) && empty($params ['refundNo']) ) ||
				 empty($params ['appId']) ||
				 empty($params ['signType']) ){
			echo '参数错误';
			return false;
		}

		$content = $this->composeReq($params);
		return $this->request(pp_conf::PP_QUERY_REFUND_URL,$content,'demo');
	}


	// 下载账单
	function download_bill($params){

		if (empty($params ['version']) || 
				 empty($params ['billDate']) || empty($params ['billType']) ||
				 empty($params ['appId']) ||
				 empty($params ['signType']) ){
			echo '参数错误';
			return false;
		}

		$content = $this->composeReq($params);

		echo pp_conf::PP_DOWNLOAD_BILL_URL.'?'.$content;

		return $this->request(pp_conf::PP_DOWNLOAD_BILL_URL,$content,'demo');
	}


	// 验签
	function test_sign($params){
		$signOrigin = $params['sign'];
		unset($params['sign']);
		ksort($params);  // 按字段名ASCII排序
		$transdata = urldecode( http_build_query($params) ); // urldecode获得原始数据
		$sign = $this->MD5_sign($transdata, pp_conf::PP_MD5_KEY );
		if($signOrigin == $sign){
			return true;
		}else{
			return false;
		}
	}


	//组装报文
	private function composeReq($params) {
	    //获取待签名字符串
		ksort($params);  // 按字段名ASCII排序
		$transdata = urldecode( http_build_query($params) ); // urldecode获得原始数据
		
		//签名，目前支持RSA、MD5两种签名方式
		if($params['signType'] == 'rsa'){
			$sign = $this->RSA_sign($transdata, pp_conf::PP_APP_KEY );
		}else if($params['signType'] == 'md5'){
			$sign = $this->MD5_sign($transdata, pp_conf::PP_MD5_KEY );
		}else{
			die('no signType');
		}

	    //组装请求报文
	    $transdata = http_build_query($params) . '&sign='.urlencode($sign);
	    return $transdata;
	}

	// 请求派洛贝接口
	private function request($remoteServer, $postData, $userAgent) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $remoteServer);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
		$data = urldecode(curl_exec($ch));
		
		if($data === false)
		{
		    echo 'Curl error: ' . curl_error($ch);
		    die();
		}
		curl_close($ch);

		return $data;
	}

	//RSA方式签名
	private function RSA_sign($data, $priKey) {
		//转换为openssl密钥
		$res = openssl_get_privatekey($priKey);
		//调用openssl内置签名方法，生成签名$sign
		openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA1);
		//释放资源
		openssl_free_key($res);
		//base64编码
		$sign = base64_encode($sign);
		return $sign;
	}

	//MD5方式签名
	private function MD5_sign($data, $md5Key) {
		//转换为openssl密钥
		$sign = md5($data.'&key='.$md5Key);
		return $sign;
	}
}


