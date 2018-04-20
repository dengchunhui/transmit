<?php
class Transmit
{
    private $des = "";
    private $key = "xpYZA7GjGWeqbyDl6SmOeIE8zURKaU";

    private $requestUrlConf = [];

    private $isCiphertext = true;

    public function __construct($isCiphertext = true)
    {
        if ($_REQUEST['debug'] == 'ok' || $_REQUEST['act']) {
            $isCiphertext = false;
        }
        $this->isCiphertext = $isCiphertext;
        if ($isCiphertext) {
            $des = new Des($this->key);
            $this->des = $des;
        }
    }

    private function requestUrlConf($key = "")
    {
        if (!$this->requestUrlConf) {
            $this->requestUrlConf = include ROOT.'requestUrlConf/conf.php';
        }
        if ($key) {
            return $this->requestUrlConf[$key];
        }
        return $this->requestUrlConf;
    }

    /**
     * 运行
     */
    public function run()
    {
        if ($this->isCiphertext) {
            $data = file_get_contents("php://input");
            if (!$data) {
                return;
            }
            $data = trim($data, "|||");
            $datas = explode("|||", $data);
            $result = "";
            foreach ($datas as $value) {
                $result .= $this->decryptData($value);
            }

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
        $info['userIp'] = $_SERVER["REMOTE_ADDR"];

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
            $res = urlencode($res);
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
    private function curlRequest($url = '', $data = [], $method = "GET")
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