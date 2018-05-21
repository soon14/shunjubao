<?php
abstract class LimitAbstract {
	/**
	 * 投票规则限制的用户id
	 * @var int
	 */
	protected $uid;

	/**
	 * 投票规则限制的用户ip
	 * @var string
	 */
	protected $ip;

	/**
	 * 规则有效时间，即多长时间内该规则生效
	 * 如为0，表示永久生效
	 * @var int
	 */
	protected $ruleTime;

	/**
	 * 每次投票的数量
	 * 默认是1，因为对投票系统来说，每次是投一票。但对其他系统来说，比如购买，这个数是改变的
	 * @var int
	 */
	protected $eachtime_num = 1;

	/**
	 * 存放着投票规则
	 * @var array
	 * 格式 array(
	 *     '规则名，如：ip' => array(
	 *         '限制对象名，如：tuan' => (int) 限制值,
	 *         ...
	 *     ),
	 *     ...
	 * )
	 */
	protected $rules;

	/**
	 * 设置投票规则
	 * @param array $rules
	 * @return boolean
	 */
	public function setRules(array $rules) {
        if (empty($rules)) {
        	return false;
        }

        if (!isset($rules['rule_time'])) {
        	return false;
        }
        if (!isInt($rules['rule_time']) || $rules['rule_time'] < 0) {
        	return false;
        }
        $this->rules['rule_time'] = $rules['rule_time'];
        unset($rules['rule_time']);

        if (isset($rules['ignore_user_logout']) && isInt($rules['ignore_user_logout'])) {
        	$this->rules['ignore_user_logout'] = $rules['ignore_user_logout'] > 0 ? 1 : 0;
        	unset($rules['ignore_user_logout']);
        }


        foreach($rules as $ruleType => $rule) {
        	if (!in_array($ruleType, $this->ruleTypes)) {
        		continue;
        	}

        	if (!is_array($rule) || empty($rule)) {
        		continue;
        	}

            foreach ($rule as $limitObject => $limitValue) {
            	if (!in_array($limitObject, $this->limitObjects)) {
            		continue;
            	}

            	if (!isInt($limitValue)) {
            		continue;
            	}

            	$this->rules[$ruleType][$limitObject] = $limitValue;
            }
        }
        return true;
	}

	const PARAM_RULE_TYPE_IP   = 'ip';

	const PARAM_RULE_TYPE_USER = 'user';

	/**
     * 规则类型
     *
     * @var array
     */
    protected $ruleTypes = array(self::PARAM_RULE_TYPE_IP, self::PARAM_RULE_TYPE_USER);

    /**
     * 限制对象
     *
     * @var array
     */
    protected $limitObjects = array();

    /**
     * 存放规则类型、限制对象与其值的对应关系
     * @var array
     */
    protected $guanxi;

    /**
     * CommCache
     *
     * @var CommCache
     */
    protected $objCommCache;

    /**
     * 由继承子类实现该方法
     */
    abstract public function __construct();

    /**
     * 投票
     * @return boolean true：表示通过投票规则；false：表示触发投票规则
     */
    public function vote($eachtime_num = null) {
    	if (isset($eachtime_num)) {
    		if (!isInt($eachtime_num) || $eachtime_num < 1) {
    			throw new Exception('每次数量必须是 >= 1 的整数');
    		}
            $this->eachtime_num = $eachtime_num;
    	}

    	$result = $this->_canVote();
        if ($result['status']) {//能投票
	        foreach ($this->ruleTypes as $ruleType) {
	            foreach ($this->limitObjects as $limitObject) {
	            	if (isset($result["{$ruleType}_{$limitObject}"])) {
	            		$cacheKey = $this->getCacheKeyForVerifyVote($ruleType, $limitObject);
                        $this->objCommCache->set($cacheKey, $result["{$ruleType}_{$limitObject}"], $this->rules['rule_time']);
	            	}
	            }
	        }
        }
        return $result;
    }

    /**
     * 判断能否投票
     * @return boolean
     */
    public function canVote($eachtime_num = null) {
        if (isset($eachtime_num)) {
            if (!isInt($eachtime_num) || $eachtime_num < 1) {
                throw new Exception('每次数量必须是 >= 1 的整数');
            }
            $this->eachtime_num = $eachtime_num;
        }

        $result = $this->_canVote();
        if ($result['status']) {//能投票
        	return true;
        } else {
        	return false;
        }
    }

    /**
     * 判断能否投票
     * @return array 成功时返回$arrVoteTrue结果；失败时返回$arrVoteFalse结果
     */
    protected function _canVote() {
    	$strMsg = '';
        $statusCode = null;
        # 投票成功
        $arrVoteTrue = array(
            'status' => true,
            'msg' => & $strMsg,
            'statusCode' => & $statusCode,
        );
        # 投票失败
        $arrVoteFalse = array(
            'status' => false,
            'msg' => & $strMsg,
            'statusCode' => & $statusCode,
        );

    	# 对用户进行限制了
        if (isset($this->rules[self::PARAM_RULE_TYPE_USER])) {
			do {
				if (isInt($this->uid)) {
					if ($this->uid > 0) break;
				} elseif(is_string($this->uid)) {
					if (strlen($this->uid) > 0) break;
				}
				
				# 走到这里，就是没有通过有效用户验证
				if (!isset($this->rules['ignore_user_logout']) || !$this->rules['ignore_user_logout']) {
            		$strMsg = '请登录后再投票！';
	                $statusCode = '06';
	                return $arrVoteFalse;
            	}
			} while (false);
        }

        foreach ($this->ruleTypes as $ruleType) {
	        foreach ($this->limitObjects as $limitObject) {
	            if (isset($this->rules[$ruleType][$limitObject])) {
	                $verifyValue = $this->ruleVerify($ruleType, $limitObject);
	                if (!$verifyValue) {
	                    $strMsg = '很抱歉，你已经投过票了';
	                    $statusCode = '07';
	                    return $arrVoteFalse;
	                }
	                $arrVoteTrue["{$ruleType}_{$limitObject}"] = $verifyValue;
	            }
	        }
        }

        $strMsg = '允许投票';
        $statusCode = '00';
        return $arrVoteTrue;
    }

    /**
     * 获取用于验证投票的缓存key
     * @param string $ruleType 规则类型
     * @param string $limitObject 限制对象
     */
    public function getCacheKeyForVerifyVote($ruleType, $limitObject) {
        $prefix = 'verify_vote_';
        return $prefix . 'ruleType' . $ruleType . '_ruleFlag' . $this->guanxi[$ruleType] . '_limitObject' . $limitObject . '_limitFlag' . $this->guanxi[$limitObject];
    }

    /**
     * 验证规则
     * @param @param string $ruleType 规则类型
     * @param string $limitObject 限制对象
     * @return int | false 不通过：false；通过：返回>=1的值
     */
    protected function ruleVerify($ruleType, $limitObject) {
        $cacheKey = $this->getCacheKeyForVerifyVote($ruleType, $limitObject);
        $votes = $this->objCommCache->get($cacheKey);
        do {
            if (empty($votes)) break;
            if (!isInt($votes)) break;
            $votes = (int) $votes;

            if ($votes + $this->eachtime_num > $this->rules[$ruleType][$limitObject]) {
            	return false;
            }

            return $votes + $this->eachtime_num;
        } while(false);

        # 流程走到这里，就认为是第一次投票
        if ($this->eachtime_num > $this->rules[$ruleType][$limitObject]) {
            return false;
        }
        return $this->eachtime_num;
    }
}
?>