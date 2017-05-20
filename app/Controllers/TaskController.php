<?php

namespace App\Controllers;

class TaskController extends Controller
{
    public function index()
    {
        $this->view->assign([
            'page_title' => 'My page',
        ]);

        $this->view->display('index.tpl');
    }
}
