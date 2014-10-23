<?php

$vendorDir = __DIR__.'/../vendor';

$file = $vendorDir.'/autoload.php';

if (file_exists($file)) {
    $autoload = require_once $file;
} else {
    echo 'Cannot find the vendor directory, have you executed composer install?';
    exit(1);
}

$config = require_once(__DIR__ . '/../config/config.php');

