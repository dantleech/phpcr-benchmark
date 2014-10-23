#!/usr/bin/env php
<?php

require_once(__DIR__ . '/common.php');

use PHPCR\Benchmark\Consumer;

$consumer = new Consumer(
    $config['rabbitmq']['host'],
    $config['rabbitmq']['port'],
    $config['rabbitmq']['user'],
    $config['rabbitmq']['pass'],
    $config['statsd']['host'],
    $config['statsd']['port']
);
$consumer->consume();
