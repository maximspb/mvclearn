<?php

namespace App\Exceptions\Validate;

class TextException extends ValidateException
{
    protected $message = 'Не введен текст';
    public $errorName = 'commentText';
}
