<?php

class Flock
{
    const PATH = "/tmp/flock/";

    private $file = "";
    private $fp = "";
    public $isLock = false;

    /**
     * 文件锁
     * @param $flag 文件标识
     * @param bool $isDeadlock 是否死锁，默认false
     * true:一旦检测到文件是锁定状态，则终止脚本
     * false：一旦检测到文件是锁定状态，则不断检测文件，直到文件锁解开，就继续执行下面的代码
     */
    public function __construct($flag, $callback, $isDeadlock = false)
    {
        $path = self::PATH;
        if (!is_dir($path)) {
            mkdir($path);
        }
        $file = $path . $flag . ".txt";
        $this->file = $file;

        if (!file_exists($file)) {
            fopen($file, 'wb');
        }

        $fp = fopen($file, 'r+');
        $this->fp = $fp;

        while (true) {
            if (!flock($fp, LOCK_EX | LOCK_NB)) {
                $this->isLock = true;
                if ($isDeadlock) {
//                    echo 'Unable to obtain lock' . PHP_EOL;
                    break;
                } else {
//                    echo 'flock sleep：1' . PHP_EOL;
                    sleep(1);
                }
            } else {
//                echo "call_user_func" . PHP_EOL;
                call_user_func($callback);
                fclose($fp);
                unlink($file);
                break;
            }
        }
    }

    public function __destruct()
    {
//        echo "fclose __destruct" . PHP_EOL;
//        echo "this->isLock" . (int)$this->isLock . PHP_EOL;
        if (file_exists($this->file)) {
            fclose($this->fp);
            if (!$this->isLock) {
                unlink($this->file);
            }
        }
    }

}