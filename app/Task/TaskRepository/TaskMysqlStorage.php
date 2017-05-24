<?php
namespace App\Task\TaskRepository;

use App\Task\Interfaces\TaskStorageInterface;

class TaskMysqlStorage implements TaskStorageInterface
{
    const DEFAULT_PER_PAGE = 10;
    const DEFAULT_ORDER_DESC = 'priority';
    const DEFAULT_ORDER_ASC = 'status';
    const TAGS_TO_DISPLAY = 3;

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

    public function getCollection($page = 1, $limit = self::DEFAULT_PER_PAGE, $sort = [])
    {
        $tasksData = [];

        try {
            $tasksData = $this->db->select('id,name,status,priority,tags')
                ->from('task')
                ->offset(0)
                ->limit($limit)
                ->orderByASC(!empty($sort['asc']) ? $sort['asc'] : [self::DEFAULT_ORDER_ASC])
                ->orderByDESC(!empty($sort['desc']) ? $sort['desc'] : [self::DEFAULT_ORDER_DESC])
                ->query();

            foreach ($tasksData as $key => $taskData) {
                $taskData['tags'] = !empty($taskData['tags']) ? json_decode($taskData['tags'], true) : [];
                $tagsQuantity = count($taskData['tags']);

                if ($tagsQuantity) {
                    array_splice($taskData['tags'], self::TAGS_TO_DISPLAY);

                    if ($tagsQuantity > self::TAGS_TO_DISPLAY) {
                        $taskData['tags']['total'] = $tagsQuantity;
                    }
                }

                $tasksData[$key]['tags'] = $taskData['tags'];
            }
        } catch (Exception $e) {
        }

        return $tasksData;
    }
}
