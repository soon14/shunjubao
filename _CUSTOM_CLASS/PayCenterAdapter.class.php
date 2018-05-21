<?php
/**
 * 支付中心适配器
 * @author gaoxiaogang@gmail.com
 *
 */
class PayCenterAdapter {

	/**
	 * 支付提供商对象
	 * @var PayCenterInterface
	 */
	private $objPayCenter;

	/**
	 * 支付提供商
	 * @var string
	 */
	private $provider;

	/**
	 * @$this->objPayCenter 支付供应商对象
	 * @param string $provider 支付提供商
	 */
	public function __construct($provider) {
		//支付提供商列文件
        $configs = include(ROOT_PATH . '/include/payCenter_config.php');
        //支付提供商配置文件
        $payCenterConfig = include(ROOT_PATH . '/include/provider_config.php');

		if (empty($payCenterConfig[$provider])) {
			throw new ParamsException("无效的支付提供商：{$provider}");
		}

		$this->provider = $provider;

		//支付提供商对象
		$class_name = $configs[$provider]['class_name'];
		if (empty($class_name)) {
			throw new ParamsException("无效的支付提供商对象：{$provider}");
		}

		$this->objPayCenter = new $class_name($payCenterConfig[$provider]);

	}

	/**
     * 获取支付表单数组信息
     * 这些信息返回给调用方，供生成提交表单
     * 程序流程：
     * 1.验证APP传递参数是否合法
     * 2.拼接订单（本平台订单号）
     * 3.初始化订单（插入或者*更新在一定状态下的订单，统称初始化）
     * 4.记录操作行为日志-获取平台流水号
     * 5.转换参数  譬如  回调URL 后台URL 编码默认值等
     * 6.调用相应第三方支付平台的获取表单方法
     * 7.返回错误信息|或者结果
     * @param array $params
     * @return InternalResultTransfer 失败：返回String型错误描述；成功：返回数组，格式：array(
     *     'action'    => (string)//作为html form元素的action属性值
     *     'params'      => (array)//处理后的支付有关的参数集
     * );
     */
    public function getPayFormArray(array $params) {
    	# 先抛开是否需要另开一个 PayParams 类的争论，checkBasicGetPayFormsParms方法的逻辑，肯定只应该属于 getPayFormArray 方法的领域范围内
    	# by gxg

		if (!isset($params['_input_charset'])) {
			$params['_input_charset'] = 'UTF-8';
		}

        //处理银行类型
        # 先处理 bank_type，再调用changeParamsForGetPayFormAction。否则的话，bank_type这个参数名很可能被changeParamsForGetPayFormAction改变
        if (isset($params['bank_type'])) {
            $bank_type = $this->changeBankTypeParam($params['bank_type']);
            //如果得到值$bank_type
            if ($bank_type) {
                $params['bank_type'] = $bank_type;
            } else {
            	# 不支持的银行类型，删除
            	unset($params['bank_type']);
            }
        }

		$changedParams = $this->changeParamsForGetPayFormAction($params);

		# 定义统一的 通知 和 回调 url
//		$changedParams['notify_url'] = ROOT_DOMAIN . "/provider/notify/{$this->provider}";
//		$changedParams['return_url'] = ROOT_DOMAIN . "/provider/return/{$this->provider}";

        return $this->objPayCenter->getPayFormArray($changedParams);
	}

