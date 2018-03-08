<?php

namespace App;

use App\Exceptions\NotFoundException;

class Application
{

    /**
     * @var Request
     * объект Request
     */
    protected $request;
    protected $config = [];
    protected static $connect;
    //protected $view;
    public function __construct(array $config)
    {

        $this->request = new Request();
        $this->config = $config;
        static::$connect = Database::getInstance($config);
        //$this->view = new View($this->config);
    }

    public function run()
    {
        try {
            $view = new View($this->config);
            ((new Router())->route($this->request, $view, static::$connect));
        } catch (NotFoundException|\Throwable $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }

    public static function getConnect()
    {
        return static::$connect;
    }
}
