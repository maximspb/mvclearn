<?php
namespace App;

class Config
{
    /**
     * @var Config
     * экземпляр класса
     */
    private static $instance;
    private $params = [];
    protected function __construct()
    {
        $this->params = include __DIR__.'/configs/config-main.php';
    }
    public static function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getParams()
    {
        return $this->params;
    }
}