	/**
	 * 转换参数。该方法供 getPayFormArray方法调用
	 * @param array $params
	 * @return array
	 */
	private function changeParamsForGetPayFormAction(array $params) {
		$provider_paycenter_key_indexes = include(ROOT_PATH . '/include/provider_paycenter_key_index.php');
		if (!isset($provider_paycenter_key_indexes[$this->provider])) {
			return $params;
		}
		$provider_paycenter_key_index = $provider_paycenter_key_indexes[$this->provider];

        foreach ($provider_paycenter_key_index as $provider_key => $paycenter_key) {
            if ($provider_key == $paycenter_key) {
                continue;
            }

            if (isset($params[$paycenter_key])) {
                $params[$provider_key] = $params[$paycenter_key];
                unset($params[$paycenter_key]);
            }
        }

        # 删除支付提供商不支持的参数
        foreach ($params as $tmpK => $tmpV) {
            if (!array_key_exists($tmpK, $provider_paycenter_key_index)) {
                unset($params[$tmpK]);
            }
        }

        return $params;
	}
	/**
	 * 转换银行类型参数。该方法供 getPayFormArray方法调用
	 * 由支付平台统一银行类型转为每个支付商独立的银行类型
	 * @param string $bankType
	 * @return string
	 */
	private function changeBankTypeParam($bankType) {
		$bank_type_param = include(ROOT_PATH . '/include/get_bank_type_param.php');
		if (!isset($bank_type_param[$bankType]) || !isset($bank_type_param[$bankType][$this->provider])) {
			return false;
		}
		return $bank_type_param[$bankType][$this->provider];
	}
	/**
	 * 转换支持商交易状态到支付平台的订单状态
	 * @param string $provider_trade_status
	 */
	public function changeProviderTradeStatusToPayCenter($provider_trade_status) {
		# 稍后把这个丢到配置文件里面去
		$configs = array(
			'twjalipay'  => array(
		        # 左边key是支付商的交易状态；右边值是支付平台的订单状态
		        'TRADE_SUCCESS'   => PayOrder::TRADE_SUCCESS,
		        'TRADE_FINISHED'  => PayOrder::TRADE_SUCCESS,
		    ),
		    'alipay'  => array(
		        # 左边key是支付商的交易状态；右边值是支付平台的订单状态
		        'TRADE_SUCCESS'   => PayOrder::TRADE_SUCCESS,
		        'TRADE_FINISHED'  => PayOrder::TRADE_SUCCESS,
		    ),
		    'tenpay'  => array(
		        TenPayCenter::TRADE_SUCCESS   => PayOrder::TRADE_SUCCESS,
		    ),
		    'cmpay'	  => array(
		    	'SUCCESS' => PayOrder::TRADE_SUCCESS,
		    ),
		    'pay99bill' => array(
		    	'10' => PayOrder::TRADE_SUCCESS,
		    ),
		    'lakala'	=> array(
		    	'SUCCESS' => PayOrder::TRADE_SUCCESS,
		    ),
		    'gopay'		=> array(
		    	'SUCCESS' => PayOrder::TRADE_SUCCESS,
		    ),
		);
		$config = $configs[$this->provider];
		if (isset($config[$provider_trade_status])) {
			return $config[$provider_trade_status];
		} else {
			return false;
		}
	}

	public function resupplyOrder() {

	}

	/**
	 * 异步通知
	 * @param array $request_params 请求参数
	 * @return InternalResultTransfer array 成功时的返回格式 array(
	 *     'order_id',//支付平台内部订单号,通过它可以查看这笔订单在支付平台存储的更详细信息
	 *     'total_fee',//金额应使用本次请求的值，而不是数据库里记录的
	 *     'trade_status',//状态应使用本次请求的值，并且是转换为对应的支付平台状态后的值
	 * );
	 */
	public function notify(array $request_params) {
		# 1、调用后端的支付商类验证本次通知请求的有效性
	    $tmpResult = $this->objPayCenter->verify_notify($request_params);
		if (!$tmpResult->isSuccess()) {
			# 验证失败的处理
			return InternalResultTransfer::fail("verify_notify失败。provider：{$this->provider}；支付类verify_notify返回的信息：{$tmpResult->getData()}");
		}

		$result = $tmpResult->getData();
		$provider_trade_status = $result['trade_status'];
		$inner_out_trade_no = $result['inner_out_trade_no'];
		$total_fee = $result['total_fee'];

		$payCenterOrderStatus = $this->changeProviderTradeStatusToPayCenter($provider_trade_status);
		if (!$payCenterOrderStatus) {
			# 转换状态失败的处理
			return InternalResultTransfer::fail('changeProviderTradeStatusToPayCenter 转换状态失败');
		}

		$objPayOrderFront = new PayOrderFront();
		$orderInfo = $objPayOrderFront->getOneOrder($inner_out_trade_no);
		if (!$orderInfo) {
			# 没有查到订单的处理
			return InternalResultTransfer::fail("getOneOrder 没有查到订单 {$inner_out_trade_no}");
		}

		# 2、验证通过，修改相关的订单业务逻辑
		$tmpResult = $objPayOrderFront->updateStatus($inner_out_trade_no, $payCenterOrderStatus, $this->provider, $total_fee);
		if (!$tmpResult) {
			# 更新状态失败的处理
			return InternalResultTransfer::fail("updateStatus 更新失败：'inner_out_trade_no':{$inner_out_trade_no}, 'payCenterOrderStatus':{$payCenterOrderStatus}, 'provider':{$this->provider}");
		}

	    if ($tmpResult === true) {
            # 没有更改到任何记录
            return InternalResultTransfer::fail('NOT_AFFECTED_ROWS');
        }

		# 4、调用后端的支付商类通知本次请求ok
		$this->objPayCenter->response_notify_success();

		# 5、返回一个数组，供调用php页面去通知第三方app的异步逻辑
		/**
		 * array(
		 *     '支付平台内部订单号',//通过它可以查看这笔订单在支付平台存储的更详细信息
		 *     '金额',//金额应使用本次请求的值，而不是数据库里记录的
		 *     '状态',//状态应使用本次请求的值，并且将其转换为对应的支付平台的状态
		 * )
		 */
		return InternalResultTransfer::success(array(
		    'order_id'        => $orderInfo['id'],
		    'total_fee'       => $total_fee,
		    'trade_status'   => $payCenterOrderStatus,
		));
	}

