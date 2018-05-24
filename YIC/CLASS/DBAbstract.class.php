<?php
/**
 * 数据库操作的抽象类
 * @author gaoxiaogang@yoka.com
 *
 */
abstract class DBAbstract {
    /**
     * 数据表名
     * 该抽象类针对表的操作（如：delete、create、findBy)都是基于该属性。由继承的子类填充该值。
     * 好处：1、如果继承的子类只针对一个表，把tableName设为静态表名即可。
     * 2、如果继承的子类针对一类表操作(如根据某个唯一标志把相同结构的数据hash到多张表中)，则针对不同表操作时，动态设置该值
     * @var string
     */
    protected $tableName;

    /**
     * 表的主键名。默认为id
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     *
     * 插入行为
     * @var string
     */
    const PARAM_CREATE_ACTION_INSERT = 'INSERT INTO';

    /**
     *
     * 插入，但重复时忽略
     * @var string
     */
    const PARAM_CREATE_ACTION_INSERT_IGNORE = 'INSERT IGNORE';

    /**
     *
     * 插入，但重复时完全replace
     * @var string
     */
    const PARAM_CREATE_ACTION_REPLACE = 'REPLACE INTO';

    /**
     *
     * 插入，但重复时自动转为update
     * @var string
     */
    const PARAM_CREATE_ACTION_ONDUPLICATE = 'ON DUPLICATE KEY UPDATE';

    /**
     * 数据库实例，可被动态切换到主库或从库
     *
     * @var MySQLite
     */
    protected $db;

    public function __construct($master_flag = 'default') {
    	global $CACHE;
    	if (!isset($CACHE['db']) || !is_array($CACHE['db'])) {
    		throw new ParamsException('依赖的$CACHE[\'db\']数据结构无效');
    	}

    	if (!isset($CACHE['db'][$master_flag]) || !is_string($CACHE['db'][$master_flag])) {
    		throw new ParamsException("传递进来的主库标志对应的dsn不存在：{$master_flag}");
    	}
//    	var_dump($CACHE);
    	$dsn = $CACHE['db'][$master_flag];
    	$this->db = new MySQLite($dsn);
//    	var_dump($this->db);die;
    }

    /**
     *
     * 获取设置的主键名
     * @return string
     */
    public function getPrimaryKey() {
    	return $this->primaryKey;
    }

    /**
     * 设置表名
     * 动态设置表名是为了拆表
     * @param $tableName
     */
    public function setTableName($tableName) {
        $this->tableName = $tableName;
    }

    /**
     * 解析条件
     * @param array $condition
     * @throws Exception parameter errors
     * @return string
     */
    protected function parseCondition(array $condition = null) {
        if(empty($condition)) return '';

        $condition = $this->quote($condition);
        $where = array();
        foreach($condition as $key => $val) {
        	if (strpos($key, '`') === false // 没用使用 ` 字符，比如 `status`
        		&& strpos($key, '(') === false) // 也不含有括号（即不是函数），比如 last_insert_id(status)
        	{
        		$key = "`{$key}`";
        	}
            if(is_scalar($val)) {
                $where[] = "{$key} " . SqlHelper::explodeCompareOperator($val);
            } elseif(is_array($val)) {
                $where[] = "{$key} IN (".join(',', $val).")";
            } else {
                throw new Exception('parameter errors');
            }
        }
        return "
            WHERE ".join(' && ', $where)."
        ";
    }
    
    /**
     * 按条件获取数据
     * @param array $condition
     * @param string $limit
     * @param string $order
     * @param string $selectCols 处于性能考虑，想要选取的列
     * @return array
     */
    public function getsByCondition(array $condition, $limit = null, $order = 'id desc', $selectCols = '*') {
    	return $this->findBy($condition , null, $limit, $selectCols, $order);
    }
    
