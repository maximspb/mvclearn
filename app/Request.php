<?php
namespace App;

class Request
{

    protected $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestVars($param, $default = null)
    {
        switch ($this->method) {
            case 'GET':
                return $this-> get($param, $default);
                break;
            case 'POST':
                return $this->post($param, $default);
                break;
            default:
                return null;
        }
    }

    protected function get($param, $default = null)
    {
        if (isset($_GET[$param])) {
            return $_GET[$param];
        }
        return $default;
    }

    protected function post($param, $default = null)
    {
        if (isset($_POST[$param])) {
            return $_POST[$param];
        }
        return $default;
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
