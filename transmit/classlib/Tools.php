<?php

class Tools
{
    public static function getParam($key, $default = "")
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

    public static function setProcess($command, $title = '', $isSync = true)
    {
        if (PHP_SAPI != 'cli' || !$command) {
            return false;
        }

        if ($title) {
            self::setProcessTitle($title);
        }

        if (!$isSync) {
            $command = "setsid $command >/dev/null  &";
        }

        exec($command, $res);
        return $res;
    }


    /**
     * 设置进程的title
     * @param $title
     * @return bool
     */
    public static function setProcessTitle($title = '')
    {
        if (!empty($title)) {
            if (extension_loaded('proctitle') && function_exists('setproctitle')) {
                return setproctitle($title);
            } elseif (function_exists('cli_set_process_title')) {
                return cli_set_process_title($title);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}