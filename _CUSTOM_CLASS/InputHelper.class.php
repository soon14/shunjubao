<?php
/**
 *
 * 输入辅助类
 * @author gxg
 *
 */
class InputHelper {

	/**
	 *
	 * 获取 $input 指定日期的开始时间戳
	 * @param string $input
	 * @return false | int
	 */
	static public function getStartTS($input) {
		$input = trim($input);
		if (empty($input)) {
			return false;
		}
		return strtotime($input.' 00:00:00');
	}

	/**
	 *
	 * 获取 $input 指定日期的结束时间戳
	 * @param string $input
	 * @return false | int
	 */
	static public function getEndTS($input) {
		$input = trim($input);
		if (empty($input)) {
			return false;
		}
		return strtotime($input.' 23:59:59');
	}
	
	/**
	 * 删除数组中空值项
	 * @param array $arr
	 * @return array
	 */
	static public function filterEmptyValue(array $arr) {
		if (!is_array($arr)) {
			return $arr;
		}
		
		return array_filter($arr, create_function('$tmpVal', 'return trim($tmpVal);'));
	}

	/**
	 * 过滤数组中的空值，并对非空值做trim处理
	 * #支持对多维数组的处理
	 * @param array $input
	 * @param array
	 */
	static public function arrayfilter(array $input) {
		if (!is_array($input)) {
			return $input;
		}
		
		$result = array();
		foreach ($input as $key => $value) {
			if (is_scalar($value)) {
				$tmp_value = trim($value);
				if (empty($tmp_value)) {
					continue;
				}
				$result[$key] = trim($value);
			} else if(is_array($value)){
				if (empty($value)) {
					continue;
				}
				
				$tmp_arr = self::arrayfilter($value);
				if (empty($tmp_arr)) {
					continue;
				}
				
				$result[$key] = $tmp_arr;
			} else {
				$result[$key] = $value;
			}
			
		}
		
		return $result;
	}
}