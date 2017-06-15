<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-9
 * Time: 下午3:16
 */

namespace malihome\queue;

class Queue {

    protected $queue;

    public function __construct($queue_type, $connection_config) {
        $queue_class = "\\malihome\\queue\\" . ucfirst($queue_type) . "Queue";
        if(class_exists($queue_class)) {
            $this->queue = new $queue_class();
            call_user_func_array(array($this->queue, "connect"), array($connection_config));
        } else {
            die("unrecognized queue type");
        }
    }

    public function push($value) {
        $this->queue->push($value);
    }

    public function pop() {
        return $this->queue->pop();
    }

    public function status() {
        return $this->queue->status();
    }
}

