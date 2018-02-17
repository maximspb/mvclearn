<?php

namespace App\Controllers;

use App\Database;
use App\View;
abstract class Controller
{

    protected $view;
    protected $dbConnect;
    public function __construct()
    {
        $this->view = new View();

    }

    public function actionRender(...$variables)
    {


    }

    public function actionView(string $template)
    {
        $content = $template;
        include __DIR__.'/../Views/layouts/main.php';
    }



}