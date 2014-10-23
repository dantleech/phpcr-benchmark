#!/usr/bin/env php
<?php

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

require_once(__DIR__ . '/common.php');

$implementation = $argv[1];

if (!$implementation) {
    echo "You must specify an implementation, e.g. doctrine-dbal-sqlite";
    exit(1);
}

$connection = new AMQPConnection(
    $config['rabbitmq']['host'],
    $config['rabbitmq']['port'],
    $config['rabbitmq']['user'],
    $config['rabbitmq']['pass']
);

$channel = $connection->channel();

$channel->queue_declare('phpcr_benchmark', false, false, false, false);
$msg = new AMQPMessage(json_encode(array(
    'implementation' => $implementation
)));
$channel->basic_publish($msg, '', 'phpcr_benchmark');
