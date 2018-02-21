<?php

namespace App\Controllers;

use App\Database;
use App\Request;
use App\View;
abstract class Controller
{

    protected $view;
    protected $request;
    public function __construct()
    {
        $this->view = new View();
        $this->request = new Request();
    }
}
