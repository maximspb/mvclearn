<?php

namespace App\Exceptions\Validate;

class UnknownUserException extends ValidateException
{
    public $errorName = 'user';
    protected $message = 'Пользователь с таким e-mail не зарегистрирован';
}