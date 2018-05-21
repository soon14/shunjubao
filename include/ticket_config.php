<?php
/**
 * 出票接口的配置文件
 */
return array(
//华阳创美公司
// 	'huayang'	=> array(
// 		'gateway'	=> 'http://124.202.244.142:81/b2blib/lotteryxml.php',//测试
// 		'agenterid'	=> '10000643',//测试
// 		'username'	=> '10000643',//测试
// 		'datakey'	=> '34dc12b5051effd979eebbebf258ca16',//测试
// 		'charset'	=> 'utf-8',
// 		'version'	=> '1.0',
// 		'method'	=> 'post',
// 	),
	'huayang'	=> array(
		'gateway'	=> 'http://interlib.198tc.com/b2blib/lotteryxml.php',//正式
		'agenterid'	=> '10000662',//正式
		'username'	=> '10000662',//正式
		'datakey'	=> '04d600687aaa0a85383f8e00cf518d34',//正式
		'charset'	=> 'utf-8',
		'version'	=> '1.0',
		'method'	=> 'post',
	),
	
// 	'zunao'	=> array(//测试
// 		'key'		=> '123456',
// 		'gateway'	=> 'http://121.12.168.124:661/ticketinterface.aspx',
// 		'charset'	=> 'utf-8',
// 		'method'	=> 'post',
// 		'version'	=> '1.0',
// 		'header'	=> 'Content-Type: text/xml',//curl的header
// 		'partnerid'	=> '349171',
// 	),
	'zunao'	=> array(//正式
		'key'		=> 'A9A8BA443CDF83231B16F805CE15C611',
		'gateway'	=> 'http://121.12.168.12:662/ticketinterface.aspx',//投注接口地址(电信)
// 		'gateway'	=> 'http://124.95.165.216:662/TicketInterface.aspx',//投注接口地址(网通)一
// 		'gateway'	=> 'http://210.51.44.6:662/ticketinterface.aspx',//投注接口地址(网通)二备用
		'charset'	=> 'utf-8',
		'method'	=> 'post',
		'version'	=> '1.0',
		'header'	=> 'Content-Type: text/xml',//curl的header
		'partnerid'	=> '349137',
	),
);