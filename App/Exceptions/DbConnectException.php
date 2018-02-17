<?php

namespace App\Exceptions;


class DbConnectException extends BaseException
{
    protected $message ='Ошибка подключения к БД';

}