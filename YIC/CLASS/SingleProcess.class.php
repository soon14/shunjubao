<?php
/**
 * 这是一个辅助性的东西，当你希望某个操作只运行一个进程的时候（例如生成缓存，既然生成缓存，几十个同时跑，我觉得还不如不要呢）
 * 还有像优享团结团后，发成功通知的短信，发了一次还发？sb了呢！
 *
 * @author gaoxiaogang@gmail.com
 *
 */
class SingleProcess {
    /**
     * 唯一标识
     * @var string
     */
    private $pid;

    /**
     * 最大生存时间 单位：秒
     * @var int
     */
    private $timeout;

    /**
     * 是否检查操作系统进程
     * 该值为true时，将检查操作系统中的进程是否存在。如果不存在，返回已超时。
     * 只用于(unix/linux)
     * @var boolean
     */
    private $checkSystemProcess;

    public function __construct($pid, $timeout = 600, $checkSystemProcess = false) {
        if (!self::isValidPid($pid)) {
            throw new Exception('invalid $pid');
        }

        if (!isInt($timeout) || $timeout < 1) {
            throw new Exception('invalid $lifetime');
        }

        if (!is_bool($checkSystemProcess)) {
            throw new Exception('invalid $checkSystemProcess');
        }

        $this->pid = $pid;
        $this->timeout = (int) $timeout;
        $this->checkSystemProcess = $checkSystemProcess;
    }

    /**
     * 1、检测一个进程是否正在运行，如果返回true 那么就是正在运行，如果false 表示已经结束，你可以放心使用！
     * 2、当进程已经超时，也会返回false
     * 3、如果指定$this->checkSystemProcess为true，将检查操作系统中的进程是否存在。如果不存在，返回false。
     *
     * @return boolean
     */
    public function isRun() {
        $pf = $this->getPidPath();

        # 不存在
        if (!file_exists( $pf )) {
            return false;
        }

        # 超时了
        if ($this->isTimeout()) {
            $this->kill();
            return false;
        }

        # 系统进程不存在了，就认为前一个进程已经结束了。
        if ($this->checkSystemProcess) {
	        $spid = $this->getSystemPid();
	        if (!self::existSystemProcess($spid)) {
	        	return false;
	        }
        }

        return true;
    }

    /**
     * 开始运行一个进程（声明：这只是一个虚拟的辅助操作，不要乱想）
     *
     * @return Boolean
     */
    public function run() {
        file_put_contents($this->getPidPath(), getmypid());

        return true;
    }

	/**
	 * 激活
	 * 如果new SignleProcess　时指定的timeout是600秒，当这个时间到达时，另一个进程就会将当前进程杀死。
	 * 而active方法的作用，就是重新计算超时时间。
	 * @param $activeFrequency 激活频率   300秒，即五分钟激活一次
	 * @return boolean
	 */
	public function active($activeFrequency = 300) {
		static $time_prev = null;
		if (is_null($time_prev)) {
			$time_prev = time();
		}

		$time_now = time();
	    # 达到激活频率，声明脚本还活着
	    if ($time_now - $time_prev >= $activeFrequency) {
	        $time_prev = $time_now;//更新上次激活时间
	        $this->run();
	        return true;
	    }
	    return false;
	}

    /**
     * 进程结束
     *
     * @return Boolean
     */
    public function complete() {
        @unlink($this->getPidPath());

        return true;
    }

    /**
     * 终止一个进程
     *
     * @return Boolean
     */
    public function kill() {
    	$pf = $this->getPidPath();
        if (!file_exists($pf)) {
            return true;
        }

        if ($this->checkSystemProcess) {
        	$spid = $this->getSystemPid();
        	if ($spid) {
        		exec("kill -9 {$spid}");
        	}
        }

        @unlink($pf);
        sleep(1);

        return true;
    }

    /**
     * 清除所有进程记录，不管有没结束
     *
     * @param boolean $checkSystemProcess 是否检查操作系统进程
     * @return Boolean
     */
    static public function cleanup($checkSystemProcess = false) {
        $path = self::getPath().'*';

        foreach (glob($path) as $filename) {
        	if ($checkSystemProcess) {
        		$spid = file_get_contents($filename);
        		if (self::existSystemProcess($spid)) {
        			exec("kill -9 {$spid}");//同时杀死该pid对应的操作系统进程
        		}
        	}

            @unlink($filename);
        }
        sleep(10);//休眠10秒
        return true;
    }

    /**
     * 取得缓存路径，如果不存在，自动创建
     *
     * @return String
     */
    static private function getPath() {
        $path  = LOG_PATH . DIRECTORY_SEPARATOR . 'sspfiles' . DIRECTORY_SEPARATOR;
        if (!file_exists($path)) {
            if (!mkdir($path, 0777, true)) {
                return false;
            }
        }
        return $path;
    }

    /**
     * 是否超时
     * @return Boolean
     */
    private function isTimeout() {
        if ((time() - filemtime($this->getPidPath())) > $this->timeout) {
            return true;
        }

        return false;
    }

    /**
     * 获取存放pid的全路径，包括pid文件名
     * @return string
     */
    private function getPidPath() {
        return self::getPath() . md5($this->pid);
    }

    /**
     * 获取系统进程pid
     * @return int | false
     */
    private function getSystemPid() {
        $spid = @file_get_contents($this->getPidPath());
        if ($spid) {
            return $spid;
        }

        return false;
    }

    /**
     * 是否存在操作系统进程
     *
     * @param int $spid 操作系统进程id
     * @return Boolean
     */
    static private function existSystemProcess($spid) {
    	if (!isInt($spid) || $spid < 1) {
    		return false;
    	}
        $cmd = 'ps -eo pid | egrep ^\ *'.$spid.'$';
        $out = exec($cmd);
        return empty($out) ? false : true;
    }

    /**
     * 是否有效的pid
     * @param string $pid
     * @return boolean
     */
    static private function isValidPid($pid) {
        if (!is_string($pid) || empty($pid)) {
            return false;
        }

        return true;
    }
}
?>
