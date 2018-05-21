<?php
/**
 *
 * 自动增量索引配置处理类
 * @author gxg
 *
 */
class AutoIncrIndexConfig extends DBSpeedyPattern {
	protected $tableName = 'auto_incr_index_config';

	protected $other_field = array(
		'prev_update_time',
		'who',
	);

	public function getsByWho($who) {
		if (empty($who)) {
			$who = '';
		}
		$condition = array(
			'who'	=> $who,
		);
		$ids = $this->findIdsBy($condition);
		return $this->gets($ids);
	}

	/**
	 * 增加一条配置
	 * @param array $info 格式：array(
	 * 'src_table'	=> '',//（必填）。源表
	 * 'dst_table'	=> '',//（必填）。目标表
	 * 'src_class'	=> '',//（必填）。驱动源表的类名称（_BASE_CLASS里的类）
	 * 'dst_class'	=> '',//（必填）。驱动目标表的类名称（_BASE_CLASS里的类）
	 * 'field_relation'	=> array(
	 *     '源表字段同'	=> '对应的目标表字段',
	 *     ... ,
	 * ),// （必填）。源表到目标表的字段对应关系
	 *
	 * 'who'	=> '',//（选填）。这个配置由哪个后台脚本处理。有一个公用的脚本处理所有不指定who的配置。
	 * 'condition'	=> array(
	 *     'status'	=> Order::STATUS_WAIT_SHIPMENT,
	 *     'consignerId'	=> 2,
	 * ),//（选填）。从源表获取数据的条件（会自动使用update_time作查询和排序条件，这里的条件是除update_time外的附加条件）
	 *
	 * @see DBSpeedyPattern::add()
	 * @return int | boolean
	 */
	public function add(array $info) {
		$info['prev_update_time'] = 0;
		return parent::add($info);
	}

	public function getsAll(){
		$ids = $this->getsIdsAll();
		return $this->gets($ids);
	}

	public function get(array $id){
		return $this->gets($id);
	}

    public function modify(array $info, $cas_token = null) {
    	return parent::modify($info, null, $cas_token);
    }

    /**
     * 检查自动增量索引配置填写是否真确
     * @param array
     */
    public function checkField(array $tableInfo){
		$dst_class = $tableInfo['dst_class'];
		$dst_table = $tableInfo['dst_table'];
		$field = '';
		foreach($tableInfo['field'] as $key =>$value){
			if($key%2 != 0){
				if($field != '') {$field .= ','; $val .=',';}
				$field .= $value;
				$val .= 0;
			}
		}
		$transId = $this->db->startTransaction();//开启事务

		$count = count($tableInfo['field']) / 2;

		if(!class_exists($dst_class)){
			return false;
		}
		$object = new $dst_class();

		$sql = "INSERT INTO `{$dst_table}` ($field) VALUES ($val)";

		$object->db->debug_level = 0;
    	$result = $object->db->query($sql);

    	$this->db->rollback($transId);

    	if($result){
    		return true;
    	}

    }

}