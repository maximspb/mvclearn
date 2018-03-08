<?php
namespace App;

use App\Exceptions\NotFoundException;

class Router
{

    public static function getRoute()
    {
        $uriParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($uriParts[1]) ? $uriParts[1] : 'index';
        $actionType = !empty($uriParts[2]) ? $uriParts[2] : 'index';
        $class = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';

        if (class_exists($class)) {
            $controller = new $class();
        } else {
            throw new NotFoundException();
        }

        $action = 'action'.ucfirst($actionType);

        try {
                $controller->$action();
        } catch (\Throwable  $exception) {
            return null;
        }
    }


    public function route(Request $request, View $view, Database $connect)
    {


        $uriParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($uriParts[1]) ? $uriParts[1] : 'index';
        $actionType = !empty($uriParts[2]) ? $uriParts[2] : 'index';
        $class = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';

        if (class_exists($class)) {
            $controller = new $class($request, $view, $connect);
        } else {
            throw new NotFoundException();
        }

        $action = 'action'.ucfirst($actionType);

        try {
            $controller->$action();
        } catch (\Throwable  $exception) {
            return null;
        }
    }
}
