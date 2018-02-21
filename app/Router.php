<?php
namespace App;

use App\Exceptions\NotFoundException;

class Router
{

    public static function getRoute(Request $request)
    {

        $class = '\\App\\Controllers\\'.ucfirst($request->getControllerName()).'Controller';

        if (class_exists($class)) {
            $controller = new $class();
        } else {
            throw new NotFoundException();
        }

        $action = 'action'.ucfirst($request->getActionType());

        try {
                $controller->$action();
        } catch (\Throwable  $exception) {
            return null;
        }
    }
}
