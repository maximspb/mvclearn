<?php
namespace App;

class Request
{

    protected $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function addRequest($param, $default = null)
    {
        return $_REQUEST[$param] ?? $default;
    }

    public function execute($param)
    {
        switch ($this->method) {
            case 'GET' === $this->method:
                return $this-> get($param);
                break;
            case 'POST' === $this->method:
                return $this->post($param);
                break;
            default:
                return null;
        }
    }

    protected function get($param, $default = null)
    {
        return $_GET[$param] ?? $default;
    }

    protected function post($param, $default = null)
    {
        return $_POST[$param] ?? $default;
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
}
