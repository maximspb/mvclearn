<?php
return [

    'dbConnect' => [
        'host' => 'localhost',
        'dbname' => 'learnbase',
        'charset' => 'UTF8',
        'username' => 'root',
        'passwd' => ''
    ],
    'templates' => [
        'path'=>__DIR__.'/../Views/templates'
    ],
    'cache' => [
        'twig'=>__DIR__.'/../cache/twig_cache',
    ],

];
