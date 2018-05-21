<?php

namespace com\cskj\pay\demo\common;
header('Content-Type:text/html;charset=utf-8');

include 'RSAUtils.php';

/**
 * 签名
 *
 * @author wylitu
 *        
 */
class SignUtil {
	
// 	public static $unSignKeyList = array (
// 			"merchantSign",
// 			"version", 
// 			"successCallbackUrl",
// 			"forPayLayerUrl"
// 	);
	public static function signWithoutToHex($params,$unSignKeyList) {
		ksort($params);
  		$sourceSignString = SignUtil::signString ( $params, $unSignKeyList );
  		//echo  "sourceSignString=".htmlspecialchars($sourceSignString)."<br/>";
  		//error_log("=========>sourceSignString:".$sourceSignString, 0);
  		$sha256SourceSignString = hash ( "sha256", $sourceSignString);	
  		//error_log($sha256SourceSignString, 0);
  		//echo "sha256SourceSignString=".htmlspecialchars($sha256SourceSignString)."<br/>";
        return RSAUtils::encryptByPrivateKey ($sha256SourceSignString);
	}
	
	public static function sign($params,$unSignKeyList) {
		ksort($params);
		$sourceSignString = SignUtil::signString ( $params, $unSignKeyList );
		error_log($sourceSignString, 0);
		$sha256SourceSignString = hash ( "sha256", $sourceSignString);
		error_log($sha256SourceSignString, 0);
		return RSAUtils::encryptByPrivateKey ($sha256SourceSignString);
	}
	
	public static function signMD5($params,$unSignKeyList) {
	   
	    ksort($params);
		
	    $sourceSignString = SignUtil::signString ($params, $unSignKeyList);
	    $sourceSignString .= "&key=" .ConfigUtil::get_val_by_key("desKey");
	    error_log($sourceSignString, 0);
		
		$fp = fopen("all_post_SignUtil.txt","a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$sourceSignString."\n\n");
		flock($fp, LOCK_UN);
		fclose($fp);
		
	    return strtoupper(md5($sourceSignString));
	}
	
	public static function signString($data, $unSignKeyList) {
		$linkStr="";
		$isFirst=true;
		ksort($data);
		$fields = array();
	    //echo gettype($data);
		foreach($data as $key=>$value){
			//echo $key;
			//echo $value;
			if($value==null || $value==""){
				continue;
			}
			$bool=false;
			foreach ($unSignKeyList as $str) {
				if($key."" == $str.""){
					$bool=true;
					break;
				}
			}
			if($bool){
				continue;
			}
			array_push($fields, $key."=".$value);
		}
		//echo htmlspecialchars(join("&",$fields));
		return join("&",$fields);
	}
	
	public function log_result_tt($file,$word){
		$fp = fopen($file,"a");
		flock($fp, LOCK_EX) ;
		fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
		flock($fp, LOCK_UN);
		fclose($fp);
	}

	
	
}

?>