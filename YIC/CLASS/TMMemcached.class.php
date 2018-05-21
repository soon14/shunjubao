<?php
/**
 * 对php扩展 Memcached 的包装
 * @author gaoxiaogang@gmail.com
 *
 */
class TMMemcached {
	/**
	 * 存放已建立的 Memcached 实例
	 * @var array
	 */
	static private $objMemcacheds = array();

	/**
	 *
	 * 当前所使用的服务器集群
	 * @var array
	 */
	private $servers;

	/**
	 *
	 * 保存当前实例下到Memcached的连接
	 * @var Memcached
	 */
	private $objMemcached;

	public function __construct($cluster_flag = 'default') {
		global $CACHE;

		if (!isset($CACHE['memcached'][$cluster_flag])) {
			throw new ParamsException("不存在的memcache集群标志 {$cluster_flag}");
		}

		$servers = $CACHE['memcached'][$cluster_flag];

		$this->servers = $servers;

		if (!isset(self::$objMemcacheds[$cluster_flag])) {
			$objMemcached = new Memcached();

			# 设置socket连接的超时时间，单位是毫秒。这个值如果设置的太小，容易导致memcached操作失败率增加。
			$objMemcached->setOption(Memcached::OPT_CONNECT_TIMEOUT, 1000);

			# 等待失败的连接重试的时间，单位秒
			$objMemcached->setOption(Memcached::OPT_RETRY_TIMEOUT, 0);

			$objMemcached->setOption(Memcached::OPT_TCP_NODELAY, true);

			# 使用一致性分布算法
			$objMemcached->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
			$objMemcached->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

			$tmpResult = $objMemcached->addServers($servers);
			if (!$tmpResult) {
				return false;
			}
			self::$objMemcacheds[$cluster_flag] = $objMemcached;
		}

		$this->objMemcached = self::$objMemcacheds[$cluster_flag];
	}

	/**
	 *
	 * 给 $key 设置对应的值
	 * @param string $key
	 * @param mixed $value
	 * @param int $expiration 过期时间 实际发送的值可以 是一个Unix时间戳，或者是一个从现在算起的以秒为单位的数字。对于后一种情况，这个 秒数不能超过60×60×24×30（30天时间的秒数）;如果失效的值大于这个值， 服务端会将其作为一个真实的Unix时间戳来处理而不是 自当前时间的偏移。
	 * 		如果失效值被设置为0（默认），此元素永不过期（但是它可能由于服务端为了给其他新的元素分配空间而被删除）。
	 * @return Boolean 成功：true；失败：false
	 *
	 */
	public function set($key, $value, $expiration = 0) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->set($key, $value, $expiration);

