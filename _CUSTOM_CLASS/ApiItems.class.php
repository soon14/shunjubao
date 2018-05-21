<?php
/**
 * api项目基础类
 * 所有输出接口描述
 * 所有错误信息描述
 */
class ApiItems {
	
	const API_ITEM_CASH 		= 1;
	const API_ITEM_SCORE 		= 2;
	const API_ITEM_MATCHINFO 	= 3;
	const API_ITEM_DASHANG_CASH = 4;
	const API_ITEM_DASHANG_SCORE = 5;
	const API_ITEM_ZHONGCHOU_CASH = 6;
	const API_ITEM_ZHONGCHOU_FH = 7;
	const API_ITEM_DALETOU = 8;
	const API_ITEM_BET_SCORE = 9;
	static public function getItemsDesc() {
		return array(
			self::API_ITEM_CASH => array(
				'desc' => '账户金额消费',
			),
			self::API_ITEM_SCORE => array(
				'desc' => '账户积分消费',
			),
			self::API_ITEM_MATCHINFO => array(
				'desc' => '获取赛事信息',
			),
			self::API_ITEM_DASHANG_CASH => array(
				'desc' => '打赏金额',
			),
			self::API_ITEM_DASHANG_SCORE => array(
				'desc' => '打赏积分',
			),
			self::API_ITEM_ZHONGCHOU_CASH => array(
				'desc' => '众筹扣款',
			),
			self::API_ITEM_ZHONGCHOU_FH => array(
				'desc' => '众筹分红',
			),self::API_ITEM_DALETOU => array(
				'desc' => '大乐透金额消费',
			),self::API_ITEM_BET_SCORE => array(
				'desc' => '投注赠送积分',
			)
		);
	}
	
	CONST ERROR_CODE_OTHER 		= 9000;
	CONST ERROR_CODE_PARAMS 	= 9001;
	CONST ERROR_CODE_TOKEN 		= 9002;
	CONST ERROR_CODE_UID 		= 9003;
	CONST ERROR_CODE_CASH_BZ 	= 9004;
	
	static public function getErrorDesc() {
		return array(
			self::ERROR_CODE_OTHER => array(
				'desc' => '其他错误',
			),
			self::ERROR_CODE_PARAMS => array(
				'desc' => '参数错误',
			),
			self::ERROR_CODE_TOKEN => array(
				'desc' => '验证错误',
			),
			self::ERROR_CODE_UID => array(
				'desc' => 'uid错误',
			),
			self::ERROR_CODE_CASH_BZ => array(
				'desc' => '余额不足',
			),
		);
	}
}