<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';
$config = require_once __DIR__.'/../app/configs/config-main.php';

try {
    ((new \App\Application($config))->run());
} catch (\App\Exceptions\DbConnectException $e) {
    echo $e->getMessage();
    exit(1);
}
