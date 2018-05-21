<?php
/**
 *
 * 数据过滤处理类
 * @author gaoxiaogang@gmail.com
 *
 */
class Filter {
	/**
	 *
	 * 过滤方法：htmlspecialchars
	 * @var string
	 */
	const HTMLSPECIALCHARS = 'htmlspecialchars';

	/**
	 *
	 * 过滤方法：strip_tags
	 * @var string
	 */
	const STRIP_TAGS = 'strip_tags';

	const STRIP_SELECTED_TAGS = 'strip_selected_tags';

	const STRIP_SCRIPT = 'strip_script';

	const TRIM = 'trim';

	static private $filters = array(
		self::HTMLSPECIALCHARS,
		self::STRIP_TAGS,
		self::STRIP_SELECTED_TAGS,
		self::STRIP_SCRIPT,
		self::TRIM,
	);

	/**
	 *
	 * 是否有效的过滤方法
	 * @param string $handle
	 * @return boolean
	 */
	static public function isValid($filter) {
		return in_array($filter, self::$filters);
	}

	/**
	 *
	 * 把html标签转化为字符串html
	 * @param string $content
	 * @return string
	 */
	static public function htmlspecialchars($content, $options = null) {
		if (is_null($options)) {
			$options = ENT_QUOTES;
		}
		return htmlspecialchars($content, $options, "UTF-8");
	}

	/**
	 *
	 * 从字符串中去除 HTML 和 PHP 标记
	 * @param string $content 输入字符串
	 * @param string $allowable_tags 使用可选的第二个参数指定不被去除的字符列表
	 * HTML 注释和 PHP 标签也会被去除。这里是硬编码处理的，所以无法通过 allowable_tags 参数进行改变。
	 * @return string
	 */
	static public function strip_tags($content, $allowable_tags = null) {
		return strip_tags($content, $allowable_tags);
	}

	/**
	 *
	 * 与 strip_tags 相反，只去除参数$stripable_tags里指定的标签
	 * @param string $content 输入字符串
	 * @param string $stripable_tags 使用可选的第二个参数指定被去除的字符列表
	 * @return string
	 */
	static public function strip_selected_tags($content, $stripable_tags = null) {
		if (is_null($stripable_tags)) {
			$stripable_tags = '';
		}
		preg_match_all("/<([^>]+)>/i", $stripable_tags, $allTags, PREG_PATTERN_ORDER);
		foreach ($allTags[1] as $tag){
			$content = preg_replace("/<\/?".$tag."[^>]*>/iU","",$content);
		}
		return $content;
	}

	/**
	 *
	 * 去除script标签
	 * @param string $content 输入字符串
	 * @return string
	 */
	static public function strip_script($content) {
		return self::strip_selected_tags($content, "<script>");
	}

	/**
	 *
	 * 去除首尾空格
	 * @param string $content 输入字符串
	 * @return string
	 */
	static public function trim($content) {
		return trim($content);
	}
}