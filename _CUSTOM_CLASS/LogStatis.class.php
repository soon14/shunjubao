<?php
/**
 *
 * 高街基础日志统计的类
 * @author gxg
 *
 */
class LogStatis {
	private $tmpStorePath = '/tmp/log_statis_tmp_store';

	/**
	 *
	 * 正则比较
	 * @var string
	 */
	const COMPARE_REGULAR = 'regular';

	public function __construct() {
		if (!file_exists($this->tmpStorePath)) {
			if (!mkdir($this->tmpStorePath, 0755, true)) {
				throw new Exception("创建目录失败:{$this->tmpStorePath}");
			}
		}
	}

	/**
	 *
	 * 根据日志文件名和配置信息获取临时存储文件名
	 * @param string $log_file
	 * @param array $config
	 * @return string 返回临时存储文件名，用于存放中间数据
	 */
	public function getTmpStore($log_file, array $config) {
		# 对$config按key升序排序
		ksort($config);
		$key = $log_file . '::' . print_r($config, true);
		$key = Algorithm::md5_16($key);
		return $this->tmpStorePath . "/{$key}.tmp";
	}

	/**
	 * 通用的统计架构。
	 * 实现目标：由配置文件驱动
	 * 支持的字段：
	 * Array
	(
	// 一定存在的：
	    [ip] => 61.173.54.22
	    [visit_ts] => 1318867147
	    [http_status] => 200
	    [request_method] => GET
	    [url] => http://www.gaojie.com/
	    [host] => www.gaojie.com

	// 可能存在的：
	    [uid] => 204705
	    [title] => 高街网-中国最时尚名品特卖网站
	    [uuid] => G4Pd806cTZ5fk2doA5Y5Ag,//唯一用户id。一般用来做uv的统计
	    [adsense_from]	=> (string),//广告联盟来源
	    [channelid]	=> (int),//渠道id
	    [referer]	=> (string),//来源

	    [ssId]		=> (int),// 特卖id
	    [ssProdId]	=> (int),// 特卖商品id
	)
	 */
	public function processLogFile($log_file, $day, array $configs) {
		if (!file_exists($log_file)) {
		    throw new Exception("日志文件:{$log_file} 不存在");
		}
		$handle = fopen($log_file, "r");

		# 分析的非当天数据，判断下是否有先前的结果可以使用，以免重复计算
		if (date('Ymd') != $day) {
			$tmpConfigs = array();
			foreach ($configs as $config) {
				$tmpStore = $this->getTmpStore($log_file, $config);
				if (!file_exists($tmpStore)) {// 没有缓存，需要计算
					$tmpConfigs[] = $config;
				}
			}

			# 全部利用到了缓存
			if (empty($tmpConfigs)) {
				return InternalResultTransfer::success();
			}

			$configs = $tmpConfigs;
		}

		# 清空之前的缓存结果
		foreach ($configs as $config) {
			$tmpStore = $this->getTmpStore($log_file, $config);
			if (file_exists($tmpStore)) {
				file_put_contents($tmpStore, '');// 清空
			}
		}

		# 开始处理
		do {
			$data = fgetcsv($handle, null, " ", '"');
			if (!$data) {
				break;
			}
			$fields = array();
			# 访问者ip
			$fields['ip'] = $data[0];

			# 获取访问时的时间戳
			$tmp_ts_fields = strptime(substr($data[3],1), '%d/%b/%Y:%H:%M:%S');
			$fields['visit_ts'] = mktime($tmp_ts_fields['tm_hour'], $tmp_ts_fields['tm_min'], $tmp_ts_fields['tm_sec'], $tmp_ts_fields['tm_mon']+1, $tmp_ts_fields['tm_mday'], $tmp_ts_fields['tm_year']+1900);

			# http 状态码
			$fields['http_status'] = $data[6];

			# 用户id
			if (Verify::int($data[11])) {
				$fields['uid'] = $data[11];
			}

			if (!preg_match('#([A-Z]+)\s/(a.gif\?[^\s]+)#', $data[5], $matches)) {
		//		echo "没有匹配到\r\n";
		//		echo $data[5], "\r\n";
//				$tmpArr[] = $data[5];
				continue;
			}
			# 请求方式：GET、POST
			$fields['request_method'] = $matches[1];

			$url_info = parse_url($matches[2]);
			$tmpQuery = $url_info['query'];
			parse_str($tmpQuery, $params);
			foreach ($params as $tmpK	=> $tmpV) {
				if ($tmpK == 'r') {// js为了请求不被浏览器cache住，特意加的一个随机时间字段
					continue;
				}
				$tmpV = trim($tmpV);
				if (empty($tmpV)) {
					continue;
				}
				$fields[$tmpK] = $tmpV;
			}

			# 处理当前url，尝试解析出特卖id、特卖商品id
			$tmp_url_info = parse_url($fields['url']);
			$tmpPath = $tmp_url_info['path'];
			$tmpPath = str_replace(' ', '/', trim(str_replace('/', ' ', $tmpPath)));

			# 获取特卖商品id
			$ssProdId = InputHelper::isSSProdUrl($fields['url']);
			if ($ssProdId) {
				$fields['ssProdId'] = $ssProdId;
			}

			# 获取特卖id
			$ssId = InputHelper::isSpecialSaleUrl($fields['url']);
			if ($ssId) {
				$fields['ssId'] = $ssId;
			}

			# 获取 referer_host
			if (isset($fields['referer'])) {
				$tmp_url_info = parse_url($fields['referer']);
				if (isset($tmp_url_info['host'])) {
					$fields['referer_host'] = $tmp_url_info['host'];
//				} else {// 有获取不到host的referer。比如这种：file:///Unsaved_Document
//					echo $fields['referer'];
//					print_r($tmp_url_info);exit;
				}
			}

			foreach ($configs as $config) {
				# 筛选出符合config里条件的日志条目
				$tmpArrCond = $config['condition'];
				foreach ($tmpArrCond as $tmpK	=> $tmpV) {
					if (!isset($fields[$tmpK])) {
						continue 2;// 不符合条件，转到下一个配置(config)
					}

					if (is_null($tmpV)) {// 条件里字段的值为null，就判断日志里对应字段是否存在，如不存在，则直接跳到下一个配置。
						// do nothing
					} else {
						if (!is_array($tmpV)) {
							$tmpV = array($tmpV);
						}

						# 值里面有比较操作符，根据比较操作符类型做对应的解析判断
						if (array_key_exists('compare', $tmpV)) {
							switch ($tmpV['compare']) {
								case LogStatis::COMPARE_REGULAR:
									if (!preg_match($tmpV['val'], $fields[$tmpK])) {
										continue 3;// 不符合条件，转到下一个配置(config)
									}
									break;
							}
						} else {
							# 值是数组，使用 in 的方式比较
							if (!in_array($fields[$tmpK], $tmpV)) {
								continue 2;
							}
						}
					}
				}

				# 按 config 里指定的output字段，输出到临时文件里
				$tmpArrOutput = $config['output'];
				$objLogStatis = new LogStatis();
				$tmpFile = $objLogStatis->getTmpStore($log_file, $config);
				$tmpArrContents = array();
				foreach ($tmpArrOutput as $tmpV) {
					$tmpArrContents[] = $fields[$tmpV];
				}
				file_put_contents($tmpFile, join("\t", $tmpArrContents)."\r\n", FILE_APPEND);
			}

		} while (true);

		return InternalResultTransfer::success();
	}
}