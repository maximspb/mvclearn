<?php

namespace App;

use App\Exceptions\NotFoundException;

class Application
{
    protected $request;
    public function __construct()
    {
        $this->request = new Request();
    }

    public function run()
    {
        try {
            Router::getRoute($this->request);
        } catch (NotFoundException|\Throwable $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }
}