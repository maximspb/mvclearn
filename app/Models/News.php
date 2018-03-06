<?php


namespace App\Models;

use App\BaseModel;

class News extends BaseModel
{
    public $title;
    public $text;
    protected static $table = 'news';

    protected function titleValidate(string $title)
    {
        return !empty($title);
    }

    protected function textValidate(string $text)
    {
        return !empty($text);
    }
}