	/**
	 * 通知第3方app合作方交易成功
	 * @param array $params 要求的格式：array(
	 *     'order_id'  => (int),//支付平台的订单id
	 *     'trade_status' => (int),//支付平台的交易状态
	 * )
	 *
	 * 这个方法会通知第三方app，通知的参数如下：
	 * array(
     *       'total_fee'     => (float),//交易金额（必填）。该笔订单的资金总额，单位为RMB-Yuan。取值范围为[0.01，100000000.00]，精确到小数点后两位。
     *       'trade_status'  => (),//本次交易状态
     *       'out_trade_no'  => (string),//第三方app调用支付平台时传递过来的订单号
     *       'partner'       => (string),//第三方app的商户号
     *       'subject'       => (string),
     *       'body'          => (string),
     *       'provider'      => (string),//本次支付所使用的支付商，如 alipay
     *       'trade_no'      => (int),//支付中心的订单号
     *       'yoka_user_id'  => (int),//YOKA用户id
     *       'extra_common_param'    => (string | null),//公用回传参数
     * );
	 *
	 * @return InternalResultTransfer
	 */
	static public function notify_partner(array $params) {
		# TODO 通知第3方app
		$order_id = $params['order_id'];
		$trade_success = $params['trade_status'];

		$objPayOrderFront = new PayOrderFront();
        $orderInfo = $objPayOrderFront->get($order_id);
        if (!$orderInfo) {
        	# TODO 获取订单失败的处理
        	return InternalResultTransfer::fail('获取订单失败');
        }

        $gate_way = $orderInfo['notify_url'];
        if (empty($gate_way)) {
        	return InternalResultTransfer::success('没有指定notify_url，故无需通知');
        }

        # 获取商户的安全key
        $partner = $orderInfo['partner'];
        $objPartnerConfig = new PartnerConfig($partner);
        $securitCode = $objPartnerConfig->getSecuritCode();

	    $objPayOrder = new PayOrder();
		$tradeStatusDesc = $objPayOrder->getStatusDesc($trade_success);
		if ($tradeStatusDesc === false) {
		    return InternalResultTransfer::fail('状态值转换成状态描述时出错');
		}

        $tmpInfo = array(
            'total_fee'     => $orderInfo['total_fee']/100,//金额由支付中心的　分　转化成　元
            'trade_status'  => $tradeStatusDesc,
            'out_trade_no'  => $orderInfo['out_trade_no'],//第三方app调用支付平台时传递过来的订单号
            'partner'       => $partner,
            'subject'       => $orderInfo['subject'],
            'body'          => $orderInfo['body'],
            'provider'      => $orderInfo['provider'],
            'trade_no'      => $order_id,//支付中心的订单号
            'yoka_user_id'  => $orderInfo['yoka_user_id'],//YOKA用户id
            'extra_common_param'    => $orderInfo['extra_common_param'],//公用回传参数
        );

        $objYokaServiceUtility = new YokaServiceUtility();
        $objYokaServiceUtility->secret = $securitCode;
        $tmpInfo['sign'] = $objYokaServiceUtility->createSign($tmpInfo);

        $objCurl = new Curl($gate_way);
        $result = $objCurl->post($tmpInfo);
        if ($result === 'success') {//明确收到处理成功的通知
        	return InternalResultTransfer::success();
        }

        return InternalResultTransfer::fail($result);
	}

