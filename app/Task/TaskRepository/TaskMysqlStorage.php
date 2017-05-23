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

    public function create(\App\Task\Interfaces\TaskInterface $task)
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

    public function update(\App\Task\Interfaces\TaskInterface $task)
    {
        $data = $task->getSaveData();
        $id = !empty($data['id']) ? $data['id'] : 0;
        $result = false;

        if ($id) {
            try {
                unset($data['id'], $data['uuid']);

                $this->db
                    ->update('task')
                    ->cols($data)
                    ->where('id = :id')
                    ->bindValues(['id' => $id])
                    ->query();

                $result = true;
            } catch (\Exception $e) {
            }
        }

        return $result;
    }

    public function saveCollection(Array $tasks)
    {

    }

    public function get($id = 0)
    {
        $id = intval($id);
        $taskData = [];

        if (!empty($id)) {
            $taskData = $this->db
                ->select('*')
                ->from('task')
                ->where('id = :id')
                ->bindValues(['id' => $id])
                ->row();
        }

        if (!empty($taskData['tags'])) {
            $taskData['tags'] = json_decode($taskData['tags'], true);
        }

        return $taskData;
    }

    public function getCollection(Array $ids = [])
    {

    }
}
