<?php
/**
 * 支付提供商与支付中心 提交支付请求接口的 key对应关系
 */
return array(
    'tenpay'    => array(// 左边key是财富通支持的参数；右边值是对应的支付平台的参数
        'sign_type'     	=> 'sign_type',
        'input_charset' 	=> '_input_charset',
	    'sign'          	=> 'sign',
	    'bank_type'     	=> 'bank_type',
	    'body'          	=> 'subject',
	    'attach'        	=> 'extra_common_param',
	    'out_trade_no'  	=> 'inner_out_trade_no',
	    'total_fee'     	=> 'total_fee',
	    'spbill_create_ip'  => 'user_ip',
    ),
    'twjalipay' => array(// 左边key是支付宝支持的参数；右边值是对应的支付平台的参数
        '_input_charset'  	=> '_input_charset',//'编码集',
		'out_trade_no'  	=> 'inner_out_trade_no',//'唯一订单号',
		'subject'  			=> 'subject',//'商品名称',
		'body'  			=> 'body',//'商品描述信息',
		'total_fee'  		=> 'total_fee',//该笔订单应付总额',
		'show_url'  		=> 'show_url',
        'defaultbank'       => 'bank_type',
		#'seller_email'  	=> '支付宝账户',
		#'payment_type'  	=> '支付类型',
		#'service'  		=> '接口名称',
		#'partner'  		=> '支付宝身份ID',
		'notify_url'  		=> 'notify_url',
		'return_url'  		=> 'return_url',
		'token'				=> 'token',// 用于快捷登录
    ),
    'alipay' => array(// 左边key是支付宝支持的参数；右边值是对应的支付平台的参数
        '_input_charset'  	=> '_input_charset',//'编码集',
		'out_trade_no'  	=> 'inner_out_trade_no',//'唯一订单号',
		'subject'  			=> 'subject',//'商品名称',
		'body'  			=> 'body',//'商品描述信息',
		'total_fee'  		=> 'total_fee',//该笔订单应付总额',
		'show_url'  		=> 'show_url',
        'defaultbank'       => 'bank_type',
		#'seller_email'  	=> '支付宝账户',
		#'payment_type'  	=> '支付类型',
		#'service'  		=> '接口名称',
		#'partner'  		=> '支付宝身份ID',
		'notify_url'  		=> 'notify_url',
		'return_url'  		=> 'return_url',
		'token'				=> 'token',// 用于快捷登录
    ),
	'pay99bill' => array (// 左边key是快钱支持的参数；右边值是对应的支付平台的参数
		'orderId' 		=> 'inner_out_trade_no',//唯一订单号
		'productName' 	=> 'subject',//商品名称
		'productDesc' 	=> 'body',//商品描述信息
		'orderAmount' 	=> 'total_fee',//该笔订单应付总额
		'bankId' 		=> 'bank_type',
    ),
    'lakala'	=> array(
    	'out_trade_no'	=> 'inner_out_trade_no',
    	'amount' 		=> 'total_fee',
    	'PRODUCTNAME'	=> 'subject',
    	'DESC'			=> 'body',
    ),
    'gopay'	=> array(
    	'merOrderNum'	=> 'inner_out_trade_no',
    	'tranAmt'		=> 'total_fee',
    	'tranIP'		=> 'user_ip',
    	'goodsName'		=> 'subject',
    	'goodsDetail'	=> 'body',
    	'bankCode'		=> 'bank_type',
    ),
);