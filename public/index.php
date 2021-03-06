<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';

$app = new \App\Application();
try {
    $app->run();
} catch (\App\Exceptions\NotFoundException $e) {
    echo $e->getMessage();
    exit(1);
} catch (\App\Exceptions\CommentException $e) {
    echo $e->getMessage();
    exit(1);
} catch (\Throwable $e) {
    echo $e->getMessage();
    exit(1);
}
