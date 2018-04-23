<?php
/**
 * php /var/www/html/transmit/service/updateSvn.php
 *
 */
if (!defined("ROOT")) {
    define("ROOT", dirname(dirname(__FILE__)) . "/");
}
include ROOT . "classlib/Tools.php";
include ROOT . "classlib/Flock.php";
$act = Tools::getParam('act');
if (!$act) {
    $act = isset($argv[1]) ? $argv[1] : "update";
}

$file = ROOT . "temp/updateSvnConf.txt";
$flag = "service-updateSvn";
if ($act == "add") {
    //判断是否有更新svn的脚本再跑
    $flock = new \Flock($flag, function () {
    }, true);
    add($file, $flock->isLock);
} elseif ($act == "update") {
    new Flock($flag, function () use ($file) {
        while (true) {
            Tools::setProcess("php " . __FILE__ . " run");
        }
    }, true);
} else if ($act == "run") {
    //判断是否是一样的脚本在跑，如有，则直接退出
    Tools::setProcessTitle("svn更新运行脚本");
    update($file);
    sleep(1);
}

function isExistScript($script)
{
    $shell = "ps -aux | grep 'S.*$script' | grep -v grep | wc -l";
}

function add($file, $isLock)
{
    $username = Tools::getParam('username', 'chunhui.deng@haiyounet.com');
    $password = Tools::getParam('password', 'deng649578964..');
    $path = Tools::getParam('path', '/var/www/html/');
    $str = "$username $password $path";
    $res = file_put_contents($file, $str);
    if (!$res) {
        die("400");
    }
    if (!$isLock) {
        die("401");
    }
    while (true) {
        if (!file_get_contents($file)) {
            echo 200;
            break;
        }
    }
}


function update($file)
{
    exec("sudo chmod -R 777 $file");
    $str = file_get_contents($file);
    if (!$str || is_numeric($str)) {
        return;
    }

    list($username, $password, $path) = explode(" ", $str);
    if (!$username || !$password || !$path) {
        return;
    }

    $shell = "sh " . ROOT . "/service/updateSvn.sh $username $password $path";
    exec($shell, $res);
    $str = end($res);
    if (strrpos($str, "At revision") !== false) {
//            echo $str . PHP_EOL;
        file_put_contents($file, "");
    }
}
