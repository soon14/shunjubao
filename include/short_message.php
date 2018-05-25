<?php
/**
 * Created by PhpStorm.
 * desc: 短信接口配置，当前使用场景为阿里大鱼
 * User: hushiyu
 * Date: 16-3-17
 * Time: 下午3:23
 */
return array(
  'alidayu' => array(
      'appkey' => MOBILE_MSG_APPKEY,//key
      'secretKey'=> MOBILE_MSG_APPSECRET,//secret
      'Extend'	=> 'smstest',//短信模版（固定）
      'SmsType'	=> 'normal',//未知（固定）
      'SmsFreeSignName'	=> '聚宝通知',//签名（固定）
      'SmsTemplateCodeList'	=> array(//短信模版列表，需要在阿里后台添加
          'SMS_3390016',//修改密码验证码: 验证码${code}，您正在尝试修改${product}登录密码，请妥善保管账户信息。
          'SMS_5515124',//网站用户操作错误提示:尊敬的用户：您好！您在聚宝网投注的方案串关有误，已经做了退票处理，请重新投注
          'SMS_5365793',//注册用户手机号验证:您正在注册成为${product}用户，验证码是${code}，5分钟内有效，聚宝网才智聚宝，财富人生，聚宝网欢迎您的到来！
      ),
  ),
);