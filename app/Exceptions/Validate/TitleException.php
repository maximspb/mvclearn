<?php
namespace App\Exceptions\Validate;

class TitleException extends ValidateException
{
    protected $message = 'Не введен заголовок';
    public $errorName = 'titleError';
}