<?php
/**
 * 用户中奖排行
 * sql中的total_prize指的是当前期的中奖和
 */
class PrizeRankFront extends DBSpeedyPattern {
	protected $tableName = 'prize_rank';
	protected $primaryKey;
	protected $real_field = array(
			'id',
			'u_id',// int(10) NOT NULL,
			'rank',// int(10) NOT NULL COMMENT '排名',
			'type',// tinyint(3) NOT NULL COMMENT '排名类型：按月或周',
			'up_down',//INT(10) NOT NULL COMMENT '排名升降数' AFTER `type`;
			'create_time',// varchar(20) COLLATE latin1_general_ci NOT NULL,
			'prize',// float(10,2) NOT NULL,
			'issue',//INT(5) NOT NULL COMMENT '期次'
	);
	
	/**
	 * 全体用户周排行
	 */
	const RANK_TYPE_ALLUSERS_WEEK = 1;
	/**
	 * 全体用户月排行
	 */
	const RANK_TYPE_ALLUSERS_MONTH = 2;
	/**
	 * 跟单用户周排行
	 */
	const RANK_TYPE_FOLLOWUSERS_WEEK = 3;
	/**
	 * 跟单用户月排行
	 */
	const RANK_TYPE_FOLLOWUSERS_MONTH = 4;
	
	/**
	 * 网站总排行
	 * type为5时的issue为0
	 */
	const RANK_TYPE_ALL_USERS = 5;
	
	/**
	 * 网站跟单总排行
	 * type为6时的issue为0
	 */
	const RANK_TYPE_ALL_FOLLOW_USERS = 6;
	
	/**
	 * 中奖用户累计统计的memkey
	 */
	const TOTAL_PRIZE_MEMKEY = 'total_prize_memkey';
	
	/**
	 * 第一周第一秒:2014-11-24
	 * 从这一秒开始的周，期数为1
	 */
	const FIRST_SECOND_WEEK = '1416758400';
	
	/**
	 * 第一月第一秒:2014-11-01
	 * 从这一秒开始的月，期数为1
	 */
	const FIRST_SECOND_MONTH = '1414771200';
	
	//周、月排行的数据读取规则：1、先找到当前的期数；2、查找当前期数是否有排行；3、若没有
	/**
	 * 获取当前期数
	 * @param boolean $isweek true时指的是周期数，false时指的是月期数
	 * @return int $issue
	 */
	public function getCurrentIssue($isweek = true) {
		if ($isweek) {
			return ceil((time() - self::FIRST_SECOND_WEEK)/(7*86400));
		}
		#TODO，直接用30除的结果并不精确
		return ceil((time() - self::FIRST_SECOND_MONTH)/(30*86400));
	}
	
	public function getCurrentIssueByType($type) {
		switch ($type) {
			case self::RANK_TYPE_ALLUSERS_WEEK:
				$currentIssue = $this->getCurrentIssue();
				break;
			case self::RANK_TYPE_ALLUSERS_MONTH:
				$currentIssue = $this->getCurrentIssue(false);
				break;
			case self::RANK_TYPE_FOLLOWUSERS_WEEK:
				$currentIssue = $this->getCurrentIssue();
				break;
			case self::RANK_TYPE_FOLLOWUSERS_MONTH:
				$currentIssue = $this->getCurrentIssue(false);
				break;
			default:
				$currentIssue = 0;
		}
		return $currentIssue;
	}
	
	/**
	 * 删除指定期数和类型的排行
	 * @param int $issue 
	 * @param int $type
	 * @return boolean
	 */
	public function deletePaiHang($issue, $type) {
		$condition = array();
		$condition['type'] = $type;
		if ($issue) {
			$condition['issue'] = $issue;
		}
		return $this->delete($condition);
	}
	
	/**
	 * 获取全体用户周排行
	 * 不存在时添加，存在时更新
	 * @return boolean
	 */
	public function addAllUsersWeek() {
		return $this->addPaihang(self::RANK_TYPE_ALLUSERS_WEEK);
	}
	
	/**
	 * 获取全体用户月排行
	 * 不存在时添加，存在时更新
	 * @return boolean
	 */
	public function addAllUsersMonth() {
		return $this->addPaihang(self::RANK_TYPE_ALLUSERS_MONTH);
	}
	
	/**
	 * 获取跟单用户周排行
	 * 不存在时添加，存在时更新
	 * @return boolean
	 */
	public function addFollowUsersWeek() {
		return $this->addPaihang(self::RANK_TYPE_FOLLOWUSERS_WEEK);
	}
	
	/**
	 * 获取跟单用户月排行
	 * 不存在时添加，存在时更新
	 * @return boolean
	 */
	public function addFollowUsersMonth() {
		return $this->addPaihang(self::RANK_TYPE_FOLLOWUSERS_MONTH);
	}
	
	/**
	 * 中奖总排行
	 */
	public function getAllUsers() {
		return $this->addPaihang(self::RANK_TYPE_ALL_USERS);
	}
	
