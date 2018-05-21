<?php
/**
 * 对php扩展 Memcached 的包装，用于操作 tokyotyrant。
 * tokyotyrant是网络接口，其后的存储由tokyocabinet。该存储里的值都是永久的，不像memcache一样，能够设置过期时间。
 * @author gaoxiaogang@gmail.com
 *
 */
class TMTTServer {
	/**
	 * 存放已建立的 Memcache 实例
	 * @var array
	 */
	static private $objMemcaches = array();

	/**
	 *
	 * 当前所使用的服务器集群
	 * @var array
	 */
	private $servers;

	/**
	 *
	 * 保存当前实例下到Memcached的连接
	 * @var Memcache
	 */
	private $objMemcache;

	public function __construct($cluster_flag = 'default') {
		global $CACHE;

		if (!isset($CACHE['ttserver'][$cluster_flag])) {
			throw new ParamsException("不存在的ttserver集群标志 {$cluster_flag}");
		}

		$servers = $CACHE['ttserver'][$cluster_flag];

		$this->servers = $servers;

		if (!isset(self::$objMemcaches[$cluster_flag])) {
			$objMemcache = new Memcache();
			foreach ($servers as $server) {
				$tmpHost = isset($server['host']) ? $server['host'] : '127.0.0.1';
				$tmpPort = isset($server['port']) ? $server['port'] : '11211';
				$tmpPersistent = isset($server['persistent']) ? (bool) $server['persistent'] : false;
				$tmpWeight = isset($server['weight']) ? $server['weight'] : 1;
				$tmpTimeout = isset($server['timeout']) ? $server['timeout'] : 2;// 默认2秒的超时
				$tmpRetry_interval = isset($server['retry_interval']) ? $server['retry_interval'] : 5;// 默认5秒超时重试

				$tmpResult = $objMemcache->addServer($tmpHost, $tmpPort, $tmpPersistent
					, $tmpWeight, $tmpTimeout, $tmpRetry_interval
				);
			}
			self::$objMemcaches[$cluster_flag] = $objMemcache;
		}

		$this->objMemcache = self::$objMemcaches[$cluster_flag];
	}

	/**
	 *
	 * 给 $key 设置对应的值
	 * @param string $key
	 * @param mixed $value
	 * @return Boolean 成功：true；失败：false
	 *
	 */
	public function set($key, $value) {
		$begin_microtime = Debug::getTime();

		if (!is_scalar($value)) {
			$value = serialize($value);
		}
		$tmpResult = $this->objMemcache->set($key, $value);
		Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, $tmpResult, 'set');

