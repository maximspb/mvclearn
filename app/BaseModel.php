<?php

namespace App;

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
        return Application::getConnect()->query($sql, [], static::class);
    }


    public static function findOne($id)
    {
        $sql = 'SELECT * FROM '. static::$table. ' WHERE id =:id';
        $options =[':id'=>$id];

        $result = Application::getConnect()->query($sql, $options, static::class);
        if (!empty($result)) {
            return $result[0];
        } else {
            throw new NotFoundException();
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

        Application::getConnect()->execute($sql, $insertValues);
        $this->id = Application::getConnect()->setId();
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

        Application::getConnect()->execute($sql, $updateValues);
    }


    public static function delete($id)
    {
        $options =[':id'=>$id];
        $sql = 'DELETE  FROM '. static::$table.' WHERE id = :id';
        Application::getConnect()->execute($sql, $options);
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