    /**
     * 可以进行某个字段的范围查找
     * @param string | num $start
     * @param string | num $end
     * @param string $field 待查找的字段
     * @param array $codition 其他条件
     * @param mix $limit
     * @param string $order
     */
    public function getsByCondtionWithField($start, $end, $field, $condition = null, $limit = null, $order = null) {
    	$sql = 'select * from '. $this->tableName;
    	$where = '';
    
    	if ($condition) {
    		$where = $this->parseCondition($condition);
    		$where .= ' && ';
    	} else {
    		$where = ' WHERE ';
    	}
    
    	$where .= " {$field} >= '{$start}' && {$field} <= '{$end}' ";
    
    	if ($order) {
    		$where .= " ORDER BY {$order} ";
    	}
    
    	if ($limit) {
    		$where .= " LIMIT {$limit} ";
    	}
    	$sql .= $where;
    	return $this->db->fetchAll($sql);
    }
    
    /**
     * 根据条件查找主键id列表集
     * 做这个方法，是出于架构上的考虑。只取出主键id集，然后通过主键id集才去取数据（内存或数据库）
     * @param array $condition 条件
     * @param string | int $limit 指定分页
     * @param string $order 指定排序
     * @return array 如：array(123, 124)。无值时返回空数组
     */
    public function findIdsBy(array $condition = null, $limit = null, $order = null) {
        $result = $this->findBy($condition, $this->primaryKey, $limit, $this->primaryKey, $order);
        if (! $result) {
            return array();
        }

        return array_keys($result);
    }

    /**
     * 查找的底层方法。对查找只提供有限支持，太复杂的查询请手动sql
     * final 让该方法禁止被继承
     * 1、根据条件查找，多条件只支持 与（＆＆），不支持或之类的
     * 2、支持limit
     * 3、group by
     * @param array $condition
     * @param string $returnAssociateKey 如果指定该指，返回的值不再以0，1，2为key，而是以其对应的值为key
     * @param string | int $limit
     * @param string $selectCols 要获取的列。语法：id, uid ,默认为 *
     * @param string $order 指定排序
     * @return array
     */
    final public function findBy(array $condition = null, $returnAssociateKey = null, $limit = null, $selectCols = '*', $order = null) {
        $where = $this->parseCondition($condition);
        if (!isset($limit) || !preg_match('#^(?:\d+\s*,\s*)?\d+$#', $limit)) {
            $strLimit = ' ';
        } else {
            $strLimit = " LIMIT $limit ";
        }

        $strOrder = '';
        if(!empty($order)) {
            $strOrder = " ORDER BY {$order} ";
        }

        if(!isset($selectCols)) {
            $selectCols = '*';
        }

        $sql = "SELECT {$selectCols} FROM {$this->tableName}
            {$where}
            {$strOrder}
            {$strLimit}
            ;
        ";
        return $this->db->fetchAll($sql, $returnAssociateKey);
    }

    public function fetchOne(array $condition = null, $selectCols = '*', $order = null) {
        $result = self::findBy($condition, null, 1, $selectCols, $order);
        if (!$result) {
        	return false;
        }
        return array_pop($result);
    }

    /**
     * 获取所有
     * @param string $order 排序方式。默认以主键倒序;有效的格式："create_time desc"
     * @param string $limit 该参数用于支持分页，默认为不使用分页。格式 "offset, length"
     * @return false | array
     */
    public function getsAll($order = null, $limit = null) {
        if (is_null($order)) {
            $order = "{$this->primaryKey} desc";
        }
        if (!is_string($order)) {
            throw new Exception('$order 必须是字符串或null');
        }

        $condition = null;
        $ids = self::findIdsBy($condition, $limit, $order);
        return $this->gets($ids);
    }

    /**
     * 获取所有id列表集
     * @param string $order 排序方式。默认以主键倒序;有效的格式："create_time desc"
     * @param string $limit 该参数用于支持分页，默认为不使用分页。格式 "offset, length"
     * @return false | array
     */
    public function getsAllIds($order = null, $limit = null) {
    	if (is_null($order)) {
            $order = "{$this->primaryKey} desc";
        }
        if (!is_string($order)) {
            throw new Exception('$order 必须是字符串或null');
        }

        $condition = null;
        $ids = self::findIdsBy($condition, $limit, $order);
        return $ids;
    }

