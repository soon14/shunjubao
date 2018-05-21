<?php
/**
 * @name Cache.class.php
 * @desc 通用缓冲机制控制类,目前只支持Memcached内存缓存
 * @author 曹晓冬
 * @createtime 2008-09-10 02:32
 * @updatetime 2009-03-20 06:12
 * @usage：
 * $cache_obj = Cache::getInstance('default');  //default为cache.config.php中$CACHE['memcached']配置的服务名称
 * $cache_obj->get($key); //$key为唯一的字符串标识
 * @todo 1.未支持清除cache时跨机房问题
 */
if(!defined('YOKA')) exit('Illegal Request');

class Cache implements CacheInterface
{
	/**
	 * 实例化数组
	 * @var array
	 */
	static $instance = array();
	/**
	 * 缓存前缀名
	 * @var string
	 */
	private $prefix = '';
	/**
	 * 服务器列表
	 * @var array
	 */
	private $serverlist = array(); 
	/**
	 * 缓存访问对象
	 * @var object
	 */
	private $cache; 
    /**
	 * @name __construct
	 * @desc 构造函数
	 * @param void
	 * @return object instance of Cache
	 * @access protected
	 *
	 */
    private function __construct($item = '', $serverList = array(), $type = 'memcached')
    {
    	if('memcached' == $type)
    	{
			$this->cache = new Memcached();
			if(!empty($serverList))
			{
				foreach($serverList as $v)
				{
					$this->cache->addServer($v['host'],$v['port']);
					$this->serverlist[] = array('ip' => $v['host'], 'port' => $v['port']);
				}
			}
    	}
		$this->prefix = $item;
    }
    /**
     * @name getInstance
     * @desc 单件模式调用Cache类入口
     * @param string $item
     * @return object instance of Cache
     * @access public
     **/
    public function getInstance($item)
    {
    	global $CACHE;
    	$obj = Cache::$instance;
    	if(!isset($obj[$item]))
    	{
    		$key = "";
    		$list = array();
			if(isset($CACHE['memcached'][$item]))
			{
				$config = $CACHE['memcached'][$item];
				$list = $config['server'];
				$key = $item;
			}
			$obj[$item] = & new Cache($item, $list);
			Cache::$instance = $obj;
		}
    	return $obj[$item];
    }
    /**
     * 将数据存入缓存。只有键值不存在时，才成功；否则失败。
     * 该方法提供原子操作！
     *
     * @param string $cacheKey
     * @param mixed $cacheValue
     * @param int $lifetime
     * @return Boolean
     */
    public function add($cacheKey, $cacheValue, $lifetime = 0) {
        $cacheKey = $this->getKey($cacheKey);
        if(empty($cacheKey)) return false;
        return $this->cache->add($cacheKey, $cacheValue, 0, $lifetime);
    }
    /**
	 * @name set
	 * @desc 将数据插入缓冲中
	 * @param string $cacheKey 字符串标识
	 * @param mixed $cacheValue 字符串对应的值
	 * @param int $lifetime 缓存的生命周期
	 * @return boolean 
	 * @access public
	 *
	 */
    public function set($cacheKey, $cacheValue, $lifetime = 0)
    {
    	$cacheKey = $this->getKey($cacheKey);
    	if(empty($cacheKey)) return false;
        if($this->cache->set($cacheKey, $cacheValue, 0, $lifetime)){
            return true;
        }
        return false;
    }
    /**
     * @name clear
     * @desc 将数据在缓冲中清除
     * @param string $cacheKey 要清除的字符串
     * @return bool
     * @access public
     **/
    public function clear($cacheKey)
    {
    	$cacheKey = $this->getKey($cacheKey);
    	if(empty($cacheKey)) return false;
        if($this->cache->delete($cacheKey)){
            return true;
        }
        return false;
    }
    /**
	 * @name get
	 * @desc 从缓冲中取得数据
	 * @param string $cacheKey 获得指定字符串的值
	 * @return mixed $cacheValue
	 * @access public
	 *
	 */
    public function get($cacheKey)
    {
    	$returnValue = "";
		$key = $this->getKey($cacheKey);
		if(empty($key)) return false;
		$begin_microtime = Debug::getTime();
        $cacheValue = $this->cache->get($key);
        if($cacheValue !== FALSE){
        	if(is_array($cacheKey))
        	{
        		$returnValue = array();
        		/*---这样逻辑是否足够好,需要考虑,是否循环结果,有时间改动 by caoxd ---*/
        		foreach($cacheKey as $value)
        		{
        			if(isset($cacheValue[$this->getKey($value)]))
        			{
        				$returnValue[$value] = $cacheValue[$this->getKey($value)];
        			}
        		}
        	}
            else $returnValue = $cacheValue;
        }
        Debug::cache($this->serverlist, $cacheKey, Debug::getTime() - $begin_microtime, $returnValue);
        return $returnValue;
    }
    /**
     * @name getKey
     * @desc 格式化Cache类中所需key
     * @param string $key
     * @return string $key
     * @access private
     *
     **/
    private function getKey($key)
    {
    	if(!empty($this->prefix))
    	{
    		if(is_array($key))
    		{
    			foreach($key as $k => $v)
    			{
    				$key[$k] = $this->prefix."_".$v;
    			}
    			return $key;
    		}
    		else return $this->prefix."_".$key;
    	}
    	return "";
    }
    
    /**
	 * @name __destruct
	 * @desc 析构函数
	 * @param void
	 * @return void
	 * @access public
	 *
	 */
    public function __destruct()
    {
        //parent::__destruct();
    }
}
?>