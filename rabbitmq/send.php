<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-20
 * Time: 上午11:30
 */

require_once('../vendor/autoload.php');

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$conn = new AMQPStreamConnection('127.0.0.1', 5672, 'guest', 'guest');
$channel = $conn->channel();

$channel->exchange_declare("test_logs", "direct");

$data = $argv[1];
$log_type = $argv[2];

$msg = new AMQPMessage($data);

$channel->basic_publish($msg, "test_logs", $log_type);

$channel->close();
$conn->close();