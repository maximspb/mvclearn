<?php

namespace App;

use App\Exceptions\DbConnectException;
use App\Exceptions\NotFoundException;

class Application
{

    /**
     * @var Request
     * объект Request
     */
    protected $request;
    protected $config = [];
    protected $view;

    public function __construct(array $config)
    {
        $this->request = new Request();
        $this->view = new View($config);
        $this->config = $config;
    }

    public function run()
    {
        $routeParams = Router::parseUri();
        try {
            $class = '\\App\\Controllers\\'.ucfirst($routeParams['name']).'Controller';
            $action = 'action'.ucfirst($routeParams['action']);
            $controller = new $class($this->request, $this->view);
            $controller->$action();
        } catch (NotFoundException|\Throwable $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }
}
