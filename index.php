<?php

class Transmit
{
    private $des = "";
    private $key = "xpYZA7GjGWeqbyDl6SmOeIE8zURKaU";

    private $requestUrlConf = [];

    private $isCiphertext = true;

    public function __construct($isCiphertext = true)
    {
        if ($_REQUEST['update'] == "ok") {
            $this->update();
            die();
        }
        if ($_REQUEST['debug'] == 'ok' || $_REQUEST['act']) {
            $isCiphertext = false;
        }
        $this->isCiphertext = $isCiphertext;
        if ($isCiphertext) {
            $des = new Des($this->key);
            $this->des = $des;
        }
    }

    private function update()
    {
//        $res=shell_exec("/usr/bin/svn up /var/www/html/");
        $res = shell_exec("sh /var/www/html/update.sh");
        echo '<pre>';
        die(var_dump(111, $res) . '<pre>');
    }

    function requestUrlConf($key = "")
    {
        if (!$this->requestUrlConf) {
            $this->requestUrlConf = include "./requestUrlConf.php";
        }
        if ($key) {
            return $this->requestUrlConf[$key];
        }
        return $this->requestUrlConf;
    }

    /**
     * 运行
     */
    function run()
    {
        if ($this->isCiphertext) {
            $data = file_get_contents("php://input");
            if (!$data) {
//                die("not data");
                return;
            }

            $result = $this->decryptData($data);
            if (!$result) {
//                die("not result");
                return;
            }
            parse_str($result, $info);
        } else {
            $info = $_REQUEST;
        }
        echo $this->sendUrl($info);
    }

    private function decryptData($data)
    {
        $result = $this->des->Decrypt($data, $this->key);
        return $result;
    }

    private function sendUrl($info)
    {
        if (!$info) {
//            die("not info");
            return;
        }
        $act = $info['act'];
        if (!$act) {
            return;
        }

        $hostName = $_SERVER['HTTP_HOST'];
        $info['hostName'] = $hostName;

        $url = $this->requestUrlConf($act);
        if (!$url) {
            return "";
        }
        $res = $this->curlRequest($url, $info, "POST");
        return $this->returnData($res);
    }

    private function returnData($res)
    {
        if ($this->isCiphertext) {
            $returnData = $this->des->Encrypt($res, $this->key);
        } else {
            $returnData = $res;
        }
        return $returnData;
    }

    /**
     * 模拟curl进行url请求
     * @param string $url
     * @param array $data
     * @param string $method
     * @return array|bool|mixed
     */
    function curlRequest($url = '', $data = [], $method = "GET")
    {
        if (empty($url) || empty($data)) {
            return false;
        }
        if ($method == "GET") {
            $url = trim($url, "&?");
            $flag = "?";
            if (strrpos($url, "?") !== false) {
                $flag = "&";
            }
            $url .= $flag . http_build_query($data);
        }

        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL, $url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if ($method == 'POST') {
            $curlPost = http_build_query($data);
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        }

        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }
}

final class Des
{
    var $iv;

    public function __construct($key)
    {
        $this->iv = $this->getDesKey($key);
    }

    //加密
    public function Encrypt($data, $key)
    {
        if (empty($key) || empty($data)) {
            return '';
        }

        try {
            $size = mcrypt_get_block_size(MCRYPT_DES, MCRYPT_MODE_CBC);
            $str = $this->pkcs5Pad($data, $size);
            return strtoupper(bin2hex(mcrypt_cbc(MCRYPT_DES, $this->iv, $str, MCRYPT_ENCRYPT, $this->iv)));
        } catch (Exception $e) {
            return '';
        }
    }

    //解密
    public function Decrypt($data, $k)
    {
        if (empty($k) || empty($data)) {
            return '';
        }

        try {
            $strBin = $this->hex2bin(strtolower($data));
            $str = mcrypt_cbc(MCRYPT_DES, $this->iv, $strBin, MCRYPT_DECRYPT, $this->iv);
            return $this->pkcs5Unpad($str);
        } catch (Exception $e) {
            return '';
        }
    }

    function getDesKey($k)
    {
        return substr(strtoupper(hash('md5', $k)), 0, 8);
    }

    function hex2bin($hexData)
    {
        $binData = '';
        for ($i = 0; $i < strlen($hexData); $i += 2) {
            $binData .= chr(hexdec(substr($hexData, $i, 2)));
        }
        return $binData;
    }

    function pkcs5Pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }

    function pkcs5Unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text))
            return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad)
            return false;
        return substr($text, 0, -1 * $pad);
    }
}

$transmit = new Transmit();
$transmit->run();