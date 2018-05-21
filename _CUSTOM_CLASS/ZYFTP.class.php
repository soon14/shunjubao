<?php
/**
 * 智赢ftp管理类 
 */
class ZYFTP {
	
	//ftp超时时间
	const FTP_TIMEOUT = 20;
	
	/**
	 * 检测一个ftp服务器是否可用
	 * @return InternalResultTransfer
	 */
	static public function isFtpAvaliable () {
		
		include_once QUERY_ITEM_INFOHUB_PATH . DIRECTORY_SEPARATOR .'config.php';
		
		$host = INFO_HUB_FTP_HOST;
		$user = INFO_HUB_FTP_USER;
		$pass = INFO_HUB_FTP_PASS;
		$port = INFO_HUB_FTP_PORT;
		
		$ftp = ftp_connect($host, $port, ZYFTP::FTP_TIMEOUT);
		if (!$ftp) {
			return InternalResultTransfer::fail('ftp服务器不可用');
		}
		
		$login = ftp_login($ftp, $user, $pass); 
		if(!$login) { 
			return InternalResultTransfer::fail('ftp帐号：'.$user.'无法登录');
		}
		
		return InternalResultTransfer::success('数据源可用');
	}
	
	/**
	 * xml文件是否存在 
	 * @param string $filename
	 * @return boolean
	 */
	static public function isXmlFileExist($filename) {
		$filename = ZYFTP::getXmlFilePath($filename);
		return file_exists($filename);
	}
	
	/**
	 * 获取文件最后的更新时间 
	 * @param string $filename
	 * @return string
	 */
	static public function getFileLastUpdatTime($filename) {
		$filename = ZYFTP::getXmlFilePath($filename);
		$time = filemtime($filename);
		return date('Y-m-d H:i:s', $time);
	}
	
	/**
	 * 获取xml文件的完整路径
	 */
	static public function getXmlFilePath($filename) {
		//是否有文件后缀
		if (substr($filename, -1, 4) != '.xml') {
			$filename .= '.xml';
		}
		return QUERY_ITEM_INFOHUB_PATH . DIRECTORY_SEPARATOR . 'xml' . DIRECTORY_SEPARATOR . $filename;
	}
}