    /**
     * 获取指定$id
     * @param int | string $id
     * @return false | array
     */
    public function get($id) {
        if (isInt($id)) {
            if ($id < 1) {
                return false;
            }
        } elseif (is_string($id)) {
            if (strlen($id) == 0) {
                return false;
            }
        } else {
            return false;
        }

        $result = self::gets(array($id));// 调用该类自身的gets方法，而不是继承者的gets方法！
        if (!$result) {
            return false;
        }
        return array_pop($result);
    }

    /**
     * 批量获取信息
     * @param array $ids id组成的数组
     * @return array 无结果时返回空数组
     */
    public function gets(array $ids) {
    	$return = array();

        if (empty($ids)) {
            return $return;
        }

        $ids = array_unique($ids);
        $condition = array(
            $this->primaryKey => $ids,
        );
        $result = $this->findBy($condition, $this->primaryKey);
        if (!$result) {
            return $return;
        }

        foreach ($ids as $id) {
        	$id = (string) $id;// php的数组下标是int整时，如果超出了操作系统平台的最大有符号正整数后，会取不到值。转成字符串型，解决这个bug
            if (array_key_exists($id, $result)) {
                $return[$id] = $result[$id];
            }
        }
        return $return;
    }

    /**
     * 创建一条记录
     * @param array $tableInfo 待插入的数据
     * @param boolean $isAutoIncrement 操作成功时，如果该值为true，返回最后插入的id；否则返回true
     * @return boolean | int
     */
    private function _create(array $tableInfo, $isAutoIncrement = true, $action = self::PARAM_CREATE_ACTION_INSERT) {
        if(empty($tableInfo)) return false;

        switch($action) {
            case self::PARAM_CREATE_ACTION_INSERT :
            case self::PARAM_CREATE_ACTION_INSERT_IGNORE :
            case self::PARAM_CREATE_ACTION_REPLACE :
                break;
            default:
                throw new Exception('error insert action');
        }

        $sql = "{$action} {$this->tableName}
            SET
        ";
        $sqlSets = '';
        $tableInfo = $this->quote($tableInfo);
        foreach($tableInfo as $key => $val) {
            if($sqlSets != '') $sqlSets .= ' ,';
            $sqlSets .= "
               `{$key}` = {$val}
            ";
        }
        $sql .= $sqlSets;

        if($this->db->query($sql)) {
            if($isAutoIncrement) {
                $id = $this->db->insertId();
                return $id > 0 ? $id : true;
            } else {
                return true;
            }
        }

        return false;
    }

    /**
     * 创建一条记录，如果重复，则替换
     * @param array $tableInfo 待插入的数据
     * @param boolean $isAutoIncrement 操作成功时，如果该值为true，返回最后插入的id；否则返回true
     * @return boolean | int
     */
    public function replace(array $tableInfo, $isAutoIncrement = true) {
        return $this->_create($tableInfo, $isAutoIncrement, self::PARAM_CREATE_ACTION_REPLACE);
    }

    /**
     * 创建一条记录
     * @param array $tableInfo 待插入的数据
     * @param boolean $isAutoIncrement 操作成功时，如果该值为true，返回最后插入的id；否则返回true
     * @return boolean | int
     */
    public function create(array $tableInfo, $isAutoIncrement = true) {
        return $this->_create($tableInfo, $isAutoIncrement, self::PARAM_CREATE_ACTION_INSERT);
    }

    /**
     * 创建一条记录，如果重复，则忽略
     * @param array $tableInfo 待插入的数据
     * @param boolean $isAutoIncrement 操作成功时，如果该值为true，返回最后插入的id；否则返回true
     * @return boolean | int PS：$isAutoIncrement = true时：1、如果插入了，返回自动id值；2、如果已存在，返回true。
     */
    public function insertIgnore(array $tableInfo, $isAutoIncrement = true) {
        return $this->_create($tableInfo, $isAutoIncrement, self::PARAM_CREATE_ACTION_INSERT_IGNORE);
    }

