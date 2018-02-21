<?php

namespace App\Models;

use App\BaseModel;
use App\Database;

class Comment extends BaseModel
{
    protected $newsId;
    protected $username;
    protected $text;

    public function __construct($newsId, $username, $text)
    {
        $this->newsId = $newsId;
        $this->username = $username;
        $this->text = $text;
        parent::__construct();
    }

    public static function findArticleComments($options = [])
    {
        $sql = 'SELECT * from comment WHERE newsId =:id';
        return Database::getInstance()->query($sql, $options);
    }



}
