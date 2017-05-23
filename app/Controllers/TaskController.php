<?php
namespace App\Controllers;

use App\Model;

class TaskController extends Controller
{
    protected $templatesDir = 'task';

    public function index()
    {


        /** @var $taskRepository \App\Task\TaskRepository\TaskRepository */
        $taskRepository = Model::instance('task_repository');

        $taskStorage = $taskRepository->getStorageDriver();
        $tasksData = $taskStorage->getCollection();

        $this->view->assign([
            'page_title' => __('tasks_list'),
            'tasks' => $tasksData,
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
            'edit_form_url' => $this->view->url("task/create"),
        ]);

        $this->render('task/edit.tpl');
    }

    public function save()
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
            $id = $taskStorage->create($task);
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

    public function update($id = 0)
    {
        $request = $_REQUEST;
        $id = intval($id);
        $result = false;
        $response = [];

        if (!empty($request['task_id']) && $id == $id) {
            if (empty($request['task_name'])) {
                $response['message'] = __('task_name_cannot_be_empty');
            } else {
                $data['id'] = $request['task_id'];
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
                $result = $taskStorage->update($task);

                if ($result) {
                    $response['message'] = __('task_updated');
                } else {
                    $response['message'] = __('task_update_failed');
                }
            }
        } else {
            $response['message'] = __('task_ids_mismatch');
        }

        $response['success'] = (bool) $result;

        $this->sendJsonResponse($response);
    }

    public function edit($id = 0)
    {
        $result = false;

        if (!empty($id)) {
            /** @var $taskRepository \App\Task\TaskRepository\TaskRepository */
            $taskRepository = Model::instance('task_repository');
            $taskStorage = $taskRepository->getStorageDriver();

            $taskData = $taskStorage->get($id);

            if (!empty($taskData)) {
                $task = Model::instance('task');

                $this->view->assign([
                    'page_title' => __('edit_task'),
                    'statuses' => $task->getStatuses(),
                    'priorities' => $task->getPriorities(),
                    'task_data' => $taskData,
                    'edit_form_url' => $this->view->url("task/update/{$id}"),
                ]);

                $result = true;
                $this->render('task/edit.tpl');
            }
        }

        if (empty($result)) {
            http_response_code(404);
            $this->render('404.tpl');
        }
    }
}
