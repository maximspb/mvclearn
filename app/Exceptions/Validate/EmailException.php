<?php

namespace App\Exceptions\Validate;

class EmailException extends ValidateException
{
    protected $message ='Некорректный e-mail';
    public $errorName = 'email';
}
