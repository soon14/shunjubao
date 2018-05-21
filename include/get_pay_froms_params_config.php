<?php
/**
 * 接入应用 获取表单 “必传”要参数
 */
return array(
    'get_pay_forms_list'  => array(
				'partner'		=> 'YOKA支付系统分配的ID',
				'yoka_user_id'  => 'YOKA用户ID',
				'out_trade_no'	=> '接入方（tuan）唯一订单号',	
		        'user_ip'		=> '用户IP地址',
		    	'subject'       => '商品名称',
		    	'body'          => '商品描述信息',
		    	'total_fee'     => '该笔订单应付总额',
				'show_url'      => '商品的链接地址',
				'notify_url'	=> '支付成功后回调接入方的通知接口地址',
				'return_url'  	=> '支付成功后，自动跳转地址',
	),
);