<?php
/**
 * 晒单类
 * 控制晒单中心的基本类
 * @author hushiyu
 *
 */
class ShowTicketFront extends DBSpeedyPattern {
	protected $tableName = 'show_ticket';
	protected $primaryKey = 'id';
	/**
	 * 数据库里的真实字段
	 * @var array
	 */
	protected $real_field = array(
		'id',// int(10) NOT NULL AUTO_INCREMENT,
		'ticket_id',// int(10) NOT NULL COMMENT '订单id',
		'u_id',// int(10) NOT NULL,
		'u_name',// varchar(40) COLLATE latin1_general_ci NOT NULL,
		'money',// float(10,2) NOT NULL COMMENT '订单金额',
		'status',// tinyint(3) NOT NULL COMMENT '状态：上下架',
		'sorder',// int(5) NOT NULL COMMENT '排序',
		'datetime',// varchar(20) COLLATE latin1_general_ci NOT NULL COMMENT '下单时间',
		'start_time',// int(11) NOT NULL COMMENT '晒单开始时间',
		'end_time',// int(11) NOT NULL COMMENT '晒单截止时间',
		'create_time',// int(11) NOT NULL COMMENT '记录创建时间',
		'click',// int(10) NOT NULL COMMENT '页面点击次数',
		'comment_num',// int(10) NOT NULL COMMENT '评论次数',
	);
	//上架
	CONST SHOW_STATUS_UP = 1;
	//下架
	CONST SHOW_STATUS_DOWN = 2;
	
	/**
	 * 订单上架，支持批量操作
	 * @param mixed $ticket_id
	 * @return boolean
	 */
	public function updateStatusToUP($ticket_id) {
		if (!is_array($ticket_id)) {
			$ticket_id = array($ticket_id);
		}
		return $this->update(array('status'=>self::SHOW_STATUS_UP), array('ticket_id'=>$ticket_id));
	}
	
	/**
	 * 订单下架，支持批量操作
	 * @param mixed $ticket_id
	 * @return boolean
	 */
	public function updateStatusToDOWN($ticket_id) {
		if (!is_array($ticket_id)) {
			$ticket_id = array($ticket_id);
		}
		return $this->update(array('status'=>self::SHOW_STATUS_DOWN), array('ticket_id'=>$ticket_id));
	}
	
	/**
	 * 订单排序
	 * @param array $ticket_orders = array(ticket_id_1=>1,ticket_id_2=>2...)
	 * @return InternalResultTransfer
	 */
	public function updateTicketOrders($ticket_orders) {
		if (!is_array($ticket_orders)) {
			return InternalResultTransfer::fail('paramters wrong');
		}
		$flag = array();
		foreach ($ticket_orders as $ticket_id=>$order) {
			$result = $this->update(array('sorder'=>$order), array('ticket_id'=>$ticket_id));
			if (!$result) {
				$flag[] = $ticket_id;
			}
		}
		if ($flag) {
			return InternalResultTransfer::fail('update not complete,ticket_id:'.implode(',', $flag));
		}
		return InternalResultTransfer::success();
	}
	
}