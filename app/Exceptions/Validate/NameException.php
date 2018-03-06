<?php
namespace App\Exceptions\Validate;

class NameException extends ValidateException
{
    protected $message = 'Некорректное имя пользователя';
    public $errorName = 'name';
}
