<?php
/*
 * 返回二维数组
 * 第一维数组键名是支付平台自定的银行类型参数值
 * 第二维数组键名是支付商名称，其中desc是对该银行的描述
 * 第二维数组值名是传给支付商的银行类型参数值
 */
return array(
	'BOCB2C' => array (
		'tenpay'    =>1052,
		'alipay'    => 'BOCB2C',
		'pay99bill' => 'BOC',
		'gopay'		=> 'BOC',
		'desc'     => '中国银行',
	),
	'ICBCB2C' => array (
		'tenpay'    =>1002,
		'alipay'    => 'ICBCB2C',
		'pay99bill' => 'ICBC',
		'gopay'		=> 'ICBC',
		'desc'     => '中国工商银行',
	),
	'CMB' => array (
		'tenpay'    =>1038,
		'alipay'    => 'CMB',
		'pay99bill' => 'CMB',
		'gopay'		=> 'CMB',
		'desc'     => '招商银行',
	),
	'CCB' => array (
		'tenpay'    =>1003,
		'alipay'    => 'CCB',
		'pay99bill' => 'CCB',
		'gopay'		=> 'CCB',
		'desc'     => '中国建设银行',
	),
	'ABC' => array (
		'tenpay'    =>1005,
		'alipay'    => 'ABC',
		'pay99bill' => 'ABC',
		'gopay'		=> 'ABC',
		'desc'     => '中国农业银行',
	),
	'SPDB' => array(
		'tenpay'    =>1004,
		'alipay'    => 'SPDB',
		'pay99bill' => 'SPDB',
		'gopay'		=> 'SPDB',
		'desc'     => '上海浦东发展银行',
	),
	'CIB' => array (
		'tenpay'    =>1009,
		'alipay'    => 'CIB',
		'pay99bill' => 'CIB',
		'gopay'		=> 'CIB',
		'desc'     => '兴业银行',
	),
	'GDB' => array (
		'tenpay'    =>1027,
		'alipay'    => 'GDB',
		'pay99bill' => 'GDB',
		'gopay'		=> 'GDB',
		'desc'     => '广东发展银行',
	),
	'SDB' => array (
		'tenpay'    =>1008,
		'alipay'    => 'SDB',
		'pay99bill' => 'SDB',
		'gopay'		=> 'SDB',
		'desc'     => '深圳发展银行',
	),
	'CMBC' => array (
		'tenpay'    =>1006,
		'alipay'    => 'CMBC',
		'pay99bill' => 'CMBC',
		'gopay'		=> 'CMBC',
		'desc'     => '中国民生银行',
	),
	'COMM' => array (
		'tenpay'    =>1020,
		'alipay'    => 'COMM',
		'pay99bill' => 'BCOM',
		'gopay'		=> 'BCOM',
		'desc'     => '交通银行',
	),
	'CITIC' => array (
		'tenpay'    =>1021,
		'alipay'    => 'CITIC',
		'pay99bill' => 'CITIC',
		'gopay'		=> 'CITIC',
		'desc'     => '中信银行',
	),
	'CEBBANK' => array (
		'tenpay'    =>1022,
		'alipay'    => 'CEBBANK',
		'pay99bill' => 'CEB',
		'gopay'		=> 'CEB',
		'desc'     => '光大银行',
	),
	'NBBANK' => array(
		'tenpay'    =>1056,
		'alipay'    => 'NBBANK',
		'pay99bill' => 'NBCB',
		'desc'     => '宁波银行',
	),
	'SPABANK' => array(
		'tenpay'    =>1010,
		'alipay'    => 'SPABANK',
		'pay99bill' => 'PAB',
		'desc'     => '平安银行',
	),
	'BJBANK' => array (
		'tenpay'    =>1032,
		'alipay'    => 'BJBANK',
		'pay99bill' => 'BOB',
		'desc'     => '北京银行',
	),
	'NJBANK' => array (
		'tenpay'    =>1054,
		'alipay'    => 'NJBANK',
		'pay99bill' => 'NJCB',
		'desc'     => '南京银行',
	),
	'PSBC-DEBIT' => array (
		'alipay'    => 'PSBC-DEBIT',// 其实支付宝不支持这家
		'desc'     => '中国邮政储蓄',
	),
     'DEFAULT' => array(
	    'pay99bill' => 'DEFAULT',
        'desc'     => '快钱信用卡',
	),
);
