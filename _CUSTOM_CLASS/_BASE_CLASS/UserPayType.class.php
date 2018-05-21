<?php
class UserPayType extends DBSpeedyPattern {

	protected $tableName = 'user_pay_type';
	/**
     * 数据库里的真实字段
     * @var array
     */
    protected $other_field = array(
    	'uid',  //用户id
        'pay_type',    //支付类型
    );

   protected $primaryKey = 'uid';

     /**
     * 添加一条记录
     * @see DBSpeedyPattern::add()
     * @param array $info 格式：array(
     * // 必要字段
     *     'uid'		=> (int),// 用户id
     *     'pay_type'	=> (float),// 支付方式
     *
     *     , ...
     * );
     * @return false | array 成功：返回数组；
     */
    public function add(array $info) {
    	if(empty($info['uid']))
    	{
    		throw new ParamsException("请指定用户ID");
    	}
    	if(empty($info['pay_type']))
    	{
    		throw new ParamsException("请指定支付类型");
    	}
    	$tmpResult = parent::add($info,parent::PARAM_CREATE_ACTION_ONDUPLICATE);
		if (Verify::unsignedInt($tmpResult)) {
			$info[$this->primaryKey] = $tmpResult;
			return $info;
		}
		return $tmpResult;
    }

    /**
     * 通过用户id获得支付选择信息
     * @param $uid //用户订单号
     * @return false| array
     */
    public function getByUid($uid)
    {
	    if (!Verify::unsignedInt($uid)) {
	    		return false;
	    	}
	    $condition = array(
			'uid'		=> $uid,
			);

		$ids = $this->findIdsBy($condition);
		return array_pop($this->gets($ids));
    }

}