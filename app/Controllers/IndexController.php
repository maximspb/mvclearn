<?php

namespace App\Controllers;

use App\Models\User;

class IndexController extends Controller
{
    public function actionIndex()
    {
        $this->view->display('index.twig');
    }


}
