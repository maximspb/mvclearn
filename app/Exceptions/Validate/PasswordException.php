<?php
namespace App\Exceptions\Validate;

class PasswordException extends ValidateException
{
    protected $message = 'Некорректный пароль';
    public $errorName = 'password';
}
