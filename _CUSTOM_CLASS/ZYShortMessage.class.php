<?php
/**
 * Created by PhpStorm.
 * desc: 聚宝短信基础类
 * 阿里api：http://open.taobao.com/doc2/apiDetail?spm=0.0.0.0.D1PYJd&apiId=25450
 * User: hushiyu
 * Date: 16-3-17
 * Time: 下午3:22
 */
include_once YIC_PATH . '/CLASS/TopSdk/TopSdk.php';
header("Content-type: text/html; charset=utf-8"); 
class ZYShortMessage {

    public function __construct() {
        $configs = include ROOT_PATH . '/include/short_message.php';
        $config = $configs['alidayu'];
        if (!is_array($config) || empty($config)) {
            throw new ParamsException('配置文件信息错误');
        }

        $this->appkey = $config['appkey'];
        $this->secretKey = $config['secretKey'];
        $this->Extend = $config['Extend'];
        $this->SmsType = $config['SmsType'];
        $this->SmsFreeSignName = $config['SmsFreeSignName'];
        $this->SmsTemplateCodeList = $config['SmsTemplateCodeList'];
    }

	 /**
     * 赛事停开通知
     * @return InternalResultTransfer
     */
    public function send_saishi_send($mobile,$matchinfo,$sdate) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['matchinfo'] = $matchinfo;
		$info['date'] = $sdate;
		//赛事数据有变化，异常内容ID:${matchinfo},异常发送日期:${date},请及时处理
        $info['SmsTemplateCode'] = 'SMS_52315002';
        
		 if(!Verify::mobile($info['mobile'])) {
            return InternalResultTransfer::fail('手机号有误');
        }

        $objTopClient = new TopClient;
	//	var_dump($objTopClient);exit();
        $objTopClient->appkey = $this->appkey;
        $objTopClient->secretKey = $this->secretKey;

        $content = '{"matchinfo":"'.$info['matchinfo'].'","date":"'.$info['date'].'"}';
        $params = array(
            'Extend'	        => $this->Extend,
            'SmsType'	        => $this->SmsType,
            'SmsFreeSignName'	=> $this->SmsFreeSignName,
            'SmsParam'	        => $content,
            'RecNum'	        => $info['mobile'],
            'SmsTemplateCode'	=> $info['SmsTemplateCode'],
        );

        $res = $objTopClient->setParams($objTopClient, $params);
        $array = xmlToArray($res);


