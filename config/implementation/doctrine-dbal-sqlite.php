<?php

$path = realpath(__DIR__ . '/../..') . '/data/doctrine-dbal-sqlite/app.sqlite';

return array(
    'user' => 'root',
    'driver' => 'pdo_sqlite',
    'dbname' => 'phpcr',
    'path' => $path,
);