		if ($this->getResultCode() == Memcached::RES_SUCCESS) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, $tmpResult, 'set');
		} else {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, 'false'.'::'.$this->getResultCode().'::'.$this->getResultMessage(), 'set');
		}

		return $tmpResult;
	}

	/**
	 *
	 * 存储多个元素
	 * @param array $items 存放在服务器上的键/值对数组。
	 * @param int $expiration 到期时间，默认为 0
	 * @return Boolean 有任何一个key设置失败，都会返回false，并且该key后的key不会再去存储；但是前面存储成功的key仍然有效。
	 * !!! 所以，批量设置的行为，具有不可预料性
	 */
	public function sets(array $items, $expiration = 0) {
		$begin_microtime = Debug::getTime();

		if (empty($items)) {
			throw new ParamsException('sets方法的参数items不能为空数组');
		}
		$tmpResult = $this->objMemcached->setMulti($items, $expiration);

		Debug::cache($this->servers, join("::", $items), Debug::getTime() - $begin_microtime, $tmpResult, 'sets');
		return $tmpResult;
	}

	/**
	 * 用于存放用户传递的回调函数
	 * ps：仅当用户调用 get 方法，设置了通用缓存回调函数，并且希望获得 cas_token 时，才会使用到这个 实例变量。
	 * @var string
	 */
	private $cache_cb = null;

	/**
	 *
	 * 仅当 wrapperCacheCallback 方法被 Memcached 自动调用，并且 wrapperCacheCallback 调用用户指定的
	 * 通用缓存回调函数成功时，设置该实例变量为 true
	 * @var boolean
	 */
	private $has_cb = false;

	/**
	 *
	 * 对通用缓存回调的包装
	 * 用于解决 get 时值不存在，通过设置的通用缓存回调函数设置默认值，但却无法获取到 $cas_token 的bug
	 * @param Memcached $objMemcached
	 * @param string $key
	 * @param mixed $value 引用传递
	 * @return Boolean 只有返回 true 时，$value 设置的值才会自动更新到 Memcached 服务器
	 */
	public function wrapperCacheCallback($objMemcached, $key, & $value) {
		$tmpVal = null;
		$tmpResult = call_user_func($this->cache_cb, $this->objMemcached, $key, & $tmpVal);
		if ($tmpResult === true) {
			$this->has_cb = true;
			$value = $tmpVal;
		}

		$this->cache_cb = null;
		return $tmpResult;
	}

	/**
	 *
	 * 获取 $key 对应的值
	 * PS: 如果指定了 通用缓存回调函数$cache_cb，并且想取得$cas_token，则会使用 $this->wrapperCacheCallback 方法
	 *     对 $cache_cb 进行包装。原因是 Memcached 扩展的 get 方法，在这种情况下是获取不到 $cas_token 的。
	 * @param string $key
	 * @param callback $cache_cb 通用缓存回调函数。如：'myfunc', array('MyClass', 'classMethod'),
	 * 		  array($obj, 'method')。
	 * @param float $cas_token 引用传递
	 * @return null | false | mixed 值不存在：返回 null；存在：返回值；其它原因导致的获取不到值：返回 false。
	 * !!! 如果 $key set 的值本身是false，请调用 getResultCode 方法来与 失败原因导致的 false 相区分。
	 *
	 */
	public function get($key, $cache_cb = null, & $cas_token = null) {
		$begin_microtime = Debug::getTime();

		if (func_num_args()	== 3 && !is_null($cache_cb)) {
			$this->cache_cb = $cache_cb;

			$tmpResult = $this->objMemcached->get($key, array($this, 'wrapperCacheCallback'), $cas_token);
		} else {
			$tmpResult = $this->objMemcached->get($key, $cache_cb, $cas_token);
		}

		if ($this->has_cb) {
			$this->objMemcached->get($key, null, $cas_token);
			$this->has_cb = false;
		}

		if ($this->getResultCode() == Memcached::RES_SUCCESS) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, $tmpResult, 'get');

			return $tmpResult;
		}

		if (Memcached::RES_NOTFOUND == $this->getResultCode()) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, null, 'get');

			return null;// 值不存在，返回 null
		} else {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, 'false'.'::'.$this->getResultCode().'::'.$this->getResultMessage(), 'get');

			return false;
		}
	}

	/**
	 *
	 * 批量获取 $keys 对应的值
	 * @param array $keys
	 * @param array $cas_tokens 引用传值
	 * @return false | array 失败：返回false，获取其中任何一个key出错，都会返回false；
	 * 						 成功：array，值不存在的key，对应的值是null。
	 */
	public function gets(array $keys, array & $cas_tokens = null) {
		if (empty($keys)) {
			return array();
		}

		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->getMulti($keys, $cas_tokens, Memcached::GET_PRESERVE_ORDER);

		Debug::cache($this->servers, join("::", $keys), Debug::getTime() - $begin_microtime, $tmpResult, 'gets');

		return $tmpResult;
	}

	/**
	 *
	 * 执行一个“检查并设置”的操作，因此，它仅在当前客户端最后一次取值后，该key 对应的值没有被其他客户端修改的情况下
	 * ，才能够将值写入。检查是通过cas_token参数进行的， 这个参数是Memcach指定给已经存在的元素的一个唯一的64位值
	 * ，怎样获取这个值请查看 Memcached::get*() 系列方法的文档
	 * 。注意：这个值作为double类型是因为PHP的整型空间限制。
	 * PS：这是Memcached扩展比Memcache扩展一个非常重要的优势，在这样一个系统级（Memcache自身提供）
	 * 的冲突检测机制（乐观锁）下， 我们才能保证高并发下的数据安全。
	 *
	 * @param float $cas_token 与已存在元素关联的唯一的值，由Memcache生成。
	 * @param string $key 用于存储值的键名。
	 * @param mixed $value 存储的值
	 * @param int $expiration 到期时间，默认为 0
	 * @return null | boolean 成功：true；失败：false；$cas_token检查不通过：null
	 * 		   如果在元素尝试存储时发现在本客户端最后一次获取后被其他客户端修改（即$cas_token检查不通过）
	 * 		   ，Memcached::getResultCode() 将返回Memcached::RES_DATA_EXISTS。
	 */
	public function cas($cas_token, $key, $value, $expiration = 0) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->cas($cas_token, $key, $value, $expiration);
		if ($tmpResult) {
			Debug::cache($this->servers, "{$cas_token}::{$key}::{$value}", Debug::getTime() - $begin_microtime, $tmpResult, 'cas');
			return true;
		}

		if ($this->getResultCode() == Memcached::RES_DATA_EXISTS) {
			Debug::cache($this->servers, "{$cas_token}::{$key}::{$value}", Debug::getTime() - $begin_microtime, null, 'cas');
			return null;
		}

		Debug::cache($this->servers, "{$cas_token}::{$key}::{$value}", Debug::getTime() - $begin_microtime, false, 'cas');
		return false;
	}

	/**
	 *
	 * 删除一个元素
	 * 从服务端删除key对应的元素。 参数time是一个秒为单位的时间(或一个UNIX时间戳表明直到那个时间)
	 * ，用来表明 客户端希望服务端在这段时间拒绝对这个key的add和replace命令。
	 * 由于这个时间段的存在, 元素被放入一个删除队列, 表明它不可以通过get命令获取到值,
	 * 但是同时 add和replace命令也会失败(无论如何set命令都会成功)。
	 * 在这段时间过去后, 元素最终被从服务端内存删除。
	 * time参数默认0(表明元素会被立即删除并且之后对这个 key的存储命令也会成功)。
	 * @param string $key 要删除的key
	 * @param int $time 服务端等待删除该元素的总时间(或一个Unix时间戳表明的实际删除时间).
	 * @return null | boolean 成功：true；失败：false；key不存在：null
	 * 		   如果key不存在, Memcached::getResultCode()将会返回Memcached::RES_NOTFOUND
	 */
	public function delete($key, $time = 0) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->delete($key, $time);

		if ($tmpResult) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, true, 'delete');

			return true;
		}

		if (Memcached::RES_NOTFOUND == $this->getResultCode()) {
			Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, null, 'delete');
			return null;
		}

		Debug::cache($this->servers, $key, Debug::getTime() - $begin_microtime, false, 'delete');
		return false;
	}

	/**
	 *
	 * 向一个新的key下面增加一个元素
	 * @param string $key 用于存储值的键名。
	 * @param mixed $value 存储的值
	 * @param int $expiration 到期时间，默认为 0
	 * @return null | boolean 成功：true；失败：false；key存在：null
	 * 		   如果key已经存在， Memcached::getResultCode()方法将会返回Memcached::RES_NOTSTORED。
	 */
	public function add($key, $value, $expiration = 0) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->add($key, $value, $expiration);

		if ($tmpResult) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, true, 'add');
			return true;
		}

		if (Memcached::RES_NOTSTORED == $this->getResultCode()) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, null, 'add');
			return null;
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
	 * @param int $expiration 到期时间，默认为 0
	 * @return null | boolean 成功：true；失败：false；key不存在：null
	 */
	public function replace($key, $value, $expiration = 0) {
		$begin_microtime = Debug::getTime();

		$tmpResult = $this->objMemcached->replace($key, $value, $expiration);

		if ($tmpResult) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, true, 'replace');
			return true;
		}

		if (Memcached::RES_NOTSTORED == $this->getResultCode()) {
			Debug::cache($this->servers, "{$key}::{$value}", Debug::getTime() - $begin_microtime, null, 'replace');
			return null;
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
	 * @return null | int | false 成功：int（递增后的值）；失败：false；key不存在：null
	 * 		   如果key不存在 Memcached::getResultCode()方法返回Memcached::RES_NOTFOUND。
	 * !!! 如果 $key 对应的值不是 int 型：通过 $this->get 方法返回的值不是 int 型
	 * a、如果不是 boolean 型：结果是0，并且 Memcached::getResultCode() 返回 Memcached::RES_SUCCESS
	 * b、如果是 boolean 型：会以0为基准递增值。
	 * !!! 所以，请尽量尽量不要对非 int 型的值使用 increment 方法
	 */
	public function increment($key, $offset = 1) {
		$begin_microtime = Debug::getTime();

		$tmpGetResult = $this->get($key);
		if (is_null($tmpGetResult)) {// $key 对应的值不存在
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, null, 'increment');
			return null;
		}

		if ($this->getResultCode() != Memcached::RES_SUCCESS ) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'increment');
			return false;
		}

		if (!Verify::naturalNumber($tmpGetResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'increment');
			return false;
		}

		$tmpResult = $this->objMemcached->increment($key, $offset);
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
	 * @return null | int | false 成功：int（减少后的值，有可能是 0）；失败：false；key不存在：null
	 * 		   如果key不存在 Memcached::getResultCode()方法返回Memcached::RES_NOTFOUND。
	 */
	public function decrement($key, $offset = 1) {
		$begin_microtime = Debug::getTime();

		$tmpGetResult = $this->get($key);
		if (is_null($tmpGetResult)) {// $key 对应的值不存在
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, null, 'decrement');
			return null;
		}

		if ($this->getResultCode() != Memcached::RES_SUCCESS ) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'decrement');
			return false;
		}

		if (!Verify::naturalNumber($tmpGetResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'decrement');
			return false;
		}

		$tmpResult = $this->objMemcached->decrement($key, $offset);
		if (Verify::naturalNumber($tmpResult)) {
			Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, $tmpResult, 'decrement');
			return $tmpResult;
		}

		Debug::cache($this->servers, "{$key}::{$offset}", Debug::getTime() - $begin_microtime, false, 'decrement');
		return false;
	}

	/**
	 *
	 * 返回最后一次操作的结果代码
	 * 返回Memcached::RES_*系列常量中的一个来表明最后一次执行Memcached方法的结果
	 *
	 * 比如常用的几个常量是：
	 * 1、Memcached::RES_SUCCESS 表示操作成功
	 * 2、Memcached::RES_NOTFOUND 元素未找到（通过get或cas操作时）
	 * 3、Memcached::RES_NOTSTORED 元素没有被存储，但并不是因为一个错误。
	 * 				这通常表明add（元素已存在）或replace（元素不存在）方式存储数据失败或者元素已经在一个删除序列中（延时删除）。
	 *
	 * @return int
	 */
	public function getResultCode() {
		return $this->objMemcached->getResultCode();
	}

	/**
	 *
	 * 返回一个字符串来描述最后一次Memcached方法执行的结果。
	 * @return string
	 */
	public function getResultMessage() {
		return $this->objMemcached->getResultMessage();
	}

}
