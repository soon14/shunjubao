<?php
/**
 * 用户票操作记录表
 */
class UserTicketOperate extends DBSpeedyPattern {
	protected $tableName = 'user_ticket_operate';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
		'id',// int(10) NOT NULL AUTO_INCREMENT,
  		'type',// tinyint(3) NOT NULL COMMENT '操作类型',
  		'operate_uid',// int(10) NOT NULL,
  		'operate_uname',// varchar(80) COLLATE latin1_general_ci NOT NULL,
  		'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
  		'user_ticket_id',// int(10) NOT NULL COMMENT '用户票id',
		'datetime',//varchar(20) COLLATE latin1_general_ci NOT NULL,
  		'money',// float(10,2) NOT NULL COMMENT '用户票金额',
		'prize',// float(10,2) NOT NULL COMMENT '用户票奖金',
	);
	
	/**
	 * 操作类型之人工出票
	 */
	CONST TYPE_MANUL_TICKET = 1;
	
	/**
	 * 操作类型之手动返奖
	 */
	CONST TYPE_MANUL_PRIZE = 2;
	
	/**
	 * 操作类型之退票
	 */
	CONST TYPE_REFUND_TICKET = 3;
	
	/**
	 * 操作类型之聚宝出票
	 */
	CONST TYPE_ZHIYING_TICKET = 4;
	
	static public function getTypeDesc() {
		return array(
				self::TYPE_ZHIYING_TICKET => array(
						'desc' => '聚宝出票',
				),
				self::TYPE_REFUND_TICKET => array(
						'desc' => '退票',
				),
				self::TYPE_MANUL_PRIZE => array(
					'desc' => '手动返奖',
				),
				self::TYPE_MANUL_TICKET => array(
						'desc' => '人工出票',
				),
		);
	}
	
	/**
	 * 固定的出票操作人组，uid=>uname
	 * @return array
	 */
	static public function getOperateUnames() {
		return array(
				'6780' => '安徽赵凯',
				'6781' => '安徽老杨',
				'6782' => '福州大砖',
				'6783' => '福州晓飞',
				'6784' => '唐山荆豪',
				'8163' => '秦皇岛',
				'8162' => '唐山',
				'8634'	=> '苏州出票',
				'8635'	=> '安徽出票',
				'13152'	=> '河北保定',
				'15160'	=> '山东',
		);
	}
	
	public function add($info) {
		$info['create_time'] = getCurrentDate();
		if (!$info['operate_uid']) $info['operate_uid'] = Runtime::getUid();
		if (!$info['operate_uname']) $info['operate_uname'] = Runtime::getUname();
		return parent::add($info);
	}
	
	public function getTotalByCondition($start, $end, $field, $operate_uname, $type) {
		 $sql = "select sum(`prize`) as total_prize,sum(`money`) as total_money from ".$this->tableName . " where `{$field}`>='{$start}' and `{$field}`<='{$end}' and `operate_uname`='{$operate_uname}' and `type`={$type} ";
		$res = $this->db->fetchOne($sql);
		return $res;
	}
	
	
	public function getTotalByCondition2($start, $end, $field, $operate_uname, $type) {
		$sql = "select * from ".$this->tableName . " where `{$field}`>='{$start}' and `{$field}`<='{$end}' and `operate_uname`='{$operate_uname}' and `type`={$type} ";
		$results = $this->db->fetchAll($sql);
		foreach ($results as $value) {
			$ids[] = $value['user_ticket_id'];
		}
		if(!empty($ids)){
			$all_ids = implode(",",$ids);
			$sql = "select sum(`prize`) as total_prize,sum(`money`) as total_money  from  user_ticket_all where id in (".$all_ids.")";
			$res = $this->db->fetchOne($sql);
		}
		
		return $res;
	
	}
	
	
	
}