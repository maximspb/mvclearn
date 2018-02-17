<?php

namespace App\Controllers;

use App\Models\Comment;
use App\Models\News;

class IndexController extends Controller
{


    public function actionIndex()
    {
        $news = News::findAll();
        include __DIR__.'/../Views/templates/index.php';
    }












}