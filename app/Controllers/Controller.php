<?php

namespace App\Controllers;

use App\Database;
use App\Request;
use App\View;

abstract class Controller
{

    protected $view;
    protected $request;
    protected $connect;

    public function __construct(Request $request, View $view, Database $connect)
    {
        $this->view = $view;
        $this->request = $request;
        $this->connect = $connect;
    }
}
