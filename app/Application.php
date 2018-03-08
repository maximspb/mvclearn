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
    protected $view;
    public function __construct(array $config)
    {
        $this->request = new Request();
        $this->view = new View($config);
        static::$connect = Database::getInstance($config);
        //конфиг передается в защищенное свойство на случай,
        //если в дальнейшем появятся дополнительные запросы к нему:
        $this->config = $config;
    }

    public function run()
    {
        try {
            ((new Router())->makeController($this->request, $this->view));
        } catch (NotFoundException|\Throwable $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }

    /**
     * статичный метод для обращения к БД в моделях
     */
    public static function getConnect()
    {
        return static::$connect;
    }
}