		return $tmpResult;
	}

	/**
	 *
	 * 获取 $key 对应的值
	 * @param string $key
	 * @return false | mixed 存在：返回值；值不存在 或 其它原因导致的获取不到值：返回 false。
	 *
	 */
	public function get($key) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcache->get($key);
		if ($tmpResult !== false) {
			# 尝试序列化
			$tmpUnserializeVal = @unserialize($tmpResult);
			if ($tmpUnserializeVal !== false) {// 反序列化成功，则使用序列化后的值
				$tmpResult = $tmpUnserializeVal;
			}
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, $tmpResult, 'get');

			return $tmpResult;
		}

		Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, false, 'get');
		return false;
	}

	/**
	 *
	 * 批量获取 $keys 对应的值
	 * @param array $keys
	 * @return false | array 失败：返回false，获取其中任何一个key出错，都会返回false；
	 * 						 成功：array，值不存在的key，对应的值是null。
	 */
	public function gets(array $keys) {
		if (empty($keys)) {
			return array();
		}

		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcache->get($keys);

		Debug::cache($this->servers, join(",", $keys), Debug::getTime() - $begin_microtime, false, 'gets');

		if ($tmpResult === false) {
			return false;
		}

		$return = array();
		foreach ($keys as $key) {
			if (isset($tmpResult[$key])) {
				# 尝试序列化
				$tmpUnserializeVal = @unserialize($tmpResult[$key]);
				if ($tmpUnserializeVal !== false) {// 反序列化成功，则使用序列化后的值
					$return[$key] = $tmpUnserializeVal;
				} else {
					$return[$key] = $tmpResult[$key];
				}
			} else {
				$return[$key] = null;
			}
		}
		return $return;
	}

	/**
	 *
	 * 删除一个元素
	 * @param string $key 要删除的key
	 * @return null | boolean 成功：true；失败：false；
	 */
	public function delete($key) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcache->delete($key);

		if ($tmpResult) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, true, 'delete');

			return true;
		}

		Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, false, 'delete');
		return false;
	}

	/**
	 *
	 * 向一个新的key下面增加一个元素
	 * @param string $key 用于存储值的键名。
	 * @param mixed $value 存储的值
	 * @return boolean 成功：true；失败：false；
	 */
	public function add($key, $value) {
		$begin_microtime = Debug::getTime();

		if (!is_scalar($value)) {
			$value = serialize($value);
		}

		$tmpResult = $this->objMemcache->add($key, $value);

		if ($tmpResult) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, true, 'add');
			return true;
		}

		Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, false, 'add');
		return false;
	}

	/**
	 *
	 * 替换已存在key下的元素
	 * 如果 服务端不存在key，操作将失败。
	 * @param string $key 用于存储值的键名。
	 * @param mixed $value 存储的值
	 * @return null | boolean 成功：true；失败：false；
	 */
	public function replace($key, $value) {
		$begin_microtime = Debug::getTime();

		if (!is_scalar($value)) {
			$value = serialize($value);
		}
		$tmpResult = $this->objMemcache->replace($key, $value);

		if ($tmpResult) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, true, 'replace');
			return true;
		}

		Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, false, 'replace');
		return false;
	}

	/**
	 *
	 * 将一个数值元素增加参数offset指定的大小。如果元素的值不是数值类型，返回false
	 * 经实验发现，Memcached 扩展的increment方法存在bug，这里对其做了修复。
	 * @param string $key 要增加值的元素的key。
	 * @param int $offset 要将元素的值增加的大小。
	 * @return int | false 成功：int（递增后的值）；失败或key不存在：false
	 * !!! 如果 $key 对应的值不是 int 型：通过 $this->get 方法返回的值不是 int 型
	 * a、如果不是 boolean 型：结果是0
	 * b、如果是 boolean 型：会以0为基准递增值。
	 * !!! 所以，请尽量尽量不要对非 int 型的值使用 increment 方法
	 */
	public function increment($key, $offset = 1) {
		$begin_microtime = Debug::getTime();

		$tmpGetResult = $this->get($key);
		if (is_null($tmpGetResult)) {// $key 对应的值不存在
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, null, 'increment');
			return false;
		}

		if (!Verify::naturalNumber($tmpGetResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'increment');
			return false;
		}

		$tmpResult = $this->objMemcache->increment($key, $offset);
		if (Verify::unsignedInt($tmpResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, $tmpResult, 'increment');
			return $tmpResult;
		}

		Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'increment');
		return false;
	}

	/**
	 *
	 * 减小一个数值元素的值，减小多少由参数offset决定。如果元素的值不是数值类型，返回false。
	 * 如果减小后的值小于0,则新的值被设置为0。
	 * 如果元素不存在，返回 null。
	 *
	 * 经实验发现，Memcached 扩展的decrement方法存在bug，这里对其做了修复。
	 * @param string $key 要减少值的元素的key。
	 * @param int $offset 要将元素的值减少的大小。
	 * @return int | false 成功：int（减少后的值，有可能是 0）；失败或key不存在：false；
	 */
	public function decrement($key, $offset = 1) {
		$begin_microtime = Debug::getTime();

		$tmpGetResult = $this->get($key);
		if (is_null($tmpGetResult)) {// $key 对应的值不存在
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, null, 'decrement');
			return false;
		}

		if (!Verify::naturalNumber($tmpGetResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'decrement');
			return false;
		}

		$tmpResult = $this->objMemcache->decrement($key, $offset);
		if (Verify::naturalNumber($tmpResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, $tmpResult, 'decrement');
			return $tmpResult;
		}

		Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'decrement');
		return false;
	}
}