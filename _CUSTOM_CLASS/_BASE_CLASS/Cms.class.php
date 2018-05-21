<?php
/**
 *
 * 后台cms功能操作类
 * @author gaoxiaogang@gmail.com
 *
 */
class Cms extends DBSpeedyPattern {
	protected $tableName = 'cms';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'u_id',
    	'extend',
    	'type',
    	'batch',
    	'create_time',
    	'start_time',
    	'end_time'
    );
    
    /**
     * 推荐类型:付费推荐
     * @var int
     */
    const TYPE_PAY		= '1';
    
    static private $cmsTypeDesc = array(
    	self::TYPE_PAY => array(
    		'desc'			=> '付费推荐',
    		'kw'			=> 'TYPE_PAY',
    		'type'			=>	self::TYPE_PAY,
    	),
    );
    
    /**
     * 获取所有CMS描述
     * @return array
     */
    static public function getCmsTypeDesc() {
    	return self::$cmsTypeDesc;
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
    
    /**
     * 按条件获取信息
     * @param array $condition
     * @return array | false
     */
    public function getsByCondition($condition, $limit  = null, $order = 'create_time asc') {
    	$ids = $this->findIdsBy($condition, $limit, $order);
    	return $this->gets($ids);
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
    
    /**
     * 获取已上传推荐的最后一期，即batch的最大值
     * @return int
     */
    public function getLastBatch() {
    	$sql = 'select max(batch) from '. $this->tableName . ' where 1';
    	return $this->db->fetchSclare($sql);;
    }
    
    public function modify($info, $condition = null, $cas_token = null) {
	    $info = parent::parseExtend($info);
    	return parent::modify($info, $condition, $cas_token);
    }
}