<?php
namespace App\Task\TaskRepository;

use App\Task\Interfaces\TaskStorageInterface;

class TaskMysqlStorage implements TaskStorageInterface
{
    protected $db;

    public function __construct(\Workerman\MySQL\Connection $db)
    {
        $this->db = $db;
    }

    public function save(\App\Task\Interfaces\TaskInterface $task)
    {
        $data = $task->getSaveData();
        $id = 0;

        try {
            unset($data['id']);

            $id = $this->db
                ->insert('task')
                ->cols($data)
                ->query();
        } catch (\Exception $e) {
        }

        return $id;
    }

    public function saveCollection(Array $tasks)
    {

    }

    public function get($id = 0)
    {

    }

    public function getCollection(Array $ids = [])
    {

    }
}
