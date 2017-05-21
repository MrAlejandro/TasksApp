<?php
namespace App\Controllers;

use App\Model;

class TaskController extends Controller
{
    protected $templatesDir = 'task';

    public function index()
    {
        /*$task = Model::instance('task');
        var_dump($task);
        die;*/

        $this->view->assign([
            'page_title' => 'My page',
        ]);

        $this->render();
    }

    public function create()
    {
        /** @var $task \App\Task\Task */
        $task = Model::instance('task');

        $this->view->assign([
            'page_title' => __('create_task'),
            'statuses' => $task->getStatuses(),
            'priorities' => $task->getPriorities(),
        ]);

        $this->render('task/edit.tpl');
    }
}
