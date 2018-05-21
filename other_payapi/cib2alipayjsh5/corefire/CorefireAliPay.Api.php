<?php
/**
 * Modify on 2016/12/03
 * @author: xb
 */
require_once "CorefireAliPay.Exception.php";
require_once "CorefireAliPay.Config.php";
require_once "CorefireAliPay.Data.php";

class CorefireAliPayApi
{

	public static function jswap($inputObj, $timeOut = 30)
	{
	    $url = "https://api.tnbpay.com/pay/gateway";
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet()) {
			throw new CorefireAliPayException("缺少wap支付接口必填参数out_trade_no！");
		}else if(!$inputObj->IsBodySet()){
			throw new CorefireAliPayException("缺少wap支付接口必填参数body！");
		}else if(!$inputObj->IsTotal_feeSet()) {
			throw new CorefireAliPayException("缺少wap支付接口必填参数total_fee！");
		}else if(!$inputObj->IsAppidSet()) {
			throw new CorefireAliPayException("缺少wap支付接口必填参数appid！");
		}else if(!$inputObj->IsMch_idSet()) {
			throw new CorefireAliPayException("缺少wap支付接口必填参数mch_id！");
        }else if(!$inputObj->IsMethodSet()) {
            throw new CorefireAliPayException("缺少wap支付接口必填参数method！");
        }

		//异步通知url未设置，则使用配置文件中的url
		if(!$inputObj->IsNotify_urlSet()){
			$inputObj->SetNotify_url(CorefireAliPayConfig::NOTIFY_URL);//异步通知url

		}

		$inputObj->SetVersion(CorefireAliPayConfig::VERSION);
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
		
		//签名
		$inputObj->SetSign();
		$xml = $inputObj->ToXml();
		
		$response = self::postXmlCurl($xml, $url, $timeOut);
		
		$result = CorefireAliPayResults::Init($response,$inputObj->GetKey());
		
