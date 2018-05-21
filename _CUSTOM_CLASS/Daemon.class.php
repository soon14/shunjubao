<?php
/**
 * 使一个php命令行脚本成为守护进程
 * usage：Daemon::create()
 *
 * @author gaoxiaogang@gmail.com
 *
 */
class Daemon {
    static public function create() {
    	if (!Runtime::isCLI()) {
    		throw new Exception('非命令行环境，不允许创建守护进程！');
    	}

    	if (!Runtime::isUnixLike()) {
    		throw new Exception('只能在类unix操作系统下使用！');
    	}

    	/**
    	 * 创建一个父进程的副本
    	 * @var int -1：表示执行失败；0：表示在子进程中；int(>0):表示在父进程中
    	 */
	    $pid = pcntl_fork();

	    if ($pid === -1 ) {//执行失败
	        return false;
	    } else if ($pid) {//父进程
	        usleep(500);
	        exit();
	    }

	    # 将守护进程放到总是存在的目录中，另外一个好处是，你的常驻进程不会限制你umount一个文件系统。
	    chdir("/");

	    # 将守护进程放到总是存在的目录中，另外一个好处是，你的常驻进程不会限制你umount一个文件系统。
	    umask(0);

	    # 使新进程成为一个新会话的“领导者”，然后使该进程不再控制终端。这是成为守护进程最关键的一步
	    # Returns the session id, or -1 on errors.
	    $sid = posix_setsid();
	    if (!$sid) {
	        return false;
	    }

	    # 再一次fork。这一步不是必须的，但通常都这么做，它最大的意义是防止获得控制终端。
	    # ps：在直接打开一个终端设备，而且没有使用O_NOCTTY标志的情况下, 会获得控制终端
	    $pid = pcntl_fork();
	    if ($pid === -1) {
	        return false;
	    } else if ($pid) {
	        usleep(500);
	        exit(0);
	    }

	    # 关闭标准I/O流
	    # 注意，如果有输出(echo)，则守护进程会失败。所以通常将STDIN, STDOUT, STDERR重定向某个指定文件.
	    if (defined('STDIN')) {
	        fclose(STDIN);
	    }
//	    if (defined('STDOUT')){
//	        fclose(STDOUT);
//	    }
//	    if (defined('STDERR')) {
//	        fclose(STDERR);
//	    }
    }
}