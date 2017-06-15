<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-9
 * Time: 下午3:52
 */

namespace malihome\queue;

class RedisQueue {
    protected $redis;
    protected $key;

    public function connect($config) {
        $this->redis = new \Redis();
        if(!$this->redis->connect($config['SERVER'], $config['PORT'], $config['timeout'])) {
            die('redis connect failed');
        }

        $this->key = $config['key'];
    }

    public function push($value) {
        $this->redis->lPush($this->key, $value);
    }

    public function pop() {
        $value = $this->redis->rPop($this->key);
        return ($value !== NULL) ? $value : false;
    }

    public function status() {
        return sprintf("队列名：%s，当前队列长度：%d" . PHP_EOL, $this->key, $this->redis->lLen($this->key));
    }


}