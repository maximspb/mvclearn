<?php

namespace App\Controllers;

class IndexController extends Controller
{
    public function actionIndex()
    {

        $this->view->display('index.twig');
    }


}
