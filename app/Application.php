<?php

namespace App;

use App\Exceptions\NotFoundException;

class Application
{
    public function run()
    {
        try {
            Router::getRoute();
        } catch (NotFoundException $exception) {
            echo $exception->getMessage();
            header("HTTP/1.0 404 Not Found");
            exit(1);
        }
    }
}