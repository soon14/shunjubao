<?php
/**
 * @name Memcached.class.php
 * @desc memCache统一操作类
 * @author space tang
 * @createtime 2008-9-10 10:54
 * @updatetime 2008-9-18 08:58 上线前应该加入bdb支持,将memcached变成memcachedb,永久存储
 */
if(!defined('YOKA')) exit('Illegal Request');

class ZYMemcache
{
    
    private $memcache;
    private $errorDesc;
    
    /**
	 * @name __construct
	 * @desc 构造函数
	 * @param void
	 * @return object instance of ClubMemCached
	 * @access public
	 *
	 */
    public function __construct()
    {
        $this->memcached = new Memcache;
	$this->memcached = new Redis();
        $this->addServer();
    }
    /**
	 * @name addServer
	 * @desc Add a server for memcache
	 * @param string $host
	 * @param string $port
	 * @return void
	 * @access public
	 *
	 */
    public function addServer($host = '127.0.0.1', $port = '11211')
    {
	$this->memcached->connect($host,'6379');
	$this->memcached->select(0);
		//$res = $this->memcached->addServer($host,$port);
    }
    /**
	 * @name add
	 * @desc Add an item to the server
	 * @param string $key
	 * @param mixed $key
	 * @param int $flag default by 0
	 * @param int $expire default by 0
	 * @return boolean
	 * @access public
	 *
	 */
    public function add($key, $val, $flag = 0, $expire = 0)
    {
        if($this->memcached->add($key, $val, $flag, $expire)){
            return true;
        }
        return false;
    }
    
    /**
	 * @name set
	 * @desc Store data at the server
	 * @param string $key
	 * @param mixed $key
	 * @param int $flag default by 0
	 * @param int $expire default by 0
	 * @return boolean
	 * @access public
	 *
	 */
    public function set($key, $val, $flag = 0, $expire = 0) {
        if($this->memcached->set($key, $val, $flag, $expire)){
            return true;
        }
        return false;
    }
    
    /**
	 * @name get
	 * @desc Retrieve item from the server
	 * @param string $key / array $keys
	 * @return Returns the string associated with the key or FALSE on failure or if such key was not found
	 * @access public
	 *
	 */
    public function get($key) {
        $result = $this->memcached->get($key);
        return $result;
    }
    
    /**
	 * @name close
	 * @desc Close memcached server connection
	 * @param void
	 * @return boolean
	 * @access public
	 *
	 */
    public function close() {
        if($this->memcached->close()){
            return true;
        }
        return false;
    }
    
    /**
	 * @name delete
	 * @desc Delete item from the server
	 * @param string $key
	 * @return public
	 * @access public
	 *
	 */
    public function delete($key, $timeout = 0) {
        if($this->memcached->delete($key, $timeout)){
            return true;   
        }
        return false;
    }
    
    /**
	 * @name setError
	 * @desc 设置错误信息
	 * @param string $errorDesc
	 * @return void
	 * @access public
	 *
	 */
    public function setError($errorDesc) {
        $this->errorDesc = $errorDesc;
    }
    
    /**
	 * @name getError
	 * @desc 取得错误信息
	 * @param void
	 * @return string $errorDesc
	 * @access public
	 *
	 */
    public function getError() {
        return $this->errorDesc;
    }
    
    
    /**
	 * @name __destruct
	 * @desc 析构函数
	 * @param void
	 * @return void
	 * @access public
	 *
	 */
    public function __destruct() {
        $this->close();
    }
}


?>
