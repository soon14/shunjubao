<?php
/**
 * 财付通支付
 * @author gaoxiaogang@gmail.com
 *
 */
class TenPayCenter implements PayCenterInterface {
	private $partner;

	private $key;

	/**
	 * 交易状态：成功
	 * @var string
	 */
	const TRADE_SUCCESS = 'TRADE_SUCCESS';

    public function __construct(array $config) {
    	# TODO 可以对$config的参数做下校验

    	$this->partner = $config['partner'];
    	$this->key = $config['security_code'];
    }

	public function getPayFormArray(array $params) {
		$gate_way = 'https://gw.tenpay.com/gateway/pay.htm';

        $tmpDefault = array(
            'partner'   => $this->partner,
            'fee_type'  => '1',
            'service_version'   => '1.0',
            'sign_key_index'    => '1',
        );
        # 优先保留$tmpDefault里的值：$tmpDefault里存在的key,不会被$params覆盖
        $params = $tmpDefault + $params;

        if (!isset($params['bank_type'])) {
        	$params['bank_type'] = 'DEFAULT';
        }

        $charset = isset($params['input_charset']) ? $params['input_charset'] : 'utf-8';

	    # 对body字段超长的处理。
        if (isset($params['body']) && mb_strlen($params['body']) > 127) {
            $params['body'] = mb_substr($params['body'], 0, 127, $charset);
        }

		$params['sign'] = $this->createSign($params);

		return InternalResultTransfer::success(array(
		    'action'  => $gate_way,
		    'params'  => $params,
		));
	}

	/**
	 * 关闭交易
	 * 财付通不支持关闭交易接口。原由：据说是纯平台，无用户支持入口，故不需提供关闭交易接口
	 * @param array $params
	 * @return InternalResultTransfer::fail('TRADE_NOT_EXIST')
	 */
	public function closeTrade(array $params) {
		return InternalResultTransfer::fail('TRADE_NOT_EXIST');
	}

	/**
	 * 验证通知的有效性
	 * @param array $request_params 请求的参数
	 * @return InternalResultTransfer 失败：返回数据是String型描述；成功：格式为 array(
	 *     'total_fee' => (int),//交易金额，单位分
	 *     'inner_out_trade_no'  => (string),//平台传给财付通的交易号
	 *     'trade_status' => (string),//本次通知的交易状态
	 * );
	 */
	public function verify_notify(array $request_params) {
		if (!$this->verifySign($request_params)) {
			return InternalResultTransfer::fail("财付通verifySign失败");
		}

		$notify_id = $request_params['notify_id'];

		$gate_way = 'https://gw.tenpay.com/gateway/verifynotifyid.xml';

		$params = array(
		    'sign_type'   		=> 'MD5',
		    'service_version' 	=> '1.0',
		    'input_charset'   	=> 'UTF-8',
		    'sign_key_index'  	=> '1',
		    'partner'         	=> $this->partner,
		    'notify_id'       	=> $notify_id,
		);
		$params['sign'] = $this->createSign($params);
		$objCurl = new Curl($gate_way);
		$result = $objCurl->post($params);
		if (empty($result)) {
			return InternalResultTransfer::fail("Curl->post请求失败。gate_way：{$gate_way}；params：" . var_export($params, true));
		}

		$tmpResult = xmlToArray($result);
		if (!$this->verifySign($tmpResult)) {
			return InternalResultTransfer::fail("对Curl->post返回的数据做this->verifySign校验时失败。返回的数据是：" . var_export($tmpResult, true));
		}

		# retcode：返回状态码，0表示成功，其他未定义
		if ($tmpResult['retcode'] != '0') {
			return InternalResultTransfer::fail("retcode返回状态码不等于0。返回的数据是：" . var_export($tmpResult, true));
		}

	    # trade_state：支付结果状态码，0表示成功，其他为失败
        if ($tmpResult['trade_state'] != '0') {
        	return InternalResultTransfer::fail("trade_state支付结果状态码不等于0。返回的数据是：" . var_export($tmpResult, true));
        }

        return InternalResultTransfer::success(array(
            'total_fee'     => $tmpResult['total_fee'],
            'inner_out_trade_no'  => $tmpResult['out_trade_no'],
            'trade_status' => self::TRADE_SUCCESS,
        ));
	}

	public function response_notify_success() {
		echo 'success';
	}

	/**
	 * 校验请求的合法性
	 * @param array $request_params
	 * @return Boolean
	 */
	public function verifySign(array $request_params) {
	    $tenpay_sign = strtolower($request_params['sign']);
        $sign = $this->createSign($request_params);
        if ($tenpay_sign != $sign) {
            return false;
        }
        return true;
	}

	/**
	 * 生成请求参数的sign
	 * @param array $params
	 * @return String
	 */
	public function createSign(array $params) {
		$signPars = "";
        ksort($params);
        foreach($params as $k => $v) {
            if("" != $v && "sign" != $k) {
                $signPars .= $k . "=" . $v . "&";
            }
        }
        $signPars .= "key=" . $this->key;
        $sign = strtolower(md5($signPars));
        return $sign;
	}

}