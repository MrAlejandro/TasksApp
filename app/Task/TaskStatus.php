<?php
namespace App\Task;

class TaskStatus implements Interfaces\TaskValueInterface
{
    CONST DEFAULT_STATUS = 1;

    protected $status;
    protected $statuses = [
        1 => 'in_progress',
        2 => 'complete',
    ];

    public function set($status = 0)
    {
        $result = false;

        if (null === $this->status) {
            $result = true;

            if (!empty($status) && !empty($this->statuses[$status])) {
                $this->status = $status;
            } else {
                $this->status = self::DEFAULT_STATUS;
            }
        }

        return $result;
    }

    public function get()
    {
        return $this->status;
    }

    public function getList()
    {
        return $this->statuses;
    }
}

