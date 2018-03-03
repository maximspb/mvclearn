<?php

namespace App;

use App\Exceptions\NotFoundException;

class Application
{

    /**
     * @var Request
     * объект Request
     */

    protected static $request;
    public function __construct()
    {

        static::$request = new Request();
    }

    public function run()
    {
        try {
            Router::getRoute();
        } catch (NotFoundException|\Throwable $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }
    public static function getRequest($param)
    {
        return static::$request->addRequest($param);
    }

    public static function getMultiple()
    {
        return static::$request->allValues();
    }
}
