<?php
namespace App\Controllers;

use App\Request;
use App\View;

abstract class Controller
{

    protected $view;
    protected $request;

    public function __construct(Request $request, View $view)
    {
        $this->view = $view;
        $this->request = $request;
    }
}
