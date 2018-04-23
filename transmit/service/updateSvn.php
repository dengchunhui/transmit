<?php
/**
 * php /var/www/html/transmit/service/updateSvn.php
 *
 */
if (!defined("ROOT")) {
    define("ROOT", dirname(dirname(__FILE__)) . "/");
}

include ROOT . "classlib/Tools.php";

$res = update();
echo $res;

function isExistScript($script)
{
    $shell = "ps -aux | grep 'S.*$script' | grep -v grep | wc -l";
}

function update()
{
    $path = Tools::getParam('path', str_replace("transmit/", "", ROOT));

    $shell = "export LANG=en_US.UTF-8 && svn cleanup $path && svn up $path 2>&1";
    exec($shell, $res);
    $str = end($res);
    if (strrpos($str, "revision") === false) {
        return 0;
    }

    $arr = explode(" ", $str);
    $version = intval(end($arr));
    return $version;
}