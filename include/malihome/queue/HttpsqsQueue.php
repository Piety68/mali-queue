<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-11
 * Time: 下午5:56
 */

namespace malihome\queue;

class HttpsqsQueue {
    protected $connect_str;

    public function connect($config) {
        $this->connect_str = "http://" . $config['SERVER'] . ":" . $config['PORT'] . "/?auth=" . $config['auth'] . "&name=" . $config['key'];
    }

    public function push($value) {
        $this->connect_str .= "&opt=put&data=" . $value;
        $return = $this->httpGet($this->connect_str);
        if($return == "HTTPSQS_PUT_OK") {
            return true;
        } else {
            return false;
        }
    }

    public function pop() {
        $this->connect_str .= "&opt=get";
        $return = $this->httpGet($this->connect_str);
        if($return == "HTTPSQS_ERROR" || $return == "HTTPSQS_GET_END") {
            return false;
        }
        return $return;
    }

    public function status() {
        $this->connect_str .= "&opt=status";
        $return = $this->httpGet($this->connect_str);
        return $return;
    }

    public function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }
}