<?php
/**
 * 用户推广链接的彩金和返点结算脚本
 * 规则：
	1、每推广成功一人，您将获得3元彩金；成功5人（含5人以上）获得20彩金；
	2、只要通过您带来的用户，产生投注，您都能将拿到1%的返点
	3、统计推广用户的注册人数、认证人数、投注总金额
	脚本运行：1和2时间:->周日24点为截止时间，收益每周一结算一次;3->每天统计一次
	推荐5人以内（含5人），每成功一人将获得3彩金；
	6人到10人获得20彩金；
	11人—19人获得30彩金；
	20人—29人获得40彩金；
	30人—39人获得60彩金；
	40人—49人获得80彩金；
	50人以上（含50 人）获得100彩金。
推荐人数以星期为周期，每周一结算
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';
//必须保证今天是周一
$week = date('w', time());//0 (for Sunday) through 6 (for Saturday)

if ($week != 1) {
	echo_exit('today is not account day');
}

//奖励
siteFromGift();
sleep(1);
//结算
siteFromRebate();
sleep(1);
//统计
siteFromStat();
sleep(1);
exit;

function siteFromGift() {
	
	$start_time = date('Y-m-d 00:00:00',strtotime(date('Y-m-d')) - 7 * 86400);//上周一的第一秒
	$end_time = date('Y-m-d 23:59:59',strtotime(date('Y-m-d')) - 1);//上周日的最后一秒
	
	$objSiteFrom = new SiteFrom();
	$condition = array();
	$condition['type'] = SiteFrom::SITE_FROM_TYPE_IN;#TODO站外人员的奖励待定
	
	$step = 100;
	$offset = 0;
	
do{
	$limit = "{$offset},{$step}";
	$results = $objSiteFrom->getsByCondition($condition, $limit ,'id asc');
	
	if (!$results) {
		break;
	}
	
	$objUserMemberFront = new UserMemberFront();
	
	foreach ($results as $key=>$value) {
		
		$u_id = $value['create_uid'];//推广人uid
		$source_key = $value['source_key'];
		
		$u_source = UserMember::verifySiteFrom($source_key);
		if (!$u_source) {
			echo 'error no source_key';
			continue;
		}
		
		$field = 'u_jointime';
		$cond = array();
		$cond['u_source'] = $u_source;
		
		$s = time();//记录查询时间用来分析性能
		$r_m = $objUserMemberFront->getsByCondtionWithField($start_time, $end_time, $field, $cond);
		if (!$r_m) {
			continue;
		}
		$e = time();
		
		#TODO数量巨大时会有性能问题，暂时发送站内信提醒
		if (($e-$s)>5) {
			sendUserPms(2, '推广人员返奖系统性能问题');
		}
		
		//是否实名认证
		$objUserRealInfoFront = new UserRealInfoFront();
		$idcard_num = 0;//一周内的推广总人数，认证用户
		$register_num = 0;
		foreach ($r_m as $k=>$v){
			$result = $objUserRealInfoFront->isUserIdentify($v['u_id']);
			if ($result) {
				$idcard_num++;
			}
		}
		
		if (!$idcard_num) {
			continue;
		}
		
		//发送彩金逻辑
		$gift = 0;
		if ($idcard_num <= 5) {
			$gift = $idcard_num * 3;
		} elseif($idcard_num <=10) {
			$gift = 20;
		} elseif($idcard_num <=19) {
			$gift = 30;
		} elseif($idcard_num <=29) {
			$gift = 40;
		} elseif($idcard_num <=39) {
			$gift = 60;
		} elseif($idcard_num <=49) {
			$gift = 80;
		} else {
			$gift = 100;
		}
		
		$objUserAccountFront = new UserAccountFront();
		$tmpResult = $objUserAccountFront->addGift($u_id, $gift);
		
		if (!$tmpResult->isSuccess()) {
			echo $tmpResult->getData();
			continue;
		}
		
		$userAccountInfo = $objUserAccountFront->get($u_id);
		
		$tableInfo = array();
		$tableInfo['u_id'] 			= $u_id;
		$tableInfo['gift'] 			= $gift;
		$tableInfo['log_type'] 		= BankrollChangeType::GIFT_TUIGUANG;
		$tableInfo['old_gift'] 		= $userAccountInfo['gift'];//原金额
		$tableInfo['record_table'] 	= 'user_account';//对应的表
		$tableInfo['record_id'] 	= $u_id;
		$tableInfo['create_time'] 	= getCurrentDate();
		//添加账户日志
		$objUserGiftLogFront = new UserGiftLogFront();
		$tmpResult = $objUserGiftLogFront->add($tableInfo);
		
		if (!$tmpResult) {
			echo "uid-{$u_id}添加账户日志失败\r\n";
			continue;
		}
		echo "uid-{$u_id}彩金{$gift}添加成功\r\n";
		sleep(1);
	}
	sleep(1);
	$offset += $step;
	
}while (true);
	
	
}

function siteFromRebate() {
	
	$start_time = date('Y-m-d 00:00:00',strtotime(date('Y-m-d')) - 7 * 86400);//上周一的第一秒
	$end_time = date('Y-m-d 23:59:59',strtotime(date('Y-m-d')) - 1);//上周日的最后一秒
	
	$objSiteFrom = new SiteFrom();
	$condition = array();
	$condition['type'] = SiteFrom::SITE_FROM_TYPE_IN;#TODO站外人员的奖励待定
	
	$step = 100;
	$offset = 0;
	
	$rebate_per_normal = 0.01;//普通用户返点比例1%
	
	//特殊用户的返点比例
	$u_rebate = array(
	    'dickie0098'	=> 0.025,
	    '中国航空'		=> 0.03,
		'Oteucy'		=> 0.07,
		'桀骜不羁'		=> 0.05,
		'fengzhenrong'	=> 0.03,
		'智赢小生'		=> 0.03,
		'hellenjoey'	=> 0.03,
		'15239955819'	=> 0.03,
		'kevin871011'	=> 0.03,
	);
	
	do{
		$limit = "{$offset},{$step}";
		$results = $objSiteFrom->getsByCondition($condition, $limit ,'id asc');
	
		if (!$results) {
			break;
		}
		
		foreach ($results as $key=>$value) {
			$u_id = $value['create_uid'];//推广人uid
			$source_key = $value['source_key'];
			
			$u_source = UserMember::verifySiteFrom($source_key);
			if (!$u_source) {
				echo 'error no source_key';
				continue;
			}
			
			
			$cond = array();
			$cond['u_source'] = $u_source;
			
			$objUserMemberFront = new UserMemberFront();
			$s = time();//记录查询时间用来分析性能
			$r_m = $objUserMemberFront->getsByCondition($cond);
			if (!$r_m) {
				continue;
			}
			$e = time();
			
			#TODO数量巨大时会有性能问题，暂时发送站内信提醒
			if (($e-$s)>5) {
				sendUserPms(2, '推广人员返奖系统性能问题');
			}
			//特殊处理
			if (array_key_exists($value['create_uname'], $u_rebate)) {
			    $rebate_per = $u_rebate[$value['create_uname']];
			} else {
			    $rebate_per = $rebate_per_normal;
			}
			
			$field = 'datetime';//按出票时间
			$objUserTicketAllFront = new UserTicketAllFront();
			$objUserAccountFront = new UserAccountFront();
			$objUserRebateFront = new UserRebateFront();
			foreach ($r_m as $k=>$v) {
				$cond_t = array();
				$cond_t['u_id'] = $v['u_id'];
				$cond_t['print_state'] = UserTicketAll::TICKET_STATE_LOTTERY_SUCCESS;
				$user_tickets = $objUserTicketAllFront->getsByCondtionWithField($start_time, $end_time, $field, $cond_t);
				if (!$user_tickets) {
					continue;
				}
				
				foreach ($user_tickets as $user_ticket) {
					//返点逻辑
			    	$score 		= $user_ticket['money'] * $rebate_per;
			    	$datetime	= getCurrentDate();
			    	//记录返点日志
			    	$tableInfo = array();
			    	$tableInfo['u_id'] 			= $u_id;
			    	$tableInfo['create_time'] 	= $datetime;
			    	$tableInfo['rebate_score'] 	= $score;
			    	$tableInfo['percent'] 		= $rebate_per;
			    	$tableInfo['ticket_id'] 	= $user_ticket['id'];//被推广人的订单id
			    	$tableInfo['ticket_money'] 	= $user_ticket['money'];
			    	$record_id = $objUserRebateFront->add($tableInfo);
			    	if (!$record_id) {
			    		echo "uid-{$u_id}记录返点失败\r\n";
			    		continue;
			    	}
			    	//添加到余额
			    	$tmpResult = $objUserAccountFront->addCash($u_id, $score);
			    	if (!$tmpResult->isSuccess()) {
			    		echo "uid-{$u_id}返点自动流入账户失败\r\n";
			    		continue;
			    	}
			    	//添加余额日志
			    	$userAccountInfo = $objUserAccountFront->get($u_id);
			    	$tableInfo = array();
			    	$tableInfo['u_id'] 			= $u_id;
			    	$tableInfo['create_time'] 	= $datetime;
			    	$tableInfo['money'] 		= $score;
			    	$tableInfo['old_money'] 	= $userAccountInfo['cash'];
			    	$tableInfo['log_type'] 		= BankrollChangeType::REBATE_TO_ACCOUNT;
			    	$tableInfo['record_table'] 	= 'user_rebate';
			    	$tableInfo['record_id'] 	= $record_id;
			    	
			    	$objUserAccountLogFront = new UserAccountLogFront($u_id);
			    	$ticket_log_id = $objUserAccountLogFront->add($tableInfo);
			    	if (!$ticket_log_id) {
			    		echo "uid{$u_id}记录返点流水失败\r\n";
			    		continue;
			    	}
			    	echo $u_id ." 返点添加成功\r\n";
			    	sleep(1);//同一时间返点记录堆积，造成返点时间一样的问题
				}
			}
		}
		
		sleep(1);
		$offset += $step;
	}while (true);
}

function siteFromStat() {
	
	$start_time = date('Y-m-d 00:00:00',strtotime(date('Y-m-d')) - 7 * 86400);//上周一的第一秒
	$end_time = date('Y-m-d 23:59:59',strtotime(date('Y-m-d')) - 1);//上周日的最后一秒
	
	$objUserMemberFront = new UserMemberFront();
	$objUserRealInfoFront = new UserRealInfoFront();
	$objUserTicketAllFront = new UserTicketAllFront();
	$objSiteFrom = new SiteFrom();
	$condition = array();
	$condition['type'] = SiteFrom::SITE_FROM_TYPE_IN;#TODO站外人员的奖励待定
	
	$step = 100;
	$offset = 0;
	
	do{
		$limit = "{$offset},{$step}";
		$results = $objSiteFrom->getsByCondition($condition, $limit ,'id asc');
	
		if (!$results) {
			break;
		}
	
		foreach ($results as $key=>$value) {
	
			$u_id = $value['create_uid'];//推广人uid
			$source_key = $value['source_key'];
	
			$u_source = UserMember::verifySiteFrom($source_key);
			if (!$u_source) {
				echo_exit('error no source_key');
			}
	
			$field = 'u_jointime';
			$cond = array();
			$cond['u_source'] = $u_source;
			
			$total_money = 0;//一周内的投注量
			$r_m = $objUserMemberFront->getsByCondition($cond);
			foreach ($r_m as $k=>$v) {
				$res = $objUserTicketAllFront->getTotalTicketMoney($start_time, $end_time, $v['u_id']);
				if ($res) {
					$total_money += $res;
				}
			}
			//更新统计信息-投注量
			if ($total_money) {
				$objSiteFrom->increaseStat($value['id'], 0, 0, $total_money);
			}
			
			$total_registers = 0;//一周内的推广总人数，注册用户
			$total_idcards = 0;//一周内的推广总人数，认证用户
			
			$s = time();//记录查询时间用来分析性能
			$r_m = $objUserMemberFront->getsByCondtionWithField($start_time, $end_time, $field, $cond);
			
			if (!$r_m) {
				//不需要更新人数
				continue;
			}
			
			$total_registers = count($r_m);
			
			$e = time();
	
			#TODO数量巨大时会有性能问题，暂时发送站内信提醒
			if (($e-$s)>5) {
				sendUserPms(2, '推广人员返奖系统性能问题');
			}
			
			//是否实名认证
			foreach ($r_m as $k=>$v){
				$result = $objUserRealInfoFront->isUserIdentify($v['u_id']);
				if ($result) {
					$total_idcards++;
				}
			}
			
			//更新统计信息-注册用户,认证用户
			$objSiteFrom->increaseStat($value['id'], $total_registers, $total_idcards, 0);
		}
		$offset += $step;
	
	}while (true);
}