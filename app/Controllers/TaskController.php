<?php
namespace App\Controllers;

use App\Model;

class TaskController extends Controller
{
    protected $templatesDir = 'task';

    public function index()
    {

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

    public function update()
    {
        $request = $_REQUEST;
        $result = false;
        $response = [];

        if (empty($request['task_name'])) {
            $response['message'] = __('task_name_cannot_be_empty');
        } else {
            $data['name'] = $request['task_name'];
            $data['status'] = !empty($request['task_status']) ? $request['task_status'] : 0;
            $data['priority'] = !empty($request['task_priority']) ? $request['task_priority'] : 0;
            $data['tags'] = !empty($request['task_tags']) ? $request['task_tags'] : [];

            /** @var $task \App\Task\Task */
            $task = Model::instance('task');
            $task->init($data);

            /** @var $taskRepository \App\Task\TaskRepository\TaskRepository */
            $taskRepository = Model::instance('task_repository');

            $taskStorage = $taskRepository->getStorageDriver();
            $id = $taskStorage->save($task);
            $result = (bool) $id;

            if ($id) {
                $response['message'] = __(
                    'task_created',
                    [
                        '{id}' => $id,
                        '{task_url}' => $this->view->url("/task/edit/{$id}"),
                    ]);
            } else {
                $response['message'] = __('task_creation_failed');
            }
        }

        $response['success'] = $result;

        $this->sendJsonResponse($response);
    }
}
