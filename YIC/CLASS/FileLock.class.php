<?php
class FileLock implements LockInterFace {
    public function getLock($filename, $lockTime) {
        if(file_exists($filename) && time() - filectime($filename) < $lockTime) {
            return false;
        }

        # 分配锁
        $fp = fopen($filename, "w+");
        fclose($fp);
        return true;
    }

    public function releaseLock($filename) {
        unlink($filename);
    }
}