<?php

namespace App\Models;

use App\BaseModel;
use App\Database;

class Comment extends BaseModel
{
    protected $newsId;
    protected $username;
    protected $text;
    protected static $table = 'comment';

    public static function findNewsComments($id)
    {
        $options =[':id' => $id];
        $sql = 'SELECT * from comment WHERE newsId =:id';
        return Database::getInstance()->query($sql, $options);
    }

    protected function usernameValidate(string $username)
    {
        return strlen($username) > 2;
    }

    protected function textValidate(string $text)
    {
        return !empty($text);
    }

    protected function newsIdValidate($newsId)
    {
        return !empty($newsId);
    }
}
