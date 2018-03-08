<?php
namespace App\Exceptions\Validate;

class UsernameException extends ValidateException
{
    protected $message = 'Некорректный юзернейм';
    public $errorName = 'username';
}