	/**
	 * 中奖总排行
	 */
	public function getAllFollowUsers() {
		return $this->addPaihang(self::RANK_TYPE_ALL_FOLLOW_USERS);
	}
	
	/**
	 * 添加某个排行榜
	 */
	public function addPaihang($type) {
		
		$end_time = getCurrentDate();
	
		switch ($type) {
			case self::RANK_TYPE_ALLUSERS_WEEK:
				$currentIssue = $this->getCurrentIssue();
				$days = 7;
				$start_time = date('Y-m-d H:i:s', $days*86400*($currentIssue-1)+self::FIRST_SECOND_WEEK);
				$other_condition = " and `datetime`>='{$start_time}' and `datetime`<='{$end_time}'";
				break;
			case self::RANK_TYPE_ALLUSERS_MONTH:
				$currentIssue = $this->getCurrentIssue(false);
				$days = 30;
				$start_time = date('Y-m-d H:i:s', $days*86400*($currentIssue-1)+self::FIRST_SECOND_MONTH);
				$other_condition = " and `datetime`>='{$start_time}' and `datetime`<='{$end_time}'";
				break;
			case self::RANK_TYPE_FOLLOWUSERS_WEEK:
				$currentIssue = $this->getCurrentIssue();
				$days = 7;
				$start_time = date('Y-m-d H:i:s', $days*86400*($currentIssue-1)+self::FIRST_SECOND_WEEK);
				$other_condition = " and `datetime`>='{$start_time}' and `datetime`<='{$end_time}' and `partent_id`<>0 ";
				break;
			case self::RANK_TYPE_FOLLOWUSERS_MONTH:
				$currentIssue = $this->getCurrentIssue(false);
				$days = 30;
				$start_time = date('Y-m-d H:i:s', $days*86400*($currentIssue-1)+self::FIRST_SECOND_MONTH);
				$other_condition = " and `datetime`>='{$start_time}' and `datetime`<='{$end_time}' and `partent_id`<>0 ";
				break;
			case self::RANK_TYPE_ALL_USERS:
				$currentIssue = 0;
				$start_time = '2014-05-01';
				$other_condition = '';
				break;
			case self::RANK_TYPE_ALL_FOLLOW_USERS:
				$currentIssue = 0;
				$start_time = '2014-05-01';
				$other_condition = ' and `partent_id`<>0 ';
				break;
		}
		
		$order = " total_prize desc ";
		$step = 100;
		$offset = 0;
		//排行位置
		$rank = 1;
		
		//是否存在当前期排行
		$condition = array();
		$condition['issue'] = $currentIssue;
		$condition['type'] = $type;
		
		$this->deletePaiHang($currentIssue, $type);
		
		do{
		
			$limit = "{$offset},{$step}";
			$orher_id = " and u_id not in(17616,17618,17619,17620,17622,17623,17624,237,17615,17617,17621,17414,17633,17642,17643,1199,3083,3086,14777,3085)";
				
			$sql = "select u_id , sum(prize) as total_prize from `user_ticket_all` where `prize_state`=".UserTicketAll::PRIZE_STATE_WIN ."  {$other_condition}  $orher_id  group by u_id order by {$order} limit {$limit}";
			
			$results = $this->db->fetchAll($sql);
			if (!$results) {
				break;
			}
			
			foreach ($results as $result) {
		
				$info = array();
				$info['u_id'] = $result['u_id'];
				$info['type'] = $type;
				$info['issue'] = $currentIssue;
				$info['prize'] = $result['total_prize'];
				$info['rank'] = $rank;
				$info['up_down'] = $this->getUpAndDown($result['u_id'], $type, $currentIssue, $rank);
				$info['create_time'] = getCurrentDate();
		
				$id = $this->add($info);
				$rank++;
			}
			$offset += $step;
			sleep(1);
		}while (true);
		
		return true;
	}
	
	/**
	 * 获取升降排行数
	 * @param int $u_id
	 * @param int $issue 当前期
	 * @param int $rank 当前排行
	 * @return int $up_down 正数表示上升，负数表示下降
	 */
	public function getUpAndDown($u_id, $type, $issue, $rank) {
		//总排行没有升降数
		if ($issue == 0) {
			return 0;
		}
		//上期的排行信息
		$condition = array();
		$condition['u_id'] = $u_id;
		$condition['issue'] = $issue - 1;
		$condition['type'] = $type;
		$last_info = $this->fetchOne($condition);
		if (!$last_info) {
			return $rank;
		}
		
		return $last_info['rank'] - $rank;
	}
	
	/**
	 * 更新所有榜单
	 */
	public function updateALLRank() {
		$this->addAllUsersWeek();
		$this->addAllUsersMonth();
		$this->addFollowUsersWeek();
		$this->addFollowUsersMonth();
		$this->getAllUsers();
		$this->getAllFollowUsers();
	}
	
}
