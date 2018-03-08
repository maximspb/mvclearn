<?php

namespace App\Exceptions\Validate;

use App\Exceptions\BaseException;

class ValidateException extends BaseException
{
    protected $message = 'Smth is wrong';
    public $errorName;
}
