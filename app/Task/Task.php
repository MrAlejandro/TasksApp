<?php
namespace App\Task;

class Task
{
    protected $id;
    protected $uuid;
    protected $name;
    protected $priority;
    protected $status;

    protected $tags = [];

    public function __construct(
        TaskId $uuid,
        TaskName $name,
        TaskPriority $priority,
        TaskStatus $status
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->priority = $priority;
        $this->status = $status;

        $this->init([
            'name' => '<p>"test"</p>',
        ]);
    }

    public function init(Array $taskData = [])
    {
        $this->uuid->set(!empty($taskData['uuid']) ? $taskData['uuid'] : '');
        $this->name->set(!empty($taskData['name']) ? $taskData['name'] : '');
        $this->priority->set(!empty($taskData['priority']) ? $taskData['priority'] : 0);
        $this->status->set(!empty($taskData['status']) ? $taskData['status'] : 0);

        return $this;
    }
}
