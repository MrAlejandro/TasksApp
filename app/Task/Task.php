<?php
namespace App\Task;

use App\Task\Interfaces\TaskInterface;

class Task implements TaskInterface
{
    protected $id;
    protected $uuid;
    protected $name;
    protected $priority;
    protected $status;
    protected $tags = [];

    public function __construct(
        TaskUuid $uuid,
        TaskName $name,
        TaskPriority $priority,
        TaskStatus $status
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->priority = $priority;
        $this->status = $status;
    }

    public function init(Array $taskData = [])
    {
        $this->uuid->set(!empty($taskData['uuid']) ? $taskData['uuid'] : '');
        $this->name->set(!empty($taskData['name']) ? $taskData['name'] : '');
        $this->priority->set(!empty($taskData['priority']) ? $taskData['priority'] : 0);
        $this->status->set(!empty($taskData['status']) ? $taskData['status'] : 0);

        if (!empty($taskData['tags'])) {
            $tags = is_array($taskData['tags']) ? $taskData['tags'] : [$taskData['tags']];
            $tags = $this->validateTags($tags);
            $this->tags = array_unique($tags);
        }

        return $this;
    }

    public function getPriorities()
    {
        return $this->priority->getList();
    }

    public function getStatuses()
    {
        return $this->status->getList();
    }

    public function getSaveData()
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid->get(),
            'name' => $this->name->get(),
            'priority' => $this->priority->get(),
            'status' => $this->status->get(),
            'tags' => json_encode($this->tags),
        ];
    }

    protected function validateTags(Array $tags = [])
    {
        return array_map(function ($tag) {
            return filter_var(
                (string) $tag,
                FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                FILTER_FLAG_NO_ENCODE_QUOTES
            );
        }, $tags);
    }
}
