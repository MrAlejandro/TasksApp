<?php

namespace App\Controllers;

class TaskController extends Controller
{
    public function index()
    {
        $this->view->display('index.tpl');
    }
}
