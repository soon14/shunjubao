<?php
/*
 * 邮件发送类
 * 封装PHPMailer
 */
class TMMail
{
    protected $objPHPMailer;

    public function __construct(array $options = null)
    {
        $this->objPHPMailer = new PHPMailer();

        $this->objPHPMailer->IsSMTP();
        $this->objPHPMailer->SMTPAuth = true;

        if(isset($options['HOSTNAME'])){
			$this->objPHPMailer->Host = $options['HOSTNAME'];
        }else{
			$this->objPHPMailer->Host = SMTP_HOSTNAME;
        }

        if(isset($options['PORT'])){
        	$this->objPHPMailer->Port = $options['PORT'];
        }else{
        	$this->objPHPMailer->Port = SMTP_PORT;
        }

        if(isset($options['TIMEOUT'])){
			$this->objPHPMailer->Timeout = $options['TIMEOUT'];
        }else{
        	$this->objPHPMailer->Timeout = SMTP_TIMEOUT;
        }

        if(isset($options['USERNAME'])){
        	$this->objPHPMailer->Username = $options['USERNAME'];
        }else{
        	$this->objPHPMailer->Username = SMTP_USERNAME;
        }

        if(isset($options['PASSWORD'])){
        	$this->objPHPMailer->Password = $options['PASSWORD'];
        }else{
        	$this->objPHPMailer->Password = SMTP_PASSWORD;
        }

        if(isset($options['CHARSET'])){
        	$this->objPHPMailer->CharSet = $options['CHARSET'];
        }else{
        	$this->objPHPMailer->CharSet = SMTP_CHARSET;
        }

        if(isset($options['Encoding'])){
        	$this->objPHPMailer->Encoding = $options['Encoding'];
        }else{
        	$this->objPHPMailer->Encoding = "base64";
        }

    }

    /**
     *
     * 发送邮件
     * @param array $info 格式：array(
     * "from"     =>  "",//发件人邮箱	默认为(noreply@gaojie100.com)
     * "fromname"   =>  "",//发件人	默认为(高街时尚网)
     * "address"    =>  array(           //必填 收件人
     *            array(
     *              "mail"  =>  "",//必填 收件人邮箱
     *              "name"  =>  "",//收件人姓名
     *            )
     *            ……
     *          ),
     * "ccaddress"    =>  array(          //抄送
     *            array(
     *              "mail"  =>  "",//必填 收件人邮箱
     *              "name"  =>  "",//收件人姓名
     *            )
     *            ……
     *          ),
     * "bccaddress"   =>  array(          //密送
     *            array(
     *              "mail"  =>  "",//必填 收件人邮箱
     *              "name"  =>  "",//收件人姓名
     *            )
     *            ……
     *          ),
     * "attachment" =>  array(
     *            "",//附件1 服务器文件全路径 /var/tmp/file.tar.gz
     *            "",//附件2
     *          ),
     * "ishtml"     =>  true|false,//yes or no, send as HTML
     * "subject"      =>  "",//必填 邮件主题
     * "body"       =>  "",//当为空时使用subject的值
     * );
     * @param int $retry_times 发送失败时的重试次数，默认为0，即不重试
     * @param int $retry_frequency 重试频率，单位：秒。默认为1秒
     * @return bool
     */
    public function send($info, $retry_times = 0, $retry_frequency = 1)
    {
    	$from = isset($info['from'])?$info['from']:'';
    	if($from){
    		if(!Verify::email($from)){
    			echo '邮箱格式不真确';
    			exit;
    		}
    		$this->objPHPMailer->From = $from;
    	}else{
    		$this->objPHPMailer->From = SMTP_FROM;
    	}

    	$fromname = isset($info['fromname'])?$info['fromname']:'';
    	if($fromname){
    		$this->objPHPMailer->FromName = $fromname;
    	}else{
    		$this->objPHPMailer->FromName = SMTP_FROMNAME;
    	}

    	if(!$info["address"]){
    		echo '收件人邮箱不能为空';
    		exit;
    	}
    	if (is_array($info["address"])){
	    	foreach($info["address"] as $address){
	    		if(!$address['mail']){
	    			echo '收件人邮箱不能为空';
	    			exit;
	    		}
	            $this->objPHPMailer->AddAddress($address["mail"], $address["name"]);
	        }
    	}else{
    		$address = explode(',', $info["address"]);
    		foreach($address as $add){
    			if(!$add) continue;
	            $this->objPHPMailer->AddAddress(trim($add));
	        }
    	}

    	if (is_array($info["ccaddress"])){
	    	foreach($info["ccaddress"] as $address){
	    		if(!$address["mail"]){
	    			echo '抄送收件人邮箱不能为空';
	    			exit;
	    		}
	    		$this->objPHPMailer->AddCC($address["mail"], $address["name"]);
	        }
    	}else{
    		$address = explode(',', $info["ccaddress"]);
    		foreach($address as $add){
    			if(!$add) continue;
	            $this->objPHPMailer->AddCC(trim($add));
	        }
    	}

    	if (is_array($info["bccaddress"])){
    		foreach($info["bccaddress"] as $address){
	    		if(!$address["mail"]){
	    			echo '密送收件人邮箱不能为空';
	    			exit;
	    		}
	    		$this->objPHPMailer->AddBCC($address["mail"], $address["name"]);
	        }
    	}else{
    		$address = explode(',', $info["bccaddress"]);
    		foreach($address as $add){
    			if(!$add) continue;
	            $this->objPHPMailer->AddBCC(trim($add));
    		}
    	}

    	$attachment = isset($info["attachment"])?$info["attachment"]:'';
        if($attachment)
        {
        	$attachmenta = explode(',', $attachment);
            foreach($attachmenta as $tmpV)
            {
            	if(!$tmpV) continue;
                $this->objPHPMailer->AddAttachment($tmpV);
            }
        }

        $ishtml = isset($info["ishtml"])?$info["ishtml"]:'';
        if($ishtml){
			$this->objPHPMailer->IsHTML($ishtml);
        }else{
        	$this->objPHPMailer->IsHTML(true);
        }

        if(!$info["subject"]){
        	echo  '主题不能为空！';
        	exit;
        }
        $this->objPHPMailer->Subject = $info["subject"];

        $body = isset($info["body"])?$info["body"]:'';
        if(!$body){
        	 $this->objPHPMailer->Body = $info["subject"];
        }else{
        	$this->objPHPMailer->Body = $body;
        }

        return $this->objPHPMailer->Send();

        while (true) {
        	$tmpSendResult = $this->objPHPMailer->Send();
	        if ($tmpSendResult) {
				return $tmpSendResult;
	        }
	        $retry_times--;
	        if ($retry_times < 0) {
	        	break;
	        }

	        sleep($retry_frequency);
        }
	}
}
