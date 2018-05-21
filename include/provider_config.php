<?php
/**
 * 支付提供商配置文件
 */
return  array(
    'twjalipay' => array(
		//请求url
        'action' => 'https://www.alipay.com/cooperate/gateway.do',
        //安全校验码
//        'security_code'  => '6bi75xp5qbvcwe0ru8gk2m5jwm6mkn75',//34o0c4ydqw9crrf1au2rn3gjun92pa7j
        'security_code'  => '8gb1okdygaboj697ny59ksnvw6k30ptz',
        //身份ID
//        'partner'  => '2088601996061934',//zy:2088311949386932
        'partner'  => '2088721145231161',//
//		'seller_email'	=> 'hr@gaojie100.com',//zhiwin365@126.com
		'seller_email'	=> 'tianwuju@126.com',
    ),
	  'alipay' => array(
		//请求url
        'action' => 'https://www.alipay.com/cooperate/gateway.do',
        //安全校验码
//        'security_code'  => '6bi75xp5qbvcwe0ru8gk2m5jwm6mkn75',//34o0c4ydqw9crrf1au2rn3gjun92pa7j
        'security_code'  => '34o0c4ydqw9crrf1au2rn3gjun92pa7j',
        //身份ID
//        'partner'  => '2088601996061934',//zy:2088311949386932
        'partner'  => '2088311949386932',//
//		'seller_email'	=> 'hr@gaojie100.com',//zhiwin365@126.com
		'seller_email'	=> 'zhiwin365@126.com',
    ),
    'tenpay'    => array(
        'partner'       => '1211656201',
        'security_code' => '779d38d6913402f616e7a698f8f6d5ea',
    ),
    #快钱支付
	'pay99bill'  => array(
        'action' => 'https://www.99bill.com/gateway/recvMerchantInfoAction.htm',#请求url
        'merchantAcctId' => '1002151247101',#人民币账号
        'security_code' => '9T3LETGI2W8CYYRE',#安全校验码
    ),
    'lakala'	=> array(
    	'action'		=> 'http://www.paygate.cn/MerchantPlugin3/BillNoGenServlet', # 收银台地址
    	'fixed_bill'	=> '312976', # 固定账单号
    	'mer_id'		=> '3G050000801', # 商户号
    	'partnerPwd'	=> 'GRE567OKYTREW349IJKMMNH', # 商户密码
    ),
    # 国付宝支付
    'gopay'		=> array(
    	'action'	=> 'https://www.gopay.com.cn/PGServer/Trans/WebClientAction.do',
    	'merchantID'	=> '0000045627', // 签约国付宝商户唯一用户ID（商户代码）
    	'virCardNoIn'	=> '0000000002000113681', # 账户
    	'VerficationCode'	=> 'E56D058A8CB06589C2', #商户的身份识别码
    ),
    #手机支付
    'cmpay' => array(
		'type' => 'DODIRECTPAYMENT',//交易类型 直接支付
        'signType' => 'MD5',
        'version' => '1.0.1',//版本号 version
        'allowNote' => '0', //是否允许用户对该笔订单进行评论  0 表示允许,默认1 表示不允许
        'authorizeMode' => 'WEB',//推荐用户进 行确认的方式
        'banks' => '',//银行代码  多个银行代码之间用分号分割。不填 写表示所有银行支付都支持,这个字段的值和下面的币种有关联。
		'notifyMobile'   => '13800000000',//订单成功或者发生退款,系统通知该手机
    	'notifyEmail'   =>'shopadmin@yoka.com',//订单成功或者发生退款,系统通知该 email
    	'deliverFlag' => '0',//是否需要在支付平台输入送货信息。0 不需要手机支付平台帮忙获取地址 1 表示需要
    	'invoiceFlag'	=> '0',//是否需要开发票,发票的抬头是否在 支付平台录入。0 表示不需要 1 表示需要默认:0
    	'pageStyle' => '',//页面风格
    	'period' => '2',//有效期数
    	'periodUnit' =>'2',//有效期单位  分钟,小时,天1 – 月; 2 – 日;3-小时;4-分钟
		/*
    	CNY:可提现金额进行支付;用户只
    	能选择可体现账户里的钱和银行账户里的钱进行支付。
		CMY:用不可提现金额支付,用户可以选择不可体现账户里面的钱+充值
		*/
    	'currency' => 'CNY',//币种
    	'signKey'=>"5BDY1njcOl6YkSHV1J0FxhM32kUACJwlIpotpyQpAoZ0cH0u4anbGwJtSAuvK45L",//安全校验码
		'merchantId'=>"888009953110400",//商户编号..
		'commUrl'=>"https://ipos.10086.cn/ips/APITrans",
		'tokenReqUrl'=>"http://ipos.10086.cn/ips/APITrans2",
		'tokenRedirectUrl'=>"https://ipos.10086.cn/ips/FormTrans3",
    	'mobile'=>"15866600099",
    ),
);
