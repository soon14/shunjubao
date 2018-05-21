<?php
/**
 * 
 * 用户出票日志后端类
 * @author Administrator
 *
 */
class UserTicketLog extends DBSpeedyPattern {
	
	protected $tableName = 'user_ticket_log10';
	protected $primaryKey = 'id';
	
	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
    	'u_id',
    	'sport',//体育类型		fb|bk
    	'pool',//玩法		hhad|had|….
		'select',//	串关		2x1|3x1|….
		'multiple',//	投注倍数		
		'money',//	投注总金额		
		'datetime',//	投注时间		
		'combination',//	投注选项		玩法|比赛id|选项&选项;玩法|比赛id|选项&选项;
		'odds',//	投注赔率		
		'return_time',//	预计反馈时间		
		'results',//	彩果		彩果;彩果
		'prize_state',//	中奖状态		0 未开奖 1 中奖 2 未中奖 
		'prize',//	总派奖金额		
		'print_state',//	出票状态		0 未出票 1 已出票 2 部分出票 3 出票失败
		'print_time',//	出票时间		
    	'return_id',//	投注流水id	
    	'return_code',//	接口返回码		
		'rerurn_code',//	接口返回说明	:按状态区分 1）投注失败时表示错误原因；2）出票成功时表示体彩中心票号
		'ticket_id',//	出票对应id		
    	'company_id',//出票公司id
	'return_str',
    );
	
    /**
     * 
     * 用户账户记录日志构造函数，表的尾数为用户id的最后一位
     * @param int $last_id
     */
	public function __construct($u_id) {
		$last_id = getUidLastNumber($u_id);
    	$this->tableName = $this->tableName . $last_id;
    	parent::__construct();
    }
   
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		return parent::findBy($condition , null, $limit, '*', $order);
    }
}
?>
