<?php

namespace App;

use App\Exceptions\DbConnectException;
use App\Exceptions\MultiException;
use App\Exceptions\NotFoundException;
use App\Exceptions\Validate\ValidateException;

abstract class BaseModel
{

    /**
     * @var
     * имя таблицы модели в базе данных
     */
    protected static $table;
    public $id;

    public static function findAll()
    {
        $sql = 'SELECT * FROM '. static::$table;
        try {
            return Database::getInstance()->query($sql, [], static::class);
        } catch (DbConnectException $exception) {
            echo $exception->getMessage();
            exit(1);
        }
    }


    public static function findOne($id)
    {
        $sql = 'SELECT * FROM '. static::$table. ' WHERE id =:id';
        $options =[':id'=>$id];
        try {
            $result = Database::getInstance()->query($sql, $options, static::class);
            if (!empty($result)) {
                return $result[0];
            } else {
                throw new NotFoundException();
            }
        } catch (DbConnectException|NotFoundException $e) {
            echo $e->getMessage();
            exit(1);
        }
    }


    protected function insert()
    {
        $vars = get_object_vars($this);
        $tableFields =[];
        $insertValues =[];

        foreach ($vars as $propertyName => $value) {
            if ('id' === $propertyName) {
                continue;
            }

            $tableFields[] = $propertyName;
            $insertValues[':'.$propertyName] = $value;
        }

        $sql = 'INSERT INTO '.static::$table.
            ' ('.implode(', ', $tableFields).') VALUES ('.
            implode(', ', array_keys($insertValues)).')'
        ;
        try {
            Database::getInstance()->execute($sql, $insertValues);
        } catch (DbConnectException $e) {
            echo $e->getMessage();
            exit(1);
        }
        $this->id = Database::getInstance()->setId();
    }


    protected function update()
    {
        $vars = get_object_vars($this);
        $setFields = [];
        $updateValues =[':id' => $this->id];
        foreach ($vars as $propertyName => $value) {
            if ('id' === $propertyName) {
                continue;
            }
            $setFields[] = $propertyName.' = :'.$propertyName;
            $updateValues[':'.$propertyName] = $value;
        }

        $sql = 'UPDATE '
            .static::$table.
            ' SET '.implode(', ', $setFields).
            ' WHERE id = :id';
        try {
            Database::getInstance()->execute($sql, $updateValues);
        } catch (DbConnectException $e) {
                echo $e->getMessage();
                exit(1);
        }
    }


    public static function delete($id)
    {
        $options =[':id'=>$id];
        $sql = 'DELETE  FROM '. static::$table.' WHERE id = :id';
        try {
            Database::getInstance()->execute($sql, $options);
        } catch (DbConnectException $e) {
            echo $e->getMessage();
            exit(1);
        }
    }

    public function save()
    {
        if (!empty($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    /**
     * @param array $data
     * @throws MultiException
     * метод заполнения модели данными из массива,
     * к примеру - из полей формы. В случае невалидного
     * ввода какого-либо поля в объект-мультиисключение
     * записывается соответствующее исключение.
     */
    public function fill(array $data)
    {
        $errors = new MultiException();
        foreach ($data as $property => $value) {
            if ('id'== $property || !property_exists($this, $property)) {
                continue;
            }

            $exception ='App\\Exceptions\\Validate\\'. ucfirst($property).'Exception';
            $validation = $property.'Validate';

            if (method_exists($this, $validation) && !$this->$validation($value)) {
                if (class_exists($exception)) {
                    $errors->addError(new $exception);
                } else {
                    $errors->addError(new ValidateException());
                }
            }
        }
        if ($errors->empty()) {
            foreach ($data as $key => $value) {
                if (!property_exists($this, $key)) {
                    continue;
                }
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        } else {
            throw $errors;
        }
    }
}
