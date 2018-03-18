<?php
namespace App;

use App\Exceptions\NotFoundException;

class Router
{
    public static function parseUri()
    {
        $uriParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($uriParts[1]) ? $uriParts[1] : 'index';
        $actionType = !empty($uriParts[2]) ? $uriParts[2] : 'index';
        return ['name' => $controllerName, 'action' => $actionType];
    }
}
