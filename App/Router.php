<?php
namespace App;

use App\Exceptions\NotFoundException;

class Router
{

    public static function getRoute()
    {


        /*$controllerName = !empty($_GET['controller']) ? $_GET['controller'] : 'index';
        $actionType = !empty($_GET['action']) ? $_GET['action'] : 'index';*/

        $uriParts = explode('/', $_SERVER['REQUEST_URI']);
        $controllerName = !empty($uriParts[1]) ? $uriParts[1] : 'index';
        $actionType = !empty($uriParts[2]) ? $uriParts[2] : 'index';

        $class = '\\App\\Controllers\\'.ucfirst($controllerName).'Controller';

        if (class_exists($class)) :
            $controller = new $class();
        else :
            throw new NotFoundException('Неверный адрес');
        endif;

        $action = 'action'.ucfirst($actionType) ?? 'actionIndex';

        try {
                $controller->$action();
        } catch (\Throwable  $exception) {
            throw $exception;
        }
    }


}
