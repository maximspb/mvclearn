<?php

namespace App;


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

    private function __construct($config)
    {
        $config = $config['dbConnect'];

        try {
            $this->connect = new \PDO(
                'mysql:host=' . $config['host'] .
                ';dbname=' . $config['dbname'] .
                '; charset =' . $config['charset'],
                $config['username'],
                $config['passwd']
            );
        } catch (\Throwable $exception) {
            throw new DbConnectException();
        }
    }


    /**
     * @return Database
     * @throws DbConnectException
     * статичный метод вызова объекта
     */
    public static function getInstance($config)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($config);
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