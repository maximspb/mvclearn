<?php

namespace App\Controllers;

use App\View;

abstract class Controller
{

    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}
