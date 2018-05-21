<?php
/**
 * 数据库操作的敏捷模式抽象类
 * 目的：统一数据库表的设计模式，为 增、删、改 提供便捷
 * PS: 通过 cas_token 字段，提供冲突检测机制（乐观锁），保证高并发下的数据安全
 *     这是模仿自 php 的 Memcached 扩展，非常好的功能，故借鉴过来
 *     cas_token已经移除
 * @author gaoxiaogang@yoka.com
 *
 */
abstract class DBSpeedyPattern extends DBAbstract {

    /**
     * 数据库里的真实字段
     * 这个实例变量的值是自动计算出来的
     * @var array
     */
    protected $real_field;
    
	protected $tableName;
	
    public function __construct($master_flag = 'default') {
    	parent::__construct($master_flag);
//    	$this->real_field = $this->other_field;
    }

    /**
     *
     * 添加一条记录
     * @param array $info
     * @param string $actionType 动态类型，这个参数控制以下行为中的一种： create、replace、insertIgnore
     *
     * ## 当$actionType的值为parent::PARAM_CREATE_ACTION_ONDUPLICATE时，该值才有意义。##
     * @param array $onDuplicate 如果重复时，需要更新的信息。如果不指定，则使用$tableInfo的值，即认为要全部更新
     * ##
     *
     * @throws ParamsException actionType 参数非法
     * @return int | boolean
     */
    public function add(array $info, $actionType = parent::PARAM_CREATE_ACTION_INSERT, array $onDuplicate = array()) {

        foreach ($info as $tmpK => $tmpV) {
            if (!in_array($tmpK, $this->real_field)) {
                unset($info[$tmpK]);
            }
        }
        $tableInfo = $info;
        
        switch ($actionType) {
        	case parent::PARAM_CREATE_ACTION_INSERT:
				$id = $this->create($tableInfo);
        		break;
        	case parent::PARAM_CREATE_ACTION_INSERT_IGNORE:
				$id = $this->insertIgnore($tableInfo);
        		break;
        	case parent::PARAM_CREATE_ACTION_REPLACE:
				$id = $this->replace($tableInfo);
        		break;
        	case parent::PARAM_CREATE_ACTION_ONDUPLICATE:
        		if (empty($onDuplicate)) {
        			$onDuplicate = $tableInfo;
        		} else {
			        foreach ($onDuplicate as $tmpK => $tmpV) {
			            if (!in_array($tmpK, $this->real_field)) {
			                unset($onDuplicate[$tmpK]);
			            }
			        }
        		}

        		$id = $this->insertDuplicate($tableInfo, $onDuplicate);
        		break;
        	default:
        		throw new ParamsException("invalid actionType");
        }

        return $id;
    }

    /**
     * 修改
     * !!!!!!
     * !!! $cas_token 提供了一种“检查并修改”机制，非常重要的优势， 在这样一个冲突检测机制（乐观锁）下， 我们才能保证高并发下的数据安全。
     * !!!!!!
     * 注：$info 或 $condition 里，一定要有一个指定 key 为 $this->primaryKey 对应的值
     * @param array $info
     * @param array $condition 条件
     * @param int $cas_token 如果$cas_token不为null，会执行一个“检查并修改”的操作。因此，仅当 $cas_token 与数据库里的值一致时，才会修改记录。
     * @return InternalResultTransfer 成功：修改并影响到了记录；
     * 	       失败：数据里含失败描述。
     * 		   另：cas_token检查不通过时，返回'CAS_TOKEN_NOT_MATCH'。这个返回值并不是严格意义上的正确，当$condition指定了条件，并且未匹配时，
     * 		   也会返回这个值。
     */
    public function modify(array $info, array $condition = null, $cas_token = null) {
        if (!isset($info[$this->primaryKey])) {
        	if (!isset($condition[$this->primaryKey])) {
				return InternalResultTransfer::fail("请指定要修改的记录");
        	}
            $info[$this->primaryKey] = $condition[$this->primaryKey];
        }
        if (!Verify::unsignedInt($info[$this->primaryKey])) {
            return InternalResultTransfer::fail("请指定有效的记录");
        }
        if (!isset($condition)) {
        	$condition = array();
        }

        $useMasterFlag = $this->db->beginUseMaster();
        $oldSpecialSale = parent::get($info[$this->primaryKey]);
        $this->db->restore($useMasterFlag);
        if (!$oldSpecialSale) {
            return InternalResultTransfer::fail("不存在的记录:{$info[$this->primaryKey]}");
        }
        
        foreach ($info as $tmpK => $tmpV) {
            if (!in_array($tmpK, $this->real_field)) {
                unset($info[$tmpK]);
            }
        }

        $tableInfo = $info;

        $condition[$this->primaryKey] = $info[$this->primaryKey];

        $result = $this->update($tableInfo, $condition);
        if (!$result) {
            return InternalResultTransfer::fail("数据库update操作失败");
        }

        $affectedRows = $this->db->affectedRows();
        if (!Verify::unsignedInt($affectedRows)) {
        	return InternalResultTransfer::success();//由于目前的数据库无update_time，因此无数据更新时仍然算更新成功
//        	return InternalResultTransfer::fail("NOT_AFFECTED_ROWS");
        }

        return InternalResultTransfer::success();
    }

    /**
     * 获取一条记录
     * @param int $id 记录id
     * @param int $cas_token 引用传值，默认为 null
     * @return false | array
     */
    public function get($id, & $cas_token = null) {
        if (!Verify::unsignedInt($id)) {
            return false;
        }

        $result = $this->gets(array($id));
        if (!$result) {
            return false;
        }

        $tmpResult = array_pop($result);
        return $tmpResult;
    }

    /**
     * 获取一批记录
     * @param array $ids 记录id集
     * @param array $cas_tokens 引用传值，默认为 null
     * @return false | array
     */
    public function gets(array $ids, array & $cas_tokens = null) {
        $result = parent::gets($ids);
        if (!$result) {
            return array();
        }       
		
        return $result;
    }

    /**
     *
     * 获取所有id集
     * @param string $order
     * @param mixed $limit
     * @return array
     */
    public function getsIdsAll($order = null, $limit = null) {
		$ids = parent::getsAllIds($order, $limit);
		return $ids;
    }
	
    /**
     * 解析extend字段，使之序列化
     * @param array $info
     * @return array $info
     */
    public function parseExtend($info) {
    	if (!is_array($info)) {
    		return $info;
    	}
    	
    	$extend = array();
    	# 找出待更新的扩展字段
        foreach ($info as $tmpK => $tmpV) {
            if (!in_array($tmpK, $this->real_field)) {
            	$extend[$tmpK] = $tmpV;
                unset($info[$tmpK]);
            }
            #待转换的信息里不能有extend字段
            if ($tmpK == 'extend') {
            	return false;
            }
        }
        $info['extend'] = serialize($extend);
    	return $info;
    } 
    
     /**
     * 解析extend字段，使之反序列化
     * @param array $info
     * @return array $info
     */
    public function UnparseExtend($info) {
    	if (!is_array($info)) {
    		return $info;
    	}
    	
    	if (!array_key_exists('extend', $info)) {
    		return $info;
    	}
    	
		$extend = array();
    	# 找出待更新的扩展字段
    	$extend = unserialize($info['extend']);
    	unset($info['extend']);
    	
        # 将存在扩展字段里的信息提出来
        foreach ($extend as $tmpK => $tmpV) {
            if (!in_array($tmpK, $this->real_field)) {
                  $info[$tmpK] = $tmpV;
             }
         }
        
    	return $info;
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
}