<?php

function https_request($url, $data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }




function http_post_data($url, $data_string ) {

    	$cacert = '';	//CA根证书  (目前暂不提供)
    	$CA = false ; 	//HTTPS时是否进行严格认证 
		$TIMEOUT = 30;	//超时时间(秒)
		$SSL = substr($url, 0, 8) == "https://" ? true : false; 

		$ch = curl_init ();
    	if ($SSL && $CA) {  
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); 	// 	只信任CA颁布的证书  
        	curl_setopt($ch, CURLOPT_CAINFO, $cacert); 			// 	CA根证书（用来验证的网站证书是否是CA颁布）  
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 		//	检查证书中是否设置域名，并且是否与提供的主机名匹配  
    	} else if ($SSL && !$CA) {  
        	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 	// 	信任任何证书  
        	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); 		// 	检查证书中是否设置域名  
    	}  

    	curl_setopt ( $ch, CURLOPT_TIMEOUT, $TIMEOUT);  
    	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $TIMEOUT-2);  
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data_string );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-Type:application/xml;charset=utf-8',
				'Content-Length:' . strlen( $data_string )
		) );

		ob_start();
		curl_exec($ch);
		$return_content = ob_get_contents();
		ob_end_clean();

		$return_code = curl_getinfo ( $ch, CURLINFO_HTTP_CODE );
		return array (
				$return_code,
				$return_content 
		);
	}


function signMD5($params,$unSignKeyList) { 
	    ksort($params);
	    $sourceSignString = signString ($params, $unSignKeyList);
	    $sourceSignString .= "&key=" .ConfigUtil::get_val_by_key("desKey");
	    return strtoupper(md5($sourceSignString));
}

function signString($data, $unSignKeyList) {
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




function encrypt($strinfo,$desKey){//数据加密
	
		$size = mcrypt_get_block_size(MCRYPT_3DES,'ecb');
		$strinfo = pkcs5_pad($strinfo, $size);
		$key = str_pad($desKey,24,'0');
		$td = mcrypt_module_open(MCRYPT_3DES, '', 'ecb', '');
		$iv = @mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		@mcrypt_generic_init($td, $key, $iv);
		$data = mcrypt_generic($td, $strinfo);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		//    $data = base64_encode($this->PaddingPKCS7($data));
		$data = base64_encode($data);
		return $data;
	}
function pkcs5_pad($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
}


function getSign($params,$signKey)//入网签名方式
{
  foreach ($params as $key => $value) {
    $value=urlencode($value);
  }
  ksort($params);
 
  $params=json_encode($params,JSON_UNESCAPED_UNICODE);
  // var_dump($params);exit;/
  $params = str_replace("\\","",$params);//编译的问题，反斜杠替换为null
  
  $sign = strtoupper(md5($params.$signKey));
  // echo $params.$signKey;exit;
  return $sign;
}


function getPaySign($params,$signKey)
{

  $string='#';

  foreach ($params as $key => $value) {
     $string .=$value.'#';  
  }

  $sign = $string.$signKey;
//var_dump($sign);
  return $sign;

}


function phpqrcode($content)
{
	include 'phpqrcode.php';
	$errorCorrectionLevel = 'L';//容错级别
	$matrixPointSize = 6;//生成图片大小
	//生成二维码图片
	QRcode::png($content, 'qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
	$logo = 'logo.png';//准备好的logo图片
	$QR = 'qrcode.png';//已经生成的原始二维码图
	
	if ($logo !== FALSE) {
		$QR = imagecreatefromstring(file_get_contents($QR));
		$logo = imagecreatefromstring(file_get_contents($logo));
		$QR_width = imagesx($QR);//二维码图片宽度
		$QR_height = imagesy($QR);//二维码图片高度
		$logo_width = imagesx($logo);//logo图片宽度
		$logo_height = imagesy($logo);//logo图片高度
		$logo_qr_width = $QR_width / 5;
		$scale = $logo_width/$logo_qr_width;
		$logo_qr_height = $logo_height/$scale;
		$from_width = ($QR_width - $logo_qr_width) / 2;
		//重新组合图片并调整大小
		imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width,
			$logo_qr_height, $logo_width, $logo_height);
	}
	//输出图片
	$img_url = "zhiying.png";
	imagepng($QR, $img_url);
	return $img_url;
}




function  log_result($file,$word){
	$fp = fopen($file,"a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y-%m-%d-%H：%M：%S",time())."\n".$word."\n\n");
	flock($fp, LOCK_UN);
	fclose($fp);
}

?>