<?php
namespace App;

use App\Exceptions\NotFoundException;

class Router
{
    public function makeController(Request $request, View $view)
    {
        $uriParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($uriParts[1]) ? $uriParts[1] : 'index';
        $actionType = !empty($uriParts[2]) ? $uriParts[2] : 'index';
        $class = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';

        if (class_exists($class)) {
            $controller = new $class($request, $view);
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
