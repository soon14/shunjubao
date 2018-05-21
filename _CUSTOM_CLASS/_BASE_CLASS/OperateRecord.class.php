<?php
/**
 *
 * 后台操作日志类
 * @author lishuming@gaojie100.com
 *
 */
class OperateRecord extends DBSpeedyPattern{
	
	protected $tableName = 'operate_record';
	
	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'type',
        'o_uid',
    	'o_uname',
    	'extend',
    	'create_time',
    );

    /**
     *  添加余额
     *  @var int
     */
    const OPTYPE_ADD_CASH = 1;
    
    /**
     * 添加彩金
     * @var int
     */
    CONST OPTYPE_ADD_GIFT = 2;
    
    /**
     * 修改密码
     * @var int
     */
    CONST OPTYPE_MODIFY_PWD = 3;
    
    /**
     * 添加积分
     * @var int
     */
    CONST OPTYPE_ADD_SCORE = 4;
	
	
	/**
     * 扣除余额
     * @var int
     */
	CONST OPTYPE_COMSUME_CASH = 5;
	CONST OPTYPE_COMSUME_GIFT = 6;
	CONST OPTYPE_COMSUME_SCORE = 7;
    
    /**
     * 
     * @var unknown
     */
    static private $typeDesc = array(
    		self::OPTYPE_ADD_CASH			=> '添加余额',
    		self::OPTYPE_ADD_GIFT			=> '添加彩金',
    		self::OPTYPE_MODIFY_PWD			=> '修改密码',
    		self::OPTYPE_ADD_SCORE			=> '添加积分',
			self::OPTYPE_COMSUME_CASH		=> '扣除余额',
			self::OPTYPE_COMSUME_GIFT		=> '扣除彩金',
			self::OPTYPE_COMSUME_SCORE		=> '扣除积分',	
    );
    
    /**
     * 获取所有操作描述
     * @return array
    */
    static public function getTypeDesc() {
    	return self::$typeDesc;
    }
        
    /**
     * 创建一个推荐cms
     * @param array $info
     * @return int or false
     */
    public function add($info) {
    	$info = parent::parseExtend($info);
    	if (!$info) {
    		return false;
    	}
    	return parent::add($info);
    }
    
    public function get($id) {
    	$tmpResult = $this->gets(array($id));
    	if (!$tmpResult) {
    		return false;
    	}
    
    	return array_pop($tmpResult);
    }
    
    public function gets($ids) {
    	$result = parent::gets($ids);
    	foreach ($result as & $tmpV) {
    		$tmpExtend = array();
    		$tmpExtend = unserialize($tmpV['extend']);
    		unset($tmpV['extend']);
    
    		# 将存在扩展字段里的信息提出来
    		if (is_array($tmpExtend)) foreach ($tmpExtend as $tmpKK => $tmpVV) {
	    		if (!in_array($tmpKK, $this->real_field)) {
	    			$tmpV[$tmpKK] = $tmpVV;
	    		}
    		}
    	}
    		return $result;
    }
    
    public function modify($info, $condition = null) {
	    $info = parent::parseExtend($info);
	    return parent::modify($info, $condition, $cas_token = null);
    }
    
    public function getNum($start, $end, $type) {
    	$type == 'all'?
    	$sql = "select count(*) as num from ".$this->tableName . " where `create_time`>='{$start}' and `create_time`<='{$end}' ":
    	$sql = "select count(*) as num from ".$this->tableName . " where `create_time`>='{$start}' and `create_time`<='{$end}' and `type`={$type}";
    	$res = $this->db->fetchOne($sql);
    	return $res['num'];
    }
}