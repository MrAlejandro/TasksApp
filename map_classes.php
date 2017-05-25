<?php

return [
    'task' => 'App\Task\Task',
    'task_uuid' => 'App\Task\TaskUuid',
    'task_name' => 'App\Task\TaskName',
    'task_status' => 'App\Task\TaskStatus',
    'task_priority' => 'App\Task\TaskPriority',
    'task_repository' => 'App\Task\TaskRepository\TaskRepository',
    'task_mysql_storage' => 'App\Task\TaskRepository\TaskMysqlStorage',
    'task_files_storage' => 'App\Task\TaskRepository\TaskFilesStorage',
];
