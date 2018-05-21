<?php
/*
 * 开心用户关系类
 *
 */
class UserKaixin extends DBSpeedyPattern
{
    protected $tableName = 'user_kaixin';

    protected $primaryKey = 'kid';

    protected $other_field = array(
    	'kid',
    	'uid'
    	);

    	public function getUid($kid)
    	{
    	    $tmpResult = $this->fetchOne(array('kid'=>$kid), 'uid');
    	    if(!$tmpResult)
    	    {
    	        return false;
    	    }
    	    return array_pop($tmpResult);
    	}

}