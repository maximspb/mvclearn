<?php
namespace App;

class Request
{

    protected $method;
    protected $uriParts;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uriParts = explode('/', $_SERVER['REQUEST_URI']);
    }

    public function addRequest($param, $default = null)
    {
        return $_REQUEST[$param] ?? $default;
    }


    /**
     * @return array
     * получение массива переданных параметров
     */
    public function allValues()
    {
        $result =[];
        foreach ($_REQUEST as $key => $value) {
            $result[$key] = $value;
        }
        return $result;
    }

    public function getControllerName()
    {
        $controller = !empty($this->uriParts[1]) ? $this->uriParts[1] : 'index';
        return $controller;
    }

    public function getActionType()
    {
        $actionType = !empty($this->uriParts[2]) ? $this->uriParts[2] : 'index';
        return $actionType;
    }
}