	/**
	 * 支付成功后的同步通知
	 * @param array $request_params 请求参数
	 * @return InternalResultTransfer 成功时的数据返回格式 array(
     *     'order_id',//支付平台内部订单号,通过它可以查看这笔订单在支付平台存储的更详细信息
     *     'total_fee',//金额应使用本次请求的值，而不是数据库里记录的
     *     'trade_status',//状态应使用本次请求的值，并且是转换为对应的支付平台状态后的值
     * );
     */
	public function redirect(array $request_params){
        # 1、调用后端的支付商类验证本次通知请求的有效性
        $tmpResult = $this->objPayCenter->verify_notify($request_params);
        if (!$tmpResult->isSuccess()) {
            # 验证失败的处理
            return InternalResultTransfer::fail("verify_notify失败。provider：{$this->provider}；支付类verify_notify返回的信息：{$tmpResult->getData()}");
        }

        $result = $tmpResult->getData();
        $provider_trade_status = $result['trade_status'];
        $inner_out_trade_no = $result['inner_out_trade_no'];
        $total_fee = $result['total_fee'];

        $payCenterOrderStatus = $this->changeProviderTradeStatusToPayCenter($provider_trade_status);
        if (!$payCenterOrderStatus) {
        	return InternalResultTransfer::fail('支持方交易状态转换为支付中心订单状态失败');
        }

	    $objPayOrderFront = new PayOrderFront();
        $orderInfo = $objPayOrderFront->getOneOrder($inner_out_trade_no);
        if (!$orderInfo) {
            return InternalResultTransfer::fail('没有查找到支付平台订单');
        }

        # 2、返回一个数组，供调用php页面去通知第三方app的异步逻辑
        /**
         * array(
         *     '支付平台内部订单号',//通过它可以查看这笔订单在支付平台存储的更详细信息
         *     '金额',//金额应使用本次请求的值，而不是数据库里记录的
         *     '状态',//状态应使用本次请求的值，并且将其转换为对应的支付平台的状态
         * )
         */
        return InternalResultTransfer::success(array(
            'order_id'        => $orderInfo['id'],
            'total_fee'       => $total_fee,
            'trade_status'   => $payCenterOrderStatus,
        ));
	}

	/**
	 * 类方法：关闭订单
	 * @param array $params
	 * @return InternalResultTransfer
	 */
	static public function closeTrade(array $params) {
		#TODO有时间再重写
		return InternalResultTransfer::success();
//		$configs = include(ROOT_PATH . '/include/provider_config.php');
//		$providers = array_keys($configs);
//
//		$inner_out_trade_no = $params['inner_out_trade_no'];
//		$objPayOrderFront = new PayOrderFront();
//		$orderInfo = $objPayOrderFront->getOneOrder($inner_out_trade_no);
//		if (!$orderInfo) {
//			return InternalResultTransfer::fail('不存在的定单，无需关闭');
//		}
//
//		if ($orderInfo['trade_status'] != PayOrder::WAIT_BUYER_PAY) {
//            return InternalResultTransfer::fail('只允许关闭未付款状态定单');
//        }
//
//        # 是否所有支付商都把订单关闭了。
//        # ps：如果支付商返回 TRADE_NOT_EXIST ，则认为是成功关闭。不存在的订单，可以认为是关闭了。
//        $isAllClosed = true;
//
//		$tmpParams = $params;
//		foreach ($providers as $provider) {
//			$tmpObjPayCenterAdapter = new self($provider);
//			$tmpResult = $tmpObjPayCenterAdapter->objPayCenter->closeTrade($tmpParams);
//			if (!$tmpResult->isSuccess() && $tmpResult->getData() != 'TRADE_NOT_EXIST') {
//				$isAllClosed = false;
//			}
//		}
//		if ($isAllClosed) {
//			$objPayOrderFront = new PayOrderFront();
//			$objPayOrderFront->updateStatus($inner_out_trade_no, PayOrder::TRADE_CLOSED);
//			return InternalResultTransfer::success();
//		} else {
//			return InternalResultTransfer::fail();
//		}
	}
}