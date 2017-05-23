<?php
namespace App\Task\TaskRepository;

use App\Task\Interfaces\TaskStorageInterface;

class TaskMysqlStorage implements TaskStorageInterface
{
    protected $db;

    public function __construct(\Simplon\Mysql\Mysql $db)
    {
        $this->db = $db;
    }

    public function save(\App\Task\Interfaces\TaskInterface $task)
    {
        $data = $task->getSaveData();
        $id = 0;

        try {
            unset($data['id']);
            $id = $this->db->insert('task', $data);
        } catch (Exception $e) {
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
