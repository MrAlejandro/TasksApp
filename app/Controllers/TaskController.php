<?php
namespace App\Controllers;

use App\Model;

class TaskController extends Controller
{
    public function index()
    {
        $task = Model::instance('task');
        var_dump($task);
        die;

        $this->view->assign([
            'page_title' => 'My page',
        ]);

        $this->view->display('index.tpl');
    }
}
