<?php
/**
 * 领克特CPS跳转页
 */
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'init.php';

	if(!get_cfg_var("register_globals"))
	{
		$a_id  = $_REQUEST["a_id"];
		$m_id  = $_REQUEST["m_id"];
		$c_id  = $_REQUEST["c_id"];
		$l_id  = $_REQUEST["l_id"];
		$l_type1 = $_REQUEST["l_type1"];
		$rd    = $_REQUEST["rd"];
//		$url	= $_REQUEST["url"]."&aid=".$_REQUEST["a_id"];
		$url	= $_REQUEST["url"]?$_REQUEST["url"]: ROOT_DOMAIN;
	}
	if($a_id=="" or $m_id=="" or $c_id=="" or $l_id=="" or $l_type1=="" or $rd=="" or $url=="")
	{
		echo ("
            <html><head><script language=\"javascript\">
            <!--
                    alert('LPMS:不能连接，请咨询网站负责人。');
                    history.go(-1);
            //-->
            </script></head></html>
		     ");
		exit;
	}
	Header("P3P:CP=\"NOI DEVa TAIa OUR BUS UNI\"");

If($rd==0){
	SetCookie("LTINFO","$a_id|$c_id|$l_id|$l_type1",0,"/", DOMAIN);
	setcookie('LTINFO_m',$m_id,0,"/",DOMAIN);
}
else{
	SetCookie("LTINFO","$a_id|$c_id|$l_id|$l_type1",time()+($rd*24*60*60),"/", DOMAIN);
	setcookie('LTINFO_m',$m_id,time()+($rd*24*60*60),"/",DOMAIN);
}

if (Request::g('channelid')) {
	$url = jointUrl($url, array('channelid' => Request::g('channelid')));
}

$url_info = parse_url($url);
$tmpQuery = $url_info['query'];
parse_str($tmpQuery, $params);

if(!$params['channelid']){
	$url = jointUrl($url, array('channelid' => '9000003'));
}

if(!$params['adsense_from']){
	$url = jointUrl($url, array('adsense_from' => 'linktech'));
}

	Header("Location: $url");
	Header("URI: $url");
?>