		return $result;
	}
	public static function wap($inputObj, $timeOut = 30)
	{
	    $url = "https://api.tnbpay.com/pay/gateway";
	    //检测必填参数
	    if(!$inputObj->IsOut_trade_noSet()) {
	        throw new CorefireAliPayException("缺少wap支付接口必填参数out_trade_no！");
	    }else if(!$inputObj->IsBodySet()){
	        throw new CorefireAliPayException("缺少wap支付接口必填参数body！");
	    }else if(!$inputObj->IsTotal_feeSet()) {
	        throw new CorefireAliPayException("缺少wap支付接口必填参数total_fee！");
	    }else if(!$inputObj->IsAppidSet()) {
	        throw new CorefireAliPayException("缺少wap支付接口必填参数appid！");
	    }else if(!$inputObj->IsMch_idSet()) {
	        throw new CorefireAliPayException("缺少wap支付接口必填参数mch_id！");
	    }else if(!$inputObj->IsMethodSet()) {
	        throw new CorefireAliPayException("缺少wap支付接口必填参数method！");
	    }
	
	    //异步通知url未设置，则使用配置文件中的url
	    if(!$inputObj->IsNotify_urlSet()){
	        $inputObj->SetNotify_url(CorefireAliPayConfig::NOTIFY_URL);//异步通知url
	
	    }
	
	    $inputObj->SetVersion(CorefireAliPayConfig::VERSION);
	    $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
	
	    //签名
	    $inputObj->SetSign();
	    $xml = $inputObj->ToXml();
	
	    $response = self::postXmlCurl($xml, $url, $timeOut);
	
	    $result = CorefireAliPayResults::Init($response,$inputObj->GetKey());
	
	    return $result;
	}
	/**
	 *
	 * 统一下单，appid,mch_id,out_trade_no、body、total_fee、trade_type必填
	 * spbill_create_ip、nonce_str不需要填入
	 * @param WxPayUnifiedOrder $inputObj
	 * @param int $timeOut
	 * @throws CorefireAliPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function unifiedOrder($inputObj, $timeOut = 30)
	{
	    //检测必填参数
	    if(!$inputObj->IsOut_trade_noSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数out_trade_no！");
	    }else if(!$inputObj->IsBodySet()){
	        throw new CorefireAliPayException("缺少统一支付接口必填参数body！");
	    }else if(!$inputObj->IsTotal_feeSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数total_fee！");
	    }else if(!$inputObj->IsAppidSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数appid！");
	    }else if(!$inputObj->IsMch_idSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数mch_id！");
	    }else if(!$inputObj->IsMethodSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数method！");
	    }else if(!$inputObj->IsOpenidSet()) {
	        throw new CorefireAliPayException("缺少统一支付接口必填参数支付宝用户号或者账号openid！");
	    }
	
	
	    //异步通知url未设置，则使用配置文件中的url
	    if(!$inputObj->IsNotify_urlSet()){
	        $inputObj->SetNotify_url(CorefireAliPayConfig::NOTIFY_URL);//异步通知url
	    }
	
	    $inputObj->SetVersion(CorefireAliPayConfig::VERSION);
	    $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
	
	    //签名
	    $inputObj->SetSign();
	    $xml = $inputObj->ToXml();

	    $response = self::postXmlCurl($xml, CorefireAliPayConfig::GATEWAY_URI, $timeOut);

	    $result = CorefireAliPayResults::Init($response,$inputObj->GetKey());
	
	    return $result;
	}
	
	/**
	 *
	 * 关闭订单，CoreireAliPayCloseOrder中appid,mchid,out_trade_no必填
	 * 
	 * @param WxPayCloseOrder $inputObj
	 * @param int $timeOut
	 * @throws CorefireAliPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function closeOrder($inputObj,$key, $timeOut = 30)
	{
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet()) {
			throw new CorefireAliPayException("订单查询接口中，out_trade_no必填！");
		}else if(!$inputObj->IsAppidSet()) {
			throw new CorefireAliPayException("缺少统一支付接口必填参数appid！");
		}else if(!$inputObj->IsMch_idSet()) {
			throw new CorefireAliPayException("缺少统一支付接口必填参数mch_id！");
        }else if(!$inputObj->IsMethodSet()) {
            throw new CorefireAliPayException("缺少统一支付接口必填参数method！");
        }
		
		$inputObj->SetVersion(CorefireAliPayConfig::VERSION);
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
	
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
	
		$response = self::postXmlCurl($xml, CorefireAliPayConfig::GATEWAY_URI, $timeOut);
		$result = CorefireAliPayResults::Init($response,$key);
	
		return $result;
	}
	
	/**
	 *
	 * 查询订单，CiticPayApiOrderQuery中out_trade_no、transaction_id至少填一个
	 * appid、mchid、spbill_create_ip、nonce_str不需要填入
	 * @param CiticPayOrderQuery $inputObj
	 * @param int $timeOut
	 * @throws CorefireAliPayException
	 * @return 成功时返回，其他抛异常
	 */
	public static function orderQuery($inputObj, $timeOut = 30)
	{		
	    $url = "https://api.tnbpay.com/pay/gateway";
        if(!$inputObj->IsAppidSet()) {
            throw new CorefireAliPayException("缺少接口必填参数appid！");
        }else if(!$inputObj->IsMch_idSet()) {
            throw new CorefireAliPayException("缺少接口必填参数mch_id！");
        }else if(!$inputObj->IsMethodSet()) {
            throw new CorefireAliPayException("缺少接口必填参数method！");
        }
        
		//检测必填参数
		if(!$inputObj->IsOut_trade_noSet() && !$inputObj->IsTransaction_idSet() && !$inputObj->IsPass_trade_noSet()) {
			throw new CorefireAliPayException("订单查询接口中，out_trade_no、transaction_id,pass_trade_no至少填一个！");
		}
		
		$inputObj->SetVersion(CorefireAliPayConfig::VERSION);
		$inputObj->SetNonce_str(self::getNonceStr());//随机字符串
	
		$inputObj->SetSign();//签名
		$xml = $inputObj->ToXml();
		
		$response = self::postXmlCurl($xml, $url, $timeOut);
		
		$result = CorefireAliPayResults::Init($response,$inputObj->GetKey());
	
		return $result;
	}
	public static function refundOrder($url,$inputObj, $timeOut = 30)
	{
	    //检测必填参数
	    if(!$inputObj->IsTransaction_idSet()&&!$inputObj->IsOut_trade_noSet()&&!$inputObj->IsPass_trade_noSet()){
	        throw new CorefireAliPayException("缺少退款接口必填参数transaction_id！");
	    }else if(!$inputObj->IsTotal_feeSet()) {
	        throw new CorefireAliPayException("缺少退款接口必填参数total_fee！");
	    }else if(!$inputObj->IsRefund_feeSet()) {
	        throw new CorefireAliPayException("缺少退款接口必填参数refund_fee！");
	    }else if(!$inputObj->IsAppidSet()) {
	        throw new CorefireAliPayException("缺少退款接口必填参数appid！");
	    }else if(!$inputObj->IsMch_idSet()) {
	        throw new CorefireAliPayException("缺少退款接口必填参数mch_id！");
	    }
	    $inputObj->SetVersion(CorefireAliPayConfig::VERSION);
	    $inputObj->SetNonce_str(self::getNonceStr());//随机字符串
	     
	    //签名
	    $inputObj->SetSign();
	
	    $xml = $inputObj->ToXml();

	    // 		$startTimeStamp = self::getMillisecond();//请求开始时间
	    $response = self::postXmlCurl($xml, $url, $timeOut);
	    
	    $result = CorefireAliPayResults::Init($response,$inputObj->GetKey());
	    // 		self::reportCostTime($url, $startTimeStamp, $result);//上报请求花费时间
	
	    return $result;
	}
	
	/**
	 * 
	 * 产生随机字符串，不长于32位
	 * @param int $length
	 * @return 产生的随机字符串
	 */
	public static function getNonceStr($length = 32) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  {  
			$str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		} 
		return $str;
	}
	
	/**
	 * 直接输出xml
	 * @param string $xml
	 */
	public static function replyNotify($xml)
	{
	    //file_put_contents('notify.txt', date("Y-m-d H:i:s")." $xml\r\n",FILE_APPEND);
		echo $xml;
	}
	
	/**
	 * 以post方式提交xml到对应的接口url
	 * 
	 * @param string $xml  需要post的xml数据
	 * @param string $url  url
	 * @param bool $useCert 是否需要证书，默认不需要
	 * @param int $second   url执行超时时间，默认30s
	 * @throws CorefireAliPayException
	 */
	public static function postXmlCurl($xml, $url,$second = 30)
	{		
		$ch = curl_init();
		//设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		
		//如果有配置代理这里就设置代理
		if(CorefireAliPayConfig::CURL_PROXY_HOST != "0.0.0.0"
			&& CorefireAliPayConfig::CURL_PROXY_PORT != 0){
			curl_setopt($ch,CURLOPT_PROXY, CorefireAliPayConfig::CURL_PROXY_HOST);
			curl_setopt($ch,CURLOPT_PROXYPORT, CorefireAliPayConfig::CURL_PROXY_PORT);
		}
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);//TRUE
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//2严格校验
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		//post提交方式
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			throw new CorefireAliPayException("curl出错，错误码:$error");
		}
	}
	
	/**
	 * 获取毫秒级别的时间戳
	 */
	private static function getMillisecond()
	{
		//获取毫秒的时间戳
		$time = explode ( " ", microtime () );
		$time = $time[1] . ($time[0] * 1000);
		$time2 = explode( ".", $time );
		$time = $time2[0];
		return $time;
	}
}

