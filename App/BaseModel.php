<?php

namespace App;

use App\Exceptions\NotFoundException;

abstract class BaseModel
{

    /**
     * @var
     * имя таблицы модели в базе данных
     */
    protected static $table;

    public $id;


    public function __construct()
    {

        static::setTable();
    }

    /**
     * @throws \ReflectionException
     * статичный метод, который задает имя таблицы
     * из бд для этой модели, если имя не задано явно:
     * в качестве имени записывается имя модели в нижнем регистре
     * т.к. мы подразумеваем, что AR-модель по умолчанию одноименна
     * своей таблице в БД. Но есть возможность переопределить таблицу
     * при необходимости.
     */

    protected static function setTable()
    {
        if (empty(static::$table)) :
            static::$table = strtolower((new \ReflectionClass(static::class))
                ->getShortName());
        endif;
    }


    public static function findAll()
    {

        static::setTable();
        $sql = 'SELECT * from '. static::$table;
        return Database::getInstance()->query($sql, [], static::class);
    }


    public static function findOne($id)
    {
        static::setTable();
        $sql = 'SELECT * from '. static::$table. ' WHERE id =:id';
        $options =[':id'=>$id];

        $result = Database::getInstance()->query($sql, $options, static::class);
        if (!empty($result)) :
            return $result[0];
        else:
            throw new NotFoundException('айди');
        endif;
    }


    protected function insert()
    {
        $vars = get_object_vars($this);
        $tableFields =[];
        $insertValues =[];

        foreach ($vars as $propertyName => $value) :
            if ('id' === $propertyName) :
                continue;
            endif;

            $tableFields[] = $propertyName;
            $insertValues[':'.$propertyName] = $value;
        endforeach;

        $sql = 'INSERT INTO '.static::$table.
            ' ('.implode(', ', $tableFields).') VALUES ('.
            implode(', ', array_keys($insertValues)).')'
        ;

        Database::getInstance()->execute($sql, $insertValues);
        $this->id = Database::getInstance()->setId();
    }


    protected function update()
    {
        $vars = get_object_vars($this);
        $setFields =[];
        $updateValues =[':id'=>$this->id];

        foreach ($vars as $propertyName => $value) :
            if ('id' === $propertyName) :
                continue;
            endif;

            $setFields[] = $propertyName.' = :'.$propertyName;
            $updateValues[':'.$propertyName] = $value;
        endforeach;

        $sql = 'UPDATE '
            .static::$table.
            ' SET '.implode(', ', $setFields).
            ' WHERE id = :id';
        Database::getInstance()->execute($sql, $updateValues);
    }


    public static function delete($id)
    {
        static::setTable();
        $options =[':id'=>$id];
        $sql = 'DELETE  FROM '. static::$table.' WHERE id = :id';

        Database::getInstance()->execute($sql, $options);
    }


    public function save()
    {
        if (!empty($this->id)) :
            $this->update();
        else :
            $this->insert();
        endif;
    }
}
