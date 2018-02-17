<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 2/17/18
 * Time: 7:46 AM
 */

namespace App\Exceptions;


class EditException extends BaseException
{
    protected $message ='Возникли проблемы с редактированием новости';

}