<?php
namespace App\Controllers;

use App\Model;

class TaskController extends Controller
{
    protected $templatesDir = 'task';

    public function index()
    {
        $page = !empty($_REQUEST['page']) ? (int) $_REQUEST['page'] : 1;
        $items_per_page = !empty($_REQUEST['items_per_page']) ? (int) $_REQUEST['items_per_page'] : 10;

        /** @var $taskRepository \App\Task\TaskRepository\TaskRepository */
        $taskRepository = Model::instance('task_repository');

        $taskStorage = $taskRepository->getStorageDriver();
        list($tasksData, $pagination) = $taskStorage->getCollection($page, $items_per_page);

        /** @var $task \App\Task\Task */
        $task = Model::instance('task');

        $this->view->assign([
            'page_title' => __('tasks_list'),
            'tasks' => $tasksData,
            'statuses' => $task->getStatuses(),
            'priorities' => $task->getPriorities(),
            'pagination' => $pagination,
        ]);

        if (!empty($_REQUEST['is_ajax'])) {
            $html = $this->view->fetch('task/index.tpl');
            $this->sendJsonResponse(['html' => $html]);
        }

        $this->render('task/index.tpl');
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

            $uuid = $task->getUuid();
            if ($id && $uuid) {
                $response['message'] = __(
                    'task_created',
                    [
                        '{id}' => $id,
                        '{task_url}' => $this->view->url("/task/edit/{$uuid}"),
                    ]);
            } else {
                $response['message'] = __('task_creation_failed');
            }
        }

        $response['success'] = $result;

        $this->sendJsonResponse($response);
    }

    public function update($uuid = 0)
    {
        $request = $_REQUEST;
        $result = false;
        $response = [];

        if (!empty($request['task_uuid']) && $uuid == $request['task_uuid']) {
            if (empty($request['task_name'])) {
                $response['message'] = __('task_name_cannot_be_empty');
            } else {
                $data['uuid'] = $uuid;
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

    public function edit($uuid = 0)
    {
        $result = false;

        if (!empty($uuid)) {
            /** @var $taskRepository \App\Task\TaskRepository\TaskRepository */
            $taskRepository = Model::instance('task_repository');
            $taskStorage = $taskRepository->getStorageDriver();

            $taskData = $taskStorage->get($uuid);

            if (!empty($taskData)) {
                $task = Model::instance('task');

                $this->view->assign([
                    'page_title' => __('edit_task'),
                    'statuses' => $task->getStatuses(),
                    'priorities' => $task->getPriorities(),
                    'task_data' => $taskData,
                    'edit_form_url' => $this->view->url("task/update/{$uuid}"),
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
