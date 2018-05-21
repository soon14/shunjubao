<?php
	/**
	 * 支付提供商列表
	 * @var array
	 */
	return  array(
		'twjalipay'   => array(
	        'class_name'   => 'TwjAliPayCenter',
	        'desc'         => '支付宝',
	    ),
	    'alipay'   => array(
	        'class_name'   => 'AliPayCenter',
	        'desc'         => '支付宝',
	    ),
	    'tenpay'   => array(
	        'class_name'   => 'TenPayCenter',
	        'desc'         => '财付通',
	    ),
	    'cmpay'   => array(
	        'class_name'   => 'CmPayCenter',
	        'desc'         => '手机支付',
	    ),
	    'pay99bill' => array(
	        'class_name'   => 'Pay99billCenter',
            'desc'         => '快钱支付',
	    ),
	    'lakala'	=> array(
	    	'class_name'	=> 'LakalaPayCenter',
	    	'desc'			=> '拉卡拉支付',
	    ),
	    'gopay'		=> array(
	    	'class_name'	=> 'GoPayCenter',
	    	'desc'			=> '国付宝支付',
	    ),
	);
?>