        if($array['result']['success'] != 'true'){
			$result =0;
		}else{
			$result =1;
		}
		return $result;
    }

    /**
     * 手机认证
     * @return InternalResultTransfer
     */
    public function sendOneRealinfo($mobile) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['code'] = $this->_createCode();
        $info['product'] = '聚宝网';
        $info['SmsTemplateCode'] = 'SMS_100810102';
        return $this->_sendOne($info);
    }
    /**
     * 密码重置
     * @return InternalResultTransfer
     */
    public function sendOneResetSecret($mobile) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['code'] = $this->_createCode();
        $info['product'] = '聚宝网';
        $info['SmsTemplateCode'] = 'SMS_3390016';
        return $this->_sendOne($info);
    }


    /**
     * 串关有误
     * @return InternalResultTransfer
     */
    public function sendOneSelectWrong($mobile) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['SmsTemplateCode'] = 'SMS_5515124';
        return $this->_sendOne($info);
    }

    /**
     * 注册用户手机号验证
     * @return InternalResultTransfer
     */
    public function sendOneRegister($mobile) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['code'] = $this->_createCode();
        $info['product'] = '聚宝网';
        $info['SmsTemplateCode'] = 'SMS_5365793';
		
        return $this->_sendOne($info);
    }

    public function getCode() {
        return $this->code;
    }
	
	
	 /**
     * 发送数据异常通知
     * @return InternalResultTransfer
     */
    public function sendDataAbort($mobile,$matchid,$date) {
        $info = array();
        $info['mobile'] = $mobile;
        $info['matchid'] = $matchid;
        $info['date'] = $date;
        $info['SmsTemplateCode'] = 'SMS_8400016';
		
		
		$objShortMessageLog = new ShortMessageLog();
		$condition = array();
		$condition['project_id'] = $info['matchid'];
		$condition['mobile'] = $info['mobile'];
		$condition['content'] = $info['date'];
	
		
		$result = $objShortMessageLog->getsByCondition($condition, null, 'create_time desc');
		if(!empty($result)){
			return 0;
		}
		

        if(!Verify::mobile($info['mobile'])) {
            return InternalResultTransfer::fail('手机号有误');
        }

        $objTopClient = new TopClient;
	//	var_dump($objTopClient);exit();
        $objTopClient->appkey = $this->appkey;
        $objTopClient->secretKey = $this->secretKey;

        $content = '{"matchid":"'.$info['matchid'].'","date":"'.$info['date'].'"}';
        $params = array(
            'Extend'	        => $this->Extend,
            'SmsType'	        => $this->SmsType,
            'SmsFreeSignName'	=> $this->SmsFreeSignName,
            'SmsParam'	        => $content,
            'RecNum'	        => $info['mobile'],
            'SmsTemplateCode'	=> $info['SmsTemplateCode'],
        );

        $res = $objTopClient->setParams($objTopClient, $params);
        $array = xmlToArray($res);

        if($array['result']['success'] != 'true'){
			$result =0;
		}else{
			
			$loginfo = array();
            $loginfo['mobile']     = $info['mobile'];
            $loginfo['feedback']   = $array['request_id'];
            $loginfo['create_time'] = time();
            $loginfo['content']    = $info['date'];
            $loginfo['project_id'] = $info['matchid'];
            $objShortMessageLog->add($loginfo);

			$result =1;
		}
		return $result;
		
		
		
	//	数据获取有异常，异常ID${matchid},异常日期${date},请及时处理
    }
	
	
    /**
     * 生成一个验证码
     */
    private function _createCode() {
        $code = rand(100000,999999);
        $this->code = $code;
        return $code;
    }

    /**
     * 单条短信发送方法
     * @param array $info=array('mobile'=>,'code'=>,'product'=>,'SmsTemplateCode'=>)
     * @return  InternalResultTransfer
     */
    private function _sendOne($info) {

        if (!Verify::mobile($info['mobile'])) {
            return InternalResultTransfer::fail('手机号有误');
        }

        $objTopClient = new TopClient;
	//	var_dump($objTopClient);exit();
        $objTopClient->appkey = $this->appkey;
        $objTopClient->secretKey = $this->secretKey;

        $content = '{"code":"'.$info['code'].'","product":"'.$info['product'].'"}';
        $params = array(
            'Extend'	        => $this->Extend,
            'SmsType'	        => $this->SmsType,
            'SmsFreeSignName'	=> $this->SmsFreeSignName,
            'SmsParam'	        => $content,
            'RecNum'	        => $info['mobile'],
            'SmsTemplateCode'	=> $info['SmsTemplateCode'],
        );

        $res = $objTopClient->setParams($objTopClient, $params);
        $array = xmlToArray($res);
		

        $objShortMessageLog = new ShortMessageLog();

        if($array['result']['success'] != 'true'){
            //$array['msg']
            /**
             *  [code] => 15
            [msg] => Remote service error
            [sub_code] => isv.BUSINESS_LIMIT_CONTROL
            [sub_msg] => 触发业务流控
            [request_id] => 13ysnlv6n7o3z
             */
            $this->errorMsg = $array['msg'];

            $loginfo = array();
            $loginfo['mobile']     = $info['mobile'];
            $loginfo['feedback']   = $array['request_id'];
            $loginfo['create_time'] = time();
            $loginfo['content']    = serialize($array);
            $loginfo['project_id'] = ShortMessageLog::PROJECT_ID_ERROR;
            $objShortMessageLog->add($loginfo);
            return InternalResultTransfer::fail('发送出错');
        }

        $request_id = $array['request_id'];
        //短信日志
        $objShortMessageLog = new ShortMessageLog();
        $loginfo = array();
        $loginfo['mobile']     = $info['mobile'];
        $loginfo['feedback']   = $request_id;
        $loginfo['create_time'] = time();
        $loginfo['content']    = $content;
        $loginfo['project_id'] = $this->getProjectIdByTpl($info['SmsTemplateCode']);
        $objShortMessageLog->add($loginfo);

        return InternalResultTransfer::success('发送成功');
    }

    public function getErrorMsg() {
        return $this->errorMsg;
    }

    public function getProjectIdByTpl($tpl) {
        $tplList = array(
            'SMS_3390016'=>ShortMessageLog::PROJECT_ID_SECRET_BACK,
            'SMS_5515124'=>ShortMessageLog::PROJECT_ID_SELECT_WRONG,
            'SMS_5365793'=>ShortMessageLog::PROJECT_ID_REGISTER,
        );
        return $tplList[$tpl];
    }
    /**
     * 是否为可用的模版
     * @param string $type
     * @return boolean
     */
    private function isSmsType($type) {
        if (!is_string($type)) return false;
        return in_array($type,$this->SmsTemplateCodeList);
    }
}