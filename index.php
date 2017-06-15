<?php
/**
 * Created by PhpStorm.
 * User: chh
 * Date: 16-7-9
 * Time: 下午3:53
 */

include_once(__DIR__ . "/vendor/autoload.php");

$queue = new \malihome\queue\Queue("httpsqs", array("SERVER"=>"127.0.0.1", "PORT"=>"1218", "auth"=>"", "timeout"=>"60", "key"=>"testlist"));

//$queue->push(0);

echo ( $queue->status());