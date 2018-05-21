<?php
/**
 * 算法集合类
 *
 */
class Algorithm {
    /**
     *
     * 改进的FNV 32位 hash 算法
     * 改进后的算法，散列效果相比 Algorithm::fnv1hash32 好很多
     * 调用的是php的扩展
     * @param string $str
     * @return string
     */
	static function fnvhash1_32($str) {
		return sprintf("%u", TMAlgorithms::fnvhash1($str));
	}

    /**
     * 计算一个字符串的 crc32 多项式
     *
     * @param string $str
     * @return string 全数字組成的32位字符串。由于 PHP 的整数是带符号的，所以由sprintf返回一个字符串。
     */
    static public function crc32($str) {
    	$hash = crc32($str);
    	return sprintf("%u", $hash);
    }

    /**
     * 计算一个字符串的 16位 md5值
     * @param string $str
     * @return string 16位的字符串
     */
    static public function md5_16($str) {
    	return substr(md5($str), 8, 16);
    }


	/**
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!
	 * !!!! 该方法不再推荐使用，他奶奶的，散裂效果不行！ !!!!
	 * 比如：Algorithm::fnv1hash32('17') == 544649053;
	 * 而 Algorithm::fnv1hash32('18') == 544649042;
	 * 规律性太强了！
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!
	 * FNV-1 32位 hash 算法
	 * Fowler/Noll /Vo 是由 Glenn Fowler, Landon Curt Noll, 和 Phong Vo 创造的非加密哈希函数.
	 * 当前版本为 FNV-1 和 FNV-1a. FNV 目前有 32, 64, 128, 256, 512, 和 1024 位几种方式.
	 * 纯粹的 FNV 实现是完全由所需位数的可用的 FNV 素数决定的.
	 * 关于 Fowler-Noll-Vo 函数的更多信息可参见:
     * http://www.isthe.com/chongo/tech/comp/fnv/index.html
     * http://en.wikipedia.org/wiki/Fowler-Noll-Vo_hash_function
	 *
	 * @param string $str
	 * @return string 全数字組成的32位字符串。由于 PHP 的整数是带符号的，所以由sprintf返回一个字符串。
	 */
    static public function fnv1hash32($str) {
        if (!is_string($str) || empty($str)) {
            throw new ParamsException();
        }
        $len = strlen($str);
        $hash = 2166136261;
        for ($i = 0; $i < $len; $i++) {
            # 因php大整数 相乘会溢出，故改成等价的下列代碼
            # $hash *= 16777619;
            $hash += ($hash << 1) + ($hash << 4) + ($hash << 7) + ($hash << 8) + ($hash << 24);
            $hash = $hash ^ ord($str{$i});

            # 修正64位平台上的bug。因php里64位平台上最大的整数值与32位平台上最大的整数值是不一样的。
            $hash = $hash & 0x0ffffffff;
        }
        $hash = $hash & 0x0ffffffff;
        return sprintf("%u", $hash);
    }
}
