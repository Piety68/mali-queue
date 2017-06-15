<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-20
 * Time: 上午11:30
 */

require_once('../vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;

$conn = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
$channel = $conn->channel();

$channel->exchange_declare("test_logs", "direct");

$callback = function($msg) {
    echo $msg->body . "\r\n";
};

$log_types = array("error", "notice", "alert");
foreach($log_types as $type) {
    list($queue_name,,) = $channel->queue_declare("", false, false, false, false);
    $channel->queue_bind($queue_name, "test_logs", $type);
    $channel->basic_consume($queue_name, '', false, false, false, false, $callback);
}

while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();

$conn->close();





