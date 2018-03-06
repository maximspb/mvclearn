<?php
namespace App\Exceptions;

use App\Exceptions\Validate\ValidateException;
use App\Traits\ArrayTrait;

/**
 * Class MultiException
 * @package App\Exceptions
 * Класс-коллекция исключений
 */
class MultiException extends \Exception implements \Throwable
{

    /**
     * @var array
     * массив исключений валидации
     */
    protected $data =[];

    /**
     * @param ValidateException $error
     * сбор исключений в массив
     */
    public function addError(ValidateException $error)
    {
        $this->data[$error->errorName] = $error;
    }

    /**
     * @return bool
     * проверка наличия исключений
     */
    public function empty() : bool
    {
        return empty($this->data);
    }

    /**
     * @return array
     * публичный метод доступа к массиву исключений валидации
     */
    public function getAllErrors()
    {
        return $this->data;
    }
}