    /**
     *
     * 插入一条记录，如果重复，自动转为更新语句
     * @param array $tableInfo
     * @param array $onDuplicate 如果重复时，需要更新的信息。如果不指定，则使用$tableInfo的值，即认为要全部更新
     * @return int | Boolean
     * 		   int：只要存在，无论之前记录是否存在，都会返回记录的id；
     * 		   true：执行成功，但获取记录id时失败；
     * 		   false：执行失败
     */
    public function insertDuplicate(array $tableInfo, array $onDuplicate = array()) {
    	if (!$tableInfo) {
    		return false;
    	}
    	$tmpArrKeys = array();
		foreach ($tableInfo as $tmpKey => $tmpV) {
			$tmpArrKeys[] = "`{$tmpKey}`";
		}
		$sql = "INSERT INTO {$this->tableName} (" . join(', ', $tmpArrKeys). ") VALUES ";

        $tmpArrValues = array();
        $new_tableInfo = $this->quote($tableInfo);
        foreach ($new_tableInfo as $tmpKey => $tmpV) {
			$tmpArrValues[] = $tmpV;
        }
        $sql .= " ( " . join(', ', $tmpArrValues) . " ) ";

        $sql .= "
            ON DUPLICATE KEY UPDATE
        ";
        $tmpArrDps = array();
        if (empty($onDuplicate)) {
        	$onDuplicate = $tableInfo;
        }

        $new_onDuplicate = $this->quote($onDuplicate);
		foreach ($new_onDuplicate as $tmpKey => $tmpV) {
			$tmpArrDps[] = " `{$tmpKey}` = {$tmpV} ";
		}
		$sql .= join(', ', $tmpArrDps);

		if (!$this->db->query($sql)) {
			return false;
		}

		$id = $this->db->insertId();
        return $id > 0 ? $id : true;
    }

    /**
     * 根据条件更新指定数据
     * @param array $tableInfo 待更新的数据（与数据库字段对应的数据）
     * @param array $condition 条件（与数据库字段对应的数据）
     * @return boolean
     */
    public function update(array $tableInfo, array $condition) {
        if(empty($tableInfo)) return false;

        $sql = "UPDATE {$this->tableName}
            SET
        ";
        $sqlSets = '';
        foreach($tableInfo as $key => $val) {
            if($sqlSets != '') $sqlSets .= ' ,';
            $sqlSets .= "
               `{$key}` = {$this->quote($val)}
            ";
        }
        $sql .= $sqlSets;

        $where = $this->parseCondition($condition);
        $sql .= "
            {$where}
            ;
        ";

        return $this->db->query($sql);
    }

    /**
     * 根据条件删除数据
     * @param Array $condition 条件
     * @return boolean
     */
    public function delete(array $condition) {
        $where = $this->parseCondition($condition);

        $sql = "DELETE FROM {$this->tableName}
            {$where}
            ;
        ";
        return $this->db->query($sql);
    }

    /**
     * 转义数据
     * @param mixed $data
     */
    public function quote($data) {
        return SqlHelper::escape($data, true);
    }

    /**
     * 判断给定的值是否是有效的自增主键值
     * @param mixid $pk
     * @return boolean
     */
    static protected function isValidPK($pk) {
        return SqlHelper::isValidPK($pk);
    }

    /**
     * 判断给定数组的某个key的值，是否是有效的自增主键值
     * @param array $arr
     * @param mixid $key
     * @return boolean
     */
    static protected function isValidPKWithArray(array $arr, $key) {
        return SqlHelper::isValidPKWithArray($arr, $key);
    }

    /**
     * 获取某个表里记录的数量
     * @return false | int
     */
    public function totals(){
        $result = $this->findBy(null, null, null, "count(*)");
        if (!$result) {
            return false;
        }
        return array_pop(array_pop($result));
    }
}