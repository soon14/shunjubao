<?php
/**
 * 彩果表
 * @author administrator
 *
 */
class PoolResultBD extends DBSpeedyPattern {
	protected $tableName = 'bd_poolresult';
	protected $primaryKey = 'id';
    /**
     * 数据库里的真实字段
     * @var array
     */
    protected $real_field = array(
    	'id',
	    'matchid',//赛事id
	    'lotteryId',//玩法代码
	    'value',//比赛结果,足球赛果用’,’分隔,
	   	 		//半场主队进球数, 半场客队进球数,全场主队进球数,全场客队进球数;
	   	 		//单场过关结果 胜 表示主胜;负 表示主负
	    'sp',//北单:胜平负开奖 sp,进球数开奖 sp,上下单双开奖 sp 值,比分开奖 sp,半全场开奖 sp
	    	//单场过关:开奖 sp 值
	    'issueNumber',//期数
	    'remark',//让球数，胜平负时使用
	    'datetime',//更新时间
    	'combination',//平台彩果代码
	    'combination_game',//平台赛果代码
    );

    public function __construct() {
    	$lottery_codes = ZunAoTicketClient::getAllLottery();//把玩法代码加入realfield
    	parent::__construct();
    }
    
	public function getsByCondition(array $condition, $limit = null, $order = null) {
		$ids = $this->findIdsBy($condition , null, $limit, '*', $order);
    	return $this->gets($ids);
    }
    
    /**
     * @desc 通过玩法和赛果值获取赛果的平台代码
     * @param string $lotteryId
     * @param string $value 接口返回的比赛结果
     * @param int $remark 让球数，生平负时使用
     * @return string $combination
     */
    static public function getCombinationByValue($lotteryId, $value, $remark = 0) {
    	$combination = '';
    	$match_value_string = $value;
    	$match_value_array = explode(',', $match_value_string);
    	
    	$home_goal = $match_value_array[2];
    	$guest_goal = $match_value_array[3];
    	
    	switch ($lotteryId) {
    		case ZunAoTicketClient::LOTTERY_CODE_SPF:
    			if ($remark) {
    				$home_goal += $remark;
    			}
    			if ($home_goal > $guest_goal) {
    				$combination = 'h';
    			}
    			if ($home_goal == $guest_goal) {
    				$combination = 'd';
    			}
    			if ($home_goal < $guest_goal) {
    				$combination = 'a';
    			}
    			
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_SF:
    			if ($match_value_string == '胜') {
    				$combination = 'h';
    			}
    			if ($match_value_string == '负') {
    				$combination = 'a';
    			}
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_BQC:
    			$home_goal_half = $match_value_array[0];
    			$guest_goal_half = $match_value_array[1];
    			if ($home_goal_half > $guest_goal_half) {
    				$combination = 'h';
    			}
    			if ($home_goal_half == $guest_goal_half) {
    				$combination = 'd';
    			}
    			if ($home_goal_half < $guest_goal_half) {
    				$combination = 'a';
    			}
    			if ($home_goal > $guest_goal) {
    				$combination .= 'h';
    			}
    			if ($home_goal == $guest_goal) {
    				$combination .= 'd';
    			}
    			if ($home_goal < $guest_goal) {
    				$combination .= 'a';
    			}
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_BF:
    			//"1:0", "2:0", "2:1", "3:0", "3:1", "3:2", "4:0", "4:1", "4:2","胜其他", 
    			if ($home_goal > $guest_goal) {
    				$combination = '-1-h';
    				if ($home_goal == 1 && $guest_goal == 0) {
    					$combination = '0100';
    				}
    				if ($home_goal == 2 && $guest_goal == 0) {
    					$combination = '0200';
    				}
    				if ($home_goal == 2 && $guest_goal == 1) {
    					$combination = '0201';
    				}
    				if ($home_goal == 3 && $guest_goal == 0) {
    					$combination = '0300';
    				}
    				if ($home_goal == 3 && $guest_goal == 1) {
    					$combination = '0301';
    				}
    				if ($home_goal == 3 && $guest_goal == 2) {
    					$combination = '0302';
    				}
    				if ($home_goal == 4 && $guest_goal == 0) {
    					$combination = '0400';
    				}
    				if ($home_goal == 4 && $guest_goal == 1) {
    					$combination = '0401';
    				}
    				if ($home_goal == 4 && $guest_goal == 2) {
    					$combination = '0402';
    				}
    			}
    			//"0:0", "1:1", "2:2", "3:3", "平其他", 
    			if ($home_goal == $guest_goal) {
    				$combination = '-1-d';
    				if ($home_goal == 0) {
    					$combination = '0000';
    				}
    				if ($home_goal == 1) {
    					$combination = '0101';
    				}
    				if ($home_goal == 2 ) {
    					$combination = '0202';
    				}
    				if ($home_goal == 3) {
    					$combination = '0303';
    				}
    			}
    			//"0:1", "0:2", "1:2", "0:3", "1:3", "2:3", "0:4", "1:4", "2:4", "负其他"
    			if ($home_goal < $guest_goal) {
    				$combination = '-1-a';
    				if ($home_goal == 0 && $guest_goal == 1) {
    					$combination = '0001';
    				}
    				if ($home_goal == 0 && $guest_goal == 2) {
    					$combination = '0002';
    				}
    				if ($home_goal == 1 && $guest_goal == 2) {
    					$combination = '0102';
    				}
    				if ($home_goal == 0 && $guest_goal == 3) {
    					$combination = '0003';
    				}
    				if ($home_goal == 1 && $guest_goal == 3) {
    					$combination = '0103';
    				}
    				if ($home_goal == 2 && $guest_goal == 3) {
    					$combination = '0203';
    				}
    				if ($home_goal == 0 && $guest_goal == 4) {
    					$combination = '0004';
    				}
    				if ($home_goal == 1 && $guest_goal == 4) {
    					$combination = '0104';
    				}
    				if ($home_goal == 2 && $guest_goal == 4) {
    					$combination = '0204';
    				}
    			}	
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_JQS:
    			$jsq = $home_goal + $guest_goal;
    			if ($jsq >= 7) {
    				$combination = 's7';
    			} else {
    				$combination = 's'.$jsq;
    			}
    			break;
    		case ZunAoTicketClient::LOTTERY_CODE_SXDS:
    			$total_goal = $home_goal + $guest_goal;//进球数，大于或等于3为上盘，否则为下盘；总进球数单双
    			if ($total_goal < 3) {
    				$combination = 'x';
    			} else {
    				$combination = 's';
    			}
    			if ($total_goal%2 == 0) {
    				$combination .= 's';
    			} else {
    				$combination .= 'd';
    			}
    			break;
    	}
    	return $combination;
    }
}
