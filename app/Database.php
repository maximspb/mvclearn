<?php

namespace App;

use App\Config;
use App\Exceptions\DbConnectException;

/**
 * Class Database
 * @package App
 * класс-синглтон
 */
class Database
{
    private $connect;

    private static $instance;

    private function __construct()
    {
        $config  = Config::getInstance()->getParams()['dbConnect'];
        try {
            $this->connect = new \PDO(
                'mysql:host='.$config['host'].'; 
                dbname='.$config['dbname'].';
                charset='.$config['charset'],
                $config['username'],
                $config['passwd']
            );
        } catch (\PDOException $exception) {
            throw new DbConnectException();
        }
    }



    public static function getInstance()
    {
        if (empty(self::$instance)) {
            try {
                self::$instance = new self();
            } catch (DbConnectException $e) {
                echo $e->getMessage();
                exit(1);
            }
        }
        return self::$instance;
    }

    public function query(string $sql, array $params = [], $class = \stdClass::class)
    {
        $stmt = $this->connect->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function execute(string $sql, array $params = [])
    {
        $stmt = $this->connect->prepare($sql);
        $stmt->execute($params);
    }

    /**
     * @return mixed
     * метод для присвоения id новому объекту, берется из базы данных
     */
    public function setId()
    {
        return $this->connect->lastInsertId();
    }
}
