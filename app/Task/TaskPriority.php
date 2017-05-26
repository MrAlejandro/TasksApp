<?php
namespace App\Task;

class TaskPriority implements Interfaces\TaskValueInterface
{
    CONST DEFAULT_PRIORITY = 20;

    protected $priority;
    protected $priorities = [
        10 => 'priority_low',
        20 => 'priority_medium',
        30 => 'priority_high',
    ];

    public function set($priority = 0)
    {
        $result = false;

        if (null === $this->priority) {
            $result = true;

            if (!empty($priority) && !empty($this->priorities[$priority])) {
                $this->priority = $priority;
            } else {
                $this->priority = self::DEFAULT_PRIORITY;
            }
        }

        return $result;
    }

    public function get()
    {
        return $this->priority;
    }

    public function getList()
    {
        return $this->priorities;
    }
}
